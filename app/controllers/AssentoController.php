<?php

require_once __DIR__ . '/../models/Assento.php';
require_once __DIR__ . '/../models/Voo.php';

class AssentoController {
    private $model;
    private $voo;
    private $db;

    public function __construct($db) {
        $this->model = new AssentoModel($db);
        $this->voo = new Voo($db);
        $this->db = $db;
    }

    public function index() {
        $assentos = $this->model->getAllAssentos();
        $vooOptions = $this->voo->getAll();
        $mensagem = $_GET['msg'] ?? '';
        include('../app/views/ctrldev/assento/index.php');
    }

    public function create($data) {
        if ($this->model->createAssento($data)) {
            header('Location: assentoRoutes.php?msg=Assento criado com sucesso!');
        } else {
            header('Location: assentoRoutes.php?msg=Erro ao criar assento!');
        }
        exit();
    }

    public function update($data) {
        if ($this->model->updateAssento($data)) {
            header('Location: assentoRoutes.php?msg=Assento atualizado com sucesso!');
        } else {
            header('Location: assentoRoutes.php?msg=Erro ao atualizar assento: ' . $this->db->error);
        }
        exit();
    }

    public function delete($ids) {
        try {
            if ($this->model->deleteAssentos($ids)) {
                header('Location: assentoRoutes.php?msg=Assento(s) excluído(s) com sucesso!');
            } else {
                header('Location: assentoRoutes.php?msg=Erro ao excluir assento(s)!');
            }
        } catch (Exception $e) {
            if ($e->getMessage() === 'constraint_violation') {
                header('Location: assentoRoutes.php?msgP=Este assento não pode ser excluído porque está associado a passagens. Por favor, exclua ou desassocie esses itens antes de tentar novamente.');
            } else {
                header('Location: assentoRoutes.php?msg=Erro inesperado ao excluir assento(s)!');
            }
        }
        exit();
    }

    public function getAssentosPorVoo($id_voo) {
        header('Content-Type: application/json');

        if (empty($id_voo)) {
            echo json_encode(['error' => 'ID do voo não fornecido']);
            return;
        }

        $assentos = $this->model->getAssentosPorVoo($id_voo);


        if (!$assentos ) {
            echo json_encode(['error' => 'Não foi possível carregar os dados']);
            return;
        }

        echo json_encode([

            'assentos' => $assentos
        ]);
    }

}

?>