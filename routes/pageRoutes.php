<?php

require_once('../../../startup/connectBD.php');
require_once('../../../app/controllers/VooController.php');
require_once('../../../app/controllers/AssentoController.php');

session_start();

if (isset($_GET['id_voo'])) {
    header('Content-Type: application/json');

    $assentoController = new AssentoController($mysqli);
    $assentoController->getAssentosPorVoo($_GET['id_voo']);
    exit;
}

$vooController = new VooController($mysqli);

$dados = $vooController->listarVoosPublico();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        if (isset($_POST['pesquisar_destino'])) {
            $vooController->buscarPorDestino($_POST['pesquisar_destino']);
            $dados['voosBusca'] = $_SESSION['voos_busca'] ?? [];
        }
        break;
    case 'GET':
    default:

        if (isset($_SESSION['voos_busca'])) {
            $dados['voosBusca'] = $_SESSION['voos_busca'];
        }
        break;
}

extract($dados);
require_once('index.php');

?>