<?php

require_once __DIR__ . '/../models/Voo.php';
require_once __DIR__ . '/../models/Aviao.php';
require_once __DIR__ . '/../models/Aeroporto.php';
require_once __DIR__ . '/../models/Portao.php';

class VooController {
    private $model;
    private $connAviao;
    private $connAeroporto;
    private $connPortao;

    public function __construct($mysqli) {
        $this->model = new Voo($mysqli);
        $this->connAviao = new Aviao($mysqli);
        $this->connAeroporto = new Aeroporto($mysqli);
        $this->connPortao = new Portao($mysqli);
    }

    public function index() {
        $voos = $this->model->getAll();
        $avioes = $this->connAviao->getAll();
        $portoes = $this->connPortao->getAll();
        $aeroportos = $this->connAeroporto->getAll();
        include '../app/views/ctrldev/voo/index.php';
    }



    public function create($data) {
        if ($this->model->create(
            $data['numero_voo'],
            $data['id_aeronave'],
            $data['id_portao'],
            $data['data_chegada'],
            $data['data_saida'],
            $data['origem_voo'],
            $data['destino_voo'],
            $data['tipo_voo'],
            $data['status_voo'],
            $data['localizacao_voo']
        )) {
            header("Location: ?msg=Voo cadastrado com sucesso!");
        } else {
            header("Location: ?msg=Erro ao cadastrar voo!");
        }
    }

    public function update($data) {
        if ($this->model->update(
            $data['id_voo_edit'],
            $data['numero_voo_edit'],
            $data['id_aeronave_edit'],
            $data['id_portao_edit'],
            $data['data_chegada_edit'],
            $data['data_saida_edit'],
            $data['origem_voo_edit'],
            $data['destino_voo_edit'],
            $data['tipo_voo_edit'],
            $data['status_voo_edit'],
            $data['localizacao_voo_edit']
        )) {
            header("Location: ?msg=Voo atualizado com sucesso!");
        } else {
            header("Location: ?msg=Erro ao atualizar voo!");
        }
    }

    public function delete($ids) {
        try {
            if ($this->model->deleteMultiple($ids)) {
                header("Location: ?msg=Voos excluídos com sucesso!");
            } else {
                header("Location: ?msg=Erro ao excluir voos!");
            }
        } catch (Exception $e) {
            if ($e->getMessage() === "constraint_violation") {
                header("Location: ?msgP=Um ou mais voos não podem ser excluídos porque estão associados a reservas e segmento de voo. Desassocie-os antes de tentar novamente.");
            } else {
                header("Location: ?msg=Erro inesperado ao excluir voos!");
            }
        }
        exit;
    }

    public function buscarPorDestino($destino) {
        $voos = $this->model->buscarPorDestino($destino);
        $_SESSION['voos_busca'] = $voos;

    }
    public function listarVoosPublico() {
        $voosNacionais = $this->model->getVoosPorTipo('Nacional');
        $voosInternacionais = $this->model->getVoosPorTipo('Internacional');

        unset($_SESSION['voos_busca']);

        // retorna os dados como array
        return [
            'voosNacionais' => $voosNacionais,
            'voosInternacionais' => $voosInternacionais,

        ];
    }
    public function getById($id)
    {
        $voo = $this->model->getById($id);

        if ($voo) {
            header('Content-Type: application/json');
            echo json_encode($voo);
        } else {
            http_response_code(404);
            echo json_encode(['erro' => 'Voo não encontrado']);
        }
    }



    public function painelVoos() {
        $dados = $this->model->getPainelVoos();
        header('Content-Type: application/json');
        echo json_encode($dados);
    }




}
