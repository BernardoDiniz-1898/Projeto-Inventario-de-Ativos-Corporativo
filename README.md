# Keep Inventory — Sistema de Gestão de Ativos Corporativos

Sistema web para inventário de notebooks e funcionários corporativos, com CRUD completo, dashboards, exportação Excel, autenticação com controle de acesso por papéis (RBAC), log de atividades, conformidade ISO 27001 e tema personalizável.

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

## Funcionalidades

- **CRUD Notebooks** — 30+ campos incluindo ISO 27001 (classificação, localização, ciclo de vida, segurança, manutenção)
- **CRUD Funcionários** — dados cadastrais, centro de custo, projeto, vinculação a notebooks
- **CRUD Usuários** — admin cria/edita/exclui usuários com roles
- **Dashboard** — stats cards, gráficos por marca/departamento, entradas recentes
- **Exportação Excel** — notebooks e funcionários em `.xlsx` via OpenSpout
- **RBAC** — 3 papéis: admin, editor, viewer
- **Log de Atividades** — diffs inline (campo: antigo → novo) com polimorfismo
- **ISO 27001** — gestão de ativos com 17 campos de conformidade
- **Dark Mode** — tema escuro via CSS customizado
- **Configurações** — tema, fonte, cor de destaque (localStorage)

---

## Estrutura do Projeto

```
├── app/
│   ├── Exports/
│   │   ├── EmployeeExport.php              # Exportação XLSX de funcionários
│   │   └── NotebookExport.php              # Exportação XLSX de notebooks (33 colunas)
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   └── UserController.php      # CRUD usuários + updateRole
│   │   │   ├── Auth/
│   │   │   │   ├── LoginController.php
│   │   │   │   └── RegisterController.php
│   │   │   ├── EmployeeController.php      # CRUD + export + logs
│   │   │   ├── NotebookController.php      # CRUD + export + logs + ISO validation
│   │   │   └── SettingsController.php
│   │   └── Middleware/
│   │       └── RoleMiddleware.php           # RBAC: aceita múltiplos papéis
│   ├── Models/
│   │   ├── ActivityLog.php                 # Polimórfico (MorphMany)
│   │   ├── Employee.php
│   │   ├── Notebook.php                    # 30+ fillable, ISO accessors
│   │   └── User.php
│   └── Traits/
│       └── LogsChanges.php                 # Trait reutilizável para logging
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
│   │   └── 2025_07_10_000007_add_data_entrega_to_notebooks_table.php
│   └── seeders/
│       └── DatabaseSeeder.php              # 1 user, 15 employees, 20 notebooks
├── resources/
│   ├── css/app.css                         # Tailwind + dark mode overrides
│   ├── js/app.js                           # Alpine.js + searchableSelect
│   └── views/
│       ├── layouts/app.blade.php           # Layout principal + dark theme CSS
│       ├── components/activity-log.blade.php
│       ├── auth/{login,register}.blade.php
│       ├── dashboard.blade.php
│       ├── notebooks/{index,create,edit,show}.blade.php
│       ├── notebooks/_iso_fields.blade.php # Partial ISO 27001 (226 linhas)
│       ├── employees/{index,create,edit,show}.blade.php
│       ├── settings/index.blade.php
│       └── admin/users/{index,create,edit}.blade.php
├── routes/web.php                           # 35 rotas
├── bootstrap/app.php                        # Middleware alias
└── README.md
```

---

## Schema do Banco de Dados

### Tabela `notebooks`

| Coluna | Tipo | Restrições | ISO 27001 |
|---|---|---|---|
| `id` | bigint (PK) | auto-increment | — |
| `marca` | string | required | — |
| `modelo` | string | required | — |
| `numero_serie` | string | unique, required | — |
| `patrimonio` | string | unique, nullable | — |
| `status` | enum(9) | required, default `em_uso` | — |
| `funcionario_id` | bigint (FK) | nullable → `employees.id`, `nullOnDelete` | — |
| `data_entrega` | date | nullable | — |
| `sistema_operacional` | string | nullable | — |
| `ram_gb` | decimal(5,1) | nullable | — |
| `armazenamento` | string | nullable | — |
| `processador` | string | nullable | — |
| `data_aquisicao` | date | nullable | — |
| `data_garantia` | date | nullable, `>= data_aquisicao` | — |
| `observacoes` | text | nullable | — |
| `forncedor` | string | nullable | — |
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

**Status possíveis:** `disponivel`, `em_uso`, `manutencao`, `ocioso`, `devolvido`, `obsoleto`, `baixa`, `extraviado`, `transferido`

**Classificação (ISO A.5.12):** `publica`, `interna`, `restrita`, `confidencial`

**Criticidade:** `baixo`, `medio`, `alto`, `critico`

**Motivo da baixa:** `obsolescencia`, `avaria`, `furto`, `descarte_seguro`, `doacao`, `venda`, `transferencia`

**Método de descarte:** `destruicao_fisica`, `reciclagem`, `limpeza_dados`, `doacao`, `venda`

**Status patches:** `atualizado`, `desatualizado`, `critico`, `nao_verificado`

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
| `status` | enum(4) | `ativo`, `afastado`, `desligado`, `ferias` |
| `data_admissao` | date | nullable |
| `observacoes` | text | nullable |
| `created_at` / `updated_at` | timestamps | — |

