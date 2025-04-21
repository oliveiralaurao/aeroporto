<?php

require_once __DIR__ . '/../models/Passagem.php';
require_once __DIR__ . '/../models/Assento.php';

class PassagemController {
    private $model;
    private $assentoModel;

    public function __construct($db) {
        $this->model = new Passagem($db);
        $this->assentoModel = new AssentoModel($db);
    }

    public function index() {
        $passagens = $this->model->getAll();
        $assentos = $this->assentoModel->getAllAssentos();
        $mensagem = $_GET['msg'] ?? '';
        include '../app/views/passagem/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $valor_passagem = $_POST['valor_passagem'];
            $assentos_id_assento = $_POST['assentos_id_assento']; // array de assentos

            $sucesso = true;
            foreach ($assentos_id_assento as $id_assento) {
                if (!$this->model->create($valor_passagem, $id_assento)) {
                    $sucesso = false;
                }
            }

            if ($sucesso) {
                header("Location: ?msg=Passagens criadas com sucesso!");
            } else {
                header("Location: ?msg=Erro ao criar uma ou mais passagens!");
            }
            exit;
        }

        $assentos = $this->assentoModel->getAllAssentos();
        include '../app/views/passagem/create.php';
    }

    public function edit($id) {
        $passagem = $this->model->getById($id);
        $assentos = $this->assentoModel->getAllAssentos();
        if ($passagem) {
            include '../app/views/passagem/edit.php';
        } else {
            header("Location: ?msg=Passagem não encontrada!");
        }
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $valor_passagem = $_POST['valor_passagem_edit'];
            $assentos_id_assento = $_POST['assentos_id_assento_edit'];

            if ($this->model->update($id, $valor_passagem, $assentos_id_assento)) {
                header("Location: ?msg=Passagem atualizada com sucesso!");
            } else {
                header("Location: ?msg=Erro ao atualizar passagem!");
            }
            exit;
        }
        header("Location: ");
    }

    public function delete($id) {
        if ($this->model->delete($id)) {
            header("Location: ?msg=Passagem excluída com sucesso!");
        } else {
            header("Location: ?msg=Erro ao excluir passagem!");
        }
        exit;
    }
}
?>
