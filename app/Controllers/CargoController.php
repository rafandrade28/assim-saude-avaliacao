<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Cargo;
use PDOException;

class CargoController extends Controller
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index(): void
    {
        $cargoModel = new Cargo();
        $cargos = $cargoModel->listar();
        
        $this->view('cargo/index', [
            'title' => 'Gestão de Cargos',
            'cargos' => $cargos,
            'termoPesquisa' => ''
        ]);
    }

    public function pesquisar(): void
    {
        $nome = $_GET['nome'] ?? '';
        $cargoModel = new Cargo();
        
        if (empty(trim($nome))) {
            $cargos = $cargoModel->listar();
        } else {
            $cargos = $cargoModel->pesquisarPorNome($nome);
        }
        
        $this->view('cargo/index', [
            'title' => 'Gestão de Cargos',
            'cargos' => $cargos,
            'termoPesquisa' => $nome
        ]);
    }

    public function salvar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /assim-saude/cargo');
            exit;
        }

        $id = $_POST['id'] ?? '';
        $nome = trim($_POST['nome'] ?? '');
        $salario = $_POST['salario'] ?? '';

        // Validações
        if (empty($nome)) {
            $_SESSION['erro'] = "O campo Nome é obrigatório.";
            header('Location: /assim-saude/cargo');
            exit;
        }

        if ($salario === '' || $salario < 0) {
            $_SESSION['erro'] = "O campo Salário é obrigatório e não pode ser negativo.";
            header('Location: /assim-saude/cargo');
            exit;
        }

        $cargoModel = new Cargo();
        $cargoModel->setNome($nome);
        $cargoModel->setSalario((float)$salario);

        if (!empty($id)) {
            // Atualizar
            $cargoModel->setId((int)$id);
            if ($cargoModel->atualizar()) {
                $_SESSION['sucesso'] = "Cargo atualizado com sucesso!";
            } else {
                $_SESSION['erro'] = "Erro ao atualizar o cargo.";
            }
        } else {
            // Inserir
            if ($cargoModel->salvar()) {
                $_SESSION['sucesso'] = "Cargo cadastrado com sucesso!";
            } else {
                $_SESSION['erro'] = "Erro ao cadastrar o cargo.";
            }
        }

        header('Location: /assim-saude/cargo');
        exit;
    }

    public function excluir(int $id = 0): void
    {
        if ($id > 0) {
            $cargoModel = new Cargo();
            try {
                if ($cargoModel->excluir($id)) {
                    $_SESSION['sucesso'] = "Cargo excluído com sucesso!";
                } else {
                    $_SESSION['erro'] = "Erro ao excluir o cargo.";
                }
            } catch (PDOException $e) {
                if ($e->getCode() == '23000') {
                    $_SESSION['erro'] = "Não é possível excluir este cargo pois existem funcionários vinculados a ele.";
                } else {
                    $_SESSION['erro'] = "Erro no banco de dados ao tentar excluir.";
                }
            }
        } else {
            $_SESSION['erro'] = "ID inválido para exclusão.";
        }

        header('Location: /assim-saude/cargo');
        exit;
    }
}
