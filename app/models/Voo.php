<?php

class Voo
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $query = "SELECT
            v.id_voo,
            v.numero_voo,
            aeronave.modelo_aeronave,
            portao.numero_portao,
            v.data_chegada,
            v.data_saida,
            origem.nome_aeroporto AS origem_nome,
            destino.nome_aeroporto AS destino_nome,
            v.tipo_voo,
            v.status_voo,
            v.localizacao_voo,
            v.id_aeronave,
            v.id_portao,
            v.origem_voo,
            v.destino_voo
        FROM
            `voos` v
        JOIN
            `aeronaves` aeronave ON v.id_aeronave = aeronave.id_aeronave
        JOIN
            `portoes` portao ON v.id_portao = portao.id_portao
        JOIN
            `aeroportos` origem ON v.origem_voo = origem.id_aeroporto
        JOIN
            `aeroportos` destino ON v.destino_voo = destino.id_aeroporto";
        $result = $this->db->query($query);
        $voos = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $voos[] = $row;
            }
        }
        return $voos;
    }

    public function create($numero_voo, $id_aeronave, $id_portao, $data_chegada, $data_saida, $origem_voo, $destino_voo, $tipo_voo, $status_voo, $localizacao_voo)
    {
        $stmt = $this->db->prepare("INSERT INTO voos (numero_voo, id_aeronave, id_portao, data_chegada, data_saida, origem_voo, destino_voo, tipo_voo, status_voo, localizacao_voo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("siisssisss", $numero_voo, $id_aeronave, $id_portao, $data_chegada, $data_saida, $origem_voo, $destino_voo, $tipo_voo, $status_voo, $localizacao_voo);
        return $stmt->execute();
    }


    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT
            v.id_voo,
            v.numero_voo,
            v.id_aeronave,
            v.id_portao,
            v.data_chegada,
            v.data_saida,
            v.origem_voo,
            v.destino_voo,
            v.tipo_voo,
            v.status_voo,
            v.localizacao_voo
        FROM
            voos v
        WHERE
            v.id_voo = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function update($id_voo, $numero_voo, $id_aeronave, $id_portao, $data_chegada, $data_saida, $origem_voo, $destino_voo, $tipo_voo, $status_voo, $localizacao_voo)
    {
        $stmt = $this->db->prepare("UPDATE voos SET numero_voo = ?, id_aeronave = ?, id_portao = ?, data_chegada = ?, data_saida = ?, origem_voo = ?, destino_voo = ?, tipo_voo = ?, status_voo = ?, localizacao_voo = ? WHERE id_voo = ?");
        $stmt->bind_param("siisssisssi", $numero_voo, $id_aeronave, $id_portao, $data_chegada, $data_saida, $origem_voo, $destino_voo, $tipo_voo, $status_voo, $localizacao_voo, $id_voo);
        return $stmt->execute();
    }


    public function deleteMultiple($ids)
    {
        if (empty($ids)) {
            return false;
        }
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $query = "DELETE FROM voos WHERE id_voo IN ($placeholders)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param(str_repeat('i', count($ids)), ...$ids);
        return $stmt->execute();
    }

    public function buscarPorDestino($destino) {
        $destino = "%$destino%";
        $stmt = $this->db->prepare("SELECT
        v.id_voo,
        v.numero_voo,
        aeronave.modelo_aeronave,
        portao.numero_portao,
        v.data_chegada,
        v.data_saida,
        origem.nome_aeroporto AS origem_nome,
        origem.localizacao_aeroporto AS nome_cidade,
        destino.nome_aeroporto AS destino_nome,
        destino.localizacao_aeroporto AS nome_cidade_volta,
        v.tipo_voo,
        v.status_voo,
        v.localizacao_voo,
        v.id_aeronave,
        v.id_portao,
        v.origem_voo,
        v.destino_voo
    FROM
        `voos` v
    JOIN
        `aeronaves` aeronave ON v.id_aeronave = aeronave.id_aeronave
    JOIN
        `portoes` portao ON v.id_portao = portao.id_portao
    JOIN
        `aeroportos` origem ON v.origem_voo = origem.id_aeroporto
    JOIN
        `aeroportos` destino ON v.destino_voo = destino.id_aeroporto
    WHERE
        destino.nome_aeroporto LIKE ?");
        $stmt->bind_param("s", $destino);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function getVoosPorTipo($tipo)
    {
        $stmt = $this->db->prepare("SELECT
        v.id_voo,
        v.numero_voo,
        aeronave.modelo_aeronave,
        portao.numero_portao,
        v.data_chegada,
        v.data_saida,
        origem.nome_aeroporto AS origem_nome,
        origem.localizacao_aeroporto AS nome_cidade,
        destino.nome_aeroporto AS destino_nome,
        destino.localizacao_aeroporto AS nome_cidade_volta,
        v.tipo_voo,
        v.status_voo,
        v.localizacao_voo,
        v.id_aeronave,
        v.id_portao,
        v.origem_voo,
        v.destino_voo
    FROM
        `voos` v
    JOIN
        `aeronaves` aeronave ON v.id_aeronave = aeronave.id_aeronave
    JOIN
        `portoes` portao ON v.id_portao = portao.id_portao
    JOIN
        `aeroportos` origem ON v.origem_voo = origem.id_aeroporto
    JOIN
        `aeroportos` destino ON v.destino_voo = destino.id_aeroporto
    WHERE
        localizacao_voo = ?");

        $stmt->bind_param("s", $tipo);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }


}