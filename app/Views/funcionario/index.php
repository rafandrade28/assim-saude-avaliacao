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
                <h3 class="card-title">Pesquisar Funcionário</h3>
            </div>
            <div class="card-body">
                <form action="/assim-saude/funcionario/pesquisar" method="GET" class="form-inline">
                    <div class="form-group mr-3">
                        <label for="pesquisa-nome" class="mr-2">Nome:</label>
                        <input type="text" name="nome" id="pesquisa-nome" class="form-control" value="<?= htmlspecialchars($termoNome ?? '') ?>">
                    </div>
                    <div class="form-group mr-3">
                        <label for="pesquisa-cpf" class="mr-2">CPF:</label>
                        <input type="text" name="cpf" id="pesquisa-cpf" class="form-control mascara-cpf" maxlength="14" value="<?= htmlspecialchars($termoCpf ?? '') ?>">
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Pesquisar</button>
                    <a href="/assim-saude/funcionario" class="btn btn-default ml-2">Limpar</a>
                </form>
            </div>
        </div>

        <!-- 2. Tabela de Resultados -->
        <div class="card">
            <div class="card-body table-responsive p-0" style="max-height: 300px;">
                <table class="table table-hover table-head-fixed text-nowrap">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>Telefone</th>
                            <th>Cargo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($funcionarios)): ?>
                            <?php foreach ($funcionarios as $func): ?>
                                <tr style="cursor: pointer;" 
                                    onclick="carregarFormulario(this)"
                                    data-id="<?= $func->id ?>"
                                    data-nome="<?= htmlspecialchars($func->nome) ?>"
                                    data-datanascimento="<?= $func->dataNascimento ?>"
                                    data-cep="<?= htmlspecialchars($func->cep) ?>"
                                    data-logradouro="<?= htmlspecialchars($func->logradouro) ?>"
                                    data-numero="<?= htmlspecialchars($func->numero) ?>"
                                    data-complemento="<?= htmlspecialchars($func->complemento) ?>"
                                    data-bairro="<?= htmlspecialchars($func->bairro) ?>"
                                    data-municipio="<?= htmlspecialchars($func->municipio) ?>"
                                    data-uf="<?= htmlspecialchars($func->uf) ?>"
                                    data-cpf="<?= htmlspecialchars($func->cpf) ?>"
                                    data-email="<?= htmlspecialchars($func->email) ?>"
                                    data-telefone="<?= htmlspecialchars($func->telefone) ?>"
                                    data-cargoid="<?= $func->cargoId ?>">
                                    
                                    <td><?= htmlspecialchars($func->nome) ?></td>
                                    <td><?= htmlspecialchars($func->cpf) ?></td>
                                    <td><?= htmlspecialchars($func->telefone) ?></td>
                                    <td><?= htmlspecialchars($func->cargo_nome) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">Nenhum funcionário encontrado.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 3. Formulário de Cadastro/Edição -->
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Dados do Funcionário</h3>
            </div>
            <form action="/assim-saude/funcionario/salvar" method="POST" id="form-funcionario">
                <div class="card-body">
                    <input type="hidden" name="id" id="form-id">
                    
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Nome <span class="text-danger">*</span></label>
                            <input type="text" name="nome" id="form-nome" class="form-control" required>
                        </div>
                        <div class="col-md-3 form-group">
                            <label>Data de Nascimento <span class="text-danger">*</span></label>
                            <input type="date" name="dataNascimento" id="form-dataNascimento" class="form-control" required>
                        </div>
                        <div class="col-md-3 form-group">
                            <label>CPF <span class="text-danger">*</span></label>
                            <input type="text" name="cpf" id="form-cpf" class="form-control mascara-cpf" maxlength="14" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2 form-group">
                            <label>CEP</label>
                            <input type="text" name="cep" id="form-cep" class="form-control mascara-cep" maxlength="9">
                            <small id="cep-loading" class="text-primary" style="display:none;">Buscando...</small>
                        </div>
                        <div class="col-md-5 form-group">
                            <label>Logradouro</label>
                            <input type="text" name="logradouro" id="form-logradouro" class="form-control">
                        </div>
                        <div class="col-md-2 form-group">
                            <label>Número</label>
                            <input type="text" name="numero" id="form-numero" class="form-control">
                        </div>
                        <div class="col-md-3 form-group">
                            <label>Complemento</label>
                            <input type="text" name="complemento" id="form-complemento" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>Bairro</label>
                            <input type="text" name="bairro" id="form-bairro" class="form-control">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Município</label>
                            <input type="text" name="municipio" id="form-municipio" class="form-control">
                        </div>
                        <div class="col-md-2 form-group">
                            <label>UF</label>
                            <input type="text" name="uf" id="form-uf" class="form-control" maxlength="2">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>E-mail</label>
                            <input type="email" name="email" id="form-email" class="form-control">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Telefone</label>
                            <input type="text" name="telefone" id="form-telefone" class="form-control mascara-telefone" maxlength="15">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Cargo <span class="text-danger">*</span></label>
                            <select name="cargoId" id="form-cargoId" class="form-control" required>
                                <option value="">Selecione um cargo</option>
                                <?php foreach ($cargos as $cargo): ?>
                                    <option value="<?= $cargo->id ?>"><?= htmlspecialchars($cargo->nome) ?></option>
                                <?php endforeach; ?>
                            </select>
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
    // --- FUNÇÕES DE FLUXO DA TELA ---
    function carregarFormulario(row) {
        document.getElementById('form-id').value = row.dataset.id;
        document.getElementById('form-nome').value = row.dataset.nome;
        document.getElementById('form-dataNascimento').value = row.dataset.datanascimento;
        document.getElementById('form-cep').value = row.dataset.cep;
        document.getElementById('form-logradouro').value = row.dataset.logradouro;
        document.getElementById('form-numero').value = row.dataset.numero;
        document.getElementById('form-complemento').value = row.dataset.complemento;
        document.getElementById('form-bairro').value = row.dataset.bairro;
        document.getElementById('form-municipio').value = row.dataset.municipio;
        document.getElementById('form-uf').value = row.dataset.uf;
        document.getElementById('form-cpf').value = row.dataset.cpf;
        document.getElementById('form-email').value = row.dataset.email;
        document.getElementById('form-telefone').value = row.dataset.telefone;
        document.getElementById('form-cargoId').value = row.dataset.cargoid;
        
        document.getElementById('btn-excluir').style.display = 'inline-block';
        document.getElementById('form-funcionario').scrollIntoView({ behavior: 'smooth' });
    }

    function limparFormulario() {
        document.getElementById('form-funcionario').reset();
        document.getElementById('form-id').value = '';
        document.getElementById('btn-excluir').style.display = 'none';
    }

    function confirmarExclusao() {
        const id = document.getElementById('form-id').value;
        if (id && confirm('Tem certeza que deseja excluir este funcionário?')) {
            window.location.href = '/assim-saude/funcionario/excluir/' + id;
        }
    }

    // --- MÁSCARAS (Vanilla JS) ---
    document.addEventListener('DOMContentLoaded', function() {
        
        // Máscara de CPF (000.000.000-00)
        document.querySelectorAll('.mascara-cpf').forEach(function(input) {
            input.addEventListener('input', function(e) {
                let v = e.target.value.replace(/\D/g, '');
                v = v.replace(/(\d{3})(\d)/, '$1.$2');
                v = v.replace(/(\d{3})(\d)/, '$1.$2');
                v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                e.target.value = v;
            });
        });

        // Máscara de CEP (00000-000)
        const inputCep = document.getElementById('form-cep');
        if (inputCep) {
            inputCep.addEventListener('input', function(e) {
                let v = e.target.value.replace(/\D/g, '');
                v = v.replace(/^(\d{5})(\d)/, '$1-$2');
                e.target.value = v;
            });

            // --- INTEGRAÇÃO VIACEP ---
            inputCep.addEventListener('blur', function(e) {
                let cep = e.target.value.replace(/\D/g, '');
                if (cep.length === 8) {
                    document.getElementById('cep-loading').style.display = 'inline';
                    
                    fetch(`https://viacep.com.br/ws/${cep}/json/` )
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('cep-loading').style.display = 'none';
                            if (!data.erro) {
                                document.getElementById('form-logradouro').value = data.logradouro;
                                document.getElementById('form-bairro').value = data.bairro;
                                document.getElementById('form-municipio').value = data.localidade;
                                document.getElementById('form-uf').value = data.uf;
                                document.getElementById('form-numero').focus();
                            } else {
                                alert('CEP não encontrado.');
                            }
                        })
                        .catch(error => {
                            document.getElementById('cep-loading').style.display = 'none';
                            console.error('Erro ao buscar CEP:', error);
                        });
                }
            });
        }

        // Máscara de Telefone (Fixo e Celular)
        document.querySelectorAll('.mascara-telefone').forEach(function(input) {
            input.addEventListener('input', function(e) {
                let v = e.target.value.replace(/\D/g, '');
                if (v.length <= 10) {
                    v = v.replace(/^(\d{2})(\d)/g, '($1) $2');
                    v = v.replace(/(\d{4})(\d)/, '$1-$2');
                } else {
                    v = v.replace(/^(\d{2})(\d)/g, '($1) $2');
                    v = v.replace(/(\d{5})(\d)/, '$1-$2');
                }
                e.target.value = v;
            });
        });
    });
</script>
