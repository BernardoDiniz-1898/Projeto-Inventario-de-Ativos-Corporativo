<?php

require __DIR__.'/vendor/autoload.php';
use App\Models\Employee;
use App\Models\Grupo;
use App\Models\Notebook;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;
use OpenSpout\Reader\XLSX\Reader;

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

// ── Helpers ──────────────────────────────────────────────

function toStr($v): string
{
    if ($v instanceof DateTimeImmutable) {
        return $v->format('d/m/Y');
    }

    return trim((string) ($v ?? ''));
}

function parseDate($v): ?string
{
    $s = toStr($v);
    // Already ISO
    if (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $s)) {
        return $s;
    }
    // dd/mm/yyyy
    if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', $s, $m)) {
        return "{$m[3]}-{$m[2]}-{$m[1]}";
    }
    // ddmmyyyy (e.g. 27012025)
    if (preg_match('/^(\d{2})(\d{2})(\d{4})$/', $s, $m)) {
        return "{$m[3]}-{$m[2]}-{$m[1]}";
    }
    // dd/mmYYYY (e.g. 10/072025, 03/072025)
    if (preg_match('/^(\d{1,2})\/(\d{2})(\d{4})$/', $s, $m)) {
        return "{$m[3]}-{$m[2]}-{$m[1]}";
    }
    // Excel serial number
    if (is_numeric($s) && $s > 40000 && $s < 60000) {
        try {
            $dt = (new DateTime())->setTimeStamp((int) (($s - 25569) * 86400));

            return $dt->format('Y-m-d');
        } catch (\Exception) {
        }
    }

    return null;
}

function splitMarcaModelo(string $raw): array
{
    $raw = trim($raw);
    if (empty($raw)) {
        return ['marca' => 'DESCONHECIDO', 'modelo' => 'DESCONHECIDO'];
    }
    $parts = preg_split('/\s+/', $raw, 2);

    return ['marca' => mb_strtoupper($parts[0]), 'modelo' => trim($parts[1] ?? '')];
}

function mapStatus($raw): string
{
    $s = strtoupper(toStr($raw));
    if (str_contains($s, 'EM USO')) {
        return 'em_uso';
    }
    if (str_contains($s, 'MANUTENCAO') || str_contains($s, 'MANUTENÇÃO')) {
        return 'manutencao';
    }
    if (str_contains($s, 'DEVOLVIDO')) {
        return 'devolvido';
    }
    if (str_contains($s, 'OCI')) {
        return 'ocioso';
    }
    if (str_contains($s, 'PERDIDO') || str_contains($s, 'EXTRAVI')) {
        return 'extraviado';
    }
    if (str_contains($s, 'TRANSFER')) {
        return 'transferido';
    }
    if (str_contains($s, 'OBSOLETO')) {
        return 'obsoleto';
    }
    if (str_contains($s, 'BAIXA')) {
        return 'baixa';
    }

    return 'em_uso';
}

function normalizeSerial($raw): string
{
    return strtoupper(trim(toStr($raw)));
}

function normalizePatrimonio($raw): string
{
    return trim(toStr($raw));
}

function isNonNotebook(string $marcaModelo): bool
{
    $s = strtolower($marcaModelo);

    return str_contains($s, 'impressor') || str_contains($s, 'tablet')
        || str_contains($s, 'monitor') || str_contains($s, 'desktop')
        || str_contains($s, 'pc ') || str_contains($s, 'celular');
}

// ── Get or create grupo ──────────────────────────────────

$grupo = Grupo::firstOrCreate(
    ['nome' => 'Chammas Engenharia'],
    ['descricao' => 'Grupo principal da Chammas Engenharia', 'cor' => '#3b82f6']
);

echo "Grupo: {$grupo->nome} (ID: {$grupo->id})\n";

// ── Build lookup sets of existing data ───────────────────

$existingSerials = array_flip(
    Notebook::whereNotNull('numero_serie')
        ->where('numero_serie', '!=', '')
        ->pluck('numero_serie', 'numero_serie')
        ->toArray()
);
$existingPatrimonios = array_flip(
    Notebook::whereNotNull('patrimonio')
        ->where('patrimonio', '!=', '')
        ->pluck('patrimonio', 'patrimonio')
        ->toArray()
);

