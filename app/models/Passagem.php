<?php

class Passagem {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        $sql = "SELECT
                   id_passagem,
                    valor_passagem,
                    id_assento,
                    numero_assento,
                    voos.numero_voo,
                    voos.id_voo
                    
                FROM passagens 
                LEFT JOIN assentos ON assentos_id_assento = id_assento INNER JOIN voos ON voos.id_voo = assentos.id_voo;";
        $result = $this->db->query($sql);
        $passagens = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $passagens[] = $row;
            }
        }
        return $passagens;
    }

    public function getById($id) {
        $sql = "SELECT
                    p.id_passagem,
                    p.valor_passagem,
                    a.id_assento,
                    a.numero_assento
                FROM passagens p
                LEFT JOIN assentos a ON p.assentos_id_assento = a.id_assento
                WHERE p.id_passagem = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($valor_passagem, $assentos_id_assento) {
        $sql = "INSERT INTO passagens (valor_passagem, assentos_id_assento) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $valor_passagem, $assentos_id_assento);
        return $stmt->execute();
    }

    public function update($id, $valor_passagem, $assentos_id_assento) {
        $sql = "UPDATE passagens SET valor_passagem = ?, assentos_id_assento = ? WHERE id_passagem = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("isi", $valor_passagem, $assentos_id_assento, $id);
        return $stmt->execute();
    }


    public function delete($id) {
        $sql = "DELETE FROM passagens WHERE id_passagem = ?";
        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $id);

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