### Tabela `users`

| Coluna | Tipo | Restrições |
|---|---|---|
| `id` | bigint (PK) | auto-increment |
| `name` | string | required |
| `email` | string | unique |
| `email_verified_at` | timestamp | nullable |
| `password` | string | hashed |
| `role` | string | default `viewer` |
| `remember_token` | string | nullable |
| `created_at` / `updated_at` | timestamps | — |

### Tabela `activity_logs` (polimórfica)

| Coluna | Tipo | Restrições |
|---|---|---|
| `id` | bigint (PK) | auto-increment |
| `loggable_type` | string | ex: `App\Models\Notebook` |
| `loggable_id` | bigint | índice composto |
| `action` | string | `created`, `updated`, `deleted` |
| `description` | text | nullable |
| `old_values` | json | nullable |
| `new_values` | json | nullable |
| `user_id` | bigint (FK) | nullable → `users.id`, `nullOnDelete` |
| `created_at` / `updated_at` | timestamps | — |

### Relacionamentos

```
User ──────── 1:N ──── ActivityLog
Employee ──── 1:N ──── Notebook     (via funcionario_id, nullOnDelete)
Employee ──── 1:N ──── ActivityLog  (MorphMany)
Notebook ──── 1:N ──── ActivityLog  (MorphMany)
```

---

## Mapa de Rotas (35 rotas)

### Públicas (sem auth)

| Método | URI | Controller | Nome |
|---|---|---|---|
| `GET` | `/` | redirect → `/login` | — |
| `GET` | `/login` | `LoginController@showLoginForm` | `login` |
| `POST` | `/login` | `LoginController@login` | — |
| `POST` | `/logout` | `LoginController@logout` | `logout` |
| `GET` | `/register` | `RegisterController@showRegistrationForm` | `register` |
| `POST` | `/register` | `RegisterController@register` | — |

### Autenticadas (auth)

| Método | URI | Controller | Nome |
|---|---|---|---|
| `GET` | `/dashboard` | Closure | `dashboard` |
| `GET` | `/settings` | `SettingsController@index` | `settings.index` |
| `POST` | `/settings` | `SettingsController@update` | `settings.update` |

### Admin + Editor (role:admin,editor)

| Método | URI | Nome |
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

### Admin only (role:admin)

| Método | URI | Nome |
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

| Papel | Notebooks/Funcionários | Usuários | Visualiza |
|---|---|---|---|
| `admin` | CRUD + Export | CRUD + Role | Tudo |
| `editor` | CRUD + Export | — | Tudo |
| `viewer` | — | — | Leitura |

- **Middleware:** `App\Http\Middleware\RoleMiddleware` — alias `role` em `bootstrap/app.php`
- **Default:** novos usuários recebem `viewer`
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
- **Polimórfico:** `activity_logs` com `loggable_type` + `loggable_id`
- **Diffs:** compara old vs new, mostra apenas campos alterados
- **Labels:** todos os 30+ campos mapeados para nomes legíveis (ex: `funcionario_id` → "Responsável")
- **Componente:** `<x-activity-log :logs="$logs" />` — diff inline: `campo: antigo (vermelho riscado) → novo (verde)`

---

## Exportação Excel

- **Lib:** `openspout/openspout` v5.7.2 (substituiu `maatwebsite/excel` — incompatível com PHP 8.5.8)
- **Notebooks:** 33 colunas (básicos + ISO 27001 completos)
- **Funcionários:** 14 colunas
- **Filtro:** por status via query string (`?status=em_uso`)

---

## Tema Dark

Implementado via CSS customizado no `layouts/app.blade.php` — seletor `.dark` no `<html>`:

- Backgrounds: `slate-900` / `slate-800`
- Cards: `slate-800` com borda `slate-700`
- Inputs: `slate-700` bg, `slate-600` border
- Badges: mapeamento manual para todas as cores
- Toggle via `localStorage` → `app_settings.theme`

---

## Setup

### Pré-requisitos

- PHP >= 8.3 (testado com 8.5.8)
- Composer
- Node.js >= 18
- SQLite (dev) ou MySQL/PostgreSQL

### Instalação

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

## Comandos Úteis

```bash
php artisan serve              # Servidor dev
php artisan migrate            # Rodar migrations
php artisan migrate:refresh    # Reset + re-run
php artisan db:seed            # Popular com dados fake
php artisan tinker             # REPL
php artisan route:list         # Listar rotas
npm run dev                    # Vite hot reload
npm run build                  # Build produção
```

---

## Notas Técnicas

- **`forncedor`** — typo no schema (deveria ser `fornecedor`), presente em todos os arquivos, não causa erro mas está permanentemente incorreto no banco
- **FK:** `notebooks.funcionario_id → employees.id` com `nullOnDelete`
- **Validation:** unique rules usam `{column},{id}` para ignorar registro atual no update
- **Blade:** não usa `function` dentro de `@php` (causava ParseError)
- **Alpine.js:** dados de funcionários passados via `window._employeesData` em `<script>` usando `@js()`
