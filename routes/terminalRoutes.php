<?php
require_once '../startup/connectBD.php';
require_once '../app/controllers/TerminalController.php';

$controller = new TerminalController($mysqli);

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        if (isset($_POST['action'])) {
            if ($_POST['action'] === 'create') {
                $controller->store($_POST);
            } elseif ($_POST['action'] === 'update') {
                $controller->update($_POST);
            } elseif ($_POST['action'] === 'delete') {
                $controller->delete($_POST['ids'] ?? []);
            }
        }
        break;
    
    default:
        $controller->index();
        break;
}
