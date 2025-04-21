<?php

class Mensagem {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        $query = "SELECT m.id_mensagem, m.conteudo_mensagem, m.email_mensagem, m.data_envio, m.status_mensagem, m.passageiros_id_passageiros, p.nome_passageiro 
                  FROM mensagem_contato m
                  INNER JOIN passageiros p ON m.passageiros_id_passageiros = p.id_passageiros";
        $result = $this->db->query($query);

        $mensagens = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $mensagens[] = $row;
            }
        }
        return $mensagens;
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT m.id_mensagem, m.conteudo_mensagem, m.email_mensagem, m.data_envio, m.status_mensagem, m.passageiros_id_passageiros, p.nome_passageiro 
                                    FROM mensagem_contato m
                                    INNER JOIN passageiros p ON m.passageiros_id_passageiros = p.id_passageiros WHERE id_mensagem = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function updateStatus($id, $status) {
        $stmt = $this->db->prepare("UPDATE mensagem_contato SET status_mensagem = ? WHERE id_mensagem = ?");
        $stmt->bind_param("si", $status, $id);
        return $stmt->execute();
    }

    public function create($conteudo_mensagem, $email_mensagem, $data_envio, $passageiros_id_passageiros) {
        $stmt = $this->db->prepare("INSERT INTO mensagem_contato (conteudo_mensagem, email_mensagem, data_envio, passageiros_id_passageiros) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $conteudo_mensagem, $email_mensagem, $data_envio, $passageiros_id_passageiros);
        return $stmt->execute();
    }

    // Adicione funções para deletar, se necessário
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM mensagem_contato WHERE id_mensagem = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}

?>