# CRUD SOLID LSP Demo

Aplicação didática em PHP 8 que gerencia passagens de pedágio. O projeto demonstra a separação em camadas (Domain, Application, Infra e camada pública) com foco nos princípios SOLID: **LSP** (políticas de cálculo de pedágio intercambiáveis), **SRP** (cada classe com responsabilidade única) e **OCP** (novos tipos de veículo entram por novas políticas sem alterar código existente). Os dados são persistidos em um banco SQLite local.

## Requisitos

- PHP 8.0 ou superior com extensão `pdo_sqlite` habilitada
- Composer (para autoload e scripts)
- SQLite 3 (já embutido na maioria das instalações PHP)
- Servidor embutido do PHP ou qualquer servidor web apontando para `public/`

## Estrutura

```
├─ composer.json          # Configura autoload PSR-4 e scripts auxiliares
├─ public/                # Camada de apresentação acessada pelo navegador
│  ├─ index.php           # Lista passagens e mostra ações CRUD
│  ├─ create.php          # Formulário de criação
│  ├─ edit.php            # Formulário de edição
│  ├─ store.php           # Endpoint de gravação
│  ├─ update.php          # Endpoint de atualização
│  └─ delete.php          # Endpoint de exclusão
├─ src/
│  ├─ Domain/             # Entidades, contratos, validador e políticas
│  │  ├─ Passage.php
│  │  ├─ PassageRepository.php
│  │  ├─ PassageValidator.php
│  │  ├─ TollPolicy.php
│  │  ├─ TollCalculator.php
│  │  └─ Policies/        # Estratégias que implementam TollPolicy (LSP/OCP)
│  ├─ Application/
│  │  └─ PassageService.php   # Orquestra regras de negócio
│  └─ Infra/
│     └─ SqlitePassageRepository.php   # Implementação concreta (PDO + SQLite)
├─ storage/
│  ├─ database.sqlite     # Banco SQLite usado pela aplicação
│  └─ migrate.php         # Script de criação da tabela
└─ vendor/
   └─ autoload.php        # Autoloader simples gerado pelo Composer
```

## Passo a passo para rodar localmente

1. **Clonar o repositório**
   ```bash
   git clone <url-do-repositorio>
   cd solid-lsp-excercise
   ```

2. **Instalar dependências e gerar autoload**
   O projeto utiliza apenas bibliotecas padrão, mas o autoload é controlado pelo Composer:
   ```bash
   composer install    # cria a pasta vendor se necessário
   composer dump       # garante autoload atualizado
   ```

3. **Criar/Migrar o banco SQLite**
   ```bash
   composer migrate
   ```
   O script cria `storage/database.sqlite` (se não existir) e garante a tabela `passages`.

4. **Iniciar o servidor de desenvolvimento**
   ```bash
   composer serve
   ```
   O Composer executa `php -S localhost:8000 -t public`, expondo a aplicação.

5. **Acessar a aplicação**
   Abra `http://localhost:8000` no navegador para listar, criar, editar ou excluir passagens. Todas as regras de pedágio são calculadas automaticamente conforme o tipo de veículo informado.

## Observando os princípios SOLID

- **LSP/OCP**: `TollCalculator` (`src/Domain/TollCalculator.php`) depende apenas da interface `TollPolicy`. Novos tipos de veículo são adicionados implementando novas políticas em `src/Domain/Policies/`, sem alterar o cálculo existente.
- **SRP**: Cada classe (validator, repositório, serviço, políticas) cuida de uma responsabilidade única, mantendo baixo acoplamento entre camadas.

## Scripts úteis

- `composer serve` — Sobe o servidor embutido apontando para `public/`.
- `composer migrate` — Cria/atualiza a tabela `passages` no SQLite.
- `composer dump` — Regenera o autoload PSR-4 caso adicione novas classes.

Os dados permanecem em `storage/database.sqlite`. Para reiniciar os registros, remova as linhas da tabela utilizando o SQLite ou delete o arquivo (ele será recriado pelo próximo `composer migrate`).
