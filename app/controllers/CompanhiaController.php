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
        include('../app/views/ctrldev/companhia/index.php');
    }

    public function create($data) {
        $nome = $this->db->real_escape_string($data['nome_companhia']);
        $codigo = $this->db->real_escape_string($data['codigo_companhia']);

        $query = "INSERT INTO `companhias` (`nome_companhia`, `codigo_companhia`) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ss", $nome, $codigo);

        if ($stmt->execute()) {
            header("Location: ?msg=Companhia cadastrada com sucesso!");
        } else {
            header("Location: ?msg=Erro ao cadastrar companhia: " . $stmt->error);
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
            header("Location: ?msg=Companhia atualizada com sucesso!");
        } else {
            header("Location: ?msg=Erro ao atualizar companhia: " . $stmt->error);
        }

        $stmt->close();
        exit();
    }

    public function delete($ids) {
        if (empty($ids)) {
            header("Location: ?msg=Nenhuma companhia selecionada para exclusão!");
            exit();
        }

        try {
            if ($this->model->deleteMultiple($ids)) {
                header("Location: ?msg=Companhia(s) excluída(s) com sucesso!");
            } else {
                header("Location: ?msg=Erro ao excluir companhia(s)!");
            }
        } catch (Exception $e) {
            if ($e->getMessage() === 'constraint_violation') {
                header("Location: ?msgP=Esta companhia não pode ser excluída porque está associada a aeronaves. Por favor, exclua ou desassocie esses itens antes de tentar novamente.");
            } else {
                header("Location: ?msg=Erro inesperado ao excluir companhia(s)!");
            }
        }
        exit();
    }

}

?>