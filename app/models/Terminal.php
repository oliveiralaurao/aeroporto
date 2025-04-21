<?php

class Terminal {
    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
    }

    public function listarTodos() {
        $sql = "SELECT t.id_terminal, t.nome_terminal, a.nome_aeroporto, a.id_aeroporto 
                FROM terminais t 
                INNER JOIN aeroportos a ON t.id_aeroporto = a.id_aeroporto";
        return $this->db->query($sql);
    }

    public function listarAeroportos() {
        return $this->db->query("SELECT * FROM aeroportos");
    }

    public function cadastrar($id_aeroporto, $nome_terminal) {
        $stmt = $this->db->prepare("INSERT INTO terminais (id_aeroporto, nome_terminal) VALUES (?, ?)");
        $stmt->bind_param("is", $id_aeroporto, $nome_terminal);
        return $stmt->execute();
    }

    public function atualizar($id_terminal, $id_aeroporto, $nome_terminal) {
        $stmt = $this->db->prepare("UPDATE terminais SET id_aeroporto = ?, nome_terminal = ? WHERE id_terminal = ?");
        $stmt->bind_param("isi", $id_aeroporto, $nome_terminal, $id_terminal);
        return $stmt->execute();
    }

    public function deletar($ids) {
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $query = "DELETE FROM terminais WHERE id_terminal IN ($placeholders)";
        $stmt = $this->db->prepare($query);
        $types = str_repeat('i', count($ids));
        $stmt->bind_param($types, ...$ids);
        return $stmt->execute();
    }
}
