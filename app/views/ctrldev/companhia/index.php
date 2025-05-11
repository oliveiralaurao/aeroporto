<?php
session_start();

if (!isset($_SESSION['email']) || (!($_SESSION['tipo_usuario'] === '1' || $_SESSION['tipo_usuario'] === '2'))) {
    header('Location: /aeroporto/login');
    exit();
}
require_once '../routes/companhiaRoutes.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Companhias</title>
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
            <a href="../routes/aviaoRoutes.php" class="menu-item">
                <i class="fas fa-plane"></i>
                <span>Aviões</span>
            </a>
            <a href="../routes/assentoRoutes.php" class="menu-item">
                <i class="fas fa-chair"></i>
                <span>Assentos</span>
            </a>
            <a href="../routes/companhiaRoutes.php" class="menu-item active">
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
        <h1>Gerenciamento de Companhias</h1>

        <?php if (isset($_GET['msg'])): ?>
            <p style="color: green;"><strong><?= htmlspecialchars($_GET['msg']) ?></strong></p>
        <?php endif; ?>
        <?php if (isset($_GET['msgP'])): ?>
            <div class="alert alert-warning">
                <strong>Atenção:</strong> <?= htmlspecialchars($_GET['msgP']) ?>

            </div>
        <?php endif; ?>

        <div class="form-container" id='formulario'>
            <h2>Cadastrar Companhia</h2>
            <form method="post" action="../routes/companhiaRoutes.php">
                <input type="hidden" name="action" value="create">

                <label for="nome_companhia">Nome da Companhia:</label>
                <input type="text" name="nome_companhia" required>

                <label for="codigo_companhia">Código:</label>
                <input type="text" name="codigo_companhia" required>

                <input type="submit" value="Cadastrar">
            </form>
        </div>

        <div class="form-container" id='formulario'>
            <h2>Editar Companhia</h2>
            <form method="post" action="../routes/companhiaRoutes.php">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id_companhia_edit" id="id_companhia_edit">

                <label for="nome_companhia_edit">Selecione a Companhia:</label>
                <select name="id_companhia_edit" id="select_companhia_editar" required onchange="preencherFormularioEdicao()">
                    <option value="">Selecione uma Companhia</option>
                    <?php
                    if (isset($companhias) && is_array($companhias)):
                        foreach ($companhias as $companhia):
                            ?>
                            <option value="<?= $companhia['id_companhia'] ?>"
                                    data-nome="<?= htmlspecialchars($companhia['nome_companhia']) ?>"
                                    data-codigo="<?= htmlspecialchars($companhia['codigo_companhia']) ?>">
                                <?= htmlspecialchars($companhia['nome_companhia']) ?> (ID: <?= $companhia['id_companhia'] ?>)
                            </option>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </select>

                <label for="nome_companhia_edit">Nome da Companhia:</label>
                <input type="text" name="nome_companhia_edit" id="nome_companhia_edit" required>

                <label for="codigo_companhia_edit">Código:</label>
                <input type="text" name="codigo_companhia_edit" id="codigo_companhia_edit" required>

                <input type="submit" value="Atualizar">
            </form>
        </div>

        <div class="form-container" id="listar">
            <h2>Lista de Companhias</h2>
            <form method="post" action="../routes/companhiaRoutes.php">
                <input type="hidden" name="action" value="deleteMultiple">

                <div class="table-container">
                    <table class="styled-table">
                        <thead>
                            <tr>
                                <th>Excluir</th>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Código</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($companhias) && is_array($companhias)):
                                foreach ($companhias as $companhia):
                                    ?>
                                    <tr>
                                        <td><input type="checkbox" name="ids[]" value="<?= $companhia['id_companhia'] ?>"></td>
                                        <td><?= $companhia['id_companhia'] ?></td>
                                        <td><?= $companhia['nome_companhia'] ?></td>
                                        <td><?= $companhia['codigo_companhia'] ?></td>
                                    </tr>
                                    <?php
                                endforeach;
                            else:
                                ?>
                                <tr><td colspan="4">Nenhuma companhia encontrada.</td></tr>
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
            const selectCompanhia = document.getElementById('select_companhia_editar');
            const selectedOption = selectCompanhia.options[selectCompanhia.selectedIndex];

            if (selectedOption.value) {
                document.getElementById('id_companhia_edit').value = selectedOption.value;
                document.getElementById('nome_companhia_edit').value = selectedOption.dataset.nome;
                document.getElementById('codigo_companhia_edit').value = selectedOption.dataset.codigo;
            } else {
                document.getElementById('id_companhia_edit').value = '';
                document.getElementById('nome_companhia_edit').value = '';
                document.getElementById('codigo_companhia_edit').value = '';
            }
        }
    </script>

</body>
</html>