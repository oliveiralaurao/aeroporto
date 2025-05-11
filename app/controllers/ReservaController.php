<?php

require_once __DIR__ . '/../../app/models/Reserva.php';

class ReservaController {
    private $model;

    public function __construct($mysqli) {
        $this->model = new Reserva($mysqli);
    }

    public function index() {
        $id_passageiro = $_GET['ids'] ?? null;
        $ids_passagens = isset($_GET['ids_passagens']) ? explode(',', $_GET['ids_passagens']) : [];

        $reservas = $this->model->getAll($id_passageiro, $ids_passagens);

        echo json_encode($reservas);
        exit;
    }

    public function listarReservas() {
        session_start();
        $id_passageiro = $_SESSION['usuario_id'];
        $reservas = $this->model->getReserva($id_passageiro);

        echo json_encode($reservas);
        exit;
    }

    public function store($data) {
        $status = 'Confirmada';
        $id_passageiro = $data['id_passageiroR'] ?? null;
        $id_voo = $data['origem'] ?? null;
        $passagens_ids = json_decode($data['passagensS'], true);
        $assentos_ids = json_decode($data['assentoS'], true);


        if (!$id_passageiro || !$id_voo || empty($passagens_ids)) {
            header("Location: ../app/views/public/checkin.php?msg=Dados incompletos para reserva");
            exit;
        }

        $passagens_inseridas = $this->model->create($status, $id_passageiro, $id_voo, $passagens_ids, $assentos_ids);

        if ($passagens_inseridas) {
            $passagens_ids_str = implode(',', $passagens_inseridas);
            header("Location: ../app/views/public/ticket.php?msg=Reserva confirmada&ids_passagens={$passagens_ids_str}&ids={$id_passageiro}");
        } else {
            header("Location: ../app/views/public/checkin.php?msg=Erro ao criar reserva");
        }
    }

    public function cancelarReserva($data) {


        $id_reserva = $data['id_reserva'] ?? null;
        $assentoN = $data['id_assento'] ?? null;

        if ($id_reserva) {
            $cancelado = $this->model->cancelarReserva($id_reserva, $assentoN);

            if ($cancelado) {
                header("Location: /aeroporto/perfil?msg=Reserva cancelada com sucesso");
            } else {
                header("Location: /aeroporto/perfil?msg=Erro ao cancelar reserva");
            }
        } else {
            header("Location: /aeroporto/perfil?msg=ID da reserva não fornecido");
        }
    }
}
