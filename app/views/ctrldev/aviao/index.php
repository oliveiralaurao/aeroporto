<?php
session_start();

if (!isset($_SESSION['email']) || (!($_SESSION['tipo_usuario'] === '1' || $_SESSION['tipo_usuario'] === '2'))) {
    header('Location: /aeroporto/login');
    exit();
}
require_once '../routes/aviaoRoutes.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Aviões</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;500;700&display=swap" rel="stylesheet">

</head>
<body id="adm">
    <aside class="sidebar">
        <div class="sidebar-header">
            <h1>FlyAir<a href="../app/views/ctrldev/"><img src="../assets/images/fly-airplane.png" alt="Logo" class="logo"></a></h1>
        </div>
        <nav class="menu">
            <a href="../routes/aeroportoRoutes.php" class="menu-item">
                <i class="fa-solid fa-plane-departure"></i>
                <span>Aeroportos</span>
            </a>
            <a href="../routes/aviaoRoutes.php" class="menu-item active">
                <i class="fas fa-plane"></i>
                <span>Aviões</span>
            </a>
            <a href="../routes/assentoRoutes.php" class="menu-item">
                <i class="fas fa-chair"></i>
                <span>Assentos</span>
            </a>
            <a href="../routes/companhiaRoutes.php" class="menu-item">
                <i class="fas fa-building"></i>
                <span>Companhias</span>
            </a>

            <a href="../routes/portaoRoutes.php" class="menu-item">
          <i class="fa-solid fa-cart-flatbed-suitcase"></i>
          <span>Portões</span>
        </a>
            <a href="../routes/passagemRoutes.php" class="menu-item">
                <i class="fas fa-tags"></i>
                <span>Passagens</span>
            </a>
            
            
            <a href="../routes/segmentoVooRoutes.php" class="menu-item">
                <i class="fas fa-route"></i>
                <span>Segmento de Voo</span>
            </a>
            <a href="../routes/terminalRoutes.php" class="menu-item">
                <i class="fa-solid fa-signs-post"></i>
                <span>Terminais</span>
            </a>
            <a href="../routes/usuarioRoutes.php" class="menu-item">
                <i class="fas fa-users"></i>
                <span>Usuários</span>
            </a>
            <a href="../routes/vooRoutes.php" class="menu-item">
                <i class="fas fa-plane-departure"></i>
                <span>Voos</span>
            </a>
            <a href="/aeroporto/logout" class="menu-item">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Sair</span>
            </a>
        </nav>
    </aside>

    <main>
        <h1>Gerenciamento de Aviões</h1>

        <?php if (isset($_GET['msg'])): ?>
            <p style="color: green;"><strong><?= htmlspecialchars($_GET['msg']) ?></strong></p>
        <?php endif; ?>
        <?php if (isset($_GET['msgP'])): ?>
            <div class="alert alert-warning">
                <strong>Atenção:</strong> <?= htmlspecialchars($_GET['msgP']) ?>

            </div>
        <?php endif; ?>

        <div class="form-container" id='formulario'>
            <h2>Cadastrar Avião</h2>
            <form method="post" action="../routes/aviaoRoutes.php" onsubmit="calcularCapacidadeCadastro()">
                <input type="hidden" name="action" value="create">

                <label for="modelo_aeronave">Modelo do Avião:</label>
                <input type="text" name="modelo_aeronave" required>

                <label for="quantidade_fileiras">Quantidade de Fileiras:</label>
                <input type="number" name="quantidade_fileiras" id="quantidade_fileiras_cadastro" required oninput="calcularCapacidadeCadastro()">

                <label for="quantidade_assentos_por_fileira">Quantidade de Assentos por Fileira:</label>
                <input type="number" name="quantidade_assentos_por_fileira" id="quantidade_assentos_por_fileira_cadastro" required oninput="calcularCapacidadeCadastro()">

                <label for="capacidade_aeronave">Capacidade:</label>
                <input type="number" name="capacidade_aeronave" id="capacidade_aeronave_cadastro" readonly>

                <label for="companhia_aeronave">Companhia Aérea:</label>
                <select name="companhia_aeronave" required>
                    <option value="">Selecione uma Companhia</option>
                    <?php
                    if (isset($companhias) && is_array($companhias)):
                        foreach ($companhias as $companhia):
                            ?>
                            <option value="<?= $companhia['id_companhia'] ?>">
                                <?= $companhia['nome_companhia'] ?>
                            </option>
                        <?php endforeach;
                    endif;
                    ?>
                </select>

                <input type="submit" value="Cadastrar">
            </form>
        </div>  

        <div class="form-container" id='formulario'>
            <h2>Editar Avião</h2>
            <form method="post" action="../routes/aviaoRoutes.php" onsubmit="calcularCapacidadeEdicao()">
                <input type="hidden" name="action" value="update">

                <label for="id_aeronave_edit">Selecione o Avião:</label>
                <select name="id_aeronave_edit" id="select_aviao_editar" required onchange="preencherFormularioEdicao()">
                    <option value="">Selecione um Avião</option>
                    <?php
                    if (isset($avioes) && is_array($avioes)):
                        foreach ($avioes as $aviao):
                            ?>
                            <option value="<?= $aviao['id_aeronave'] ?>"
                                    data-modelo="<?= htmlspecialchars($aviao['modelo_aeronave']) ?>"
                                    data-fileiras="<?= htmlspecialchars($aviao['quantidade_fileiras']) ?>"
                                    data-assentos="<?= htmlspecialchars($aviao['quantidade_assentos_por_fileira']) ?>"
                                    data-capacidade="<?= htmlspecialchars($aviao['capacidade_aeronave']) ?>"
                                    data-companhia="<?= htmlspecialchars($aviao['id_companhia']) ?>">
                                <?= $aviao['modelo_aeronave'] ?> (ID: <?= $aviao['id_aeronave'] ?>)
                            </option>
                        <?php endforeach;
                    endif;
                    ?>
                </select>

                <label for="modelo_aeronave_edit">Modelo do Avião:</label>
                <input type="text" name="modelo_aeronave_edit" id="modelo_aeronave_edit" required>

                <label for="quantidade_fileiras_edit">Quantidade de Fileiras:</label>
                <input type="number" name="quantidade_fileiras_edit" id="quantidade_fileiras_edit" required oninput="calcularCapacidadeEdicao()">

                <label for="quantidade_assentos_por_fileira_edit">Quantidade de Assentos por Fileira:</label>
                <input type="number" name="quantidade_assentos_por_fileira_edit" id="quantidade_assentos_por_fileira_edit" required oninput="calcularCapacidadeEdicao()">

                <label for="capacidade_aeronave_edit">Capacidade:</label>
                <input type="number" name="capacidade_aeronave_edit" id="capacidade_aeronave_edit" readonly>

                <label for="companhia_aeronave_edit">Companhia Aérea:</label>
                <select name="companhia_aeronave_edit" id="companhia_aeronave_edit" required>
                    <option value="">Selecione uma Companhia</option>
                    <?php
                    if (isset($companhias) && is_array($companhias)):
                        foreach ($companhias as $companhia):
                            ?>
                            <option value="<?= $companhia['id_companhia'] ?>">
                                <?= $companhia['nome_companhia'] ?>
                            </option>
                        <?php endforeach;
                    endif;
                    ?>
                </select>

                <input type="submit" value="Atualizar">
            </form>
        </div>

        <div class="form-container" id="listar">
            <h2>Lista de Aviões</h2>
            <form method="post" action="../routes/aviaoRoutes.php">
                <input type="hidden" name="action" value="deleteMultiple">

                <div class="table-container">
                    <table class="styled-table">
                        <thead>
                            <tr>
                                <th>Excluir</th>
                                <th>Modelo</th>
                                <th>Capacidade</th>
                                <th>Fileiras</th>
                                <th>Assentos/Fileira</th>
                                <th>Companhia</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($avioes) && is_array($avioes)):
                                foreach ($avioes as $aviao):
                                    ?>
                                    <tr>
                                        <td><input type="checkbox" name="ids[]" value="<?= $aviao['id_aeronave'] ?>"></td>
                                        <td><?= $aviao['modelo_aeronave'] ?></td>
                                        <td><?= $aviao['quantidade_fileiras'] * $aviao['quantidade_assentos_por_fileira'] ?></td>
                                        <td><?= $aviao['quantidade_fileiras'] ?></td>
                                        <td><?= $aviao['quantidade_assentos_por_fileira'] ?></td>
                                        <td><?= $aviao['nome_companhia'] ?></td>
                                    </tr>
                                <?php endforeach;
                            else: ?>
                                <tr><td colspan="6">Nenhum avião encontrado.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="button-wrapper">
                    <input type="submit" value="Excluir Selecionados" class="btn-delete">
                </div>
            </form>
        </div>

    </main>

    <script>
        function calcularCapacidadeCadastro() {
            const fileiras = parseInt(document.getElementById('quantidade_fileiras_cadastro').value) || 0;
            const assentos = parseInt(document.getElementById('quantidade_assentos_por_fileira_cadastro').value) || 0;
            document.getElementById('capacidade_aeronave_cadastro').value = fileiras * assentos;
        }

        function calcularCapacidadeEdicao() {
            const fileiras = parseInt(document.getElementById('quantidade_fileiras_edit').value) || 0;
            const assentos = parseInt(document.getElementById('quantidade_assentos_por_fileira_edit').value) || 0;
            document.getElementById('capacidade_aeronave_edit').value = fileiras * assentos;
        }

        function preencherFormularioEdicao() {
            const selectAviao = document.getElementById('select_aviao_editar');
            const selectedOption = selectAviao.options[selectAviao.selectedIndex];

            if (selectedOption.value) {
                document.getElementById('modelo_aeronave_edit').value = selectedOption.dataset.modelo;
                document.getElementById('quantidade_fileiras_edit').value = selectedOption.dataset.fileiras;
                document.getElementById('quantidade_assentos_por_fileira_edit').value = selectedOption.dataset.assentos;
                document.getElementById('capacidade_aeronave_edit').value = selectedOption.dataset.capacidade;
                document.getElementById('companhia_aeronave_edit').value = selectedOption.dataset.companhia;
            } else {
                document.getElementById('modelo_aeronave_edit').value = '';
                document.getElementById('quantidade_fileiras_edit').value = '';
                document.getElementById('quantidade_assentos_por_fileira_edit').value = '';
                document.getElementById('capacidade_aeronave_edit').value = '';
                document.getElementById('companhia_aeronave_edit').value = '';
            }
            calcularCapacidadeEdicao(); 
        }

        calcularCapacidadeCadastro();
    </script>

</body>
</html>