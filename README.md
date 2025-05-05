# Radar LCC

Introdução
O Radar LCC é um sistema web desenvolvido em Laravel 11 (PHP 8.2) voltado para gestão e análise de custos do ciclo de vida (LCC – Life Cycle Cost). Ele permite controlar ativos físicos, despesas de capital (CAPEX) e despesas operacionais (OPEX), gerenciar empresas e usuários, além de realizar estudos econômicos (como curva LCC e valor presente). O sistema também inclui integrações como pagamentos via PagSeguro, editor de texto enriquecido TinyMCE e geração de relatórios em PDF com mPDF.

# Tecnologias

O projeto utiliza tecnologias modernas de back-end e front-end, incluindo:

## Laravel 11 (PHP 8.2)
 Framework PHP para a lógica do servidor, rotas, autenticação e models.
## MySQL
 Banco de dados relacional (padrão Laravel) para armazenamento das tabelas.
## Bootstrap 4.1.3 e TailwindCSS 3
 Frameworks CSS para estilização de interfaces.
## Alpine.js
 Para interações dinâmicas leves no front-end.
## TinyMCE
 Editor de texto enriquecido utilizado em formulários HTML (via componente Blade).
## PagSeguro
 Integração de pagamentos (configurada em config/pagseguro.php).
## mPDF
 Biblioteca PHP para geração de arquivos PDF (usada em relatórios de estudo).
## Laravel Breeze
 Scaffold de autenticação (login/registro/confirmar senha) instalado para gerenciar usuários.
## PestPHP/PHPUnit
 Frameworks de testes automatizados para garantir qualidade do código.



# Instalação

Antes de tudo, certifique-se de ter instalados PHP 8.2 e Composer, além de um servidor MySQL configurado. Também é necessário Node.js (para o processamento de assets via Vite). Os requisitos detalhados estão em Requisitos.txt.

1. Clonar o repositório:
```bash
git clone https://github.com/devquimy/radar-lcc.git
cd radar-lcc
```

2. Instalar dependências PHP:
```bash
composer install
```

3. Instalar dependências JavaScript:
```bash
npm install
npm run dev   # Compila os assets front-end (ou npm run build para produção)
```

4. Configurar variáveis de ambiente:

Copie o arquivo de exemplo .env.example para .env.
No .env, defina as credenciais do banco de dados (DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD) e as chaves de API do PagSeguro (PAGSEGURO_TOKEN, PAGSEGURO_SANDBOX, PAGSEGURO_NOTIFICATION).

Gere a chave da aplicação:
```bash
 php artisan key:generate.
```

5. Banco de dados e migrações:
```bash
php artisan migrate
php artisan db:seed    # Se houver seeders configurados (opcional)
```

Os arquivos de migração em database/migrations/ criam as tabelas users, cache e jobs. Outros modelos precisam de tabelas que podem ser criadas manualmente ou por migrações adicionais.




## Estrutura do Projeto

Abaixo está um resumo da estrutura do projeto, com explicação dos principais arquivos e pastas:

### `app/` – Código-fonte principal (lógica de negócio)

- `.DS_Store` – Arquivo do macOS (inútil).
- `Helpers/helper.php` – Funções auxiliares globais (ex: `verificarUsuarioLogado()`).
- `Http/Controllers/` – Controladores das requisições:
  - `AtivoFisicoController.php` – CRUD de Ativos Físicos e estudos.
  - `CapexController.php` – CRUD de CAPEX.
  - `CreditoController.php` – Gerencia Créditos e planos.
  - `CreditosUsuariosController.php` – Créditos por usuário.
  - `DocumentosController.php` – Upload/edição de Documentos.
  - `EmpresaController.php` – CRUD de Empresas.
  - `EstudosController.php` – Estudos de LCC, relatórios.
  - `InflacaoController.php` – Índices de Inflação.
  - `NiveisAcessoController.php` – Controle de permissões.
  - `OpexController.php` – CRUD de OPEX.
  - `PedidosController.php` – Geração de Pedidos (com PagSeguro).
  - `UsuarioController.php` – CRUD de Usuários e vínculo com empresas.
  - Subpasta `Auth/` – Autenticação (Laravel Breeze).
  - `ProfileController.php` – Perfil do usuário logado.
- `Http/Requests/` – Validação de requisições:
  - `Auth/LoginRequest.php`, `ProfileUpdateRequest.php`.
- `Models/` – Modelos Eloquent:
  - Econômicos: `AtivoFisico`, `Capex`, `Opex`, `Inflacao`, `ValorPresente`, etc.
  - Créditos: `Credito`, `CreditoUsuario`, `HistoricoTransacaoCredito`.
  - Empresa: `Empresa`, `UserEmpresa`, `LogRemocaoEmpresa`.
  - Outros: `Estudo`, `NiveisAcesso`, `Pedido`, `User`, `Documento`.
- `Providers/` – Service Providers do Laravel:
  - `AppServiceProvider.php` – (padrão Laravel).
- `View/Components/` – Componentes Blade:
  - `AppLayout`, `GuestLayout`, `Forms/tinymceEditor.php`, `Head/tinymceConfig.php`.

### `config/` – Configurações

