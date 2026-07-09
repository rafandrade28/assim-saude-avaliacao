<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Funcionario;
use App\Models\Cargo;

class RelatorioController extends Controller
{
    public function index(): void
    {
        $funcionarioModel = new Funcionario();
        $cargoModel = new Cargo();
        
        $this->view('relatorio/index', [
            'title' => 'Relatório de Funcionários',
            'dados' => $funcionarioModel->relatorio(),
            'cargos' => $cargoModel->listar(),
            'termoNome' => '',
            'termoCargo' => ''
        ]);
    }

    public function pesquisar(): void
    {
        $nome = $_GET['nome'] ?? '';
        $cargoId = $_GET['cargoId'] ?? '';
        
        $funcionarioModel = new Funcionario();
        $cargoModel = new Cargo();
        
        $this->view('relatorio/index', [
            'title' => 'Relatório de Funcionários',
            'dados' => $funcionarioModel->relatorio($nome, $cargoId),
            'cargos' => $cargoModel->listar(),
            'termoNome' => $nome,
            'termoCargo' => $cargoId
        ]);
    }
}
