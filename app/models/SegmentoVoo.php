<?php

class SegmentoVooModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        $query = "SELECT sv.id_segmento, v.numero_voo, oa.nome_aeroporto AS origem, da.nome_aeroporto AS destino, sv.hora_partida, sv.hora_chegada, sv.id_voo, v.numero_voo,oa.id_aeroporto AS idorigem, da.id_aeroporto AS iddestino
                  FROM `segmentoVoo` sv
                  JOIN `voos` v ON sv.id_voo = v.id_voo
                  JOIN `aeroportos` oa ON sv.origem = oa.id_aeroporto
                  JOIN `aeroportos` da ON sv.destino = da.id_aeroporto;";
        $result = $this->db->query($query);
        $segmentos = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $segmentos[] = $row;
            }
        }
        return $segmentos;
    }

    public function getById($id) {
        $query = "SELECT * FROM `segmentoVoo` WHERE id_segmento = ?";
        if ($stmt = $this->db->prepare($query)) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        }
        return null;
    }

    public function create($id_voo, $origem, $destino, $hora_partida, $hora_chegada) {
        $query = "INSERT INTO `segmentoVoo` (id_voo, origem, destino, hora_partida, hora_chegada) VALUES (?, ?, ?, ?, ?)";
        if ($stmt = $this->db->prepare($query)) {
            $stmt->bind_param("issss", $id_voo, $origem, $destino, $hora_partida, $hora_chegada);
            return $stmt->execute();
        }
        return false;
    }

    public function update($id_segmento, $id_voo, $origem, $destino, $hora_partida, $hora_chegada) {
        $query = "UPDATE `segmentoVoo` SET id_voo = ?, origem = ?, destino = ?, hora_partida = ?, hora_chegada = ? WHERE id_segmento = ?";
        if ($stmt = $this->db->prepare($query)) {
            $stmt->bind_param("issssi", $id_voo, $origem, $destino, $hora_partida, $hora_chegada, $id_segmento);
            return $stmt->execute();
        }
        return false;
    }

    public function delete($id) {
        $query = "DELETE FROM `segmentoVoo` WHERE id_segmento = ?";
        if ($stmt = $this->db->prepare($query)) {
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        }
        return false;
    }

    public function deleteMultiple(array $ids) {
        if (empty($ids)) {
            return false;
        }
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $types = str_repeat('i', count($ids));
        $query = "DELETE FROM `segmentoVoo` WHERE id_segmento IN ($placeholders)";
        if ($stmt = $this->db->prepare($query)) {
            $stmt->bind_param($types, ...$ids);
            return $stmt->execute();
        }
        return false;
    }

    public function getVoos() {
        $query = "SELECT id_voo, numero_voo FROM `voos`";
        $result = $this->db->query($query);
        $voos = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $voos[] = $row;
            }
        }
        return $voos;
    }

    public function getAeroportos() {
        $query = "SELECT id_aeroporto, nome_aeroporto FROM `aeroportos`";
        $result = $this->db->query($query);
        $aeroportos = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $aeroportos[] = $row;
            }
        }
        return $aeroportos;
    }
}

?>