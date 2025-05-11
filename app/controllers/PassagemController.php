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
        include '../app/views/ctrldev/passagem/index.php';
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
        include '../app/views/ctrldev/passagem/create.php';
    }



    public function update($data) {

        if ($this->model->update($data['id_passagem_edit'], $data['valor_passagem_edit'], $data['assentos_id_assento_edit'])) {
            header("Location: ?msg=Passagem atualizada com sucesso!");
        } else {
            header("Location: ?msg=Erro ao atualizar passagem!");
        }
        exit;
    }


    public function delete($ids) {
        $sucesso = true;

        try {
            foreach ($ids as $id) {
                if (!$this->model->delete($id)) {
                    $sucesso = false;
                }
            }

            $msg = $sucesso ? 'Passagens excluídas com sucesso!' : 'Erro ao excluir uma ou mais passagens!';
            header("Location: ?msg=" . urlencode($msg));
        } catch (Exception $e) {
            if ($e->getMessage() === 'constraint_violation') {
                header("Location: ?msgP=Esta passagem não pode ser excluída porque está associada a reservas. Por favor, exclua ou desassocie esses itens antes de tentar novamente.");
            } else {
                header("Location: ?msg=Erro inesperado ao excluir passagens!");
            }
        }

        exit;
    }


}
?>
