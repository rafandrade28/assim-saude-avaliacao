<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Funcionario;
use App\Models\Cargo;
use PDOException;
use DateTime;

class FuncionarioController extends Controller
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index(): void
    {
        $funcionarioModel = new Funcionario();
        $cargoModel = new Cargo();
        
        $this->view('funcionario/index', [
            'title' => 'Gestão de Funcionários',
            'funcionarios' => $funcionarioModel->listar(),
            'cargos' => $cargoModel->listar(),
            'termoNome' => '',
            'termoCpf' => ''
        ]);
    }

    public function pesquisar(): void
    {
        $nome = $_GET['nome'] ?? '';
        $cpf = $_GET['cpf'] ?? '';
        
        $funcionarioModel = new Funcionario();
        $cargoModel = new Cargo();
        
        if (empty(trim($nome)) && empty(trim($cpf))) {
            $funcionarios = $funcionarioModel->listar();
        } else {
            $funcionarios = $funcionarioModel->pesquisar($nome, $cpf);
        }
        
        $this->view('funcionario/index', [
            'title' => 'Gestão de Funcionários',
            'funcionarios' => $funcionarios,
            'cargos' => $cargoModel->listar(),
            'termoNome' => $nome,
            'termoCpf' => $cpf
        ]);
    }

    public function salvar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /assim-saude/funcionario');
            exit;
        }

        $id = $_POST['id'] ?? '';
        $nome = trim($_POST['nome'] ?? '');
        $dataNascimento = $_POST['dataNascimento'] ?? '';
        $cpf = trim($_POST['cpf'] ?? '');
        $cargoId = $_POST['cargoId'] ?? '';

        // 1. Validação de campos obrigatórios
        if (empty($nome) || empty($dataNascimento) || empty($cpf) || empty($cargoId)) {
            $_SESSION['erro'] = "Os campos Nome, Data de Nascimento, CPF e Cargo são obrigatórios.";
            header('Location: /assim-saude/funcionario');
            exit;
        }

        // 2. Validação Matemática do CPF
        if (!$this->validarCpf($cpf)) {
            $_SESSION['erro'] = "O CPF informado é inválido.";
            header('Location: /assim-saude/funcionario');
            exit;
        }

        // 3. Validação de Data de Nascimento
        if (!$this->validarDataNascimento($dataNascimento)) {
            $_SESSION['erro'] = "A Data de Nascimento é inválida ou não pode ser uma data futura.";
            header('Location: /assim-saude/funcionario');
            exit;
        }

        $funcionarioModel = new Funcionario();
        $funcionarioModel->setNome($nome);
        $funcionarioModel->setDataNascimento($dataNascimento);
        $funcionarioModel->setCep($_POST['cep'] ?? '');
        $funcionarioModel->setLogradouro($_POST['logradouro'] ?? '');
        $funcionarioModel->setNumero($_POST['numero'] ?? '');
        $funcionarioModel->setComplemento($_POST['complemento'] ?? '');
        $funcionarioModel->setBairro($_POST['bairro'] ?? '');
        $funcionarioModel->setMunicipio($_POST['municipio'] ?? '');
        $funcionarioModel->setUf($_POST['uf'] ?? '');
        $funcionarioModel->setCpf($cpf);
        $funcionarioModel->setEmail($_POST['email'] ?? '');
        $funcionarioModel->setTelefone($_POST['telefone'] ?? '');
        $funcionarioModel->setCargoId((int)$cargoId);

        try {
            if (!empty($id)) {
                $funcionarioModel->setId((int)$id);
                if ($funcionarioModel->atualizar()) {
                    $_SESSION['sucesso'] = "Funcionário atualizado com sucesso!";
                } else {
                    $_SESSION['erro'] = "Erro ao atualizar o funcionário.";
                }
            } else {
                if ($funcionarioModel->salvar()) {
                    $_SESSION['sucesso'] = "Funcionário cadastrado com sucesso!";
                } else {
                    $_SESSION['erro'] = "Erro ao cadastrar o funcionário.";
                }
            }
        } catch (PDOException $e) {
            if ($e->getCode() == '23000') {
                $_SESSION['erro'] = "Já existe um funcionário cadastrado com este CPF.";
            } else {
                $_SESSION['erro'] = "Erro no banco de dados: " . $e->getMessage();
            }
        }

        header('Location: /assim-saude/funcionario');
        exit;
    }

    public function excluir(int $id = 0): void
    {
        if ($id > 0) {
            $funcionarioModel = new Funcionario();
            try {
                if ($funcionarioModel->excluir($id)) {
                    $_SESSION['sucesso'] = "Funcionário excluído com sucesso!";
                } else {
                    $_SESSION['erro'] = "Erro ao excluir o funcionário.";
                }
            } catch (PDOException $e) {
                $_SESSION['erro'] = "Erro no banco de dados ao tentar excluir.";
            }
        } else {
            $_SESSION['erro'] = "ID inválido para exclusão.";
        }

        header('Location: /assim-saude/funcionario');
        exit;
    }

    // --- MÉTODOS PRIVADOS DE VALIDAÇÃO ---

    private function validarCpf(string $cpf): bool
    {
        // Extrai somente os números
        $cpf = preg_replace('/[^0-9]/is', '', $cpf);

        // Verifica se tem 11 dígitos
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se foi informada uma sequência de dígitos repetidos (ex: 111.111.111-11)
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Faz o cálculo matemático para validar os dígitos verificadores
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }

    private function validarDataNascimento(string $data): bool
    {
        $d = DateTime::createFromFormat('Y-m-d', $data);
        // Verifica se a data é válida no calendário
        if (!$d || $d->format('Y-m-d') !== $data) {
            return false;
        }
        // Verifica se a data não é no futuro
        $hoje = new DateTime();
        if ($d > $hoje) {
            return false;
        }
        return true;
    }
}
