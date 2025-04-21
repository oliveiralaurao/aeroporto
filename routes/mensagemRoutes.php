<?php

require_once('../startup/connectBD.php');
require_once '../app/controllers/MensagemController.php';

$mensagemController = new MensagemController($mysqli);

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        if (isset($_POST['action'])) {
            if ($_POST['action'] === 'enviarResposta') {
                $mensagemController->enviarResposta($_POST['id'], $_POST['email'], $_POST['response']);
            } elseif ($_POST['action'] === 'criar') {
                $mensagemController->criarMensagem($_POST['conteudo_mensagem'], $_POST['email_mensagem'], $_POST['data_envio'], $_POST['passageiros_id_passageiros']);
            } elseif ($_POST['action'] === 'alterarStatus') {
                $mensagemController->alterarStatus($_POST['id_mensagem_edit'], $_POST['status_edit']);
            } elseif ($_POST['action'] === 'deletar') {
                $mensagemController->deletarMensagem($_POST['id']);
            }
        }
        break;

    default:
        $mensagemController->index();
        break;
}
?>