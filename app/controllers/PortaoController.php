<?php

require_once __DIR__ . '/../models/Portao.php';
require_once __DIR__ . '/../models/Terminal.php';

class PortaoController {
    private $model;
    private $modelTerminal;

    public function __construct($db) {
        $this->model = new Portao($db);
        $this->modelTerminal = new Terminal($db);
    }

    public function index() {
        $portoes = $this->model->getAll();
        $terminais = $this->modelTerminal->listarTodos();
        $mensagem = $_GET['msg'] ?? '';
        include '../app/views/portao/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $numero_portao = $_POST['numero_portao'];
            $id_terminal = $_POST['terminal_portao'];

            if ($this->model->create($numero_portao, $id_terminal)) {
                header("Location: ?msg=Portão cadastrado com sucesso!");
            } else {
                header("Location: ?msg=Erro ao cadastrar portão!");
            }
            exit;
        }
        $terminais = $this->modelTerminal->listarTodos();
        include '../views/portoes/index.php'; // Pode criar um form separado se preferir
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_portao_edit'] ?? null;
            $numero = $_POST['numero_portao_edit'] ?? '';
            $terminal = $_POST['terminal_portao_edit'] ?? null;

            if (!$id || empty($numero) || !$terminal) {
                echo "Todos os campos são obrigatórios!";
                exit;
            }

            if ($this->model->update($id, $numero, $terminal)) {
                header("Location: ?msg=Portão atualizado com sucesso!");
            } else {
                header("Location: ?msg=Erro ao atualizar portão!");
            }
            exit;
        }
        $portao = $this->model->getById($_GET['id']); // Passar ID pela URL
        $terminais = $this->modelTerminal->listarTodos();
        include '../views/portoes/index.php'; // Adapte conforme sua necessidade
    }

    public function deleteMultiple() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ids = $_POST['ids'] ?? [];

            if ($this->model->deleteMultiple($ids)) {
                header('Location: ?msg=Portão(s) excluído(s) com sucesso!');
            } else {
                header('Location: ?msg=Erro ao excluir portões!');
            }
            exit;
        }
    }
}

?>