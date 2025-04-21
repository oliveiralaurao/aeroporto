<?php

require_once __DIR__ . '/../models/Aeroporto.php';

class AeroportoController {
    private $model;

    public function __construct($mysqli) {
        $this->model = new Aeroporto($mysqli);
    }

    public function index() {
        $dados_aeroportos = $this->model->getAll();
        $mensagem = $_GET['msg'] ?? '';
        include '../app/views/aeroporto/index.php';
    }

    public function store($data) {

        if ($this->model->create($data['nome_aeroporto'], $data['codigo_aeroporto'], $data['localizacao_aeroporto'])) {
            header("Location: ?msg=Aeroporto criado com sucesso!");
        } else {
            header("Location: ?msg=Erro ao criar aeroporto!");
        }
    }

    public function update($data) {
        if ($this->model->update($data['id_aeroporto'], $data['nome_aeroporto'], $data['codigo_aeroporto'], $data['localizacao_aeroporto'])) {
            header("Location: ?msg=Aeroporto atualizado com sucesso!");
        } else {
            header("Location: ?msg=Erro ao atualizar aeroporto!");
        }
    }

    public function delete($ids) {
        if ($this->model->deleteMultiple($ids)) {
            header("Location: ?msg=Aeroportos excluídos com sucesso!");
        } else {
            header("Location: ?msg=Erro ao excluir aeroportos!");
        }
    }
}
?>
