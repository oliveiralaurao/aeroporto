<?php

class Aviao {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM `aeronaveView`";
        $result = $this->db->query($query);
        $avioes = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $avioes[] = $row;
            }
        }
        return $avioes;
    }

    public function create($modelo, $capacidade, $fileiras, $assentosPorFileira, $companhia) {
        $stmt = $this->db->prepare("
            INSERT INTO aeronaves (modelo_aeronave, capacidade_aeronave, quantidade_fileiras, quantidade_assentos_por_fileira, id_companhia)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("siiii", $modelo, $capacidade, $fileiras, $assentosPorFileira, $companhia);
        return $stmt->execute();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM aeronaves WHERE id_aeronave = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function update($id, $modelo, $capacidade, $fileiras, $assentosPorFileira, $companhia) {
        $stmt = $this->db->prepare("
            UPDATE aeronaves
            SET modelo_aeronave = ?, capacidade_aeronave = ?, quantidade_fileiras = ?, quantidade_assentos_por_fileira = ?, id_companhia = ?
            WHERE id_aeronave = ?
        ");
        $stmt->bind_param("siiiii", $modelo, $capacidade, $fileiras, $assentosPorFileira, $companhia, $id);
        return $stmt->execute();
    }

    public function deleteMultiple($ids) {
        if (empty($ids)) {
            return false;
        }
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $query = "DELETE FROM aeronaves WHERE id_aeronave IN ($placeholders)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param(str_repeat('i', count($ids)), ...$ids);
        return $stmt->execute();
    }
}

?>