<?php

require_once __DIR__ . '/../models/Assento.php';

class AssentoController {
    private $model;
    private $db; // Adicione uma propriedade para a conexão com o banco

    public function __construct($db) {
        $this->model = new AssentoModel($db);
        $this->db = $db; // Inicialize a propriedade do banco
    }

    public function index() {
        $assentos = $this->model->getAllAssentos();
        $vooOptions = $this->model->getVooOptions();
        $mensagem = $_GET['msg'] ?? '';
        include('../app/views/assento/index.php');
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
        if ($this->model->deleteAssentos($ids)) {
            header('Location: assentoRoutes.php?msg=Assento(s) excluído(s) com sucesso!');
        } else {
            header('Location: assentoRoutes.php?msg=Erro ao excluir assento(s)!');
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