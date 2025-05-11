<?php

require_once __DIR__ . '/../models/SegmentoVoo.php';
require_once __DIR__ . '/../models/Aeroporto.php';
require_once __DIR__ . '/../models/Voo.php';

class SegmentoVooController {
    private $model;
    private $modelAeroporto;
    private $modelVoo;

    public function __construct($db) {
        $this->model = new SegmentoVooModel($db);
        $this->modelAeroporto = new Aeroporto($db);
        $this->modelVoo = new Voo($db);
    }

    public function index() {
        $segmentos = $this->model->getAll();
        $aeroportos = $this->modelAeroporto->getAll();
        $voos = $this->modelVoo->getAllByEscala();
        $mensagem = $_GET['msg'] ?? '';
        include '../app/views/ctrldev/segmentoVoo/index.php';
    }

    public function create($data) {
        $numero_voo = $data['voo'];
        $destino = $data['destino'];
        $hora_partida = $data['hora_partida'];
        $hora_chegada = $data['hora_chegada'];

        if ($this->model->create($numero_voo, $destino, $hora_partida, $hora_chegada)) {
            header("Location: ?msg=Segmento cadastrado com sucesso!");
        } else {
            header("Location: ?msg=Erro ao cadastrar segmento!");
        }
    }

    public function update($data) {
        $id_segmento = $data['id_segmento'];
        $id_voo = $data['voo_edit'];
        $destino = $data['destino_edit'];
        $hora_partida = $data['hora_partida_edit'];
        $hora_chegada = $data['hora_chegada_edit'];

        if ($this->model->update($id_segmento, $id_voo, $destino, $hora_partida, $hora_chegada)) {
            header("Location: ?msg=Segmento atualizado com sucesso!");
        } else {
            header("Location: ?msg=Erro ao atualizar segmento!");
        }
    }


    public function delete($id) {
        if ($this->model->delete($id)) {
            header("Location: ?msg=Segmento excluído com sucesso!");
        } else {
            header("Location: ?msg=Erro ao excluir segmento!");
        }
        exit;
    }

    public function deleteMultiple(array $ids) {
        if ($this->model->deleteMultiple($ids)) {
            header("Location: ?msg=Segmentos excluídos com sucesso.");
        } else {
            header('Location: ?msg=Erro ao excluir segmentos.');
        }
        exit;
    }
}

?>