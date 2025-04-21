<?php

require_once('../startup/connectBD.php');
require_once('../app/controllers/AeroportoController.php');

$aeroportoController = new AeroportoController($mysqli);

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        if (isset($_POST['action'])) {
            if ($_POST['action'] === 'create') {
                $aeroportoController->store($_POST);
            } elseif ($_POST['action'] === 'update') {
                $aeroportoController->update($_POST);
            } elseif ($_POST['action'] === 'deleteMultiple') {
                $aeroportoController->delete($_POST['ids'] ?? []);
            }
        }
        break;

    default:
        $aeroportoController->index();
        break;
}
?>  