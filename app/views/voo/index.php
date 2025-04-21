<?php
require_once '../routes/vooRoutes.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Voos</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;500;700&display=swap" rel="stylesheet">

</head>
<body id="adm">
<aside class="sidebar">
    <div class="sidebar-header">
        <h1>FlyAir<a href="../app/views/index.php"><img src="../assets/images/fly-airplane.png" alt="Logo" class="logo"></a></h1>
    </div>
    <nav class="menu">
        <a href="../routes/aeroportoRoutes.php" class="menu-item">
            <i class="fa-solid fa-plane-departure"></i>
            <span>Aeroportos</span>
        </a>
        <a href="../routes/aviaoRoutes.php" class="menu-item">
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
        <a href="../routes/mensagemRoutes.php" class="menu-item">
            <i class="fas fa-envelope"></i>
            <span>Mensagens</span>
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
        <a href="../routes/vooRoutes.php" class="menu-item active">
            <i class="fas fa-plane-departure"></i>
            <span>Voos</span>
        </a>
        <a href="../routes/logOut.php" class="menu-item">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Sair</span>
        </a>
    </nav>
</aside>

<main>
    <h1>Gerenciamento de Voos</h1>

    <?php if (isset($_GET['msg'])): ?>
        <p style="color: green;"><strong><?= htmlspecialchars($_GET['msg']) ?></strong></p>
    <?php endif; ?>

    <div class="form-container" id='formulario'>
        <h2>Cadastrar Voo</h2>
        <form method="post" action="../routes/vooRoutes.php">
            <input type="hidden" name="action" value="create">

            <label for="numero_voo">Número do Voo:</label>
            <input type="text" name="numero_voo" required>

            <label for="data_saida">Data de Saída:</label>
            <input type="datetime-local" name="data_saida" required>

            <label for="data_chegada">Data de Chegada:</label>
            <input type="datetime-local" name="data_chegada" required>

            <label for="origem_voo">Origem:</label>
            <select name="origem_voo" required>
                <option value="" disabled selected>Selecione o Aeroporto de Origem</option>
                <?php
                if (isset($aeroportos) && is_array($aeroportos)):
                    foreach ($aeroportos as $aeroporto):
                        ?>
                        <option value="<?= $aeroporto['id_aeroporto'] ?>">
                            <?= $aeroporto['nome_aeroporto'] ?> (<?= $aeroporto['codigo_aeroporto'] ?>)
                        </option>
                    <?php endforeach;
                endif;
                ?>
            </select>

            <label for="destino_voo">Destino:</label>
            <select name="destino_voo" required>
                <option value="" disabled selected>Selecione o Aeroporto de Destino</option>
                <?php
                if (isset($aeroportos) && is_array($aeroportos)):
                    foreach ($aeroportos as $aeroporto):
                        ?>
                        <option value="<?= $aeroporto['id_aeroporto'] ?>">
                            <?= $aeroporto['nome_aeroporto'] ?> (<?= $aeroporto['codigo_aeroporto'] ?>)
                        </option>
                    <?php endforeach;
                endif;
                ?>
            </select>




            <label for="tipo_voo">Tipo de Voo:</label>
            <select name="tipo_voo" id="tipo_voo" required>
                <option value="" disabled selected>Selecione o Tipo de Voo</option>
                <option value="Direto">Direto</option>
                <option value="Escala">Escala</option>
            </select>

            <label for="status_voo">Status do Voo:</label>
            <select name="status_voo" id="status_voo" required>
                <option value="" disabled selected>Selecione o Status</option>
                <option value="Atrasado">Atrasado</option>
                <option value="No horário">No horário</option>
                <option value="Embarcando">Embarcando</option>
                <option value="Decolando">Decolando</option>
                <option value="Cancelado">Cancelado</option>
                <option value="Pousando">Pousando</option>
                <option value="Taxiando">Taxiando</option>
                <option value="Finalizado">Finalizado</option>
                <option value="Aguardando Autorização">Aguardando Autorização</option>
                <option value="Desembarcando">Desembarcando</option>
                <option value="Manutenção">Manutenção</option>
                <option value="Reprogramado">Reprogramado</option>
                <option value="Fechado">Fechado</option>
                <option value="Suspenso">Suspenso</option>
                <option value="Em Rota">Em Rota</option>
                <option value="Desviado">Desviado</option>
                <option value="Check-in Aberto">Check-in Aberto</option>
                <option value="Portão Fechado">Portão Fechado</option>
            </select>

            <label for="localizacao_voo">Localização do Voo:</label>
            <select name="localizacao_voo" id="localizacao_voo" required>
                <option value="" disabled selected>Selecione a Localização</option>
                <option value="Nacional">Nacional</option>
                <option value="Internacional">Internacional</option>
            </select>




            <label for="id_aeronave">Aeronave:</label>
            <select name="id_aeronave" required>
                <option value="" disabled selected>Selecione uma Aeronave</option>
                <?php
                if (isset($avioes) && is_array($avioes)):
                    foreach ($avioes as $aviao):
                        ?>
                        <option value="<?= $aviao['id_aeronave'] ?>">
                            <?= $aviao['modelo_aeronave'] ?>
                        </option>
                    <?php endforeach;
                endif;
                ?>
            </select>

            <label for="id_portao">Portão:</label>
            <select name="id_portao" required>
                <option value="" disabled selected>Selecione um Portão</option>
                <?php
                if (isset($portoes) && is_array($portoes)):
                    foreach ($portoes as $portao):
                        ?>
                        <option value="<?= $portao['id_portao'] ?>">
                            <?= $portao['numero_portao']  ?> - <?= $portao['nome_terminal'] ?>
                        </option>
                    <?php endforeach;
                endif;
                ?>
            </select>

            <input type="submit" value="Cadastrar">
        </form>
    </div>

    <div class="form-container" id='formulario'>
        <h2>Editar Voo</h2>
        <form method="post" action="../routes/vooRoutes.php">
            <input type="hidden" name="action" value="update">

            <label for="id_voo_edit">Selecione o Voo:</label>
            <select name="id_voo_edit" id="select_voo_editar" required onchange="preencherFormularioEdicao()">
                <option value="">Selecione um Voo</option>
                <?php
                if (isset($voos) && is_array($voos)):
                    foreach ($voos as $voo):
                        ?>
                        <option value="<?= $voo['id_voo'] ?>"
                                data-numero="<?= htmlspecialchars($voo['numero_voo']) ?>"
                                data-saida="<?= htmlspecialchars($voo['data_saida']) ?>"
                                data-chegada="<?= htmlspecialchars($voo['data_chegada']) ?>"
                                data-origem="<?= htmlspecialchars($voo['origem_voo']) ?>"
                                data-destino="<?= htmlspecialchars($voo['destino_voo']) ?>"
                                data-tipo="<?= htmlspecialchars($voo['tipo_voo']) ?>"
                                data-status="<?= htmlspecialchars($voo['status_voo']) ?>"
                                data-localizacao="<?= htmlspecialchars($voo['localizacao_voo']) ?>"

                                data-aeronave="<?= htmlspecialchars($voo['id_aeronave']) ?>"
                                data-portao="<?= htmlspecialchars($voo['id_portao']) ?>">
                            <?= $voo['numero_voo'] ?> (ID: <?= $voo['id_voo'] ?>)
                        </option>
                    <?php endforeach;
                endif;
                ?>
            </select>

            <label for="numero_voo_edit">Número do Voo:</label>
            <input type="text" name="numero_voo_edit" id="numero_voo_edit" required>

            <label for="data_saida_edit">Data de Saída:</label>
            <input type="datetime-local" name="data_saida_edit" id="data_saida_edit" required>

            <label for="data_chegada_edit">Data de Chegada:</label>
            <input type="datetime-local" name="data_chegada_edit" id="data_chegada_edit" required>

            <label for="origem_voo_edit">Origem:</label>
            <select name="origem_voo_edit" id="origem_voo_edit" required>
                <option value="" disabled selected>Selecione o Aeroporto de Origem</option>
                <?php
                if (isset($aeroportos) && is_array($aeroportos)):
                    foreach ($aeroportos as $aeroporto):
                        ?>
                        <option value="<?= $aeroporto['id_aeroporto'] ?>">
                            <?= $aeroporto['nome_aeroporto'] ?> (<?= $aeroporto['codigo_aeroporto'] ?>)
                        </option>
                    <?php endforeach;
                endif;
                ?>
            </select>

            <label for="destino_voo_edit">Destino:</label>
            <select name="destino_voo_edit" id="destino_voo_edit" required>
                <option value="" disabled selected>Selecione o Aeroporto de Destino</option>
                <?php
                if (isset($aeroportos) && is_array($aeroportos)):
                    foreach ($aeroportos as $aeroporto):
                        ?>
                        <option value="<?= $aeroporto['id_aeroporto'] ?>">
                            <?= $aeroporto['nome_aeroporto'] ?> (<?= $aeroporto['codigo_aeroporto'] ?>)
                        </option>
                    <?php endforeach;
                endif;
                ?>
            </select>


            <label for="tipo_voo_edit">Tipo de Voo:</label>
            <select name="tipo_voo_edit" id="tipo_voo_edit" required>
                <option value="" disabled selected>Selecione o Tipo de voo</option>
                <option value="Direto">Direto</option>
                <option value="Escala">Escala</option>
            </select>

            <label for="status_voo_edit">Status do Voo:</label>
            <select name="status_voo_edit" id="status_voo_edit" required>
                <option value="" disabled selected>Selecione o Status</option>
                <option value="Atrasado">Atrasado</option>
                <option value="No horário">No horário</option>
                <option value="Embarcando">Embarcando</option>
                <option value="Decolando">Decolando</option>
                <option value="Cancelado">Cancelado</option>
                <option value="Pousando">Pousando</option>
                <option value="Taxiando">Taxiando</option>
                <option value="Finalizado">Finalizado</option>
                <option value="Aguardando Autorização">Aguardando Autorização</option>
                <option value="Desembarcando">Desembarcando</option>
                <option value="Manutenção">Manutenção</option>
                <option value="Reprogramado">Reprogramado</option>
                <option value="Fechado">Fechado</option>
                <option value="Suspenso">Suspenso</option>
                <option value="Em Rota">Em Rota</option>
                <option value="Desviado">Desviado</option>
                <option value="Check-in Aberto">Check-in Aberto</option>
                <option value="Portão Fechado">Portão Fechado</option>
            </select>


            <label for="localizacao_voo_edit">Localização do Voo:</label>
            <select name="localizacao_voo_edit" id="localizacao_voo_edit" required>
                <option value="" disabled selected>Selecione a Localização</option>
                <option value="Nacional">Nacional</option>
                <option value="Internacional">Internacional</option>
            </select>




            <label for="id_aeronave_edit">Aeronave:</label>
            <select name="id_aeronave_edit" id="id_aeronave_edit" required>
                <option value="" disabled selected>Selecione uma Aeronave</option>
                <?php
                if (isset($avioes) && is_array($avioes)):
                    foreach ($avioes as $aviao):
                        ?>
                        <option value="<?= $aviao['id_aeronave'] ?>">
                            <?= $aviao['modelo_aeronave'] ?>
                        </option>
                    <?php endforeach;
                endif;
                ?>
            </select>

            <label for="id_portao_edit">Portão:</label>
            <select name="id_portao_edit" id="id_portao_edit" required>
                <option value="" disabled selected>Selecione um Portão</option>
                <?php
                if (isset($portoes) && is_array($portoes)):
                    foreach ($portoes as $portao):
                        ?>
                        <option value="<?= $portao['id_portao'] ?>">
                            <?= $portao['numero_portao']  ?> - <?= $portao['nome_terminal'] ?>
                        </option>
                    <?php endforeach;
                endif;
                ?>
            </select>

            <input type="submit" value="Atualizar">
        </form>
    </div>

    <div class="form-container" id="listar">
        <h2>Lista de Voos</h2>
        <form method="post" action="../routes/vooRoutes.php">
            <input type="hidden" name="action" value="deleteMultiple">

            <div class="table-container">
                <table class="styled-table">
                    <thead>
                    <tr>
                        <th>Excluir</th>
                        <th>Número do Voo</th>
                        <th>Aeronave</th>
                        <th>Origem</th>
                        <th>Destino</th>
                        <th>Data de Saída</th>
                        <th>Data de Chegada</th>
                        <th>Tipo de Voo</th>
                        <th>Portão</th>
                        <th>Status</th>
                        <th>Localização</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (isset($voos) && is_array($voos)):
                        foreach ($voos as $voo):

                            ?>
                            <tr>
                                <td><input type="checkbox" name="ids[]" value="<?= $voo['id_voo'] ?>"></td>
                                <td><?= $voo['numero_voo'] ?></td>
                                <td><?= $voo['modelo_aeronave'] ?></td>
                                <td><?= $voo['origem_nome'] ?></td>
                                <td><?= $voo['destino_nome'] ?></td>
                                <td><?= $voo['data_saida'] ?></td>
                                <td><?= $voo['data_chegada'] ?></td>
                                <td><?= $voo['tipo_voo'] ?></td>
                                <td><?= $voo['numero_portao'] ?></td>
                                <td><?= $voo['status_voo'] ?></td>
                                <td><?= $voo['localizacao_voo'] ?></td>
                            </tr>
                        <?php endforeach;
                    else: ?>
                        <tr><td colspan="8">Nenhum voo encontrado.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <input type="submit" value="Excluir Selecionados">
        </form>
    </div>
</main>

<script>
    function preencherFormularioEdicao() {
        const select = document.getElementById("select_voo_editar");
        const voo = select.options[select.selectedIndex];
        document.getElementById("numero_voo_edit").value = voo.getAttribute("data-numero");
        document.getElementById("data_saida_edit").value = voo.getAttribute("data-saida");
        document.getElementById("data_chegada_edit").value = voo.getAttribute("data-chegada");
        document.getElementById("origem_voo_edit").value = voo.getAttribute("data-origem");
        document.getElementById("destino_voo_edit").value = voo.getAttribute("data-destino");
        document.getElementById("tipo_voo_edit").value = voo.getAttribute("data-tipo");
        document.getElementById("status_voo_edit").value = voo.getAttribute("data-status");
        document.getElementById("localizacao_voo_edit").value = voo.getAttribute("data-localizacao");

        document.getElementById("id_aeronave_edit").value = voo.getAttribute("data-aeronave");
        document.getElementById("id_portao_edit").value = voo.getAttribute("data-portao");
    }
</script>
</body>
</html>
