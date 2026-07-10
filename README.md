# Keep Inventory — Sistema de Gestão de Ativos Corporativos

Sistema web para inventário de notebooks e funcionários corporativos, com CRUD completo, dashboards, exportação Excel, autenticação com controle de acesso por papéis (RBAC), log de atividades e tema personalizável.

**Repositório:** [github.com/BernardoDiniz-1898/Projeto-Inventario-de-Ativos-Corporativo](https://github.com/BernardoDiniz-1898/Projeto-Inventario-de-Ativos-Corporativo)

---

## Stack Tecnológica

| Camada | Tecnologia | Versão |
|---|---|---|
| Backend | Laravel | 13.19.0 |
| PHP | CLI | 8.5.8 |
| Frontend | Vite + Tailwind CSS v4 | Vite 8.x / Tailwind 4.x |
| JS Interativo | Alpine.js | 3.15.12 |
| DB (dev) | SQLite | — |
| Exportação Excel | OpenSpout | 5.7.2 |
| OS (dev) | Arch Linux | Git v26.4.0 |

---

## Estrutura do Projeto

```
├── app/
│   ├── Exports/
│   │   ├── EmployeeExport.php          # Exportação de funcionários (XLSX via OpenSpout)
│   │   └── NotebookExport.php          # Exportação de notebooks (XLSX via OpenSpout)
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   └── UserController.php  # Gerenciamento de usuários (admin)
│   │   │   ├── Auth/
│   │   │   │   ├── LoginController.php # Login/logout
│   │   │   │   └── RegisterController.php # Registro
│   │   │   ├── EmployeeController.php  # CRUD funcionários + export
│   │   │   ├── NotebookController.php  # CRUD notebooks + export
│   │   │   └── SettingsController.php  # Configurações (client-side)
│   │   └── Middleware/
│   │       └── RoleMiddleware.php       # RBAC: admin | editor | viewer
│   ├── Models/
│   │   ├── ActivityLog.php             # Log de atividades (polimórfico)
│   │   ├── Employee.php                # Modelo de funcionários
│   │   ├── Notebook.php                # Modelo de notebooks
│   │   └── User.php                    # Modelo de usuários (auth)
│   └── Traits/
│       └── LogsChanges.php             # Trait reutilizável para logging de CRUD
├── database/
│   ├── factories/
│   │   ├── EmployeeFactory.php         # Factory para dados fake de funcionários
│   │   └── NotebookFactory.php         # Factory para dados fake de notebooks
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   ├── 2025_07_10_000001_create_notebooks_table.php
│   │   ├── 2025_07_10_000002_create_employees_table.php
│   │   ├── 2025_07_10_000003_add_funcionario_id_to_notebooks_table.php
│   │   ├── 2025_07_10_000004_create_users_table.php
│   │   └── 2025_07_10_000005_create_activity_logs_table.php
│   └── seeders/
│       └── DatabaseSeeder.php          # Seed: 1 usuário, 15 funcionários, 20 notebooks
├── resources/
│   ├── css/
│   │   └── app.css                     # Tailwind imports + dark mode overrides
│   ├── js/
│   │   └── app.js                      # Alpine.js + componente searchableSelect
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php           # Layout principal com dark theme CSS
│       ├── components/
│       │   └── activity-log.blade.php  # Componente reutilizável de log
│       ├── auth/
│       │   ├── login.blade.php
│       │   └── register.blade.php
│       ├── dashboard.blade.php         # Dashboard com stats e gráficos
│       ├── notebooks/                  # index, create, edit, show
│       ├── employees/                  # index, create, edit, show
│       ├── settings/
│       │   └── index.blade.php         # Configurações de tema/fonte/cor
│       └── admin/users/
│           └── index.blade.php         # Gerenciamento de usuários
├── routes/
│   └── web.php                         # 31 rotas definidas
├── bootstrap/
│   └── app.php                         # Middleware alias + redirect guests
├── vite.config.js
├── tailwind.config.js
├── composer.json
└── package.json
```

---

## Schema do Banco de Dados

### Tabela `notebooks`

| Coluna | Tipo | Restrições |
|---|---|---|
| `id` | bigint (PK) | auto-increment |
| `marca` | string | required |
| `modelo` | string | required |
| `numero_serie` | string | unique, required |
| `patrimonio` | string | unique, nullable |
| `status` | enum | `disponivel`, `em_uso`, `manutencao`, `ocioso`, `devolvido`, `obsoleto` |
| `funcionario_id` | bigint (FK) | nullable → `employees.id`, `nullOnDelete` |
| `sistema_operacional` | string | nullable |
| `ram_gb` | decimal(5,1) | nullable |
| `armazenamento` | string | nullable |
| `processador` | string | nullable |
| `data_aquisicao` | date | nullable |
| `data_garantia` | date | nullable, `>= data_aquisicao` |
| `observacoes` | text | nullable |
| `forncedor` | string | nullable |
| `preco` | decimal | nullable |
| `created_at` / `updated_at` | timestamps | |

### Tabela `employees`

| Coluna | Tipo | Restrições |
|---|---|---|
| `id` | bigint (PK) | auto-increment |
| `nome` | string | required |
| `matricula` | string | unique, nullable |
| `email` | string | unique, nullable |
| `telefone` | string | nullable |
| `departamento` | string | nullable |
| `centro_custo` | string | nullable |
| `projeto` | string | nullable |
| `setor` | string | nullable |
| `cargo` | string | nullable |
| `status` | enum | `ativo`, `afastado`, `desligado`, `ferias` |
| `data_admissao` | date | nullable |
| `observacoes` | text | nullable |
| `created_at` / `updated_at` | timestamps | |

### Tabela `users`

| Coluna | Tipo | Restrições |
|---|---|---|
| `id` | bigint (PK) | auto-increment |
| `name` | string | |
| `email` | string | unique |
| `email_verified_at` | timestamp | nullable |
| `password` | string | hashed |
| `role` | enum | `admin`, `editor`, `viewer` (default: `viewer`) |
| `remember_token` | string | nullable |
| `created_at` / `updated_at` | timestamps | |

### Tabela `activity_logs` (polimórfica)

| Coluna | Tipo | Restrições |
|---|---|---|
| `id` | bigint (PK) | auto-increment |
| `loggable_type` | string | (ex: `App\Models\Notebook`) |
| `loggable_id` | bigint | index composta com `loggable_type` |
| `action` | string | `created`, `updated`, `deleted` |
| `description` | text | nullable |
| `old_values` | json | nullable |
| `new_values` | json | nullable |
| `user_id` | bigint (FK) | nullable → `users.id`, `nullOnDelete` |
| `created_at` / `updated_at` | timestamps | |

### Relacionamentos

```
User ──────── 1:N ──── ActivityLog
Employee ──── 1:N ──── Notebook     (via funcionario_id, nullOnDelete)
Employee ──── 1:N ──── ActivityLog  (MorphMany)
Notebook ──── 1:N ──── ActivityLog  (MorphMany)
```

---

## Mapa de Rotas (31 rotas)

### Públicas (sem auth)

| Método | URI | Controller / Closure | Nome |
|---|---|---|---|
| `GET` | `/` | redirect → `/login` | — |
| `GET` | `/login` | `LoginController@showLoginForm` | `login` |
| `POST` | `/login` | `LoginController@login` | — |
| `POST` | `/logout` | `LoginController@logout` | `logout` |
| `GET` | `/register` | `RegisterController@showRegistrationForm` | `register` |
| `POST` | `/register` | `RegisterController@register` | — |

### Autenticadas (`auth` middleware)

| Método | URI | Controller | Nome | Middleware extra |
|---|---|---|---|---|
| `GET` | `/dashboard` | Closure (stats + gráficos) | `dashboard` | — |
| `GET` | `/settings` | `SettingsController@index` | `settings.index` | — |
| `POST` | `/settings` | `SettingsController@update` | `settings.update` | — |

### Admin + Editor (`role:admin,editor`)

| Método | URI | Controller | Nome |
|---|---|---|---|
| `GET` | `/notebooks` | `NotebookController@index` | `notebooks.index` |
| `POST` | `/notebooks` | `NotebookController@store` | `notebooks.store` |
| `GET` | `/notebooks/create` | `NotebookController@create` | `notebooks.create` |
| `GET` | `/notebooks/{id}` | `NotebookController@show` | `notebooks.show` |
| `PUT` | `/notebooks/{id}` | `NotebookController@update` | `notebooks.update` |
| `DELETE` | `/notebooks/{id}` | `NotebookController@destroy` | `notebooks.destroy` |
| `GET` | `/notebooks/{id}/edit` | `NotebookController@edit` | `notebooks.edit` |
| `GET` | `/notebooks/export/xlsx` | `NotebookController@export` | `notebooks.export` |
| `GET` | `/employees` | `EmployeeController@index` | `employees.index` |
| `POST` | `/employees` | `EmployeeController@store` | `employees.store` |
| `GET` | `/employees/create` | `EmployeeController@create` | `employees.create` |
| `GET` | `/employees/{id}` | `EmployeeController@show` | `employees.show` |
| `PUT` | `/employees/{id}` | `EmployeeController@update` | `employees.update` |
| `DELETE` | `/employees/{id}` | `EmployeeController@destroy` | `employees.destroy` |
| `GET` | `/employees/{id}/edit` | `EmployeeController@edit` | `employees.edit` |
| `GET` | `/employees/export/xlsx` | `EmployeeController@export` | `employees.export` |

### Admin only (`role:admin`)

| Método | URI | Controller | Nome |
|---|---|---|---|
| `GET` | `/admin/users` | `UserController@index` | `admin.users.index` |
| `PUT` | `/admin/users/{user}` | `UserController@update` | `admin.users.update` |
| `DELETE` | `/admin/users/{user}` | `UserController@destroy` | `admin.users.destroy` |

---

## Sistema de Controle de Acesso (RBAC)

### Papéis

| Papel | Cria/Edita notebooks e funcionários | Gerencia usuários | Visualiza dados |
|---|---|---|---|
| `admin` | ✅ | ✅ | ✅ |
| `editor` | ✅ | ❌ | ✅ |
| `viewer` | ❌ | ❌ | ✅ |

### Implementação

- **Middleware:** `App\Http\Middleware\RoleMiddleware` — registra alias `role` em `bootstrap/app.php`
- **Uso nas rotas:** `Route::middleware(['role:admin,editor'])` — aceita múltiplos papéis via variadic `string ...$roles`
- **Novos registros:** recebem `role: viewer` por padrão
- **Métodos helper no User model:** `isAdmin()`, `isEditor()`, `isViewer()`
- **Acesso restrito:** redirect para `/login` se não autenticado; `abort(403)` se papel insuficiente

### Usuário admin padrão (seed manual)

```bash
php artisan tinker
```

```php
App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => bcrypt('password'),
    'role' => 'admin',
]);
```

---

## Sistema de Log de Atividades

Implementado via trait reutilizable `App\Traits\LogsChanges`, utilizado em `NotebookController` e `EmployeeController`.

### Mecanismo

- **`logCreate($model, $attributes)`** — registra criação com `new_values` = atributos
- **`logUpdate($model, $old, $new)`** — compara arrays, registra apenas campos alterados (`old_values` / `new_values`)
- **`logDelete($model)`** — registra exclusão com `old_values` = todos os atributos antes de deletar
- **`describeAction()`** — gera descrição legível: `Notebook "Dell Latitude 5540" criado`

### Armazenamento

- Tabela `activity_logs` com morph polimórfico (`loggable_type` + `loggable_id`)
- JSON casts em `old_values` e `new_values` para diff granular
- Índice composto em `(loggable_type, loggable_id)` para performance

### Exibição

- Componente Blade `<x-activity-log :logs="$logs" />` — renderizado nas páginas de detalhe de notebooks e funcionários
- Pagination: 10 registros por página
- Mostra: avatar do usuário (iniciais), descrição, data/hora, diff de campos alterados

---

## Exportação Excel

Implementada via `openspout/openspout` (substituiu `maatwebsite/excel` por incompatibilidade com PHP 8.5.8).

### Classes

- `App\Exports\NotebookExport` — exporta notebooks com colunas: Patrimônio, Marca, Modelo, Nº Série, Status, Responsável, SO, Processador, RAM, Armazenamento, Fornecedor, Preço, Datas, Observações
- `App\Exports\EmployeeExport` — exporta funcionários com colunas: Nome, Matrícula, Email, Telefone, Departamento, Centro de Custo, Projeto, Setor, Cargo, Status, Data Admissão, Qtd Notebooks, Observações

### Fluxo

```
GET /notebooks/export/xlsx  →  NotebookExport::export($status)
GET /employees/export/xlsx  →  EmployeeExport::export($status)
```

- Download automático no browser como `.xlsx`
- Filtro opcional por status via query string (`?status=em_uso`)
- Arquivo: `notebooks_YYYY-MM-DD_HH-MM-SS.xlsx` / `funcionarios_YYYY-MM-DD_HH-MM-SS.xlsx`

---

## Configurações de UI (Client-side)

Persistidas em `localStorage` com chave `app_settings`.

| Configuração | Valores | Aplicação |
|---|---|---|
| `theme` | `light`, `dark` | Toggle classe `.dark` no `<html>` |
| `font_size` | `small` (14px), `normal` (16px), `large` (18px) | `data-font` attribute |
| `accent_color` | `blue`, `green`, `purple`, `red`, `orange` | `data-accent` attribute |
| `sidebar` | `expanded`, `collapsed` | `data-sidebar` attribute |

### Tema Dark

Implementado via CSS customizado no layout principal (`layouts/app.blade.php`) — **não usa plugin do Tailwind**. Estilo aplicado via seletor `.dark`:

- Backgrounds: `slate-900` / `slate-800`
- Cards: `slate-800` com borda `slate-700`
- Texto: `slate-100` / `slate-200` / `slate-300`
- Inputs: `slate-700` background, `slate-600` border
- Badges e alertas: mapeamento manual de todas as cores (`green-*`, `red-*`, `yellow-*`, etc.)
- Paginação, dropdowns, hovers, seleções — todos com overrides para `.dark`
- Auth pages (login/register) possuem dark mode independente via `<style>` inline

---

## Factories e Seed

### EmployeeFactory

Gera dados fake com:
- 9 departamentos (TI, Financeiro, RH, Marketing, Vendas, Operações, Administrativo, Jurídico, Comercial)
- Cargos específicos por departamento
- Matrícula: `MAT-#####`
- Status: random entre `ativo`, `afastado`, `desligado`, `ferias`
- Centro de custo: `CC-???-###` (60% probabilidade)
- Projetos: 6 opções (40% probabilidade)

### NotebookFactory

Gera dados fake com:
- 6 marcas (Dell, Lenovo, HP, Acer, Samsung, ASUS) com modelos específicos por marca
- Nº série: formato alfanumérico `??#####-####`
- Patrimônio: `PAT-#####`
- Specs: RAM (4/8/16/32 GB), armazenamento (SSD/HDD), processadores Intel/AMD
- SO: Windows 10/11, Linux Ubuntu, macOS
- Preço: R$ 1.500–8.000

### DatabaseSeeder

```php
User::factory()->create(['name' => 'Test User', 'email' => 'test@example.com']);
$employees = Employee::factory(15)->create();
Notebook::factory(20)->create(['funcionario_id' => null]);
// 12 notebooks aleatórios vinculados a funcionários com status 'em_uso'
```

---

## Setup e Instalação

### Pré-requisitos

- PHP >= 8.3 (testado com 8.5.8)
- Composer
- Node.js >= 18 (testado com v8.5.8)
- npm
- SQLite (dev) ou MySQL/PostgreSQL (produção)

### Instalação

```bash
# Clonar repositório
git clone https://github.com/BernardoDiniz-1898/Projeto-Inventario-de-Ativos-Corporativo.git
cd Projeto-Inventario-de-Ativos-Corporativo

# Dependências PHP
composer install

# Dependências JS
npm install

# Configuração
cp .env.example .env
php artisan key:generate

# Banco de dados (SQLite)
touch database/database.sqlite
php artisan migrate
php artisan db:seed

# Build do frontend
npm run build

# Criar usuário admin
php artisan tinker
# App\Models\User::create(['name'=>'Admin','email'=>'admin@example.com','password'=>bcrypt('password'),'role'=>'admin']);

# Iniciar servidor
php artisan serve
```

### Acesso

| URL | Credenciais |
|---|---|
| `http://localhost:8000/login` | `admin@example.com` / `password` |

---

## Comandos Úteis

```bash
php artisan serve              # Servidor de desenvolvimento
php artisan migrate            # Rodar migrations
php artisan migrate:refresh    # Resetar e re-rodar migrations
php artisan db:seed            # Popular banco com dados fake
php artisan tinker             # REPL interativo
php artisan view:clear         # Limpar cache de views compiladas
npm run dev                    # Vite dev server (hot reload)
npm run build                  # Build de produção
```

---

## Notas Técnicas

- **`maatwebsite/excel`** foi removido por incompatibilidade com PHP 8.5.8; `openspout/openspout` v5.7.2 é usado para exportação XLSX
- **`@json()` dentro de `x-data`** do Alpine.js quebrava parsing HTML; solução: `@js()` em `<script>` com `window._employeesData`
- **Componente `activity-log`** não usa `function` dentro de `@php` (causava ParseError no Blade); formatação inline
- **`2025_07_10_000004_create_users_table.php`** foi reescrito como no-op (tabela já existia, coluna `role` adicionada via ALTER TABLE)
- **Dark mode** usa seletor `.dark` (classe no `<html>`), não `[data-theme="dark"]`
- **Foreign Key:** `notebooks.funcionario_id → employees.id` com `nullOnDelete` (ao deletar funcionário, notebook fica sem responsável)
- **Validation:** unique rules usam `{column},{id}` para ignorar o registro atual no update
