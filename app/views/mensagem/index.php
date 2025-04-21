<?php
require_once '../routes/mensagemRoutes.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Mensagens</title>
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
            <a href="../routes/mensagemRoutes.php" class="menu-item active">
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
        <h1>Gerenciamento de Mensagens</h1>

        <?php if (isset($_GET['msg'])): ?>
            <p style="color: green;"><strong><?= htmlspecialchars($_GET['msg']) ?></strong></p>
        <?php endif; ?>

        <div class="form-container" id="formulario">
            <h2>Responder Mensagem</h2>
            <form method="post" action="../routes/mensagemRoutes.php">
                <input type="hidden" name="action" value="enviarResposta">

                <label for="id_resposta">Selecione a Mensagem:</label>
                <select name="id" id="select_mensagem_resposta" required onchange="preencherFormularioResposta()">
                    <option value="">Selecione uma Mensagem</option>
                    <?php foreach ($mensagens as $msg): ?>
                        <option value="<?= $msg['id_mensagem'] ?>"
                            data-email="<?= htmlspecialchars($msg['email_mensagem']) ?>"
                            data-conteudo="<?= htmlspecialchars($msg['conteudo_mensagem']) ?>">
                            ID: <?= $msg['id_mensagem'] ?> - <?= substr($msg['conteudo_mensagem'], 0, 30) ?>...
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="email_resposta">Email do Remetente:</label>
                <input type="email" name="email" id="email_resposta" readonly>

                <label for="mensagem_original">Mensagem Original:</label>
                <textarea id="mensagem_original" rows="4" readonly></textarea>

                <label for="response">Sua Resposta:</label>
                <textarea name="response" rows="6" required></textarea>

                <input type="submit" value="Enviar Resposta">
            </form>
        </div>

        <div class="form-container" id="formulario">
            <h2>Editar Status da Mensagem</h2>
            <form method="post" action="../routes/mensagemRoutes.php">
                <input type="hidden" name="action" value="alterarStatus">

                <label for="id_mensagem_edit">Selecione a Mensagem:</label>
                <select name="id_mensagem_edit" id="select_mensagem_editar" required onchange="preencherFormularioStatus()">
                    <option value="">Selecione uma Mensagem</option>
                    <?php foreach ($mensagens as $msg): ?>
                        <option value="<?= $msg['id_mensagem'] ?>"
                            data-conteudo="<?= htmlspecialchars($msg['conteudo_mensagem']) ?>"
                            data-email="<?= htmlspecialchars($msg['email_mensagem']) ?>"
                            data-data="<?= $msg['data_envio'] ?>"
                            data-status="<?= $msg['status_mensagem'] ?>"
                            data-passageiro="<?= $msg['nome_passageiro'] ?>">
                            ID: <?= $msg['id_mensagem'] ?> - <?= substr($msg['conteudo_mensagem'], 0, 30) ?>...
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="conteudo_edit">Conteúdo:</label>
                <textarea id="conteudo_edit" disabled></textarea>

                <label for="email_edit">Email:</label>
                <input type="email" id="email_edit" disabled>

                <label for="data_edit">Data de Envio:</label>
                <input type="datetime-local" id="data_edit" disabled>

                <label for="passageiro_edit">Passageiro:</label>
                <input type="text" id="passageiro_edit" disabled>

                <label for="status_edit">Status:</label>
                <select name="status_edit" id="status_edit" required>
                    <option value="Lida">Lida</option>
                    <option value="Não Lida">Não Lida</option>
                    <option value="Respondida">Respondida</option>
                </select>

                <input type="submit" value="Atualizar Status">
            </form>
        </div>

        <div class="form-container" id="listar">
            <h2>Lista de Mensagens</h2>
            <form method="post" action="../routes/mensagemRoutes.php">
                <input type="hidden" name="action" value="deleteMultiple">

                <div class="table-container">
                    <table class="styled-table">
                        <thead>
                            <tr>
                                <th>Excluir</th>
                                <th>Conteúdo</th>
                                <th>Email</th>
                                <th>Data</th>
                                <th>Status</th>
                                <th>Passageiro</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($mensagens as $msg): ?>
                                <tr>
                                    <td><input type="checkbox" name="ids[]" value="<?= $msg['id_mensagem'] ?>"></td>
                                    <td><?= htmlspecialchars($msg['conteudo_mensagem']) ?></td>
                                    <td><?= htmlspecialchars($msg['email_mensagem']) ?></td>
                                    <td><?= $msg['data_envio'] ?></td>
                                    <td><?= $msg['status_mensagem'] ?></td>
                                    <td><?= htmlspecialchars($msg['nome_passageiro']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="button-wrapper">
                    <input type="submit" value="Excluir Selecionadas" class="btn-delete">
                </div>
            </form>
        </div>
    </main>

    <script>
        function preencherFormularioStatus() {
            const select = document.getElementById('select_mensagem_editar');
            const option = select.options[select.selectedIndex];

            if (option.value) {
                document.getElementById('conteudo_edit').value = option.dataset.conteudo;
                document.getElementById('email_edit').value = option.dataset.email;
                document.getElementById('data_edit').value = option.dataset.data;
                document.getElementById('status_edit').value = option.dataset.status;
                document.getElementById('passageiro_edit').value = option.dataset.passageiro;
            } else {
                document.getElementById('conteudo_edit').value = '';
                document.getElementById('email_edit').value = '';
                document.getElementById('data_edit').value = '';
                document.getElementById('status_edit').value = '';
                document.getElementById('passageiro_edit').value = '';
            }
        }

        function preencherFormularioResposta() {
            const select = document.getElementById('select_mensagem_resposta');
            const option = select.options[select.selectedIndex];

            if (option.value) {
                document.getElementById('email_resposta').value = option.dataset.email;
                document.getElementById('mensagem_original').value = option.dataset.conteudo;
            } else {
                document.getElementById('email_resposta').value = '';
                document.getElementById('mensagem_original').value = '';
            }
        }
    </script>
</body>
</html>