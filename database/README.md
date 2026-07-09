# Estrutura do Banco de Dados - Assim Saúde

Este documento descreve a modelagem de dados do Sistema de Gestão de Funcionários.

## Entidades e Relacionamentos

O sistema possui duas entidades principais com um relacionamento de **1:N (Um para Muitos)**:
- **Um** `Cargo` pode ter **vários** `Funcionários`.
- **Um** `Funcionário` pertence a **apenas um** `Cargo`.

## Tabelas

### 1. `cargo`
Armazena os cargos disponíveis na empresa.
- `id`: Chave Primária (Auto Increment).
- `nome`: Nome do cargo.
- `salario`: Remuneração base do cargo (Decimal 10,2).
- `created_at` / `updated_at`: Controle de auditoria de tempo.

### 2. `funcionario`
Armazena os dados pessoais e de endereço dos colaboradores.
- `id`: Chave Primária (Auto Increment).
- `cpf`: Documento único do funcionário. Possui restrição `UNIQUE` para impedir duplicidade no sistema.
- `cargoId`: Chave Estrangeira (Foreign Key) referenciando `cargo(id)`.
- **Regra de Deleção (RESTRICT)**: Não é possível excluir um cargo se houver funcionários vinculados a ele.
- **Regra de Atualização (CASCADE)**: Se o ID do cargo mudar, a alteração reflete nos funcionários.
- `created_at` / `updated_at`: Controle de auditoria de tempo.

## Índices (Performance)
Foram criados índices nas colunas `cargoId` e `nome` da tabela `funcionario` para otimizar futuras consultas, relatórios e paginações.
