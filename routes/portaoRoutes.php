<?php

require_once('../startup/connectBD.php');
require_once '../app/controllers/PortaoController.php';

$portaoController = new PortaoController($mysqli);

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        if (isset($_POST['action'])) {
            if ($_POST['action'] === 'create') {
                $portaoController->create($_POST);
            } elseif ($_POST['action'] === 'update') {
                $portaoController->update($_POST);
            } elseif ($_POST['action'] === 'deleteMultiple') {
                $portaoController->deleteMultiple($_POST['ids'] ?? []);
            }
        }
        break;

    default:
        $portaoController->index();
        break;
}

?>