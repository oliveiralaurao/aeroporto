<?php

class Aeroporto {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM `aeroportos`";
        $result = $this->db->query($query);
        $aeroportos = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $aeroportos[] = $row;
            }
        }
        return $aeroportos;
    }

    public function create($nome, $codigo, $localizacao) {
        $stmt = $this->db->prepare("INSERT INTO aeroportos (nome_aeroporto, codigo_aeroporto, localizacao_aeroporto) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $codigo, $localizacao);
        return $stmt->execute();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM aeroportos WHERE id_aeroporto = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function update($id, $nome, $codigo, $localizacao) {
        $stmt = $this->db->prepare("UPDATE aeroportos SET nome_aeroporto = ?, codigo_aeroporto = ?, localizacao_aeroporto = ? WHERE id_aeroporto = ?");
        $stmt->bind_param("sssi", $nome, $codigo, $localizacao, $id);
        return $stmt->execute();
    }

    public function deleteMultiple($ids) {
        if (empty($ids)) {
            return false;
        }
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $query = "DELETE FROM aeroportos WHERE id_aeroporto IN ($placeholders)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param(str_repeat('i', count($ids)), ...$ids);
        return $stmt->execute();
    }
    public function checkDependents($ids) {
        if (empty($ids)) {
            return false;
        }

        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $query = "
        SELECT destino 
        FROM segmentovoo 
        INNER JOIN aeroportos ON segmentovoo.destino = aeroportos.id_aeroporto 
        WHERE destino IN ($placeholders)

        UNION

        SELECT terminais.id_aeroporto 
        FROM terminais 
        INNER JOIN aeroportos ON terminais.id_aeroporto = aeroportos.id_aeroporto 
        WHERE terminais.id_aeroporto IN ($placeholders)
    ";

        $stmt = $this->db->prepare($query);


        $params = array_merge($ids, $ids);
        $types = str_repeat('i', count($params));


        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }

}

?>
