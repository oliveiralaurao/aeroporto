<?php

require_once('../startup/connectBD.php');
require_once('../app/controllers/VooController.php');
require_once('../app/controllers/AssentoController.php');

session_start();

if (isset($_GET['id_voo'])) {
    header('Content-Type: application/json');

    $assentoController = new AssentoController($mysqli);
    $assentoController->getAssentosPorVoo($_GET['id_voo']);
    exit;
}


extract($dados);
require_once('index.php');

?>