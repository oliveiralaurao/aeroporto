
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Passagens</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;500;700&display=swap" rel="stylesheet">

</head>
<body id="adm">
<aside class="sidebar">
    <div class="sidebar-header">
        <h1>FlyAir<a href="../app/views/index.php"><img src="../../assets/images/fly-airplane.png" alt="Logo" class="logo"></a></h1>
    </div>
    <nav class="menu">
        <a href="../../routes/aeroportoRoutes.php" class="menu-item"><i class="fa-solid fa-plane-departure"></i><span>Aeroportos</span></a>
        <a href="../../routes/aviaoRoutes.php" class="menu-item"><i class="fas fa-plane"></i><span>Aviões</span></a>
        <a href="../../routes/assentoRoutes.php" class="menu-item"><i class="fas fa-chair"></i><span>Assentos</span></a>
        <a href="../../routes/companhiaRoutes.php" class="menu-item"><i class="fas fa-building"></i><span>Companhias</span></a>
        <a href="../../routes/mensagemRoutes.php" class="menu-item"><i class="fas fa-envelope"></i><span>Mensagens</span></a>
        <a href="../../routes/portaoRoutes.php" class="menu-item"><i class="fa-solid fa-cart-flatbed-suitcase"></i><span>Portões</span></a>
        <a href="../../routes/passagemRoutes.php" class="menu-item"><i class="fas fa-tags"></i><span>Passagens</span></a>
        <a href="../../routes/segmentoVooRoutes.php" class="menu-item"><i class="fas fa-route"></i><span>Segmento de Voo</span></a>
        <a href="../../routes/terminalRoutes.php" class="menu-item"><i class="fa-solid fa-signs-post"></i><span>Terminais</span></a>
        <a href="../../routes/usuarioRoutes.php" class="menu-item">
            <i class="fas fa-users"></i>
            <span>Usuários</span>
        </a>
        <a href="../routes/vooRoutes.php" class="menu-item">
            <i class="fas fa-plane-departure"></i>
            <span>Voos</span>
        </a>
        <a href="../routes/logOut.php" class="menu-item">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Sair</span>
        </a>
    </nav>
</aside>

<main>
    <header class="main-header">
        <h2>Olá, seja bem vindo</h2>
    </header>
    <section class="dashboard-content">
        <?php if (isset($_GET['msg'])) : ?>
            <p class="alert alert-info"><?= htmlspecialchars($_GET['msg']) ?></p>
        <?php endif; ?>



    </section>
</main>


</body>
</html>
