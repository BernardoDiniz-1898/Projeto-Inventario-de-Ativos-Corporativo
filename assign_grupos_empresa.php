<?php

require __DIR__.'/vendor/autoload.php';
use App\Models\Grupo;
use App\Models\Notebook;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;
use OpenSpout\Reader\XLSX\Reader;

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

function toStr($v): string
{
    if ($v instanceof DateTimeImmutable) {
        return $v->format('d/m/Y');
    }

    return trim((string) ($v ?? ''));
}

// ── Create groups ────────────────────────────────────────

$grupoChammas = Grupo::firstOrCreate(
    ['nome' => 'Chammas Engenharia'],
    ['descricao' => 'Empresa principal', 'cor' => '#3b82f6']
);

$grupoSimpleLab = Grupo::firstOrCreate(
    ['nome' => 'SimpleLab'],
    ['descricao' => 'SimpleLab', 'cor' => '#10b981']
);

echo "Grupos: Chammas Engenharia ({$grupoChammas->id}), SimpleLab ({$grupoSimpleLab->id})\n\n";

// ── Build lookup: serial/patrimonio -> notebook ──────────

$serialMap = [];
$patMap = [];
foreach (Notebook::select('id', 'numero_serie', 'patrimonio')->get() as $nb) {
    if (! empty($nb->numero_serie)) {
        $serialMap[strtoupper($nb->numero_serie)] = $nb->id;
    }
    if (! empty($nb->patrimonio)) {
        $patMap[strtoupper(trim($nb->patrimonio))] = $nb->id;
    }
}

echo "Notebooks no banco: " . Notebook::count() . "\n";
echo "Serials mapeados: " . count($serialMap) . "\n";
echo "Patrimonios mapeados: " . count($patMap) . "\n\n";

// ── Read Excel and assign groups ────────────────────────

$path = 'C:\Users\Administrador\Downloads\Inventário de Ativos.xlsx';
$reader = new Reader;
$reader->open($path);

$matched = 0;
$unmatched = 0;
$grupoCounts = ['Chammas Engenharia' => 0, 'SimpleLab' => 0, 'sem grupo' => 0];

foreach ($reader->getSheetIterator() as $sheet) {
    if ($sheet->getName() !== 'Notebook - Chammas') {
        continue;
    }

    $rowNum = 0;
    foreach ($sheet->getRowIterator() as $row) {
        $rowNum++;
        if ($rowNum <= 2) {
            continue;
        }

        $v = $row->toArray();
        $serial = strtoupper(trim(toStr($v[4])));
        $patrimonio = strtoupper(trim(toStr($v[2])));
        $empresa = strtoupper(trim(toStr($v[7])));

        // Find notebook by serial or patrimonio
        $notebookId = null;
        if (! empty($serial) && isset($serialMap[$serial])) {
            $notebookId = $serialMap[$serial];
        } elseif (! empty($patrimonio) && $patrimonio !== '-' && isset($patMap[$patrimonio])) {
            $notebookId = $patMap[$patrimonio];
        }

        if (! $notebookId) {
            $unmatched++;
            continue;
        }

        $matched++;

        // Determine group
        $grupo = null;
        if (str_contains($empresa, 'SIMPLELAB')) {
            $grupo = $grupoSimpleLab;
            $grupoCounts['SimpleLab']++;
        } elseif (str_contains($empresa, 'CHAMMAS')) {
            $grupo = $grupoChammas;
            $grupoCounts['Chammas Engenharia']++;
        } else {
            $grupoCounts['sem grupo']++;
        }

        if ($grupo) {
            // Remove existing group assignments for this notebook
            DB::table('notebook_grupo')->where('notebook_id', $notebookId)->delete();
            // Attach to correct group
            DB::table('notebook_grupo')->insert([
                'grupo_id' => $grupo->id,
                'notebook_id' => $notebookId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

$reader->close();

echo "=== RESULTADO ===\n";
echo "Notebooks correspondidos: {$matched}\n";
echo "Sem correspondência: {$unmatched}\n\n";

echo "=== ATRIBUIÇÕES POR GRUPO ===\n";
foreach ($grupoCounts as $grupo => $count) {
    echo "  {$grupo}: {$count}\n";
}

echo "\n=== VERIFICAÇÃO NO BANCO ===\n";
$groups = DB::table('notebook_grupo')
    ->join('grupos', 'grupos.id', '=', 'notebook_grupo.grupo_id')
    ->select('grupos.nome', DB::raw('count(*) as cnt'))
    ->groupBy('grupos.nome')
    ->get();
foreach ($groups as $g) {
    echo "  {$g->nome}: {$g->cnt} notebooks\n";
}
