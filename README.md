# Keep Inventory — Sistema de Gestao de Ativos Corporativos

Sistema web para inventario de notebooks e funcionarios corporativos, com CRUD completo, dashboards, exportacao Excel, autenticacao com controle de acesso por papeis (RBAC), log de atividades, conformidade ISO 27001, suporte a 3 idiomas e tema personalizavel.

**Repositorio:** [github.com/BernardoDiniz-1898/Projeto-Inventario-de-Ativos-Corporativo](https://github.com/BernardoDiniz-1898/Projeto-Inventario-de-Ativos-Corporativo)

---

## Stack Tecnologica

| Camada | Tecnologia | Versao |
|---|---|---|
| Backend | Laravel | 13.19.0 |
| PHP | CLI | 8.5.8 |
| Frontend | Vite + Tailwind CSS v4 | Vite 8.x / Tailwind 4.x |
| JS Interativo | Alpine.js | 3.15.12 |
| DB (dev) | SQLite | — |
| Exportacao Excel | OpenSpout | 5.7.2 |
| i18n | 3 idiomas | pt_BR, en, es |
| OS (dev) | Arch Linux | Git v26.4.0 |

---

## Funcionalidades

- **CRUD Notebooks** — 30+ campos incluindo ISO 27001 (classificacao, localizacao, ciclo de vida, seguranca, manutencao)
- **CRUD Funcionarios** — dados cadastrais, centro de custo, projeto, vinculacao a notebooks
- **CRUD Grupos** — organizacao de ativos e funcionarios por grupo, com cor e slug, soft deletes
- **CRUD Usuarios** — admin cria/edita/exclui usuarios com roles
- **Inventario Unificado** — pagina dedicada com visao consolidada de notebooks + funcionarios, filtros e busca
- **Dashboard** — stats cards, graficos por marca/departamento/grupo, entradas recentes
- **Exportacao Excel** — notebooks e funcionarios em `.xlsx` via OpenSpout, headers traduzidos
- **RBAC** — 3 papeis: admin, editor, viewer
- **Log de Atividades** — diffs inline (campo: antigo -> novo) com polimorfismo, 100% traduzido (3 idiomas)
- **ISO 27001** — gestao de ativos com 17 campos de conformidade
- **Dark Mode** — tema escuro via CSS customizado
- **i18n** — suporte completo a 3 idiomas (pt_BR, en, es) em todas as views, controllers e exports
- **Configuracoes** — tema, fonte, cor de destaque (localStorage)

---

## Estrutura do Projeto

```
├── app/
│   ├── Exports/
│   │   ├── EmployeeExport.php              # Exportacao XLSX de funcionarios
│   │   └── NotebookExport.php              # Exportacao XLSX de notebooks (40 colunas)
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   └── UserController.php      # CRUD usuarios + updateRole
│   │   │   ├── Auth/
│   │   │   │   ├── LoginController.php
│   │   │   │   └── RegisterController.php
│   │   │   ├── EmployeeController.php      # CRUD + export + logs + grupo filter
│   │   │   ├── GrupoController.php         # CRUD Grupos (soft deletes)
│   │   │   ├── InventoryController.php     # Inventario unificado
│   │   │   ├── NotebookController.php      # CRUD + export + logs + ISO validation + grupo filter
│   │   │   └── SettingsController.php
│   │   ├── Middleware/
│   │   │   └── RoleMiddleware.php           # RBAC: aceita multiplos papeis
│   │   └── Requests/
│   │       ├── Store/Update{Notebook,Employee,Grupo}Request.php
│   ├── Models/
│   │   ├── ActivityLog.php                 # Polimorfico (MorphMany)
│   │   ├── Employee.php                    # SoftDeletes, grupo relationship
│   │   ├── Grupo.php                       # SoftDeletes, slug, cor, morphMany
│   │   ├── Notebook.php                    # 30+ fillable, ISO accessors, grupo relationship
│   │   └── User.php
│   ├── Services/
│   │   └── DashboardService.php            # Stats + graficos (por grupo incluido)
│   └── Traits/
│       └── LogsChanges.php                 # Trait reutilizavel, 100% traduzido
├── database/
│   ├── factories/
│   │   ├── EmployeeFactory.php
│   │   └── NotebookFactory.php
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   ├── 2025_07_10_000001_create_notebooks_table.php
│   │   ├── 2025_07_10_000002_create_employees_table.php
│   │   ├── 2025_07_10_000003_add_funcionario_id_to_notebooks_table.php
│   │   ├── 2025_07_10_000004_add_role_to_users_table.php
│   │   ├── 2025_07_10_000005_create_activity_logs_table.php
│   │   ├── 2025_07_10_000006_add_iso27001_fields_to_notebooks_table.php
│   │   ├── 2025_07_10_000007_add_data_entrega_to_notebooks_table.php
│   │   ├── 2026_07_22_000001_create_grupos_table.php
│   │   ├── 2026_07_22_000002_add_grupo_id_to_notebooks_table.php
│   │   └── 2026_07_22_000003_add_grupo_id_to_employees_table.php
│   └── seeders/
│       └── DatabaseSeeder.php              # 1 user, 15 employees, 20 notebooks, grupos
├── lang/
│   ├── pt_BR/                              # 13 arquivos de traducao
│   ├── en/                                 # 13 arquivos de traducao
│   └── es/                                 # 13 arquivos de traducao
├── resources/
│   ├── css/app.css                         # Tailwind + dark mode overrides (209+ linhas)
│   ├── js/app.js                           # Alpine.js + searchableSelect
│   └── views/
│       ├── layouts/app.blade.php           # Layout principal + dark theme CSS
│       ├── components/
│       │   ├── activity-log.blade.php      # Log com diffs inline traduzido
│       │   ├── lang-switcher.blade.php     # Seletor de idioma (pt_BR/en/es)
│       │   └── ui/                         # Componentes reutilizaveis (avatar, stat-card, etc.)
│       ├── auth/{login,register}.blade.php
│       ├── dashboard.blade.php             # Graficos por marca/departamento/grupo
│       ├── notebooks/{index,create,edit,show}.blade.php
│       ├── notebooks/_iso_fields.blade.php # Partial ISO 27001
│       ├── employees/{index,create,edit,show}.blade.php
│       ├── grupos/{index,create,edit,show}.blade.php
│       ├── inventory/index.blade.php       # Inventario unificado
│       ├── settings/index.blade.php
│       └── admin/users/{index,create,edit}.blade.php
├── routes/web.php                           # 42 rotas
├── bootstrap/app.php                        # Middleware alias
└── README.md
```

---

## Schema do Banco de Dados

### Tabela `notebooks`

| Coluna | Tipo | Restricoes | ISO 27001 |
|---|---|---|---|
| `id` | bigint (PK) | auto-increment | — |
| `marca` | string | required | — |
| `modelo` | string | required | — |
| `numero_serie` | string | unique, required | — |
| `patrimonio` | string | unique, nullable | — |
| `status` | enum(9) | required, default `em_uso` | — |
| `funcionario_id` | bigint (FK) | nullable -> `employees.id`, `nullOnDelete` | — |
| `grupo_id` | bigint (FK) | nullable -> `grupos.id`, `nullOnDelete` | — |
| `data_entrega` | date | nullable | — |
| `sistema_operacional` | string | nullable | — |
| `ram_gb` | decimal(5,1) | nullable | — |
| `armazenamento` | string | nullable | — |
| `processador` | string | nullable | — |
| `data_aquisicao` | date | nullable | — |
| `data_garantia` | date | nullable, `>= data_aquisicao` | — |
| `observacoes` | text | nullable | — |
| `fornecedor` | string | nullable | — |
| `preco` | decimal | nullable | — |
| `classificacao` | enum(4) | nullable | A.5.12 |
| `localizacao` | string | nullable | A.5.9 |
| `predio` | string | nullable | A.5.9 |
| `andar` | string | nullable | A.5.9 |
| `sala` | string | nullable | A.5.9 |
| `criticidade` | enum(4) | nullable | A.5.9/A.5.11 |
| `data_vida_util` | date | nullable | A.7.14 |
| `data_baixa` | date | nullable | A.5.11 |
| `motivo_baixa` | enum(7) | nullable | A.5.11 |
| `metodo_descarte` | enum(5) | nullable | A.5.11 |
| `criptografia` | boolean | nullable | A.8.1/A.8.24 |
| `antivirus` | boolean | nullable | A.8.7 |
| `status_patches` | enum(4) | nullable | A.8.8 |
| `backup_configurado` | boolean | nullable | A.8.13 |
| `ultima_manutencao` | date | nullable | A.7.13 |
| `proxima_manutencao` | date | nullable, `>= ultima_manutencao` | A.7.13 |
| `historico_manutencao` | text | nullable | A.7.13 |
| `created_at` / `updated_at` | timestamps | — | — |

**Status possiveis:** `disponivel`, `em_uso`, `manutencao`, `ocioso`, `devolvido`, `obsoleto`, `baixa`, `extraviado`, `transferido`

**Classificacao (ISO A.5.12):** `publica`, `interna`, `restrita`, `confidencial`

**Criticidade:** `baixo`, `medio`, `alto`, `critico`

**Motivo da baixa:** `obsolescencia`, `avaria`, `furto`, `descarte_seguro`, `doacao`, `venda`, `transferencia`

**Metodo de descarte:** `destruicao_fisica`, `reciclagem`, `limpeza_dados`, `doacao`, `venda`

**Status patches:** `atualizado`, `desatualizado`, `critico`, `nao_verificado`

### Tabela `employees`

| Coluna | Tipo | Restricoes |
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
| `status` | enum(4) | `ativo`, `afastado`, `desligado`, `ferias` |
| `data_admissao` | date | nullable |
| `observacoes` | text | nullable |
| `grupo_id` | bigint (FK) | nullable -> `grupos.id`, `nullOnDelete` |
| `created_at` / `updated_at` | timestamps | — |

### Tabela `grupos`

| Coluna | Tipo | Restricoes |
|---|---|---|
| `id` | bigint (PK) | auto-increment |
| `nome` | string | required, unique |
| `slug` | string | unique, auto-gerado |
| `cor` | string | nullable (hex color) |
| `descricao` | text | nullable |
| `deleted_at` | timestamp | nullable (soft deletes) |
| `created_at` / `updated_at` | timestamps | — |

### Tabela `users`

| Coluna | Tipo | Restricoes |
|---|---|---|
| `id` | bigint (PK) | auto-increment |
| `name` | string | required |
| `email` | string | unique |
| `email_verified_at` | timestamp | nullable |
| `password` | string | hashed |
| `role` | string | default `viewer` |
| `remember_token` | string | nullable |
| `created_at` / `updated_at` | timestamps | — |

### Tabela `activity_logs` (polimorfica)

| Coluna | Tipo | Restricoes |
|---|---|---|
| `id` | bigint (PK) | auto-increment |
| `loggable_type` | string | ex: `App\Models\Notebook` |
| `loggable_id` | bigint | indice composto |
| `action` | string | `created`, `updated`, `deleted` |
| `description` | text | nullable |
| `old_values` | json | nullable |
| `new_values` | json | nullable |
| `user_id` | bigint (FK) | nullable -> `users.id`, `nullOnDelete` |
| `created_at` / `updated_at` | timestamps | — |

### Relacionamentos

```
User ──────── 1:N ──── ActivityLog
Grupo ─────── 1:N ──── Notebook     (via grupo_id, nullOnDelete)
Grupo ─────── 1:N ──── Employee     (via grupo_id, nullOnDelete)
Employee ──── 1:N ──── Notebook     (via funcionario_id, nullOnDelete)
Employee ──── 1:N ──── ActivityLog  (MorphMany)
Notebook ──── 1:N ──── ActivityLog  (MorphMany)
```

---

## Mapa de Rotas (42 rotas)

### Publicas (sem auth)

| Metodo | URI | Controller | Nome |
|---|---|---|---|
| `GET` | `/` | redirect -> `/login` | — |
| `GET` | `/login` | `LoginController@showLoginForm` | `login` |
| `POST` | `/login` | `LoginController@login` | — |
| `POST` | `/logout` | `LoginController@logout` | `logout` |
| `GET` | `/register` | `RegisterController@showRegistrationForm` | `register` |
| `POST` | `/register` | `RegisterController@register` | — |

### Autenticadas (auth)

| Metodo | URI | Controller | Nome |
|---|---|---|---|
| `GET` | `/dashboard` | Closure | `dashboard` |
| `GET` | `/settings` | `SettingsController@index` | `settings.index` |
| `POST` | `/settings` | `SettingsController@update` | `settings.update` |
| `GET` | `/inventory` | `InventoryController@index` | `inventory.index` |

### Admin + Editor (role:admin,editor)

| Metodo | URI | Nome |
|---|---|---|
| `GET` | `/notebooks` | `notebooks.index` |
| `POST` | `/notebooks` | `notebooks.store` |
| `GET` | `/notebooks/create` | `notebooks.create` |
| `GET` | `/notebooks/{notebook}` | `notebooks.show` |
| `PUT` | `/notebooks/{notebook}` | `notebooks.update` |
| `DELETE` | `/notebooks/{notebook}` | `notebooks.destroy` |
| `GET` | `/notebooks/{notebook}/edit` | `notebooks.edit` |
| `GET` | `/notebooks/export/xlsx` | `notebooks.export` |
| `GET` | `/employees` | `employees.index` |
| `POST` | `/employees` | `employees.store` |
| `GET` | `/employees/create` | `employees.create` |
| `GET` | `/employees/{employee}` | `employees.show` |
| `PUT` | `/employees/{employee}` | `employees.update` |
| `DELETE` | `/employees/{employee}` | `employees.destroy` |
| `GET` | `/employees/{employee}/edit` | `employees.edit` |
| `GET` | `/employees/export/xlsx` | `employees.export` |
| `GET` | `/grupos` | `grupos.index` |
| `POST` | `/grupos` | `grupos.store` |
| `GET` | `/grupos/create` | `grupos.create` |
| `GET` | `/grupos/{grupo}` | `grupos.show` |
| `PUT` | `/grupos/{grupo}` | `grupos.update` |
| `DELETE` | `/grupos/{grupo}` | `grupos.destroy` |
| `GET` | `/grupos/{grupo}/edit` | `grupos.edit` |

### Admin only (role:admin)

| Metodo | URI | Nome |
|---|---|---|
| `GET` | `/admin/users` | `admin.users.index` |
| `GET` | `/admin/users/create` | `admin.users.create` |
| `POST` | `/admin/users` | `admin.users.store` |
| `GET` | `/admin/users/{user}/edit` | `admin.users.edit` |
| `PUT` | `/admin/users/{user}` | `admin.users.update` |
| `DELETE` | `/admin/users/{user}` | `admin.users.destroy` |
| `PUT` | `/admin/users/{user}/role` | `admin.users.role` |

---

## RBAC (Role-Based Access Control)

| Papel | Notebooks/Funcionarios/Grupos | Usuarios | Visualiza |
|---|---|---|---|
| `admin` | CRUD + Export + Inventario | CRUD + Role | Tudo |
| `editor` | CRUD + Export + Inventario | — | Tudo |
| `viewer` | — | — | Leitura |

- **Middleware:** `App\Http\Middleware\RoleMiddleware` — alias `role` em `bootstrap/app.php`
- **Default:** novos usuarios recebem `viewer`
- **Admin seed:** `admin@example.com` / `password`

---

## ISO 27001 — Mapeamento de Controles

| Controle | Campo(s) no Notebook |
|---|---|
| **A.5.9** — Inventory of assets | `localizacao`, `predio`, `andar`, `sala`, `data_vida_util` |
| **A.5.11** — Return of assets | `motivo_baixa`, `metodo_descarte`, `data_baixa` |
| **A.5.12** — Classification of assets | `classificacao` |
| **A.7.13** — Equipment maintenance | `ultima_manutencao`, `proxima_manutencao`, `historico_manutencao` |
| **A.7.14** — Secure disposal | `metodo_descarte`, `data_baixa` |
| **A.8.1** — User endpoint devices | `criptografia`, `antivirus` |
| **A.8.8** — Technical vulnerability mgmt | `status_patches` |
| **A.8.13** — Information backup | `backup_configurado` |
| **A.5.9/A.5.11** — Asset lifecycle | `criticidade`, `data_vida_util` |

---

## Log de Atividades

- **Trait:** `App\Traits\LogsChanges` — `logCreate()`, `logUpdate()`, `logDelete()`
- **Polimorfico:** `activity_logs` com `loggable_type` + `loggable_id`
- **Diffs:** compara old vs new, mostra apenas campos alterados
- **Labels:** todos os 30+ campos mapeados para nomes legiveis, traduzidos em 3 idiomas via `lang/*/logs.php`
- **Componente:** `<x-activity-log :logs="$logs" />` — diff inline: `campo: antigo (vermelho riscado) -> novo (verde)`

---

## Exportacao Excel

- **Lib:** `openspout/openspout` v5.7.2 (substituiu `maatwebsite/excel` — incompativel com PHP 8.5.8)
- **Notebooks:** 40 colunas (basicos + ISO 27001 completos + grupo + aluguel)
- **Funcionarios:** 14 colunas (incluindo grupo)
- **Headers:** traduzidos automaticamente via `__()` (3 idiomas)
- **Filtro:** por status via query string (`?status=em_uso`)

---

## Suporte a Idiomas (i18n)

- **3 idiomas:** Portugues (pt_BR), Ingles (en), Espanhol (es)
- **13 arquivos de traducao por idioma:** activity, auth, common, dashboard, employee, grupo, inventory, logs, messages, nav, notebook, pagination, settings, user
- **Seletor de idioma:** componente `<x-lang-switcher />` no navbar, persistido em cookie
- **Cobertura:** todas as views Blade, controllers, exports, logs de atividade, mensagens flash

---

## Dark Mode

Implementado via CSS customizado no `layouts/app.blade.php` — seletor `.dark` no `<html>`:

- Backgrounds: `slate-900` / `slate-800`
- Cards: `slate-800` com borda `slate-700`
- Inputs: `slate-700` bg, `slate-600` border
- Badges: mapeamento manual para todas as cores
- Toggle via `localStorage` -> `app_settings.theme`

---

## Setup

### Pre-requisitos

- PHP >= 8.3 (testado com 8.5.8)
- Composer
- Node.js >= 18
- SQLite (dev) ou MySQL/PostgreSQL

### Instalacao

```bash
git clone https://github.com/BernardoDiniz-1898/Projeto-Inventario-de-Ativos-Corporativo.git
cd Projeto-Inventario-de-Ativos-Corporativo

composer install
npm install

cp .env.example .env
php artisan key:generate

touch database/database.sqlite
php artisan migrate
php artisan db:seed

npm run build
php artisan serve
```

### Acesso

| URL | Credenciais |
|---|---|
| `http://localhost:8000` | `admin@example.com` / `password` |

---

## Comandos Uteis

```bash
php artisan serve              # Servidor dev
php artisan migrate            # Rodar migrations
php artisan migrate:refresh    # Reset + re-run
php artisan db:seed            # Popular com dados fake
php artisan tinker             # REPL
php artisan route:list         # Listar rotas
php artisan view:clear         # Limpar cache de views
npm run dev                    # Vite hot reload
npm run build                  # Build producao
```

---

## Notas Tecnicas

- **FK:** `notebooks.funcionario_id -> employees.id` com `nullOnDelete`
- **FK:** `notebooks.grupo_id -> grupos.id` com `nullOnDelete`
- **FK:** `employees.grupo_id -> grupos.id` com `nullOnDelete`
- **Grupo:** soft deletes, slug auto-gerado, cor hex, integrado a notebooks/employees/inventario/dashboard
- **Validation:** unique rules usam `{column},{id}` para ignorar registro atual no update
- **Blade:** nao usa `function` dentro de `@php` (causava ParseError)
- **Alpine.js:** dados de funcionarios passados via `window._employeesData` em `<script>` usando `@js()`
