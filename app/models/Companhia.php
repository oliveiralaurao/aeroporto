<?php

class Companhia {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM `companhias`";
        $result = $this->db->query($query);

        $companhias = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $companhias[] = $row;
            }
        }
        return $companhias;
    }

    public function create($nome, $codigo) {
        $stmt = $this->db->prepare("INSERT INTO companhias (nome_companhia, codigo_companhia) VALUES (?, ?)");
        $stmt->bind_param("ss", $nome, $codigo);
        return $stmt->execute();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM companhias WHERE id_companhia = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function update($id, $nome, $codigo) {
        $stmt = $this->db->prepare("UPDATE companhias SET nome_companhia = ?, codigo_companhia = ? WHERE id_companhia = ?");
        $stmt->bind_param("ssi", $nome, $codigo, $id);
        return $stmt->execute();
    }

    public function deleteMultiple($ids) {
        if (empty($ids)) {
            return false;
        }

        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $query = "DELETE FROM companhias WHERE id_companhia IN ($placeholders)";
        $stmt = $this->db->prepare($query);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param(str_repeat('i', count($ids)), ...$ids);

        try {
            return $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            if (strpos($e->getMessage(), 'a foreign key constraint fails') !== false) {
                throw new Exception("constraint_violation");
            }
            throw $e;
        }
    }

}

?>