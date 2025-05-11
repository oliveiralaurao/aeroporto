<?php

class Reserva {
    private $conn;

    public function __construct($mysqli) {
        $this->conn = $mysqli;
    }

    public function getAll($id_passageiro, $passagens) {
        if (empty($passagens)) return [];

        $placeholders = implode(',', array_fill(0, count($passagens), '?'));
        $types = str_repeat('i', count($passagens) + 1);
        $params = array_merge([$id_passageiro], $passagens);

        $sql = "SELECT
        p.nome_passageiro,
        r.status_reserva,
        ao.nome_aeroporto AS nome_aeroporto_origem,
        ad.nome_aeroporto AS nome_aeroporto_destino,
        po.numero_portao,
        ter.nome_terminal,
        asse.numero_assento,
        v.id_voo
    FROM
        reservas r
    INNER JOIN
        passageiros p ON r.id_passageiro = p.id_passageiros
    INNER JOIN
        voos v ON r.id_voo = v.id_voo
    INNER JOIN
        aeroportos ao ON v.origem_voo = ao.id_aeroporto
    INNER JOIN
        aeroportos ad ON v.destino_voo = ad.id_aeroporto
    INNER JOIN
        portoes po ON v.id_portao = po.id_portao
    INNER JOIN
        terminais ter ON po.id_terminal = ter.id_terminal
    INNER JOIN
        passagens pass ON r.passagens_id_passagem = pass.id_passagem
    INNER JOIN
        assentos asse ON pass.assentos_id_assento = asse.id_assento
    WHERE id_passageiro = ? AND r.passagens_id_passagem IN ($placeholders)";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) return [];

        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();

        $reservas = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        $stmt->close();

        // Agora adicionamos as escalas para cada reserva
        foreach ($reservas as &$reserva) {
            $id_voo = $reserva['id_voo'];

            // Buscar escalas do voo
            $stmt = $this->conn->prepare("SELECT a.nome_aeroporto
                                      FROM segmentovoo sv
                                      JOIN aeroportos a ON sv.destino = a.id_aeroporto
                                      WHERE sv.id_voo = ?");
            $stmt->bind_param("i", $id_voo);
            $stmt->execute();
            $result = $stmt->get_result();

            $escalas = [];
            while ($row = $result->fetch_assoc()) {
                $escalas[] = $row['nome_aeroporto'];
            }
            $stmt->close();

            // Adiciona escalas à reserva
            if (!empty($escalas)) {
                $reserva['escalas'] = $escalas;
            } else {
                $reserva['escalas'] = null;
            }
        }

        return $reservas;
    }


    public function getReserva($id_passageiro) {

        if (empty($id_passageiro)) return [];

        $sql = "SELECT
                r.id_reserva,
                p.nome_passageiro,
                r.status_reserva,
                ao.nome_aeroporto AS nome_aeroporto_origem,
                ad.nome_aeroporto AS nome_aeroporto_destino,
                po.numero_portao,
                ter.nome_terminal,
                asse.numero_assento,
                v.numero_voo,
                DATE_FORMAT(v.data_saida, '%d/%m/%Y %H:%i:%s') AS data_saida
            FROM
                reservas r
            INNER JOIN
                passageiros p ON r.id_passageiro = p.id_passageiros
            INNER JOIN
                voos v ON r.id_voo = v.id_voo
            INNER JOIN
                aeroportos ao ON v.origem_voo = ao.id_aeroporto
            INNER JOIN
                aeroportos ad ON v.destino_voo = ad.id_aeroporto
            INNER JOIN
                portoes po ON v.id_portao = po.id_portao
            INNER JOIN
                terminais ter ON po.id_terminal = ter.id_terminal
            INNER JOIN
                passagens pass ON r.passagens_id_passagem = pass.id_passagem
            INNER JOIN
                assentos asse ON pass.assentos_id_assento = asse.id_assento
            WHERE r.id_passageiro = ?";


        $stmt = $this->conn->prepare($sql);

        if (!$stmt) return [];

        $stmt->bind_param("i", $id_passageiro);
        $stmt->execute();
        $result = $stmt->get_result();


        $reservas = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];


        $stmt->close();

        return $reservas;
    }






    public function create($status, $id_passageiro, $id_voo, $passagens_ids, $assentos_ids) {
        $this->conn->begin_transaction();

        $stmt = $this->conn->prepare("INSERT INTO reservas (status_reserva, id_passageiro, id_voo, passagens_id_passagem) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            $this->conn->rollback();
            return false;
        }

        $update = $this->conn->prepare("UPDATE assentos SET status_assento = 'ocupado' WHERE id_assento = ?");
        if (!$update) {
            $stmt->close();
            $this->conn->rollback();
            return false;
        }

        $passagens_inseridas = [];

        for ($i = 0; $i < count($passagens_ids); $i++) {
            $id_passagem = $passagens_ids[$i];
            $id_assento = $assentos_ids[$i] ?? null;

            if ($id_assento === null) {
                $stmt->close();
                $update->close();
                $this->conn->rollback();
                return false;
            }

            $stmt->bind_param("siii", $status, $id_passageiro, $id_voo, $id_passagem);
            if (!$stmt->execute()) {
                $stmt->close();
                $update->close();
                $this->conn->rollback();
                return false;
            }

            $update->bind_param("i", $id_assento);
            if (!$update->execute()) {
                $stmt->close();
                $update->close();
                $this->conn->rollback();
                return false;
            }

            $passagens_inseridas[] = $id_passagem;

        }

        $stmt->close();
        $update->close();

        $this->conn->commit();
        return $passagens_inseridas;
    }


    public function cancelarReserva($id_reserva, $assentoN) {
        $sql = "UPDATE reservas SET status_reserva = 'Cancelada' WHERE id_reserva = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $id_reserva);
        $resultReserva = $stmt->execute();
        $stmt->close();

        if (!$resultReserva) {
            return false;
        }

        $sqlAssento = "UPDATE assentos SET status_assento = 'Disponível' WHERE numero_assento = ?";
        $stmtAssento = $this->conn->prepare($sqlAssento);
        if (!$stmtAssento) {
            return false;
        }

        $stmtAssento->bind_param("s", $assentoN);
        $resultAssento = $stmtAssento->execute();
        $stmtAssento->close();

        if (!$resultAssento) {
            return false;
        }

        return true;
    }


}
