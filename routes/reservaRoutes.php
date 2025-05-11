<?php

require_once('../startup/connectBD.php');
require_once('../app/controllers/ReservaController.php');

$reservaController = new ReservaController($mysqli);

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        if (isset($_POST['action'])) {
            if ($_POST['action'] === 'delete') {
                $reservaController->cancelarReserva($_POST);
            }
        } else {
            $reservaController->store($_POST);
        }
        break;

    case 'GET':
        if (isset($_GET['perfil'])) {
            $reservaController->listarReservas();
        } else {
            $reservaController->index();
        }
        break;
}
