<?php

require_once __DIR__ . '/../models/Terminal.php';

class TerminalController {
    private $model;

    public function __construct($mysqli) {
        $this->model = new Terminal($mysqli);
    }

    public function index() {
        $terminais = $this->model->listarTodos();
        $aeroportos = $this->model->listarAeroportos();
        include '../app/views/terminal/index.php';
    }

    public function store($data) {
        if ($this->model->cadastrar($data['id_aeroporto'], $data['nome_terminal'])) {
            header("Location: ?msg=Terminal cadastrado com sucesso!");
        } else {
            header("Location: ?msg=Erro ao cadastrar terminal!");
        }
    }

    public function update($data) {
        if ($this->model->atualizar($data['id_terminal'], $data['id_aeroporto_edit'], $data['update_nome_terminal'])) {
            header("Location: ?msg=Terminal atualizado com sucesso!");
        } else {
            header("Location: ?msg=Erro ao atualizar terminal!");
        }
    }

    public function delete($ids) {
        if ($this->model->deletar($ids)) {
            header("Location: ?msg=Terminais excluídos com sucesso!");
        } else {
            header("Location: ?msg=Erro ao excluir terminais!");
        }
    }
}
