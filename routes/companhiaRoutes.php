<?php

require_once('../startup/connectBD.php');
require_once('../app/controllers/CompanhiaController.php');

$companhiaController = new CompanhiaController($mysqli);

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        if (isset($_POST['action'])) {
            if ($_POST['action'] === 'create') {
                $companhiaController->create($_POST);
            } elseif ($_POST['action'] === 'update') {
                $companhiaController->update($_POST);
            } elseif ($_POST['action'] === 'deleteMultiple') {
                $companhiaController->delete($_POST['ids'] ?? []);
            }
        }
        break;
    default:
        $companhiaController->index();
        break;
}

?>