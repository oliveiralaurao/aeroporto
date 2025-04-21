<?php

require_once('../startup/connectBD.php');
require_once('../app/controllers/AssentoController.php');

$assentoController = new AssentoController($mysqli);

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        if (isset($_POST['action'])) {
            if ($_POST['action'] === 'create') {
                $assentoController->create($_POST);
            } elseif ($_POST['action'] === 'update') {
                $assentoController->update($_POST);
            } elseif ($_POST['action'] === 'deleteMultiple') {
                $assentoController->delete($_POST['ids'] ?? []);
            }
        }
        break;

    default:
        $assentoController->index();
        break;
}
?>