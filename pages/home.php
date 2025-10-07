<?php
global $conn;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valkyria</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="/valkyria/public/img/axe2.svg">
    <link href="/valkyria/public/css/main.css" rel="stylesheet">
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <i class="fas fa-truck me-2"></i>VALKYRIA
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 p-0">
            <div class="sidebar px-3">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="javascript:void(0)" data-section="dashboard" onclick="showSection('dashboard', this)">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0)" data-section="register" onclick="showSection('register', this)">
                            <i class="fas fa-plus me-2"></i>Nova Viagem
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10">
            <!-- Dashboard Section -->
            <div id="dashboard-section" class="p-4">
                <h2 class="mb-4">Dashboard</h2>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Viagens Recentes</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                <tr>
                                    <th class="ps-3">Nº DA VIAGEM</th>
                                    <th>Origem</th>
                                    <th>Destino</th>
                                    <th>Motorista</th>
                                    <th>Envio</th>
                                    <th>Entrega</th>
                                    <th>PDF</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                require __DIR__ . '/../config/conexao.php';
                                $stmt = $conn->query("SELECT * FROM viagens ORDER BY id DESC LIMIT 10");
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr>
                                        <td class='ps-3'>#{$row['id']}</td>
                                        <td>{$row['origem']}</td>
                                        <td>{$row['destino']}</td>
                                        <td>{$row['motorista']}</td>
                                        <td>" . date('d/m/Y', strtotime($row['data_envio'])) . "</td>
                                        <td>" . date('d/m/Y', strtotime($row['data_prevista'])) . "</td>
                                        <td><a href='gerar_pdf.php?id={$row['id']}'><i class='fas fa-file-pdf'></i></a></td>
                                    </tr>";
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Register Section -->
            <div id="register-section" class="p-4" style="display: none;">
                <h2 class="mb-4">Nova Viagem</h2>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Cadastrar Viagem</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="controller/salvar_viagem.php"
                              onsubmit="this.querySelector('button[type=submit]').disabled = true;">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="origem" class="form-label">Origem</label>
                                    <input type="text" class="form-control" id="origem" name="origem" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="destino" class="form-label">Destino</label>
                                    <input type="text" class="form-control" id="destino" name="destino" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Motorista</label>
                                    <input type="text" class="form-control" name="motorista" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Responsável Envio</label>
                                    <input type="text" class="form-control" name="responsavel_envio" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Responsável Recebimento</label>
                                    <input type="text" class="form-control" name="responsavel_recebimento" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Data de Envio</label>
                                    <input type="date" class="form-control" name="data_envio" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Data Prevista Entrega</label>
                                    <input type="date" class="form-control" name="data_prevista" required>
                                </div>
                            </div>

                            <!-- Tabs Navigation -->
                            <ul class="nav nav-tabs mb-3" id="viagemTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="itens-tab" data-bs-toggle="tab"
                                            data-bs-target="#itens-content" type="button" role="tab"
                                            aria-controls="itens-content" aria-selected="true">
                                        <i class="fas fa-box me-2"></i>Itens da Viagem
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="frota-tab" data-bs-toggle="tab"
                                            data-bs-target="#frota-content" type="button" role="tab"
                                            aria-controls="frota-content" aria-selected="false">
                                        <i class="fas fa-truck me-2"></i>Frota
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="implemento-tab" data-bs-toggle="tab"
                                            data-bs-target="#implemento-content" type="button" role="tab"
                                            aria-controls="implemento-content" aria-selected="false">
                                        <i class="fas fa-tools me-2"></i>Implemento
                                    </button>
                                </li>
                            </ul>

                            <!-- Tabs Content -->
                            <div class="tab-content" id="viagemTabsContent">
                                <!-- Itens Tab -->
                                <div class="tab-pane fade show" id="itens-content" role="tabpanel" aria-labelledby="itens-tab">
                                    <div class="mb-3">
                                        <label class="form-label">Itens da Viagem</label>
                                        <div id="items-container">
                                            <div class="item-row">
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <input type="text" class="form-control" name="item_nome[]"
                                                               placeholder="Nome do item" required>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="number" class="form-control" name="item_qtd[]"
                                                               placeholder="Qtd" required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <select class="form-select" name="item_unidade[]" required>
                                                            <option value="un">Unidade</option>
                                                            <option value="kg">Kg</option>
                                                            <option value="m">Metros</option>
                                                            <option value="m2">M²</option>
                                                            <option value="m3">M³</option>
                                                            <option value="ton">Toneladas</option>
                                                            <option value="sc">Sacos</option>
                                                            <option value="cx">Caixa</option>
                                                            <option value="lt">Litro</option>
                                                            <option value="bd">Balde</option>
                                                            <option value="par">Par</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="button" class="btn btn-outline-secondary btn-sm w-100"
                                                                onclick="removeItem(this)">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="addItem()">
                                            <i class="fas fa-plus me-1"></i>Adicionar Item
                                        </button>
                                    </div>
                                </div>

                                <!-- Frota Tab -->
                                <div class="tab-pane fade" id="frota-content" role="tabpanel" aria-labelledby="frota-tab">
                                    <div class="mb-3">
                                        <label class="form-label">Frota</label>
                                        <div id="frota-container">
                                            <div class="item-row">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <input type="text" class="form-control" name="frota[]"
                                                               placeholder="Ex: Caminhão Mercedes-Benz Actros 2651, Placa ABC-1234">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="button" class="btn btn-outline-secondary btn-sm w-100"
                                                                onclick="removeFrota(this)">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="addFrota()">
                                            <i class="fas fa-plus me-1"></i>Adicionar Frota
                                        </button>
                                        <small class="text-muted d-block mt-2">Informe os dados da(s) frota(s) utilizada(s) nesta viagem</small>
                                    </div>
                                </div>

                                <!-- Implemento Tab -->
                                <div class="tab-pane fade" id="implemento-content" role="tabpanel" aria-labelledby="implemento-tab">
                                    <div class="mb-3">
                                        <label class="form-label">Implemento</label>
                                        <div id="implemento-container">
                                            <div class="item-row">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <input type="text" class="form-control" name="implemento[]"
                                                               placeholder="Ex: Carreta Basculante, Placa XYZ-5678">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="button" class="btn btn-outline-secondary btn-sm w-100"
                                                                onclick="removeImplemento(this)">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="addImplemento()">
                                            <i class="fas fa-plus me-1"></i>Adicionar Implemento
                                        </button>
                                        <small class="text-muted d-block mt-2">Informe os dados do(s) implemento(s) utilizado(s) nesta viagem</small>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary">Cadastrar Viagem</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="/valkyria/public/js/script.js"></script>
</body>
</html>