echo "Notebooks existentes: " . Notebook::count() . "\n";
echo "Serials no banco: " . count($existingSerials) . "\n";
echo "Patrimonios no banco: " . count($existingPatrimonios) . "\n\n";

// ── Employee lookup ──────────────────────────────────────

$employeeCache = [];

function findOrCreateEmployee(string $nome, string $matricula, ?Grupo $grupo): ?Employee
{
    global $employeeCache;
    $nome = trim($nome);
    $matricula = trim($matricula);

    if (empty($nome) || $nome === 'SEM PROPRIETARIO' || $nome === 'ATIVO OCIOSO'
        || $nome === 'DEVOLVIDO' || $nome === 'PERDIDO' || $nome === 'VERIFICAR'
        || str_contains(strtoupper($nome), 'OCIOSO') || str_contains(strtoupper($nome), 'VERIFICAR')
        || str_contains(strtoupper($nome), 'ATIVO') || str_contains(strtoupper($nome), 'COLETADO')
        || str_contains(strtoupper($nome), 'DESLIGADO') || str_contains(strtoupper($nome), 'TI')
        || str_contains(strtoupper($nome), 'RECOLHIDO') || str_contains(strtoupper($nome), 'SERÁ')
        || str_contains(strtoupper($nome), 'LABORATOR') || str_contains(strtoupper($nome), 'TRIAXIAL')
        || str_contains(strtoupper($nome), 'ITABIRA') || str_contains(strtoupper($nome), 'EUROCHEM')
        || str_contains(strtoupper($nome), 'SIMPLELAB') || str_contains(strtoupper($nome), 'INVENTÁRIO')
        || str_contains(strtoupper($nome), 'INVENTARIO')) {
        return null;
    }

    // Strip leading numeric matricula from name
    if (preg_match('/^\d+\s*-\s*/', $nome)) {
        $nome = preg_replace('/^\d+\s*-\s*/', '', $nome);
    }
    if (preg_match('/^\d+\s+/', $nome)) {
        $nome = preg_replace('/^\d+\s+/', '', $nome);
    }

    // Strip trailing status keywords
    $nome = preg_replace('/\s*-\s*DEVOLVIDO\s*$/i', '', $nome);
    $nome = preg_replace('/\s*-\s*RESERVADO\s+TI\s*$/i', '', $nome);
    $nome = preg_replace('/\s+em\s+manuten[cç][aã]o\s*$/i', '', $nome);
    $nome = trim($nome);

    if (empty($nome)) {
        return null;
    }

    $key = strtoupper($nome);
    if (isset($employeeCache[$key])) {
        return $employeeCache[$key];
    }

    $emp = Employee::where('nome', $nome)->first();
    if (! $emp && ! empty($matricula)) {
        $emp = Employee::where('matricula', $matricula)->first();
    }
    if (! $emp) {
        $emp = Employee::create([
            'nome' => $nome,
            'matricula' => $matricula ?: null,
            'status' => 'ativo',
            'grupo_id' => $grupo->id,
        ]);
    }
    $employeeCache[$key] = $emp;

    return $emp;
}

// ── Import "Notebook - Chammas" sheet ────────────────────

$path = 'C:\Users\Administrador\Downloads\Inventário de Ativos.xlsx';
$reader = new Reader;
$reader->open($path);

$created = 0;
$skipped = 0;
$updated = 0;
$employeesCreated = 0;
$errors = [];

