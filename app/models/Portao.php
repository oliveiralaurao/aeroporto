<?php

class Portao {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        $sql = "SELECT 
                    p.id_portao, 
                    p.numero_portao, 
                    p.id_terminal,
                    t.nome_terminal,
                    a.nome_aeroporto
                FROM `portoes` p
                INNER JOIN `terminais` t ON p.id_terminal = t.id_terminal
                INNER JOIN `aeroportos` a ON t.id_aeroporto = a.id_aeroporto;";
        $result = $this->db->query($sql);
        $portoes = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $portoes[] = $row;
            }
        }
        return $portoes;
    }


    public function create($numero_portao, $id_terminal) {
        $query = "INSERT INTO `portoes` (`numero_portao`, `id_terminal`) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("si", $numero_portao, $id_terminal);
        return $stmt->execute();
    }

    public function update($id, $numero_portao, $id_terminal) {
        $query = "UPDATE `portoes` 
                  SET `numero_portao` = ?, `id_terminal` = ? 
                  WHERE `id_portao` = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sii", $numero_portao, $id_terminal, $id);
        return $stmt->execute();
    }

    public function deleteMultiple($ids) {
        if (empty($ids)) {
            return false;
        }
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $queryDelete = "DELETE FROM `portoes` WHERE `id_portao` IN ($placeholders)";
        if ($stmt = $this->db->prepare($queryDelete)) {
            $stmt->bind_param(str_repeat('i', count($ids)), ...$ids);
            return $stmt->execute();
        }
        return false;
    }

    public function getById($id) {
        $sql = "SELECT 
                    p.id_portao, 
                    p.numero_portao, 
                    p.id_terminal,
                    t.nome_terminal,
                    a.nome_aeroporto
                FROM `portoes` p
                INNER JOIN `terminais` t ON p.id_terminal = t.id_terminal
                INNER JOIN `aeroportos` a ON t.id_aeroporto = a.id_aeroporto
                WHERE p.id_portao = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}

?>