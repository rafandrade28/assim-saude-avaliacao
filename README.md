<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/d0bd814b-aad7-44c6-806b-2c82d70e88b0" /># Avaliação Técnica – Desenvolvedor PHP | Assim Saúde

## Objetivo

Este projeto foi desenvolvido como parte da avaliação técnica para a vaga de Desenvolvedor PHP da Assim Saúde.

A aplicação consiste em um sistema web para gerenciamento de cargos e funcionários, desenvolvido utilizando arquitetura MVC (Model-View-Controller), Programação Orientada a Objetos (POO), PHP e MySQL, conforme especificado no desafio proposto.

---

# Tecnologias Utilizadas

* PHP 8.2
* Apache 2.4 (Laragon)
* MySQL 8.4
* HTML5
* CSS3
* JavaScript (Vanilla JS)
* AdminLTE 3
* PDO (PHP Data Objects)

---

# Arquitetura

O projeto foi desenvolvido seguindo o padrão MVC (Model-View-Controller).

A separação de responsabilidades foi adotada da seguinte forma:

### Model

Responsável pelo acesso ao banco de dados e persistência das informações.

Toda consulta SQL está concentrada exclusivamente nesta camada.

### Controller

Responsável pelo fluxo da aplicação, tratamento das requisições, validações de regras de negócio e comunicação entre Model e View.

### View

Responsável apenas pela apresentação dos dados ao usuário.

Não possui regras de negócio nem consultas SQL.

---

# Estrutura do Projeto

```text
app/
│
├── Controllers/
├── Models/
├── Views/
│
Core/
│
database/
│
public/
```

---

# Funcionalidades Implementadas

## Cadastro de Cargos

* Cadastro
* Alteração
* Exclusão
* Pesquisa por nome

Campos:

* Nome
* Salário

---

## Cadastro de Funcionários

* Cadastro
* Alteração
* Exclusão
* Pesquisa por Nome
* Pesquisa por CPF

Campos:

* Nome
* Data de Nascimento
* CEP
* Logradouro
* Número
* Complemento
* Bairro
* Município
* UF
* CPF
* E-mail
* Telefone
* Cargo

---

## Relatório

Relatório contendo:

* Nome
* Telefone
* Cargo
* Salário

Filtros disponíveis:

* Nome
* Cargo

---

# Regras de Negócio

Foram implementadas as seguintes regras:

* Não permitir CPF inválido.
* Não permitir CPF duplicado.
* Não permitir data de nascimento inválida.
* Não permitir salário negativo.
* Campos obrigatórios validados no backend.

---

# Diferenciais Implementados

Além dos requisitos solicitados no desafio, foram implementados os seguintes diferenciais:

* Máscaras para CPF, CEP e Telefone utilizando JavaScript puro.
* Integração com a API ViaCEP para preenchimento automático do endereço.
* Prepared Statements em todas as consultas SQL.
* Organização em arquitetura MVC.
* Programação Orientada a Objetos.
* Layout utilizando AdminLTE 3.

---

# API Externa

ViaCEP

Utilizada para preenchimento automático do endereço através do CEP informado pelo usuário.

---

# Banco de Dados

Nome do banco:

```sql
assim_saude
```

Tabelas:

```text
cargo

funcionario
```

Importe o arquivo:

```text
database/script.sql
```

---

# Como Executar o Projeto

## Pré-requisitos

* PHP 8.2
* Apache 2.4
* MySQL 8.4

Recomendado o Laragon (ou ambiente equivalente)

---

## Passo 1

Clone o repositório.

```bash
git clone https://github.com/rafandrade28/assim-saude-avaliacao.git
```

---

## Passo 2

Coloque o projeto na pasta:

```text
C:\laragon\www\
```

---

## Passo 3

Crie o banco:

```text
assim_saude
```

---

## Passo 4

Execute:

```text
database/script.sql
```

---

## Passo 5

Configure o arquivo:

```text
app/config.php
```

Informando:

* Host
* Banco
* Usuário
* Senha

---

## Passo 6

Inicie o Apache e o MySQL.

---

## Passo 7

Acesse:

```text
http://localhost/assim-saude/
```

---

# Estrutura das Rotas

Página inicial

```text
/
```

Cadastro de Cargos

```text
/cargo
```

Cadastro de Funcionários

```text
/funcionario
```

Relatórios

```text
/relatorio
```

---

# Decisões Técnicas

Durante o desenvolvimento foram adotadas algumas decisões visando organização, segurança e facilidade de manutenção:

* Utilização da arquitetura MVC para separar responsabilidades.
* Centralização das consultas SQL na camada Model.
* Uso de PDO com Prepared Statements para reduzir riscos de SQL Injection.
* Reutilização da conexão com o banco através de uma implementação Singleton.
* Reutilização do layout AdminLTE em todas as telas para manter consistência visual.

---

# Guia para Evolução do Sistema

## Como adicionar um novo campo

1. Atualizar a estrutura da tabela no banco de dados.
2. Adicionar o atributo correspondente no Model.
3. Atualizar os métodos de inserção, atualização e consulta.
4. Implementar validações necessárias no Controller.
5. Atualizar a View para exibir o novo campo.
6. Executar os testes de cadastro, edição, pesquisa e relatório.

---

## Como adicionar uma nova funcionalidade

Para manter a arquitetura do projeto:

1. Criar o Model correspondente.
2. Criar o Controller.
3. Criar a View.
4. Configurar a rota.
5. Adicionar a opção no menu lateral.
6. Testar o fluxo completo da funcionalidade.

---

# Boas Práticas Adotadas

* SQL apenas na camada Model.
* Controllers responsáveis apenas pelo fluxo da aplicação.
* Views sem regras de negócio.
* Prepared Statements em todas as consultas.
* Reutilização do layout padrão.
* Separação de responsabilidades seguindo o padrão MVC.

---

# Autor

Projeto desenvolvido como parte da avaliação técnica para a vaga de Desenvolvedor da Assim Saúde.
