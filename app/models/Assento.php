<?php

class AssentoModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllAssentos() {
        $query = "SELECT a.id_assento, a.numero_assento, a.status_assento, v.numero_voo, a.id_voo 
                  FROM assentos a
                  JOIN voos v ON a.id_voo = v.id_voo";
        $result = $this->db->query($query);
        $assentos = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $assentos[] = $row;
            }
        }
        return $assentos;
    }

    public function getVooOptions() {
        $query = "SELECT id_voo, numero_voo FROM voos";
        $result = $this->db->query($query);
        $voos = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $voos[] = $row;
            }
        }
        return $voos;
    }

    public function createAssento($data) {
        $stmt = $this->db->prepare("INSERT INTO assentos (numero_assento, status_assento, id_voo) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $data['numero_assento'], $data['status_assento'], $data['id_voo']);
        return $stmt->execute();
    }

    public function getAssentoById($id) {
        $stmt = $this->db->prepare("SELECT * FROM assentos WHERE id_assento = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updateAssento($data) {
        $stmt = $this->db->prepare("UPDATE assentos SET numero_assento = ?, status_assento = ?, id_voo = ? WHERE id_assento = ?");
        $stmt->bind_param("ssii", $data['update_numero_assento'], $data['update_status_assento'], $data['update_id_voo'], $data['id_assento']);
        return $stmt->execute();
    }

    public function deleteAssentos($ids) {
        if (empty($ids)) {
            return false;
        }
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $query = "DELETE FROM assentos WHERE id_assento IN ($placeholders)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param(str_repeat('i', count($ids)), ...$ids);
        return $stmt->execute();
    }
    public function getAssentosPorVoo($id_voo)
    {


        // busca assentos da aeronave
        $queryAssentos = "SELECT numero_assento, status_assento 
                          FROM assentos 
                          WHERE id_voo = ?";
        $stmtAssentos = $this->db->prepare($queryAssentos);
        $stmtAssentos->bind_param('i', $id_voo);
        $stmtAssentos->execute();
        $resultAssentos = $stmtAssentos->get_result();

        $assentos = [];
        while ($row = $resultAssentos->fetch_assoc()) {
            $assentos[] = $row;
        }

        return [

            'assentos' => $assentos
        ];
    }
}

?>