<?php

require_once('../startup/connectBD.php');
require_once '../app/controllers/SegmentoVooController.php';

$segmentoVooController = new SegmentoVooController($mysqli);

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        if (isset($_POST['action'])) {
            if ($_POST['action'] === 'create') {
                $segmentoVooController->create($_POST);
            } elseif ($_POST['action'] === 'update') {
                $segmentoVooController->update($_POST);
            } elseif ($_POST['action'] === 'deleteMultiple') {
                $segmentoVooController->deleteMultiple($_POST['segmentos_ids'] ?? []);
            }
        }
        break;

    default:
        $segmentoVooController->index();
        break;
}

?>