<?php
$mensagemSucesso = $_SESSION['sucesso'] ?? null;
$mensagemErro = $_SESSION['erro'] ?? null;
unset($_SESSION['sucesso'], $_SESSION['erro']);
?>

<div class="row mt-4">
    <div class="col-12">
        
        <?php if ($mensagemSucesso): ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?= htmlspecialchars($mensagemSucesso) ?>
            </div>
        <?php endif; ?>

        <?php if ($mensagemErro): ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?= htmlspecialchars($mensagemErro) ?>
            </div>
        <?php endif; ?>

        <!-- 1. Área de Pesquisa -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Pesquisar Cargo</h3>
            </div>
            <div class="card-body">
                <form action="/assim-saude/cargo/pesquisar" method="GET" class="form-inline">
                    <div class="form-group mr-2">
                        <label for="pesquisa-nome" class="mr-2">Nome do cargo:</label>
                        <input type="text" name="nome" id="pesquisa-nome" class="form-control" value="<?= htmlspecialchars($termoPesquisa ?? '') ?>">
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Pesquisar</button>
                    <a href="/assim-saude/cargo" class="btn btn-default ml-2">Limpar</a>
                </form>
            </div>
        </div>

        <!-- 2. Tabela de Resultados -->
        <div class="card">
            <div class="card-body table-responsive p-0" style="max-height: 300px;">
                <table class="table table-hover table-head-fixed text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Salário (R$)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($cargos)): ?>
                            <?php foreach ($cargos as $cargo): ?>
                                <tr style="cursor: pointer;" onclick="carregarFormulario(<?= $cargo->id ?>, '<?= htmlspecialchars(addslashes($cargo->nome)) ?>', <?= $cargo->salario ?>)">
                                    <td><?= $cargo->id ?></td>
                                    <td><?= htmlspecialchars($cargo->nome) ?></td>
                                    <td><?= number_format($cargo->salario, 2, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center">Nenhum cargo encontrado.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 3. Formulário de Cadastro/Edição -->
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Dados do Cargo</h3>
            </div>
            <form action="/assim-saude/cargo/salvar" method="POST" id="form-cargo">
                <div class="card-body">
                    <input type="hidden" name="id" id="form-id">
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="form-nome">Nome <span class="text-danger">*</span></label>
                                <input type="text" name="nome" id="form-nome" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="form-salario">Salário <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" min="0" name="salario" id="form-salario" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-default" onclick="limparFormulario()">Novo</button>
                    <button type="submit" class="btn btn-success">Salvar</button>
                    <button type="button" class="btn btn-danger float-right" id="btn-excluir" style="display: none;" onclick="confirmarExclusao()">Excluir</button>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
    function carregarFormulario(id, nome, salario) {
        document.getElementById('form-id').value = id;
        document.getElementById('form-nome').value = nome;
        document.getElementById('form-salario').value = salario;
        
        document.getElementById('btn-excluir').style.display = 'inline-block';
        document.getElementById('form-cargo').scrollIntoView({ behavior: 'smooth' });
    }

    function limparFormulario() {
        document.getElementById('form-id').value = '';
        document.getElementById('form-nome').value = '';
        document.getElementById('form-salario').value = '';
        
        document.getElementById('btn-excluir').style.display = 'none';
    }

    function confirmarExclusao() {
        const id = document.getElementById('form-id').value;
        if (id && confirm('Tem certeza que deseja excluir este cargo?')) {
            window.location.href = '/assim-saude/cargo/excluir/' + id;
        }
    }
</script>
