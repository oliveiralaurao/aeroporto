<?php

require_once('../startup/connectBD.php');
require_once('../app/controllers/AviaoController.php');

$aviaoController = new AviaoController($mysqli);

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        if (isset($_POST['action'])) {
            if ($_POST['action'] === 'create') {
                $aviaoController->create($_POST);
            } elseif ($_POST['action'] === 'update') {
                $aviaoController->update($_POST);
            } elseif ($_POST['action'] === 'deleteMultiple') {
                $aviaoController->delete($_POST['ids'] ?? []);
            }
        }
        break;

    default:
            $aviaoController->index();
        
        break;
}
?>