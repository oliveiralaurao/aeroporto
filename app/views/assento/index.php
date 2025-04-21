<?php
    require_once '../routes/assentoRoutes.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Assentos</title>
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
            <a href="../routes/aviaoRoutes.php" class="menu-item ">
                <i class="fas fa-plane"></i>
                <span>Aviões</span>
            </a>
            <a href="../routes/assentoRoutes.php" class="menu-item active">
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
        <h1>Gerenciamento de Assentos</h1>

        <?php if (isset($_GET['msg'])): ?>
            <p style="color: green;"><strong><?= htmlspecialchars($_GET['msg']) ?></strong></p>
        <?php endif; ?>

        <div class="form-container" id='formulario'>
            <h2>Cadastrar Assento</h2>
            <form method="post" action="../routes/assentoRoutes.php">
                <input type="hidden" name="action" value="create">

                <label for="numero_assento">Número do Assento:</label>
                <input type="text" name="numero_assento" required>

                <label for="status_assento">Status:</label>
                <select name="status_assento" required>
                    <option value="">Selecione um Status</option>
                    <option value="Disponível">Disponível</option>
                    <option value="Ocupado">Ocupado</option>
                    <option value="Corredor">Corredor</option>
                </select>

                <label for="id_voo">Voo:</label>
                <select name="id_voo" required>
                    <option value="">Selecione um Voo</option>
                    <?php if (isset($vooOptions) && is_array($vooOptions)): ?>
                        <?php foreach ($vooOptions as $voo): ?>
                            <option value="<?= $voo['id_voo'] ?>">
                                <?= $voo['numero_voo'] ?> (ID: <?= $voo['id_voo'] ?>)
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>

                <input type="submit" value="Cadastrar">
            </form>
        </div>

        <div class="form-container" id='formulario'>
            <h2>Editar Assento</h2>
            <form method="post" action="../routes/assentoRoutes.php">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id_assento" id="id_assento">


                <label for="id_assento_edit">Selecione o Assento:</label>
                <select name="id_assento_edit" id="select_assento_editar" required onchange="preencherFormularioEdicao()">
                    <option value="">Selecione um Assento</option>
                    <?php if (isset($assentos) && is_array($assentos)): ?>
                        <?php foreach ($assentos as $assento): ?>
                            <option value="<?= $assento['id_assento'] ?>"
                                    data-numero="<?= htmlspecialchars($assento['numero_assento']) ?>"
                                    data-status="<?= htmlspecialchars($assento['status_assento']) ?>"
                                    data-idvoo="<?= htmlspecialchars($assento['id_voo']) ?>">
                                Assento <?= htmlspecialchars($assento['numero_assento']) ?> (ID: <?= $assento['id_assento'] ?>, Voo: <?= htmlspecialchars($assento['numero_voo']) ?>)
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>

                <label for="update_numero_assento">Número do Assento:</label>
                <input type="text" name="update_numero_assento" id="update_numero_assento" required>

                <label for="update_status_assento">Status:</label>
                <select name="update_status_assento" id="update_status_assento" required>
                    <option value="">Selecione um Status</option>
                    <option value="Disponível">Disponível</option>
                    <option value="Ocupado">Ocupado</option>
                    <option value="Corredor">Corredor</option>
                </select>

                <label for="update_id_voo">Voo:</label>
                <select name="update_id_voo" id="update_id_voo" required>
                    <option value="">Selecione um Voo</option>
                    <?php if (isset($vooOptions) && is_array($vooOptions)): ?>
                        <?php foreach ($vooOptions as $voo): ?>
                            <option value="<?= $voo['id_voo'] ?>">
                                <?= $voo['numero_voo'] ?> (ID: <?= $voo['id_voo'] ?>)
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>

                <input type="submit" value="Atualizar">
            </form>
        </div>

        <div class="form-container" id="listar">
            <h2>Lista de Assentos</h2>
            <form method="post" action="../routes/assentoRoutes.php">
                <input type="hidden" name="action" value="deleteMultiple">

                <div class="table-container">
                    <table class="styled-table">
                        <thead>
                            <tr>
                                <th>Excluir</th>
                                <th>ID</th>
                                <th>Número</th>
                                <th>Status</th>
                                <th>Número do Voo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($assentos) && is_array($assentos)): ?>
                                <?php foreach ($assentos as $assento): ?>
                                    <tr>
                                        <td><input type="checkbox" name="ids[]" value="<?= $assento['id_assento'] ?>"></td>
                                        <td><?= $assento['id_assento'] ?></td>
                                        <td><?= $assento['numero_assento'] ?></td>
                                        <td><?= $assento['status_assento'] ?></td>
                                        <td><?= $assento['numero_voo'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="5">Nenhum assento encontrado.</td></tr>
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
        function preencherFormularioEdicao() {
    const selectAssento = document.getElementById('select_assento_editar');
    const selectedOption = selectAssento.options[selectAssento.selectedIndex];

    if (selectedOption.value) {
        document.getElementById('update_numero_assento').value = selectedOption.dataset.numero;
        document.getElementById('update_status_assento').value = selectedOption.dataset.status;
        document.getElementById('update_id_voo').value = selectedOption.dataset.idvoo;
        document.getElementById('id_assento').value = selectedOption.value;
    } else {
        document.getElementById('update_numero_assento').value = '';
        document.getElementById('update_status_assento').value = '';
        document.getElementById('update_id_voo').value = '';
        document.getElementById('id_assento').value = '';
    }
}

    </script>

</body>
</html>