- `app.php`, `auth.php`, `cache.php`, `database.php`, `filesystems.php`, `logging.php`, `mail.php`, `queue.php`, `services.php`, `session.php`.
- `pagseguro.php` – Configuração da API do PagSeguro.

### `templates_layout/` – Templates PHP antigos

- Ex: `ativos_fisicos_form.php`, `capex_form.php`, `curva_lcc.php`, `creditos.php`, `timeline.php`, etc.

### `routes/` – Definição das rotas

- `web.php` – Rotas principais.
- `auth.php` – Login, registro, etc.
- `console.php` – Comandos personalizados.

### `database/` – Banco de dados

- `migrations/` – Tabelas padrão (`users`, `cache`, `jobs`).
- `seeders/` – `DatabaseSeeder.php` (sem dados por padrão).

### `resources/` – Front-end

- `views/` – Blade templates por domínio:
  - Pastas: `ativo_fisico/`, `capex/`, `documento/`, `estudo/`, etc.
  - `layouts/`, `components/`, arquivos soltos como `login.blade.php`, `welcome.blade.php`.
- Assets são gerados via Vite (ficam em `public/`).

### `public/` – Arquivos públicos

- `index.php` – Front controller.
- `css/`, `js/`, `img/`, `webfonts/` – Assets compilados.
- Outros: `.htaccess`, `favicon.ico`, `robots.txt`, `termo_uso.docx`.

### `tests/` – Testes automatizados

- `Feature/`, `Unit/` – Testes de funcionalidade e unidade.
- `Pest.php`, `TestCase.php` – Configuração de testes.

### Arquivos na raiz do projeto

- `artisan` – CLI do Laravel.
- `composer.json`, `composer.lock` – Dependências PHP.
- `package.json`, `vite.config.js`, `tailwind.config.js`, `postcss.config.js` – Front-end (Vite, Tailwind).
- `phpunit.xml` – Configuração de testes.
- `Requisitos.txt` – Requisitos mínimos (PHP 8.2, MySQL, Laravel 11).
- `.gitignore` – Itens ignorados pelo Git.
- `storage/`, `bootstrap/`, `vendor/` – Pastas internas do Laravel.


# Execução
Após instalação, rode o servidor de desenvolvimento do Laravel:
```bash
php artisan serve
``` 
Isso iniciará a aplicação em http://localhost:8000/. Acesse essa URL no navegador para usar o sistema. Outras dicas de execução:

Se usar Laravel Sail (Docker), execute ./vendor/bin/sail up para iniciar containers (requer configurar arquivo .env).

Para rodar testes automatizados, use:
```bash
./vendor/bin/pest    # ou "php artisan test"
```

Sempre atualize as migrações depois de alterações:
```bash
php artisan migrate:fresh --seed
``` 
Compile assets em produção com:
```bash
npm run build
``` 

# Licença
Este projeto é licenciado sob a licença MIT (conforme definido em composer.json). Isso permite uso e modificação livre do código, desde que se mantenha a atribuição adequada.












## Funcionalidades

- Consulta e visualização de grupos de pesquisa do LCC
- Listagem de pesquisadores associados
- Informações detalhadas sobre projetos e produções científicas
- Integração com dados da Plataforma Lattes via XML
- Interface amigável e organizada para navegação dos dados
- Importação e atualização de currículos Lattes

---

## 🛠️ Tecnologias Utilizadas

- [Laravel 10.x](https://laravel.com/)
- PHP 8.1+
- MySQL / MariaDB
- TailwindCSS (via Laravel Mix)
- Blade (motor de templates Laravel)
- Composer
- Artisan

---

## 📦 Instalação Local

### Pré-requisitos

- PHP >= 8.1
- Composer
- MySQL ou outro banco compatível
- Node.js + npm (para build do frontend)
- Git

### Passo a passo

1. Clone o repositório:

```bash
git clone https://github.com/devquimy/radar-lcc.git
cd radar-lcc
``` 

2. Instale as dependências PHP com o Composer:
```bash
composer install
npm install
```
3. Copie o arquivo .env.example para .env e configure o ambiente:
```bash
cp .env.example .env
```

4. Gere a chave da aplicação:

```bash
php artisan key:generate
```

5. Configure as credenciais do banco de dados no arquivo .env.

6. Rode as migrações para criar o schema do banco:
```bash
php artisan migrate
```

7. Instale as dependências do frontend (opcional, para estilos e scripts):
```bash
php artisan migrate

```
Inicie o servidor local:

bash
Copiar
Editar
php artisan serve
Acesse: http://localhost:8000

🧠 Estrutura do Projeto
bash
Copiar
Editar
app/
│   ├── Helpers/        # Default laravel
│   ├── Http/           # Controllers, Requests
│   ├── Models/         # Modelos Eloquent
│   ├── Profiders/         # Modelos Eloquent
│   ├── Models/         # Modelos Eloquent
│   ├── Models/         # Modelos Eloquent
│   ├── Models/         # Modelos Eloquent
│   └── Services/       # Lógica de negócio e integração externa
resources/
│   └── views/          # Views em Blade
routes/
│   └── web.php         # Rotas da aplicação
database/
│   ├── migrations/     # Migrações do banco
│   └── seeders/        # Dados iniciais
public/                 # Assets públicos
🔄 


✅ Licença
Este projeto está sob a licença MIT. Veja o arquivo LICENSE para mais informações.
---

