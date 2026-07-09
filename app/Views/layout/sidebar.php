<?php
// Captura a URL atual para determinar qual menu deve ficar ativo
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Lógica de identificação das rotas
$isHome = ($uri === '/assim-saude/' || $uri === '/assim-saude/index.php' || $uri === '/assim-saude');
$isCargo = strpos($uri, '/assim-saude/cargo') === 0;
$isFuncionario = strpos($uri, '/assim-saude/funcionario') === 0;
$isRelatorio = strpos($uri, '/assim-saude/relatorio') === 0;

// Lógica para manter os menus "pai" abertos
$isCadastroOpen = $isCargo || $isFuncionario;
$isRelatorioOpen = $isRelatorio;
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Logo -->
    <a href="/assim-saude/" class="brand-link">
        <span class="brand-text font-weight-light">Assim Saúde</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                <!-- Início -->
                <li class="nav-item">
                    <a href="/assim-saude/" class="nav-link <?= $isHome ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Início</p>
                    </a>
                </li>

                <!-- Cadastro (Menu Dropdown) -->
                <li class="nav-item <?= $isCadastroOpen ? 'menu-open' : '' ?>">
                    <a href="#" class="nav-link <?= $isCadastroOpen ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            Cadastro
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/assim-saude/cargo" class="nav-link <?= $isCargo ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Cargo</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/assim-saude/funcionario" class="nav-link <?= $isFuncionario ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Funcionário</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Relatórios (Menu Dropdown) -->
                <li class="nav-item <?= $isRelatorioOpen ? 'menu-open' : '' ?>">
                    <a href="#" class="nav-link <?= $isRelatorioOpen ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>
                            Relatórios
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/assim-saude/relatorio" class="nav-link <?= $isRelatorio ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Funcionários</p>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>
    </div>
</aside>
