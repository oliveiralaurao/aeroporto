<?php

class Usuario {
    private $conn;

    public function __construct($mysqli) {
        $this->conn = $mysqli;
    }

    public function getAll() {
        $sql = "SELECT * FROM passageiros";
        $result = $this->conn->query($sql);

        $usuarios = [];
        while ($row = $result->fetch_assoc()) {
            $usuarios[] = $row;
        }

        return $usuarios;
    }

    public function create($nome, $email, $senha, $telefone, $pais, $documento, $data_nasc, $tipo) {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $stmt = $this->conn->prepare("INSERT INTO passageiros (nome_passageiro, email_passageiro, senha_passageiro, telefone_passageiro, pais_passageiro, documento_passageiro, datanasc_passageiro, tipo_passageiro) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $nome, $email, $senhaHash, $telefone, $pais, $documento, $data_nasc, $tipo);

        return $stmt->execute();
    }


    public function update($id, $nome, $email, $senha, $telefone, $pais, $documento, $data_nasc, $tipo) {
        $stmt = $this->conn->prepare("UPDATE passageiros SET nome_passageiro = ?, email_passageiro = ?, senha_passageiro = ?, telefone_passageiro = ?, pais_passageiro = ?, documento_passageiro = ?, datanasc_passageiro = ?, tipo_passageiro = ? WHERE id_passageiros = ?");
        $stmt->bind_param("ssssssssi", $nome, $email, $senha, $telefone, $pais, $documento, $data_nasc, $tipo, $id);
        return $stmt->execute();
    }

    public function deleteMultiple($ids) {
        if (empty($ids)) return false;

        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $types = str_repeat('i', count($ids));
        $stmt = $this->conn->prepare("DELETE FROM passageiros WHERE id_passageiros IN ($placeholders)");

        $stmt->bind_param($types, ...$ids);
        return $stmt->execute();
    }

    public function getByEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM passageiros WHERE email_passageiro = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

}
