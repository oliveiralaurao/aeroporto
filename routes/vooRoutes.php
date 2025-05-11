<?php
require_once('../startup/connectBD.php');
require_once('../app/controllers/VooController.php');

session_start();

$vooController = new VooController($mysqli);

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        if (isset($_POST['action'])) {
            if ($_POST['action'] === 'create') {
                $vooController->create($_POST);
            } elseif ($_POST['action'] === 'update') {
                $vooController->update($_POST);
            } elseif ($_POST['action'] === 'deleteMultiple') {
                $vooController->delete($_POST['ids'] ?? []);
            }
        }
        break;

    case 'GET':
    default:
        if (isset($_GET['pesquisar_destino'])) {
            $vooController->buscarPorDestino($_GET['pesquisar_destino']);
        }elseif ($_SERVER['REQUEST_URI'] === '/aeroporto') {
            $vooController->listarVoosPublico();
        }elseif (isset($_GET['id_voo'])) {
            $vooController->getById($_GET['id_voo']);
        }
        elseif (isset($_GET['painel_voos'])) {
            $vooController->painelVoos();
        } else {
            $vooController->index();
        }
        break;
}