<?php

require_once __DIR__ . '/../models/Mensagem.php';

class MensagemController {
    private $model;

    public function __construct($db) {
        $this->model = new Mensagem($db);
    }

    public function index() {
        $mensagens = $this->model->getAll();
        $mensagem = $_GET['msg'] ?? '';
        include '../app/views/ctrldev/mensagem/index.php';
    }

    public function detalhes($id) {
        $mensagem = $this->model->getById($id);
        if ($mensagem) {
            echo json_encode($mensagem);
        } else {
            echo json_encode(['error' => 'Mensagem não encontrada']);
        }
    }

    public function alterarStatus($id_mensagem_edit, $status_edit) {
        if ($this->model->updateStatus($id_mensagem_edit, $status_edit)) {
            header("Location: ?msg=Status alterado com sucesso!");
        } else {
            header("Location: ?msg=Erro ao alterar status");
        }
    }

    public function criarMensagem($assunto, $nome, $sobrenome) {
        if ($this->model->create($assunto, $nome, $sobrenome)) {
            header("Location: /aeroporto/sac?msg=Mensagem enviada com sucesso!");
        } else {
            header("Location: /aeroporto/sac?msg=Erro ao enviar mensagem");
        }
    }

    public function enviarResposta($id, $email_destino, $response) {
        $subject = "Resposta à sua mensagem";
        $message = "Você recebeu uma resposta da nossa equipe:\n\n" . $response;
        $headers = "From: laura.pimenta2110@hotmail.com";

        if (mail($email_destino, $subject, $message, $headers)) {
            $this->model->updateStatus($id, 'Respondida');
            header("Location: /aeroporto/sac?msg=Mensagem enviada");
        } else {
            header("Location: /aeroporto/sac?msg=Erro ao enviar mensagem");
        }
    }

    public function deletarMensagem($ids) {
        if ($this->model->deleteMultiple($ids)) {
            header("Location: ?msg=Mensagens excluídas com sucesso!");
        } else {
            header("Location: ?msg=Erro ao excluir mensagens!");
        }
    }
}
?>
