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

    case 'GET':
        if (isset($_GET['action']) && $_GET['action'] === 'deleteMultiple') {
            // Os IDs virão da URL neste caso
            $aeroportoController->delete($_GET['ids'] ?? []);
        } else {
            $aeroportoController->index();
        }
        break;

    default:
        $aeroportoController->index();
        break;
}
?>