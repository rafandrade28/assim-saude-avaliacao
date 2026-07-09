<div class="row mt-4">
    <div class="col-12">
        
        <!-- 1. Área de Filtros -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Filtros do Relatório</h3>
            </div>
            <div class="card-body">
                <form action="/assim-saude/relatorio/pesquisar" method="GET" class="form-inline">
                    <div class="form-group mr-3 mb-2">
                        <label for="filtro-nome" class="mr-2">Nome do Funcionário:</label>
                        <input type="text" name="nome" id="filtro-nome" class="form-control" value="<?= htmlspecialchars($termoNome ?? '') ?>">
                    </div>
                    
                    <div class="form-group mr-3 mb-2">
                        <label for="filtro-cargo" class="mr-2">Cargo:</label>
                        <select name="cargoId" id="filtro-cargo" class="form-control">
                            <option value="">Todos os cargos</option>
                            <?php foreach ($cargos as $cargo): ?>
                                <option value="<?= $cargo->id ?>" <?= ($termoCargo == $cargo->id) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cargo->nome) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary mb-2"><i class="fas fa-search"></i> Pesquisar</button>
                    <a href="/assim-saude/relatorio" class="btn btn-default ml-2 mb-2">Limpar</a>
                </form>
            </div>
        </div>

        <!-- 2. Tabela de Resultados -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Resultados</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-striped text-nowrap">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Telefone</th>
                            <th>Cargo</th>
                            <th>Salário (R$)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($dados)): ?>
                            <?php foreach ($dados as $linha): ?>
                                <tr>
                                    <td><?= htmlspecialchars($linha->nome) ?></td>
                                    <td><?= htmlspecialchars($linha->telefone) ?></td>
                                    <td><?= htmlspecialchars($linha->cargo_nome) ?></td>
                                    <td><?= number_format($linha->salario, 2, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">Nenhum registro encontrado com os filtros informados.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
