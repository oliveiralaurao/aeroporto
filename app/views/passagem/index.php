<?php
require_once '../routes/passagemRoutes.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Passagens</title>
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
        <a href="../routes/aeroportoRoutes.php" class="menu-item"><i class="fa-solid fa-plane-departure"></i><span>Aeroportos</span></a>
        <a href="../routes/aviaoRoutes.php" class="menu-item"><i class="fas fa-plane"></i><span>Aviões</span></a>
        <a href="../routes/assentoRoutes.php" class="menu-item"><i class="fas fa-chair"></i><span>Assentos</span></a>
        <a href="../routes/companhiaRoutes.php" class="menu-item"><i class="fas fa-building"></i><span>Companhias</span></a>
        <a href="../routes/mensagemRoutes.php" class="menu-item"><i class="fas fa-envelope"></i><span>Mensagens</span></a>
        <a href="../routes/portaoRoutes.php" class="menu-item"><i class="fa-solid fa-cart-flatbed-suitcase"></i><span>Portões</span></a>
        <a href="../routes/passagemRoutes.php" class="menu-item active"><i class="fas fa-tags"></i><span>Passagens</span></a>
        <a href="../routes/segmentoVooRoutes.php" class="menu-item"><i class="fas fa-route"></i><span>Segmento de Voo</span></a>
        <a href="../routes/terminalRoutes.php" class="menu-item"><i class="fa-solid fa-signs-post"></i><span>Terminais</span></a>
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
    <header class="main-header">
        <h2>Gerenciar Passagens</h2>
    </header>
    <section class="dashboard-content">
        <?php if (isset($_GET['msg'])) : ?>
            <p class="alert alert-info"><?= htmlspecialchars($_GET['msg']) ?></p>
        <?php endif; ?>

        <div class="form-container" id='formulario'>
            <h2>Cadastrar Passagem</h2>
            <form method="post" action="../routes/passagemRoutes.php">
                <input type="hidden" name="action" value="create">

                <label for="valor_passagem">Valor da Passagem:</label>
                <input type="number" name="valor_passagem" required>

                <label>Selecionar Assentos:</label>
                <input type="text" id="filtro-assento" placeholder="Filtrar por número do assento...">
                <div class="assentos-grid" id="grid-assentos">
                    <?php if (isset($assentos) && is_array($assentos)): ?>
                        <?php foreach ($assentos as $assento): ?>
                            <div class="assento-card" data-numero="<?= htmlspecialchars($assento['numero_assento']) ?>">
                                <input type="checkbox" class="assento-checkbox" id="assento_<?= $assento['id_assento'] ?>" name="assentos_id_assento[]" value="<?= $assento['id_assento'] ?>">
                                <label class="assento-label" for="assento_<?= $assento['id_assento'] ?>">
                                    <?= htmlspecialchars($assento['numero_assento']) ?><br>
                                    (N° Voo: <?= htmlspecialchars($assento['numero_voo']) ?>)
                                </label>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <input type="submit" value="Cadastrar">
            </form>
        </div>

        <div class="form-container" id='formulario'>
            <h2>Editar Passagem</h2>
            <form method="post" action="../routes/passagemRoutes.php">
                <input type="hidden" name="action" value="update">

                <label for="id_passagem_edit">Selecione a Passagem:</label>
                <select name="id_passagem_edit" id="select_passagem_editar" required onchange="preencherFormularioEdicaoPassagem()">
                    <option value="">Selecione uma Passagem</option>
                    <?php if (isset($passagens) && is_array($passagens)):
                        foreach ($passagens as $passagem): ?>
                            <option value="<?= $passagem['id_passagem'] ?>"
                                    data-valor="<?= htmlspecialchars($passagem['valor_passagem']) ?>"
                                    data-assento_id="<?= htmlspecialchars($passagem['id_assento']) ?>">
                                ID: <?= $passagem['id_passagem'] ?> (Valor: <?= $passagem['valor_passagem'] ?>, Assento ID: <?= $passagem['id_assento'] ?>)
                            </option>
                        <?php endforeach;
                    endif; ?>
                </select>

                <label for="valor_passagem_edit">Valor da Passagem:</label>
                <input type="number" name="valor_passagem_edit" id="valor_passagem_edit" required>

                <label for="assentos_id_assento_edit">Assento:</label>
                <select name="assentos_id_assento_edit" id="assentos_id_assento_edit" required>
                    <option value="">Selecione um Assento</option>
                    <?php if (isset($assentos) && is_array($assentos)):
                        foreach ($assentos as $assento): ?>
                            <option value="<?= $assento['id_assento'] ?>">
                                <?= htmlspecialchars($assento['numero_assento']) ?> (ID: <?= htmlspecialchars($assento['id_assento']) ?>)
                            </option>
                        <?php endforeach;
                    endif; ?>
                </select>

                <input type="submit" value="Atualizar">
            </form>
        </div>

        <div class="form-container" id="listar">
            <h2>Lista de Passagens</h2>
            <form method="post" action="../routes/passagemRoutes.php">
                <input type="hidden" name="action" value="deleteMultiple">

                <div class="table-container">
                    <table class="styled-table">
                        <thead>
                            <tr>
                                <th>Excluir</th>
                                <th>ID</th>
                                <th>Valor</th>
                                <th>Número Voo</th>
                                <th>Número Assento</th>
                            </tr>
                        </thead>
                        <tbody>
    <?php if (isset($passagens) && is_array($passagens)): ?>
        <?php foreach ($passagens as $passagem): ?>
            <tr>
                <td><input type="checkbox" name="ids[]" value="<?= $passagem['id_passagem'] ?>"></td>
                <td><?= $passagem['id_passagem'] ?></td>
                <td><?= $passagem['valor_passagem'] ?></td>
                <td><?= htmlspecialchars($passagem['numero_voo']) ?></td> <!-- Exibindo o numero_voo -->
                <td><?= $passagem['numero_assento'] ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="5">Nenhuma passagem encontrada.</td></tr>
    <?php endif; ?>
</tbody>

                    </table>
                </div>

                <div class="button-wrapper">
                    <input type="submit" value="Excluir Selecionados" class="btn-delete">
                </div>
            </form>
        </div>
    </section>
</main>

<script>
    function preencherFormularioEdicaoPassagem() {
        const selectPassagem = document.getElementById('select_passagem_editar');
        const selectedOption = selectPassagem.options[selectPassagem.selectedIndex];

        if (selectedOption.value) {
            document.getElementById('valor_passagem_edit').value = selectedOption.dataset.valor;
            document.getElementById('assentos_id_assento_edit').value = selectedOption.dataset.assento_id;
        } else {
            document.getElementById('valor_passagem_edit').value = '';
            document.getElementById('assentos_id_assento_edit').value = '';
        }
    }

    const filtro = document.getElementById('filtro-assento');
    const assentos = document.querySelectorAll('.assento-card');

    filtro.addEventListener('input', function () {
        const termo = this.value.toLowerCase();

        assentos.forEach(card => {
            const numero = card.dataset.numero.toLowerCase();
            card.style.display = numero.includes(termo) ? '' : 'none';
        });
    });
</script>
</body>
</html>
