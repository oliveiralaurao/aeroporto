<?php
session_start();

if (!isset($_SESSION['email']) || (!($_SESSION['tipo_usuario'] === '1' || $_SESSION['tipo_usuario'] === '2'))) {
    header('Location: /aeroporto/login');
    exit();
}
require_once '../routes/usuarioRoutes.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciamento de Usuários</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;500;700&display=swap" rel="stylesheet">

</head>
<body id="adm">
<aside class="sidebar">
    <div class="sidebar-header">
        <h1>FlyAir<a href="../app/views/ctrldev/"><img src="../assets/images/fly-airplane.png" alt="Logo" class="logo"></a></h1>
    </div>
    <nav class="menu">
        <a href="../routes/aeroportoRoutes.php" class="menu-item">
            <i class="fa-solid fa-plane-departure"></i>
            <span>Aeroportos</span>
        </a>
        <a href="../routes/aviaoRoutes.php" class="menu-item ">
            <i class="fas fa-plane"></i>
            <span>Aviões</span>
        </a>
        <a href="../routes/assentoRoutes.php" class="menu-item">
            <i class="fas fa-chair"></i>
            <span>Assentos</span>
        </a>
        <a href="../routes/companhiaRoutes.php" class="menu-item">
            <i class="fas fa-building"></i>
            <span>Companhias</span>
        </a>

        <a href="../routes/portaoRoutes.php" class="menu-item">
            <i class="fa-solid fa-cart-flatbed-suitcase"></i>
            <span>Portões</span>
        </a>
        <a href="../routes/passagemRoutes.php" class="menu-item">
            <i class="fas fa-tags"></i>
            <span>Passagens</span>
        </a>


        <a href="../routes/segmentoVooRoutes.php" class="menu-item">
            <i class="fas fa-route"></i>
            <span>Segmento de Voo</span>
        </a>
        <a href="../routes/terminalRoutes.php" class="menu-item">
            <i class="fa-solid fa-signs-post"></i>
            <span>Terminais</span>
        </a>
        <a href="../routes/usuarioRoutes.php" class="menu-item active">
            <i class="fas fa-users"></i>
            <span>Usuários</span>
        </a>
        <a href="../routes/vooRoutes.php" class="menu-item">
            <i class="fas fa-plane-departure"></i>
            <span>Voos</span>
        </a>
        <a href="/aeroporto/logout" class="menu-item">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Sair</span>
        </a>
    </nav>
</aside>

