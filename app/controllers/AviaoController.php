<?php

require_once __DIR__ . '/../models/Aviao.php';
require_once __DIR__ . '/../models/Companhia.php'; 

class AviaoController {
    private $aviaoModel;
    private $companhiaModel;

    public function __construct($mysqli) {
        $this->aviaoModel = new Aviao($mysqli);
        $this->companhiaModel = new Companhia($mysqli);
    }

    public function index() {
        $mensagem = $_GET['msg'] ?? '';
        $avioes = $this->aviaoModel->getAll();
        $companhias = $this->companhiaModel->getAll();
        include '../app/views/ctrldev/aviao/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $modelo = $_POST['modelo_aeronave'];
            $capacidade = $_POST['capacidade_aeronave'];
            $fileiras = $_POST['quantidade_fileiras'];
            $assentosPorFileira = $_POST['quantidade_assentos_por_fileira'];
            $companhia = $_POST['companhia_aeronave'];

            if ($this->aviaoModel->create($modelo, $capacidade, $fileiras, $assentosPorFileira, $companhia)) {
                header("Location: ?msg=Avião criado com sucesso!");
            } else {
                header("Location: ?msg=Erro ao criar avião!");
            }
            exit;
        }
        $companhias = $this->companhiaModel->getAll();
        include '../views/ctrldev/avioes/aviao_form_add.php';
    }



    public function update($data) {
        if ($this->aviaoModel->update(
            $data['id_aeronave_edit'],
            $data['modelo_aeronave_edit'],
            $data['capacidade_aeronave_edit'],
            $data['quantidade_fileiras_edit'],
            $data['quantidade_assentos_por_fileira_edit'],
            $data['companhia_aeronave_edit']
        )) {
            header("Location: ?msg=Avião atualizado com sucesso!");
        } else {
            header("Location: ?msg=Erro ao atualizar avião!");
        }
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ids = $_POST['ids'] ?? [];

            try {
                if ($this->aviaoModel->deleteMultiple($ids)) {
                    header("Location: ?msg=Avião(s) excluído(s) com sucesso!");
                } else {
                    header("Location: ?msg=Erro ao excluir aviões!");
                }
            } catch (Exception $e) {
                if ($e->getMessage() === "constraint_violation") {
                    header("Location: ?msgP=Este avião não pode ser excluído porque está associado a voos. Por favor, exclua ou desassocie esse item antes de tentar novamente.");
                } else {
                    header("Location: ?msg=Erro inesperado ao excluir aviões!");
                }
            }

            exit;
        } else {
            header("Location: ?msg=Método de requisição inválido para exclusão!");
        }
    }

}

?>