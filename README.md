# Keep Inventory — Sistema de Gestao de Ativos Corporativos

Sistema web para inventario de notebooks, funcionarios, localizacoes e grupos corporativos, com CRUD completo, dashboard gerencial, exportacao Excel, autenticacao com controle de acesso por papeis (RBAC), log de atividades, aluguel de ativos, conformidade ISO 27001, suporte a 3 idiomas e tema personalizavel.

**Repositorio:** [github.com/BernardoDiniz-1898/Projeto-Inventario-de-Ativos-Corporativo](https://github.com/BernardoDiniz-1898/Projeto-Inventario-de-Ativos-Corporativo)

---

## Stack Tecnologica

| Camada | Tecnologia | Versao |
|---|---|---|
| Backend | Laravel | 13.x |
| PHP | CLI | 8.5.8 (minimo 8.3) |
| Frontend | Vite + Tailwind CSS v4 | Vite 8.x / Tailwind 4.x |
| JS Interativo | Alpine.js | 3.15.12 |
| DB (dev) | SQLite | — |
| Exportacao Excel | OpenSpout | 5.7.2 |
| i18n | 3 idiomas | pt_BR, en, es |
| OS (dev) | Arch Linux | — |

---

## Funcionalidades

- **CRUD Notebooks** — 30+ campos incluindo ISO 27001 (classificacao, localizacao, ciclo de vida, seguranca, manutencao) e modulo de aluguel (locataria, contrato, valor, periodo)
- **CRUD Funcionarios** — dados cadastrais, centro de custo, projeto, vinculacao a notebooks
- **CRUD Grupos** — organizacao de ativos e funcionarios por grupo (N:M), com cor e slug, soft deletes
- **CRUD Localizacoes** — cadastro de locais (predio, andar, sala) vinculados a grupo, com contagem de notebooks por local
- **Inventario Unificado** — pagina dedicada com visao consolidada de notebooks + funcionarios, filtros (alocados, em estoque, sem equipamento), busca e agrupamento por grupo
- **Dashboard** — stats cards, graficos por marca/departamento/grupo, valor total, garantias vencendo, manutencao pendente, distribuicao por status, compliance de seguranca, alugueis ativos, atividade recente
- **Exportacao Excel** — notebooks e funcionarios em `.xlsx` via OpenSpout, headers traduzidos
- **RBAC** — 3 papeis: admin, editor, viewer
- **Log de Atividades** — diffs inline (campo: antigo -> novo) com polimorfismo, 100% traduzido (3 idiomas)
- **ISO 27001** — gestao de ativos com 17 campos de conformidade
- **Aluguel de ativos** — contratos de locacao com periodo, valor e datas; contabilizado no dashboard
- **Dark Mode** — tema escuro via CSS customizado
- **i18n** — suporte completo a 3 idiomas (pt_BR, en, es) em views, controllers e exports
- **Configuracoes** — tema, fonte, cor de destaque, sidebar (localStorage)

---

## Estrutura do Projeto

```
├── app/
│   ├── Exports/
│   │   ├── EmployeeExport.php              # Exportacao XLSX de funcionarios (14 colunas)
│   │   └── NotebookExport.php              # Exportacao XLSX de notebooks (40 colunas)
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   └── UserController.php      # CRUD usuarios + updateRole
│   │   │   ├── Auth/
│   │   │   │   ├── LoginController.php
│   │   │   │   └── RegisterController.php  # cria usuarios com role viewer
│   │   │   ├── EmployeeController.php      # CRUD + export + logs + grupo filter
│   │   │   ├── GrupoController.php         # CRUD Grupos (soft deletes)
│   │   │   ├── InventoryController.php     # Inventario unificado
│   │   │   ├── LocalizacaoController.php   # CRUD Localizacoes + logs
│   │   │   ├── LocaleController.php        # Troca de idioma (sessao)
│   │   │   ├── NotebookController.php      # CRUD + export + logs + ISO validation
│   │   │   └── SettingsController.php
│   │   ├── Middleware/
│   │   │   ├── RoleMiddleware.php           # RBAC: aceita multiplos papeis
│   │   │   └── SetLocale.php                # Aplica idioma da sessao
│   │   └── Requests/
│   │       ├── Store/Update{Notebook,Employee,Grupo,Localizacao,User}Request.php
│   ├── Models/
│   │   ├── ActivityLog.php                 # Polimorfico (MorphMany)
│   │   ├── Employee.php                    # SoftDeletes, grupos N:M
│   │   ├── Grupo.php                       # SoftDeletes, slug, cor
│   │   ├── Localizacao.php                 # BelongsTo Grupo, HasMany Notebook
│   │   ├── Notebook.php                    # 30+ fillable, ISO accessors, grupos N:M
│   │   └── User.php                        # role + helpers isAdmin/isEditor/isViewer
│   ├── Services/
│   │   └── DashboardService.php            # Stats, graficos, compliance, alugueis
│   └── Traits/
│       └── LogsChanges.php                 # Trait reutilizavel, 100% traduzido
├── database/
│   ├── factories/
│   │   ├── EmployeeFactory.php
│   │   └── NotebookFactory.php
│   ├── migrations/
│   │   ├── 0001_01_01_0000xx_*             # users, cache, jobs (padrao Laravel)
│   │   ├── 2025_07_10_0000xx_*             # notebooks, employees, role, logs, ISO, aluguel
│   │   ├── 2026_07_22_*                    # grupos (N:M via tabelas pivot)
│   │   ├── 2026_07_23_*                    # localizacoes + localizacao_id em notebooks
│   │   ├── 2026_07_27_000001_*             # grupo_id em localizacoes
│   │   └── 2026_08_17_*                    # pivot tables + fix nomes + loggable_id nullable
│   └── seeders/
│       └── DatabaseSeeder.php              # 1 usuario admin
├── lang/
│   ├── pt_BR/                              # 15 arquivos de traducao
│   ├── en/                                 # 15 arquivos de traducao
│   └── es/                                 # 15 arquivos de traducao
├── resources/
│   ├── css/app.css                         # Tailwind + dark mode overrides
│   ├── js/app.js                           # Alpine.js + searchableSelect
│   └── views/
│       ├── layouts/app.blade.php           # Layout principal + dark theme CSS
│       ├── components/
│       │   ├── activity-log.blade.php      # Log com diffs inline traduzido
│       │   ├── lang-switcher.blade.php     # Seletor de idioma (rota /locale/{locale})
│       │   └── ui/                         # Componentes reutilizaveis (avatar, stat-card, etc.)
│       ├── auth/{login,register}.blade.php
│       ├── dashboard.blade.php             # Graficos por marca/departamento/grupo
│       ├── notebooks/{index,create,edit,show}.blade.php
│       ├── notebooks/_iso_fields.blade.php # Partial ISO 27001 + aluguel
│       ├── employees/{index,create,edit,show}.blade.php
│       ├── grupos/{index,create,edit,show}.blade.php
│       ├── localizacoes/{index,create,edit,show}.blade.php
│       ├── inventory/index.blade.php       # Inventario unificado
│       ├── settings/index.blade.php
│       └── admin/users/{index,create,edit}.blade.php
├── routes/web.php                           # 48 rotas web
├── bootstrap/app.php                        # Alias 'role' + middleware SetLocale
├── import_chammas.php                       # Script avulso de importacao (nao usado pelo app)
├── assign_grupos_empresa.php                # Script avulso de atribuicao (nao usado pelo app)
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
| `status` | enum(10) | required, default `em_uso` | — |
| `funcionario_id` | bigint (FK) | nullable -> `employees.id`, `nullOnDelete` | — |
| `localizacao_id` | bigint (FK) | nullable -> `localizacoes.id` | — |
| `data_entrega` | date | nullable | — |
| `sistema_operacional` | string | nullable | — |
| `ram_gb` | decimal(5,1) | nullable | — |
| `armazenamento` | string | nullable | — |
| `processador` | string | nullable | — |
| `data_aquisicao` | date | nullable | — |
| `data_garantia` | date | nullable, `>= data_aquisicao` | — |
| `observacoes` | text | nullable | — |
| `fornecedor` | string | nullable (renomeado de `forncedor`) | — |
| `preco` | decimal | nullable | — |
| `classificacao` | enum(4) | nullable | A.5.12 |
| `localizacao` | string | nullable (texto livre) | A.5.9 |
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
| `empresa_locataria` | string | nullable (aluguel) | — |
| `numero_contrato` | string | nullable (aluguel) | — |
| `valor_aluguel` | decimal(10,2) | nullable (aluguel) | — |
| `periodo_aluguel` | enum(4) | nullable (aluguel) | — |
| `data_inicio_aluguel` | date | nullable (aluguel) | — |
| `data_fim_aluguel` | date | nullable (aluguel) | — |
| `created_at` / `updated_at` | timestamps | — | — |

**Status possiveis (10):** `disponivel`, `em_uso`, `manutencao`, `ocioso`, `devolvido`, `obsoleto`, `baixa`, `extraviado`, `transferido`, `alugado`

**Classificacao (ISO A.5.12):** `publica`, `interna`, `restrita`, `confidencial`

**Criticidade:** `baixo`, `medio`, `alto`, `critico`

**Motivo da baixa:** `obsolescencia`, `avaria`, `furto`, `descarte_seguro`, `doacao`, `venda`, `transferencia`

**Metodo de descarte:** `destruicao_fisica`, `reciclagem`, `limpeza_dados`, `doacao`, `venda`

**Status patches:** `atualizado`, `desatualizado`, `critico`, `nao_verificado`

**Periodo de aluguel:** `mensal`, `trimestral`, `semestral`, `anual`

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

### Tabela `localizacoes`

| Coluna | Tipo | Restricoes |
|---|---|---|
| `id` | bigint (PK) | auto-increment |
| `nome` | string | required |
| `predio` | string | nullable |
| `andar` | string | nullable |
| `sala` | string | nullable |
| `grupo_id` | bigint (FK) | nullable -> `grupos.id` |
| `created_at` / `updated_at` | timestamps | — |

### Tabelas pivot `notebook_grupo` e `employee_grupo`

Grupos se relacionam com notebooks e funcionarios em **muitos-para-muitos** atraves das tabelas pivot `notebook_grupo` e `employee_grupo` (criadas por migracao e alimentadas automaticamente com os dados legados de `grupo_id`):

| Coluna | Tipo | Restricoes |
|---|---|---|
| `id` | bigint (PK) | auto-increment |
| `grupo_id` | bigint (FK) | -> `grupos.id`, `cascadeOnDelete` |
| `notebook_id` / `employee_id` | bigint (FK) | -> tabela correspondente, `cascadeOnDelete` |
| `created_at` / `updated_at` | timestamps | — |
| unique | `(grupo_id, notebook_id)` / `(grupo_id, employee_id)` | — |

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
| `loggable_id` | bigint | nullable (ex: registro excluido) |
| `action` | string | `created`, `updated`, `deleted` |
| `description` | text | nullable |
| `old_values` | json | nullable |
| `new_values` | json | nullable |
| `user_id` | bigint (FK) | nullable -> `users.id`, `nullOnDelete` |
| `created_at` / `updated_at` | timestamps | — |

### Relacionamentos

```
User          1:N  ActivityLog
Localizacao   1:N  Notebook        (via localizacao_id)
Grupo         1:N  Localizacao     (via grupo_id)
Employee      1:N  Notebook        (via funcionario_id, nullOnDelete)
Grupo         N:M  Notebook        (pivot: notebook_grupo)
Grupo         N:M  Employee        (pivot: employee_grupo)
Notebook/Employee/Grupo/Localizacao  MorphMany ActivityLog
```

---

## Mapa de Rotas (48 rotas web)

### Publicas (sem auth)

| Metodo | URI | Controller | Nome |
|---|---|---|---|
| `GET` | `/` | redirect -> `/login` | — |
| `GET` | `/locale/{locale}` | `LocaleController@switch` | `locale.switch` |
| `GET` | `/login` | `LoginController@showLoginForm` | `login` |
| `POST` | `/login` | `LoginController@login` | — |
| `POST` | `/logout` | `LoginController@logout` | `logout` |
| `GET` | `/register` | `RegisterController@showRegistrationForm` | `register` |
| `POST` | `/register` | `RegisterController@register` | — |

### Autenticadas (auth)

| Metodo | URI | Controller | Nome |
|---|---|---|---|
| `GET` | `/dashboard` | Closure + `DashboardService` | `dashboard` |
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
| `GET` | `/localizacoes` | `localizacoes.index` |
| `POST` | `/localizacoes` | `localizacoes.store` |
| `GET` | `/localizacoes/create` | `localizacoes.create` |
| `GET` | `/localizacoes/{localizacao}` | `localizacoes.show` |
| `PUT` | `/localizacoes/{localizacao}` | `localizacoes.update` |
| `DELETE` | `/localizacoes/{localizacao}` | `localizacoes.destroy` |
| `GET` | `/localizacoes/{localizacao}/edit` | `localizacoes.edit` |

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

| Papel | Dashboard/Inventario/Config | Notebooks/Funcionarios/Grupos/Localizacoes | Usuarios |
|---|---|---|---|
| `admin` | Sim | CRUD + Export | CRUD + Alterar Role |
| `editor` | Sim | CRUD + Export | — |
| `viewer` | Somente leitura | — | — |

- **Middleware:** `App\Http\Middleware\RoleMiddleware` — alias `role` em `bootstrap/app.php`, aceita multiplos papeis (`role:admin,editor`)
- **Default:** registros via `/register` recebem `viewer`
- **Admin seed:** `admin@local.com` / `admin123`

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

---

## Log de Atividades

- **Trait:** `App\Traits\LogsChanges` — `logCreate()`, `logUpdate()`, `logDelete()` capazes de ignorar falhas (try-catch) para nao bloquear operacoes CRUD
- **Polimorfico:** `activity_logs` com `loggable_type` + `loggable_id` (nullable)
- **Diffs:** compara old vs new, mostra apenas campos alterados
- **Labels:** todos os 40+ campos mapeados para nomes legiveis, traduzidos em 3 idiomas via `lang/*/logs.php`
- **Componente:** `<x-activity-log :logs="$logs" />` — diff inline: `campo: antigo (vermelho riscado) -> novo (verde)`

---

## Dashboard

Tudo calculado em `App\Services\DashboardService`:

- Stats cards: total, disponiveis, em uso, manutencao, ociosos, total de funcionarios
- Graficos: por marca, por departamento, por grupo (N:M)
- Valor total de ativos (`sum(preco)`)
- Garantias vencendo (proximos 30 dias)
- Manutencao pendente (proximos 30 dias)
- Distribuicao por status (donut)
- Compliance de seguranca (criptografia, antivirus, backup, patches)
- Alugueis ativos (quantidade + total mensal)
- Atividade recente (ultimos 8 logs)
- Entradas recentes e notebooks sem funcionario

---

## Exportacao Excel

- **Lib:** `openspout/openspout` v5.7.2 (substituiu `maatwebsite/excel` — incompativel com PHP 8.5)
- **Notebooks:** 40 colunas (basicos + ISO 27001 completos + aluguel + grupos N:M)
- **Funcionarios:** 14 colunas (incluindo grupos N:M e quantidade de notebooks)
- **Headers:** traduzidos automaticamente via `__()` (3 idiomas)
- **Filtros (notebooks):** status, grupo, sistema operacional, fornecedor, classificacao, criticidade e busca
- **Filtro (funcionarios):** status

---

## Suporte a Idiomas (i18n)

- **3 idiomas:** Portugues (pt_BR), Ingles (en), Espanhol (es)
- **15 arquivos de traducao por idioma:** activity, auth, common, dashboard, employee, grupo, inventory, localizacao, logs, messages, nav, notebook, pagination, settings, user
- **Persistencia:** sessao — middleware `SetLocale` aplica `App::setLocale()` e a rota `GET /locale/{locale}` grava a escolha
- **Seletor de idioma:** componente `<x-lang-switcher />` no navbar
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
| `http://localhost:8000` | `admin@local.com` / `admin123` |

Usuarios criados em `/register` assumem o papel `viewer`; um admin pode promover via `/admin/users`.

---

## Testes

```bash
composer test
```

Includes: `tests/Feature/RbacTest.php` (controle de acesso por papel) e `tests/Feature/NotebookTest.php`.

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
composer run dev               # server + queue + pail + vite (concurrently)
```

---

## Notas Tecnicas

- **Grupos N:M:** `grupo_id` em `notebooks`/`employees` foi substituido por tabelas pivot `notebook_grupo` e `employee_grupo` (migracao replica os dados legados)
- **FK:** `notebooks.funcionario_id -> employees.id` com `nullOnDelete`
- **FK:** `notebooks.localizacao_id -> localizacoes.id`
- **FK:** `localizacoes.grupo_id -> grupos.id`
- **Logs:** `loggable_id` nullable para preservar registros de exclusao
- **Validation:** unique rules usam `{column},{id}` para ignorar registro atual no update
- **Blade:** nao usa `function` dentro de `@php` (causava ParseError); `number_format` movido para blocos `@php`
- **Alpine.js:** dados de funcionarios passados via `window._employeesData` em `<script>` usando `@js()`
- **Scripts avulsos:** `import_chammas.php` e `assign_grupos_empresa.php` sao utilitarios one-off de importacao, nao fazem parte do fluxo da aplicacao
