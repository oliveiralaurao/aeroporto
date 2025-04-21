<?php

require_once('../startup/connectBD.php');
require_once('../app/controllers/UsuarioController.php');

$usuarioController = new UsuarioController($mysqli);

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        if (isset($_POST['action'])) {
            if ($_POST['action'] === 'create') {
                $usuarioController->store($_POST);
            } elseif ($_POST['action'] === 'update') {
                $usuarioController->update($_POST);
            }elseif ($_POST['action'] === 'login') {
                $usuarioController->login($_POST);
            }elseif ($_POST['action'] === 'createUser') {
                $usuarioController->storeUser($_POST);
            } elseif ($_POST['action'] === 'deleteMultiple') {
                $usuarioController->delete($_POST['ids'] ?? []);
            }
        }
        break;

    default:
        $usuarioController->index();
        break;
}


?>
