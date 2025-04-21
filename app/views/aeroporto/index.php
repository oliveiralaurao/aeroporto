<?php
require_once '../routes/aeroportoRoutes.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Gerenciamento de Aeroportos</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;500;700&display=swap" rel="stylesheet">

</head>

<body id="adm">
<aside class="sidebar">
    <div class="sidebar-header">
        <h1>FlyAir<a href="../app/views/index.php"><img src="../assets/images/fly-airplane.png" alt="Logo" class="logo"></a></h1>
    </div>
    <nav class="menu">
        <a href="../routes/aeroportoRoutes.php" class="menu-item active">
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
    <h1>Gerenciamento de Aeroportos</h1>

    <?php if (isset($_GET['msg'])): ?>
        <p style="color: green;"><strong><?= htmlspecialchars($_GET['msg']) ?></strong></p>
    <?php endif; ?>

    <!-- Formulário de Cadastro -->
    <div class="form-container" id='formulario'>
        <h2>Cadastrar Aeroporto</h2>
        <form method="post" action="../routes/AeroportoRoutes.php">
            <input type="hidden" name="action" value="create">

            <label for="nome_aeroporto">Nome do Aeroporto:</label>
            <input type="text" name="nome_aeroporto" required>

            <label for="codigo_aeroporto">Código do Aeroporto:</label>
            <input type="text" name="codigo_aeroporto" required>

            <label for="localizacao_aeroporto">Localização:</label>
            <input type="text" name="localizacao_aeroporto" required>

            <input type="submit" value="Cadastrar">
        </form>
    </div>

    <!-- Formulário de Edição -->
    <div class="form-container" id='formulario'>
        <h2>Editar Aeroporto</h2>
        <form method="post" action="../routes/AeroportoRoutes.php">
            <input type="hidden" name="action" value="update">

            <label for="id_aeroporto">Selecione o Aeroporto:</label>
            <select name="id_aeroporto" required>
                <option disabled selected>Selecione uma opção</option>
                <?php
                if (isset($dados_aeroportos) && is_array($dados_aeroportos)):
                    foreach ($dados_aeroportos as $aeroporto):
                        ?>
                        <option
                                value="<?= $aeroporto['id_aeroporto'] ?>"
                                data-nome="<?= htmlspecialchars($aeroporto['nome_aeroporto']) ?>"
                                data-codigo="<?= htmlspecialchars($aeroporto['codigo_aeroporto']) ?>"
                                data-localizacao="<?= htmlspecialchars($aeroporto['localizacao_aeroporto']) ?>"
                        >
                            <?= $aeroporto['nome_aeroporto'] ?> (<?= $aeroporto['codigo_aeroporto'] ?>)
                        </option>
                    <?php endforeach;
                endif;
                ?>
            </select>

            <label for="update_nome_aeroporto">Nome do Aeroporto:</label>
            <input type="text" name="nome_aeroporto" id="update_nome_aeroporto" required>

            <label for="update_codigo_aeroporto">Código do Aeroporto:</label>
            <input type="text" name="codigo_aeroporto" id="update_codigo_aeroporto" required>

            <label for="update_localizacao_aeroporto">Localização:</label>
            <input type="text" name="localizacao_aeroporto" id="update_localizacao_aeroporto" required>

            <input type="submit" value="Atualizar">
        </form>
    </div>

    <!-- Lista de Aeroportos -->
    <div class="form-container" id="listar">
        <h2>Lista de Aeroportos</h2>
        <form method="post" action="../routes/AeroportoRoutes.php">
            <input type="hidden" name="action" value="deleteMultiple">

            <div class="table-container">
                <table class="styled-table">
                    <thead>
                    <tr>
                        <th>Excluir</th>
                        <th>Nome</th>
                        <th>Código</th>
                        <th>Localização</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (isset($dados_aeroportos) && is_array($dados_aeroportos)):
                        foreach ($dados_aeroportos as $aeroporto):
                            ?>
                            <tr>
                                <td><input type="checkbox" name="ids[]" value="<?= $aeroporto['id_aeroporto'] ?>"></td>
                                <td><?= $aeroporto['nome_aeroporto'] ?></td>
                                <td><?= $aeroporto['codigo_aeroporto'] ?></td>
                                <td><?= $aeroporto['localizacao_aeroporto'] ?></td>
                            </tr>
                        <?php endforeach;
                    else: ?>
                        <tr><td colspan="4">Nenhum aeroporto encontrado.</td></tr>
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
    document.addEventListener("DOMContentLoaded", () => {
        const select = document.querySelector("select[name='id_aeroporto']");
        const nomeInput = document.getElementById("update_nome_aeroporto");
        const codigoInput = document.getElementById("update_codigo_aeroporto");
        const localizacaoInput = document.getElementById("update_localizacao_aeroporto");

        function preencherCampos() {
            const selected = select.options[select.selectedIndex];
            nomeInput.value = selected.dataset.nome || "";
            codigoInput.value = selected.dataset.codigo || "";
            localizacaoInput.value = selected.dataset.localizacao || "";
        }

        preencherCampos();
        select.addEventListener("change", preencherCampos);
    });
</script>

</body>
</html>
