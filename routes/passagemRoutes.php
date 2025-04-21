<?php

require_once('../startup/connectBD.php');
require_once('../app/controllers/PassagemController.php');

$passagemController = new PassagemController($mysqli);

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        if (isset($_POST['action'])) {
            if ($_POST['action'] === 'create') {
                $passagemController->create($_POST);
            } elseif ($_POST['action'] === 'update') {
                $passagemController->update($_POST);
            } elseif ($_POST['action'] === 'deleteMultiple') {
                $passagemController->delete($_POST['ids'] ?? []);
            }
        }
        break;

    default:
        $passagemController->index();
        break;
}
?>