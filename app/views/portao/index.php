<?php
require_once '../routes/portaoRoutes.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Portões</title>
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
                <i class="fa-solid fa-plane-departure"></i><span>Aeroportos</span>
            </a>
            <a href="../routes/aviaoRoutes.php" class="menu-item">
                <i class="fas fa-plane"></i><span>Aviões</span>
            </a>
            <a href="../routes/assentoRoutes.php" class="menu-item">
                <i class="fas fa-chair"></i><span>Assentos</span>
            </a>
            <a href="../routes/companhiaRoutes.php" class="menu-item">
                <i class="fas fa-building"></i><span>Companhias</span>
            </a>
            <a href="../routes/mensagemRoutes.php" class="menu-item">
                <i class="fas fa-envelope"></i><span>Mensagens</span>
            </a>
            <a href="../routes/portaoRoutes.php" class="menu-item active">
                <i class="fa-solid fa-cart-flatbed-suitcase"></i><span>Portões</span>
            </a>
            <a href="../routes/passagemRoutes.php" class="menu-item">
                <i class="fas fa-tags"></i><span>Passagens</span>
            </a>
            
            <a href="../routes/segmentoVooRoutes.php" class="menu-item">
                <i class="fas fa-route"></i><span>Segmento de Voo</span>
            </a>
            <a href="../routes/terminalRoutes.php" class="menu-item">
                <i class="fa-solid fa-signs-post"></i><span>Terminais</span>
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
        <h1>Gerenciamento de Portões</h1>

        <?php if (isset($_GET['msg'])): ?>
            <p class="success-message"><?= htmlspecialchars($_GET['msg']) ?></p>
        <?php endif; ?>

        <section class="form-container" id='formulario'>
            <h2>Cadastrar Portão</h2>
            <form method="post" action="../routes/portaoRoutes.php">
                <input type="hidden" name="action" value="create">

                <label for="numero_portao">Número do Portão:</label>
                <input type="text" name="numero_portao" required>

                <label for="terminal_portao">Terminal:</label>
                <select name="terminal_portao" required>
                    <option value="">Selecione um Terminal</option>
                    <?php foreach ($terminais as $terminal): ?>
                        <option value="<?= $terminal['id_terminal'] ?>">
                            <?= $terminal['nome_terminal'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <input type="submit" value="Cadastrar">
            </form>
        </section>

        <section class="form-container" id='formulario'>
            <h2>Editar Portão</h2>
            <form method="post" action="../routes/portaoRoutes.php">
                <input type="hidden" name="action" value="update">

                <label for="id_portao_edit">Portão:</label>
                <select name="id_portao_edit" id="id_portao_edit" required onchange="preencherFormularioPortao()">
                    <option value="">Selecione um Portão</option>
                    <?php foreach ($portoes as $portao): ?>
                        <option value="<?= $portao['id_portao'] ?>"
                                data-numero="<?= $portao['numero_portao'] ?>"
                                data-terminal="<?= $portao['id_terminal'] ?>">
                            <?= $portao['numero_portao'] ?> (ID: <?= $portao['id_portao'] ?>)
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="numero_portao_edit">Número do Portão:</label>
                <input type="text" name="numero_portao_edit" id="numero_portao_edit" required>

                <label for="terminal_portao_edit">Terminal:</label>
                <select name="terminal_portao_edit" id="terminal_portao_edit" required>
                    <option value="">Selecione um Terminal</option>
                    <?php foreach ($terminais as $terminal): ?>
                        <option value="<?= $terminal['id_terminal'] ?>">
                            <?= $terminal['nome_terminal'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <input type="submit" value="Atualizar">
            </form>
        </section>

        <section class="form-container">
            <h2>Lista de Portões</h2>
            <form method="post" action="../routes/portaoRoutes.php">
                <input type="hidden" name="action" value="deleteMultiple">
                <div class="table-container">
                    <table class="styled-table">
                        <thead>
                            <tr>
                                <th>Excluir</th>
                                <th>Número do Portão</th>
                                <th>Terminal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($portoes)): ?>
                                <?php foreach ($portoes as $portao): ?>
                                    <tr>
                                        <td><input type="checkbox" name="ids[]" value="<?= $portao['id_portao'] ?>"></td>
                                        <td><?= $portao['numero_portao'] ?></td>
                                        <td><?= $portao['nome_terminal'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="3">Nenhum portão encontrado.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="button-wrapper">
                    <input type="submit" value="Excluir Selecionados" class="btn-delete">
                </div>
            </form>
        </section>
    </main>

    <script>
        function preencherFormularioPortao() {
            const select = document.getElementById('id_portao_edit');
            const selected = select.options[select.selectedIndex];

            document.getElementById('numero_portao_edit').value = selected.dataset.numero || '';
            document.getElementById('terminal_portao_edit').value = selected.dataset.terminal || '';
        }
    </script>
</body>
</html>