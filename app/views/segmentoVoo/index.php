<?php
require_once '../routes/segmentoVooRoutes.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Segmentos de Voo</title>
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
            <a href="../routes/segmentoVooRoutes.php" class="menu-item active">
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
            <a href="../routes/logOut.php" class="menu-item">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Sair</span>
            </a>
        </nav>
    </aside>

    <main>
        <h1>Gerenciamento de Segmentos de Voo</h1>

        <?php if (isset($_GET['msg'])): ?>
            <p style="color: green;"><strong><?= htmlspecialchars($_GET['msg']) ?></strong></p>
        <?php endif; ?>

        <div class="form-container" id='formulario'>
            <h2>Cadastrar Segmento</h2>
            <form method="post" action="../routes/segmentoVooRoutes.php" onsubmit="return validarHoraChegadaCadastro()">
                <input type="hidden" name="action" value="create">
                <label for="voo">Voo:</label>
                <select name="voo" required>
                    <option value="">Selecione o voo</option>
                    <?php foreach ($voos as $voo): ?>
                        <option value="<?= $voo['id_voo'] ?>"><?= $voo['numero_voo'] ?></option>
                    <?php endforeach; ?>
                </select>
                <label for="origem">Origem:</label>
                <select name="origem" required>
                    <option value="">Selecione o aeroporto de origem</option>
                    <?php foreach ($aeroportos as $aeroporto): ?>
                        <option value="<?= $aeroporto['id_aeroporto'] ?>"><?= $aeroporto['nome_aeroporto'] ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="destino">Destino:</label>
                <select name="destino" required>
                    <option value="">Selecione o aeroporto de destino</option>
                    <?php foreach ($aeroportos as $aeroporto): ?>
                        <option value="<?= $aeroporto['id_aeroporto'] ?>"><?= $aeroporto['nome_aeroporto'] ?></option>
                    <?php endforeach; ?>
                </select>



                <label for="hora_partida">Hora de Partida:</label>
                <input type="datetime-local" name="hora_partida" id="hora_partida" required>

                <label for="hora_chegada">Hora de Chegada:</label>
                <input type="datetime-local" name="hora_chegada" id="hora_chegada" required>

                <input type="submit" value="Cadastrar">
            </form>
        </div>

        <div class="form-container" id='formulario'>
            <h2>Editar Segmento</h2>
            <form method="post" action="../routes/segmentoVooRoutes.php" onsubmit="return validarHoraChegadaEdicao()">
                <input type="hidden" name="action" value="update">

                <label for="id_segmento">Segmento:</label>
                <select name="id_segmento" id="select_segmento" onchange="preencherFormularioSegmento()" required>
                    <option value="">Selecione um segmento</option>
                    <?php foreach ($segmentos as $seg): ?>
                        <option value="<?= $seg['id_segmento'] ?>"
                                data-origem="<?= $seg['idorigem'] ?>"
                                data-destino="<?= $seg['iddestino'] ?>"
                                data-voo="<?= $seg['id_voo'] ?>"
                                data-partida="<?= $seg['hora_partida'] ?>"
                                data-chegada="<?= $seg['hora_chegada'] ?>">
                            <?= $seg['origem'] ?> → <?= $seg['destino'] ?> (<?= $seg['numero_voo'] ?>)
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="origem_edit">Origem:</label>
                <select name="origem_edit" id="origem_edit" required>
                    <option value="">Selecione o aeroporto de origem</option>
                    <?php foreach ($aeroportos as $aeroporto): ?>
                        <option value="<?= $aeroporto['id_aeroporto'] ?>"><?= $aeroporto['nome_aeroporto'] ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="destino_edit">Destino:</label>
                <select name="destino_edit" id="destino_edit" required>
                    <option value="">Selecione o aeroporto de destino</option>
                    <?php foreach ($aeroportos as $aeroporto): ?>
                        <option value="<?= $aeroporto['id_aeroporto'] ?>"><?= $aeroporto['nome_aeroporto'] ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="voo_edit">Voo:</label>
                <select name="voo_edit" id="voo_edit" required>
                    <option value="">Selecione o voo</option>
                    <?php foreach ($voos as $voo): ?>
                        <option value="<?= $voo['id_voo'] ?>"><?= $voo['numero_voo'] ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="hora_partida_edit">Hora de Partida:</label>
                <input type="datetime-local" name="hora_partida_edit" id="hora_partida_edit" required>

                <label for="hora_chegada_edit">Hora de Chegada:</label>
                <input type="datetime-local" name="hora_chegada_edit" id="hora_chegada_edit" required>

                <input type="submit" value="Atualizar">
            </form>
        </div>

        <div class="form-container" id="listar">
            <h2>Lista de Segmentos</h2>
            <form method="post" action="../routes/segmentoVooRoutes.php">
                <input type="hidden" name="action" value="deleteMultiple">

                <div class="table-container">
                    <table class="styled-table">
                        <thead>
                            <tr>
                                <th>Excluir</th>
                                <th>Origem</th>
                                <th>Destino</th>
                                <th>Voo</th>
                                <th>Hora de Partida</th>
                                <th>Hora de Chegada</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($segmentos)): ?>
                                <?php foreach ($segmentos as $seg): ?>
                                    <tr>
                                        <td><input type="checkbox" name="segmentos_ids[]" value="<?= $seg['id_segmento'] ?>"></td>
                                        <td><?= $seg['origem'] ?></td>
                                        <td><?= $seg['destino'] ?></td>
                                        <td><?= $seg['numero_voo'] ?></td>
                                        <td><?= $seg['hora_partida'] ?></td>
                                        <td><?= $seg['hora_chegada'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6">Nenhum segmento cadastrado</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <input type="submit" value="Excluir Selecionados">
            </form>
        </div>
    </main>

    <script>
        function preencherFormularioSegmento() {
            const select = document.getElementById('select_segmento');
            const option = select.options[select.selectedIndex];

            document.getElementById('origem_edit').value = option.dataset.origem;
            document.getElementById('destino_edit').value = option.dataset.destino;
            document.getElementById('voo_edit').value = option.dataset.voo;
            document.getElementById('hora_partida_edit').value = option.dataset.partida;
            document.getElementById('hora_chegada_edit').value = option.dataset.chegada;
        }

        function validarHoraChegadaCadastro() {
        const horaPartida = document.getElementById('hora_partida').value;
        const horaChegada = document.getElementById('hora_chegada').value;
        if (horaChegada && horaPartida && new Date(horaChegada) < new Date(horaPartida)) {
            alert('A hora de chegada não pode ser anterior à hora de partida.');
            return false;
        }
        return true;
    }

    function validarHoraChegadaEdicao() {
        const horaPartida = document.getElementById('hora_partida_edit').value;
        const horaChegada = document.getElementById('hora_chegada_edit').value;
        if (horaChegada && horaPartida && new Date(horaChegada) < new Date(horaPartida)) {
            alert('A hora de chegada não pode ser anterior à hora de partida.');
            return false;
        }
        return true;
    }
    </script>
</body>
</html>
