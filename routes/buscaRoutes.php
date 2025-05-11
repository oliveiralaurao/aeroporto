<?php
require_once('../startup/connectBD.php');


session_start();

$query_voos = "SELECT COUNT(*) AS total_voos FROM voos";
$query_passagens = "SELECT COUNT(*) AS total_passagens FROM passagens";
$query_aeronaves = "SELECT COUNT(*) AS total_aeronaves FROM aeronaves";
$query_assentos = "SELECT COUNT(*) AS total_assentos FROM assentos";
$query_companhias = "SELECT COUNT(*) AS total_companhias FROM companhias";
$query_aeroportos = "SELECT COUNT(*) AS total_aeroportos FROM aeroportos";
$query_mensagens = "SELECT COUNT(*) AS mensagens_nao_lidas FROM mensagem_contato WHERE status_mensagem = 'Não lida'";
$query_usuarios = "SELECT COUNT(*) AS total_usuarios FROM passageiros";
$query_portoes = "SELECT COUNT(*) AS total_portao FROM portoes";
$query_escala = "SELECT COUNT(*) AS total_escalas FROM segmentovoo";


$total_voos = $mysqli->query($query_voos)->fetch_assoc();
$total_passagens = $mysqli->query($query_passagens)->fetch_assoc();
$total_aeronaves = $mysqli->query($query_aeronaves)->fetch_assoc();
$total_assentos = $mysqli->query($query_assentos)->fetch_assoc();
$total_companhias = $mysqli->query($query_companhias)->fetch_assoc();
$total_aeroportos = $mysqli->query($query_aeroportos)->fetch_assoc();
$mensagens_nao_lidas = $mysqli->query($query_mensagens)->fetch_assoc();
$total_usuarios = $mysqli->query($query_usuarios)->fetch_assoc();
$total_portoes = $mysqli->query($query_portoes)->fetch_assoc();
$total_escala = $mysqli->query($query_escala)->fetch_assoc();


$dashboard = [
    'total_voos' => $total_voos['total_voos'],
    'total_passagens' => $total_passagens['total_passagens'],
    'total_aeronaves' => $total_aeronaves['total_aeronaves'],
    'total_assentos' => $total_assentos['total_assentos'],
    'total_companhias' => $total_companhias['total_companhias'],
    'total_aeroportos' => $total_aeroportos['total_aeroportos'],
    'mensagens_nao_lidas' => $mensagens_nao_lidas['mensagens_nao_lidas'],
    'total_usuarios' => $total_usuarios['total_usuarios'],
    'total_portoes' => $total_portoes['total_portao'],
    'total_escala' => $total_escala['total_escalas']
];

// Enviar os dados como JSON
echo json_encode($dashboard);
exit;