<main>
    <h1>Gerenciamento de Usuários</h1>

    <?php if (isset($_GET['msg'])): ?>
        <p style="color: green;"><strong><?= htmlspecialchars($_GET['msg']) ?></strong></p>
    <?php endif; ?>
    <?php if (isset($_GET['msgP'])): ?>
        <div class="alert alert-warning">
            <strong>Atenção:</strong> <?= htmlspecialchars($_GET['msgP']) ?>

        </div>
    <?php endif; ?>

    <div class="form-container" id="formulario">
        <h2>Cadastrar Usuário</h2>
        <form method="post" action="../routes/usuarioRoutes.php">
            <input type="hidden" name="action" value="create">

            <label>Nome:</label>
            <input type="text" name="nome_passageiro" required>

            <label>Email:</label>
            <input type="email" name="email_passageiro" required>

            <label>Senha:</label>
            <input type="password" name="senha_passageiro" required>

            <label>Telefone:</label>
            <input type="text" name="telefone_passageiro" id="telefone_passageiro" required>

            <label>País:</label>
            <select name="pais" id="pais" required>

            </select>


            <label>CPF:</label>
            <input type="text" name="documento_passageiro" id="documento_passageiro"required>

            <label>Data de Nascimento:</label>
            <input type="date" name="datanasc_passageiro" id="datanasc_passageiro" required>

            <label>Tipo:</label>
            <select name="tipo_passageiro" required>
                <option value="">Selecione um tipo</option>
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>

            </select>

            <input type="submit" value="Cadastrar">
        </form>
    </div>

    <div class="form-container" id="formulario">
        <h2>Editar Usuário</h2>
        <form method="post" action="../routes/usuarioRoutes.php">
            <input type="hidden" name="action" value="update">

            <label for="id_passageiros">Selecione o Usuário:</label>
            <select name="id_passageiros" id="select_usuario_editar" required onchange="preencherEdicaoUsuario()">
                <option value="">Selecione um usuário</option>
                <?php foreach ($dados_usuarios as $usuario): ?>
                    <option value="<?= $usuario['id_passageiros'] ?>"
                            data-nome="<?= $usuario['nome_passageiro'] ?>"
                            data-email="<?= $usuario['email_passageiro'] ?>"
                            data-senha="<?= $usuario['senha_passageiro'] ?>"
                            data-telefone="<?= $usuario['telefone_passageiro'] ?>"
                            data-pais="<?= $usuario['pais_passageiro'] ?>"
                            data-documento="<?= $usuario['documento_passageiro'] ?>"
                            data-data="<?= $usuario['datanasc_passageiro'] ?>"
                            data-tipo="<?= $usuario['tipo_passageiro'] ?>">
                        <?= $usuario['nome_passageiro'] ?> (ID: <?= $usuario['id_passageiros'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Nome:</label>
            <input type="text" name="nome_passageiro_edit" id="nome_passageiro_edit" required>

            <label>Email:</label>
            <input type="email" name="email_passageiro_edit" id="email_passageiro_edit" required>


            <input type="hidden" name="senha_passageiro_edit" id="senha_passageiro_edit" required>

            <label>Telefone:</label>
            <input type="text" name="telefone_passageiro_edit" id="telefone_passageiro_edit" required>

            <label>País:</label>
            <input type="text" name="pais_passageiro_edit" id="pais_passageiro_edit" required>

            <label>Documento:</label>
            <input type="text" name="documento_passageiro_edit" id="documento_passageiro_edit" required>

            <label>Data de Nascimento:</label>
            <input type="date" name="datanasc_passageiro_edit" id="datanasc_passageiro_edit" required>

            <label>Tipo:</label>
            <select name="tipo_passageiro_edit" id="tipo_passageiro_edit" required>
                <option value="">Selecione um tipo</option>
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>

            </select>

            <input type="submit" value="Atualizar">
        </form>
    </div>

    <div class="form-container" id="listar">
        <h2>Lista de Usuários</h2>
        <form method="post" action="../routes/usuarioRoutes.php">
            <input type="hidden" name="action" value="deleteMultiple">

            <div class="table-container">
                <table class="styled-table">
                    <thead>
                    <tr>
                        <th>Excluir</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>País</th>
                        <th>Documento</th>
                        <th>Data Nasc.</th>
                        <th>Tipo</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($dados_usuarios as $usuario): ?>
                        <tr>
                            <td><input type="checkbox" name="ids[]" value="<?= $usuario['id_passageiros'] ?>"></td>
                            <td><?= $usuario['nome_passageiro'] ?></td>
                            <td><?= $usuario['email_passageiro'] ?></td>
                            <td><?= $usuario['telefone_passageiro'] ?></td>
                            <td><?= $usuario['pais_passageiro'] ?></td>
                            <td><?= $usuario['documento_passageiro'] ?></td>
                            <td><?= $usuario['datanasc_passageiro'] ?></td>
                            <td><?= $usuario['tipo_passageiro'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="button-wrapper">
                <input type="submit" value="Excluir Selecionados" class="btn-delete">
            </div>
        </form>
    </div>
</main>
<?php if (isset($_GET['msg'])): ?>
    <script>
        alert("<?= htmlspecialchars($_GET['msg']) ?>");
    </script>
<?php endif; ?>

<script>
    function calcularIdade(dataNascimento) {
        const hoje = new Date();
        const nascimento = new Date(dataNascimento);
        let idade = hoje.getFullYear() - nascimento.getFullYear();
        const mes = hoje.getMonth() - nascimento.getMonth();

        if (mes < 0 || (mes === 0 && hoje.getDate() < nascimento.getDate())) {
            idade--;
        }

        return idade;
    }


    const formCadastro = document.querySelector("form[action='../routes/usuarioRoutes.php'][method='post']");
    const inputDataNascimento = document.getElementById("datanasc_passageiro");

    formCadastro.addEventListener("submit", function (e) {
        const idade = calcularIdade(inputDataNascimento.value);
        if (idade < 18) {
            e.preventDefault();
            alert("Usuário deve ter no mínimo 18 anos.");
        }
    });


    const formEdicao = document.querySelectorAll("form[action='../routes/usuarioRoutes.php'][method='post']")[1];
    const inputDataNascimentoEdit = document.getElementById("datanasc_passageiro_edit");

    formEdicao.addEventListener("submit", function (e) {
        const idade = calcularIdade(inputDataNascimentoEdit.value);
        if (idade < 18) {
            e.preventDefault();
            alert("Usuário deve ter no mínimo 18 anos.");
        }
    });

    const cpfInput = document.getElementById("documento_passageiro");
    cpfInput.addEventListener("input", function () {
        let value = this.value.replace(/\D/g, "");
        value = value.replace(/(\d{3})(\d)/, "$1.$2");
        value = value.replace(/(\d{3})(\d)/, "$1.$2");
        value = value.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
        this.value = value;
    });

    const telefoneInput = document.getElementById("telefone_passageiro");
    telefoneInput.addEventListener("input", function () {
        let value = this.value.replace(/\D/g, "");
        value = value.replace(/^(\d{2})(\d)/, "($1) $2");
        value = value.replace(/(\d{5})(\d)/, "$1-$2");
        this.value = value;
    });
    const cpfInput2 = document.getElementById("documento_passageiro_edit");
    cpfInput2.addEventListener("input", function () {
        let value = this.value.replace(/\D/g, "");
        value = value.replace(/(\d{3})(\d)/, "$1.$2");
        value = value.replace(/(\d{3})(\d)/, "$1.$2");
        value = value.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
        this.value = value;
    });

    const telefoneInput2 = document.getElementById("telefone_passageiro_edit");
    telefoneInput2.addEventListener("input", function () {
        let value = this.value.replace(/\D/g, "");
        value = value.replace(/^(\d{2})(\d)/, "($1) $2");
        value = value.replace(/(\d{5})(\d)/, "$1-$2");
        this.value = value;
    });
    fetch('https://restcountries.com/v3.1/all?fields=translations')
        .then(res => res.json())
        .then(data => {
            const paisSelect = document.getElementById('pais');
            const nomes = data.map(p => p.translations?.por?.common).filter(Boolean).sort();
            nomes.forEach(nome => {
                const option = document.createElement('option');
                option.value = nome;
                option.textContent = nome;
                paisSelect.appendChild(option);
            });
        })
        .catch(error => console.error("Erro ao carregar países:", error));

    document.querySelector('form[action="../routes/usuarioRoutes.php"]').addEventListener('submit', function (e) {
        const nome = this.nome_passageiro.value.trim();
        const email = this.email_passageiro.value.trim();
        const senha = this.senha_passageiro.value;
        const telefone = this.telefone_passageiro.value.trim();
        const pais = this.pais.value.trim();
        const documento = this.documento_passageiro.value.trim();
        const dataNasc = this.datanasc_passageiro.value;
        const tipo = this.tipo_passageiro.value;

        let erros = [];


        if (nome.split(' ').length < 2) {
            erros.push("Informe o nome completo.");
        }


        const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!regexEmail.test(email)) {
            erros.push("Email inválido.");
        }


        if (senha.length < 6) {
            erros.push("A senha deve ter pelo menos 6 caracteres.");
        }


        const telNumeros = telefone.replace(/\D/g, '');
        if (telNumeros.length < 10) {
            erros.push("Telefone inválido.");
        }





        if (documento === "") {
            erros.push("Informe o número do documento.");
        }


        const hoje = new Date();
        const nascimento = new Date(dataNasc);
        if (nascimento > hoje) {
            erros.push("Data de nascimento inválida.");
        }




        if (erros.length > 0) {
            e.preventDefault();
            alert("Erros encontrados:\n\n" + erros.join("\n"));
        }
    });

    function preencherEdicaoUsuario() {
        const select = document.getElementById('select_usuario_editar');
        const option = select.options[select.selectedIndex];

        document.getElementById('nome_passageiro_edit').value = option.dataset.nome || '';
        document.getElementById('email_passageiro_edit').value = option.dataset.email || '';
        document.getElementById('senha_passageiro_edit').value = option.dataset.senha || '';
        document.getElementById('telefone_passageiro_edit').value = option.dataset.telefone || '';
        document.getElementById('pais_passageiro_edit').value = option.dataset.pais || '';
        document.getElementById('documento_passageiro_edit').value = option.dataset.documento || '';
        document.getElementById('datanasc_passageiro_edit').value = option.dataset.data || '';
        document.getElementById('tipo_passageiro_edit').value = option.dataset.tipo || '';
    }
</script>
</body>
</html>