foreach ($reader->getSheetIterator() as $sheet) {
    if ($sheet->getName() !== 'Notebook - Chammas') {
        continue;
    }

    echo "=== Sheet: {$sheet->getName()} ===\n";

    $rowNum = 0;
    foreach ($sheet->getRowIterator() as $row) {
        $rowNum++;
        // Skip title row and header row
        if ($rowNum <= 2) {
            continue;
        }

        $v = $row->toArray();

        $matricula = toStr($v[0]);       // MATRICULA
        $proprietario = toStr($v[1]);     // PROPRIETÁRIO
        $patrimonio = normalizePatrimonio($v[2]);  // PATRIMONIO
        $statusRaw = toStr($v[3]);        // STATUS
        $serial = normalizeSerial($v[4]); // SERIAL
        $marcaModelo = toStr($v[5]);      // MARCA/MODELO
        $dataEntrada = parseDate($v[6]);  // ENTRADA
        $fornecedor = toStr($v[8]);       // FORNECEDOR
        $obs = toStr($v[9]);             // OBSERVAÇÃO/NOTA
        $ficha = toStr($v[10]);           // FICHA TI
        $datto = toStr($v[11]);           // DATTO INSTALADO?
        $bitdefender = toStr($v[12]);     // BIT DEFENDER INSTALADO?

        // Skip empty rows
        if (empty($serial) && empty($patrimonio) && empty($marcaModelo)) {
            $skipped++;
            continue;
        }

        // Skip non-notebooks (printers, etc.)
        if (isNonNotebook($marcaModelo)) {
            $skipped++;
            continue;
        }

        // ── Deduplication ──
        $isDuplicate = false;

        if (! empty($serial) && $serial !== '-' && isset($existingSerials[$serial])) {
            $isDuplicate = true;
        }
        if (! empty($patrimonio) && $patrimonio !== '-' && isset($existingPatrimonios[$patrimonio])) {
            $isDuplicate = true;
        }

        if ($isDuplicate) {
            $skipped++;
            continue;
        }

        // ── Parse brand/model ──
        $mm = splitMarcaModelo($marcaModelo);

        // ── Security fields from FICHA/DATTO/BITDEFENDER ──
        $backupConfigurado = false;
        if (strtoupper($ficha) === 'OK' || strtoupper($ficha) === 'SIM') {
            $backupConfigurado = true;
        }

        $dattoInstalled = false;
        if (strtoupper($datto) === 'SIM') {
            $dattoInstalled = true;
        }

        $antivirus = false;
        if (strtoupper($bitdefender) === 'SIM') {
            $antivirus = true;
        }

        // ── Status mapping ──
        $status = mapStatus($statusRaw);

        // ── Build observacoes ──
        $fullObs = $obs;
        if ($dattoInstalled) {
            $fullObs .= ($fullObs ? ' | ' : '').'DATTO instalado';
        }

        // ── Employee ──
        $employee = null;
        if (! empty($proprietario) && $proprietario !== 'SEM PROPRIETARIO') {
            $employee = findOrCreateEmployee($proprietario, $matricula, $grupo);
            if ($employee && $employee->wasRecentlyCreated) {
                $employeesCreated++;
            }
        }

        // ── Create notebook ──
        $data = [
            'marca' => $mm['marca'],
            'modelo' => $mm['modelo'],
            'numero_serie' => $serial ?: ('NO-SERIAL-'.time().'-'.$rowNum),
            'patrimonio' => (! empty($patrimonio) && $patrimonio !== '-') ? $patrimonio : null,
            'status' => $status,
            'fornecedor' => $fornecedor ?: null,
            'observacoes' => $fullObs ?: null,
            'data_entrega' => $dataEntrada,
            'criptografia' => false,
            'antivirus' => $antivirus,
            'backup_configurado' => $backupConfigurado,
            'grupo_id' => $grupo->id,
        ];

        if ($employee) {
            $data['funcionario_id'] = $employee->id;
        }

        try {
            Notebook::create(array_filter($data, fn ($x) => $x !== null));
            $created++;

            if (! empty($serial) && $serial !== '-') {
                $existingSerials[$serial] = true;
            }
            if (! empty($patrimonio) && $patrimonio !== '-') {
                $existingPatrimonios[$patrimonio] = true;
            }
        } catch (\Exception $e) {
            $errors[] = "Row {$rowNum}: {$e->getMessage()}";
            $skipped++;
        }
    }
}

$reader->close();

echo "\n=== RESULTADO ===\n";
echo "Notebooks criados: {$created}\n";
echo "Employees criados: {$employeesCreated}\n";
echo "Ignorados (duplicados/vazios): {$skipped}\n";
if ($errors) {
    echo "\nErros (".count($errors)."):\n";
    foreach (array_slice($errors, 0, 20) as $err) {
        echo "  {$err}\n";
    }
}

echo "\n=== TOTAIS NO BANCO ===\n";
echo "Notebooks: ".Notebook::count()."\n";
echo "Employees: ".Employee::count()."\n";

echo "\n=== NOTEBOOKS POR STATUS ===\n";
Notebook::select('status', DB::raw('count(*) as t'))->groupBy('status')->orderByDesc('t')->get()->each(function ($s) {
    echo "  {$s->status}: {$s->t}\n";
});
