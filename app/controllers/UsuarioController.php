<?php

require_once __DIR__ . '/../models/Usuario.php';

class UsuarioController {
    private $model;

    public function __construct($mysqli) {
        $this->model = new Usuario($mysqli);
    }

    public function index() {
        $dados_usuarios = $this->model->getAll();
        $mensagem = $_GET['msg'] ?? '';
        include '../app/views/ctrldev/usuario/index.php';
    }

    public function store($data) {
        $nome = $data['nome_passageiro'];
        $email = $data['email_passageiro'];
        $senha = $data['senha_passageiro'];
        $telefone = $data['telefone_passageiro'];
        $pais = $data['pais'];
        $documento = $data['documento_passageiro'];
        $data_nasc = $data['datanasc_passageiro'];
        $tipo = $data['tipo_passageiro'];

        if ($this->model->getByEmail($email)) {
            header("Location: ?msg=E-mail já cadastrado.");
            return;
        }

        if ($this->model->buscaCPF($documento)) {
            header("Location: ?msg=CPF já cadastrado.");
            return;
        }

        if ($this->model->create($nome, $email, $senha, $telefone, $pais, $documento, $data_nasc, $tipo)) {
            header("Location: ?msg=Usuário criado com sucesso!");
        } else {
            header("Location: ?msg=Erro ao criar usuário!");
        }

    }
    public function storeUser($data) {
        $nome = $data['nome'];
        $email = $data['email'];
        $senha = $data['senha'];
        $telefone = $data['telefone'];
        $pais = $data['pais'];
        $documento = $data['cpf'];
        $data_nasc = $data['dataasc'];
        $tipo = '0';

        header('Content-Type: application/json'); // ← importante

        if ($this->model->getByEmail($email)) {
            echo json_encode(['success' => false, 'message' => 'E-mail já cadastrado.']);
            exit();
        }

        if ($this->model->buscaCPF($documento)) {
            echo json_encode(['success' => false, 'message' => 'CPF já cadastrado.']);
            exit();
        }

        if ($this->model->create($nome, $email, $senha, $telefone, $pais, $documento, $data_nasc, $tipo)) {
            echo json_encode(['success' => true, 'message' => 'Cadastro realizado com sucesso!']);
            exit();
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao cadastrar.']);
            exit();
        }
    }



    public function login($data) {
        $email = $data['email'];
        $senha = $data['senha'];

        $usuario = $this->model->getByEmail($email);

        if ($usuario && password_verify($senha, $usuario['senha_passageiro'])) {
            session_start();
            $_SESSION['usuario_id'] = $usuario['id_passageiros'];
            $_SESSION['usuario_nome'] = $usuario['nome_passageiro'];
            $_SESSION['email'] = $usuario['email_passageiro'];
            $_SESSION['tipo_usuario'] = $usuario['tipo_passageiro'];
            $_SESSION['data_nasc'] = $usuario['datanasc_passageiro'];
            $_SESSION['telefone'] = $usuario['telefone_passageiro'];
            $_SESSION['doc'] = $usuario['documento_passageiro'];

            if ($usuario['tipo_passageiro'] == 1 || $usuario['tipo_passageiro'] == 2) {
                header("Location: http://localhost/aeroporto/app/views/ctrldev/");
            } else {
                header("Location: http://localhost/aeroporto/");
            }

            exit;
        } else {

            header("Location: http://localhost/aeroporto/login?msgE=Email ou senha incorretos");
            exit;
        }
    }



    public function update($data) {
        $id = $data['id_passageiros'];
        $nome = $data['nome_passageiro_edit'];
        $email = $data['email_passageiro_edit'];
        $senha = $data['senha_passageiro_edit'];
        $telefone = $data['telefone_passageiro_edit'];
        $pais = $data['pais_passageiro_edit'];
        $documento = $data['documento_passageiro_edit'];
        $data_nasc = $data['datanasc_passageiro_edit'];
        $tipo = $data['tipo_passageiro_edit'];

        if ($this->model->update($id, $nome, $email, $senha, $telefone, $pais, $documento, $data_nasc, $tipo)) {
            header("Location: ?msg=Usuário atualizado com sucesso!");
        } else {
            header("Location: ?msg=Erro ao atualizar usuário!");
        }
    }

    public function delete($ids) {
        try {
            if ($this->model->deleteMultiple($ids)) {
                header("Location: ?msg=Usuários excluídos com sucesso!");
            } else {
                header("Location: ?msg=Erro ao excluir usuários!");
            }
        } catch (Exception $e) {
            if ($e->getMessage() === "constraint_violation") {
                header("Location: ?msgP=Um ou mais usuários não podem ser excluídos porque estão associados a registros de reservas. Desassocie-os antes de tentar novamente.");
            } else {
                header("Location: ?msg=Erro inesperado ao excluir usuários!");
            }
        }
        exit;
    }




}
