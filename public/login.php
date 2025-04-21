
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login / Cadastro</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;500;700&display=swap" rel="stylesheet">

</head>
<body id="auth">
<header class="header-public">
    <div class="header-content">
        <div class="logo">
            <a href="/aeroporto">FlyAir</a>
        </div>
        <nav>
            <ul class="nav-links">
                <li><a href="/aeroporto">Home</a></li>
                <li><a href="/aeroporto#listavoos">Voos</a></li>
                <li><a href="/aeroporto/sac">Atendimento</a></li>

            </ul>
        </nav>
    </div>
</header>
<div class="auth-box">
    <div class="form-toggle">
        <button id="btn-login" class="active">Entrar</button>
        <button id="btn-cadastro">Cadastrar</button>
    </div>

    <form id="form-login" class="auth-form" action="routes/usuarioRoutes.php" method="post">
        <h2>Login</h2>
        <input type="hidden" name="action" value="login">
        <label>Email</label>
        <input type="email" name="email" required>
        <label>Senha</label>
        <input type="password" name="senha" required>

        <?php if (isset($_GET['msg'])): ?>
            <p style="color: green;"><strong><?= htmlspecialchars($_GET['msg']) ?></strong></p>
        <?php endif; ?>
        <input type="submit" value="Entrar">
    </form>

    <form id="form-cadastro" class="auth-form hidden" action="routes/usuarioRoutes.php" method="post">
        <h2>Cadastro</h2>
        <input type="hidden" name="action" value="createUser">
        <label for="nome">Nome</label>
        <input type="text" id="nome" name="nome" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="pais">País</label>
        <select name="pais" id="pais" required>
            <option value="" disabled selected>Selecione um país</option>
        </select>

        <label for="senha">Senha</label>
        <input type="password" id="senha" name="senha" required>

        <label for="telefone">Telefone</label>
        <input type="text" id="telefone" name="telefone" required>

        <label for="dataasc">Data de Nascimento</label>
        <input type="date" id="dataasc" name="dataasc" required>

        <label for="cpf">CPF</label>
        <input type="text" id="cpf" name="cpf" maxlength="14" required>

        <input type="submit" value="Cadastrar">
    </form>
</div>

<script>
    const btnLogin = document.getElementById('btn-login');
    const btnCadastro = document.getElementById('btn-cadastro');
    const formLogin = document.getElementById('form-login');
    const formCadastro = document.getElementById('form-cadastro');

    btnLogin.onclick = () => {
        btnLogin.classList.add('active');
        btnCadastro.classList.remove('active');
        formLogin.classList.remove('hidden');
        formCadastro.classList.add('hidden');
    }

    btnCadastro.onclick = () => {
        btnCadastro.classList.add('active');
        btnLogin.classList.remove('active');
        formCadastro.classList.remove('hidden');
        formLogin.classList.add('hidden');
    }

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
        });

    // máscara de CPF
    const cpfInput = document.getElementById("cpf");
    cpfInput.addEventListener("input", function () {
        let value = this.value.replace(/\D/g, "");
        value = value.replace(/(\d{3})(\d)/, "$1.$2");
        value = value.replace(/(\d{3})(\d)/, "$1.$2");
        value = value.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
        this.value = value;
    });

    const telefoneInput = document.getElementById("telefone");
    telefoneInput.addEventListener("input", function () {
        let value = this.value.replace(/\D/g, "");
        value = value.replace(/^(\d{2})(\d)/, "($1) $2");
        value = value.replace(/(\d{5})(\d)/, "$1-$2");
        this.value = value;
    });
</script>
</body>
</html>
