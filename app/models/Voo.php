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

    public function getAllByEscala()
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
            `aeroportos` destino ON v.destino_voo = destino.id_aeroporto WHERE tipo_voo = 'Escala'";
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

        $stmt = $this->db->prepare("SELECT v.*, a.nome_aeroporto AS nome_origem, ap.nome_aeroporto AS nome_destino, p.numero_portao, t.nome_terminal
        FROM voos v
        JOIN aeroportos a ON v.origem_voo = a.id_aeroporto
        JOIN aeroportos ap ON v.destino_voo = ap.id_aeroporto
        JOIN portoes p ON v.id_portao = p.id_portao
        JOIN terminais t ON p.id_terminal = t.id_terminal
        WHERE v.id_voo = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $voo = $stmt->get_result()->fetch_assoc();
        $stmt->close();


        $stmt = $this->db->prepare("SELECT a.nome_aeroporto
        FROM segmentovoo sv
        JOIN aeroportos a ON sv.destino = a.id_aeroporto
        WHERE sv.id_voo = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();


        $escalas = [];
        while ($row = $result->fetch_assoc()) {
            $escalas[] = $row['nome_aeroporto'];
        }
        $stmt->close();


        if (!empty($escalas)) {
            $voo['escalas'] = $escalas;
        } else {
            $voo['escalas'] = null;
        }

        return $voo;
    }



    public function update($id_voo, $numero_voo, $id_aeronave, $id_portao, $data_chegada, $data_saida, $origem_voo, $destino_voo, $tipo_voo, $status_voo, $localizacao_voo)
    {
        $stmt = $this->db->prepare("UPDATE voos SET numero_voo = ?, id_aeronave = ?, id_portao = ?, data_chegada = ?, data_saida = ?, origem_voo = ?, destino_voo = ?, tipo_voo = ?, status_voo = ?, localizacao_voo = ? WHERE id_voo = ?");
        $stmt->bind_param("siisssisssi", $numero_voo, $id_aeronave, $id_portao, $data_chegada, $data_saida, $origem_voo, $destino_voo, $tipo_voo, $status_voo, $localizacao_voo, $id_voo);
        return $stmt->execute();
    }


    public function deleteMultiple($ids) {
        if (empty($ids)) {
            return false;
        }

        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $query = "DELETE FROM voos WHERE id_voo IN ($placeholders)";
        $stmt = $this->db->prepare($query);
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
    public function getPainelVoos() {
        $stmt = $this->db->prepare("
        SELECT 
            v.numero_voo, 
            c.nome_companhia AS companhia, 
            ar.nome_aeroporto AS origem, 
            ard.nome_aeroporto AS destino,
            DATE_FORMAT(v.data_saida, '%d/%m/%Y %H:%i:%s') AS data_saida,
            DATE_FORMAT(v.data_chegada, '%d/%m/%Y %H:%i:%s') AS data_chegada,
            p.numero_portao AS portao,
            v.status_voo AS status
        FROM voos v
        JOIN aeroportos ar ON v.origem_voo = ar.id_aeroporto
        JOIN aeroportos ard ON v.destino_voo = ard.id_aeroporto
        JOIN aeronaves a ON v.id_aeronave = a.id_aeronave
        JOIN companhias c ON a.id_companhia = c.id_companhia
        JOIN portoes p ON v.id_portao = p.id_portao
        ORDER BY v.data_saida DESC
    ");

        $stmt->execute();
        $result = $stmt->get_result();

        $dados = [];
        while ($row = $result->fetch_assoc()) {
            $dados[] = $row;
        }

        return $dados;
    }






}