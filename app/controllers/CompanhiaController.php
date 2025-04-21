<?php

require_once __DIR__ . '/../models/Companhia.php';

class CompanhiaController {
    private $model;
    private $db;

    public function __construct($db) {
        $this->model = new Companhia($db);
        $this->db = $db;
    }

    public function index() {
        $companhias = $this->model->getAll();
        $mensagem = $_GET['msg'] ?? '';
        include('../app/views/companhia/index.php');
    }

    public function create($data) {
        $nome = $this->db->real_escape_string($data['nome_companhia']);
        $codigo = $this->db->real_escape_string($data['codigo_companhia']);

        $query = "INSERT INTO `companhias` (`nome_companhia`, `codigo_companhia`) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ss", $nome, $codigo);

        if ($stmt->execute()) {
            header("Location: ../routes/companhiaRoutes.php?msg=Companhia cadastrada com sucesso!");
        } else {
            header("Location: ../routes/companhiaRoutes.php?msg=Erro ao cadastrar companhia: " . $stmt->error);
        }

        $stmt->close();
        exit();
    }

    public function update($data) {
        $id = (int)$data['id_companhia_edit'];
        $nome = $this->db->real_escape_string($data['nome_companhia_edit']);
        $codigo = $this->db->real_escape_string($data['codigo_companhia_edit']);

        $query = "UPDATE `companhias` SET `nome_companhia` = ?, `codigo_companhia` = ? WHERE `id_companhia` = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ssi", $nome, $codigo, $id);

        if ($stmt->execute()) {
            header("Location: ../routes/companhiaRoutes.php?msg=Companhia atualizada com sucesso!");
        } else {
            header("Location: ../routes/companhiaRoutes.php?msg=Erro ao atualizar companhia: " . $stmt->error);
        }

        $stmt->close();
        exit();
    }

    public function delete($ids) {
        if (empty($ids)) {
            header("Location: ../routes/companhiaRoutes.php?msg=Nenhuma companhia selecionada para exclusão!");
            exit();
        }

        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $query = "DELETE FROM `companhias` WHERE `id_companhia` IN ($placeholders)";

        if ($stmt = $this->db->prepare($query)) {
            $stmt->bind_param(str_repeat('i', count($ids)), ...$ids);

            if ($stmt->execute()) {
                header("Location: ../routes/companhiaRoutes.php?msg=Companhia(s) excluída(s) com sucesso!");
            } else {
                header("Location: ../routes/companhiaRoutes.php?msg=Erro ao excluir registro(s): " . $stmt->error);
            }

            $stmt->close();
        }
        exit();
    }
}

?>