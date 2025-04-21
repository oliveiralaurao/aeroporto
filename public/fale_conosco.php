<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fale Conosco</title>

  <link rel="stylesheet" href="assets/css/style.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;500;700&display=swap" rel="stylesheet">

</head>

<body id="public">
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
          <li>
              <?php if (isset($_SESSION['usuario_id'])): ?>
                  <a href="/aeroporto/logout" class="login-btn">Sair</a>
              <?php else: ?>
                  <a href="/aeroporto/login" class="login-btn">Entrar</a>
              <?php endif; ?>
          </li>
        </ul>
    </nav>
  </div>
</header>

<main class="reclamareclama">
  <div class="olhaolha">
    <h1><span class="font-25 bold-400">Fale Conosco</span></h1>
    <p class="text-justify font-18">
      Para falar sobre passagens aéreas entre em contato pelo telefone 21 2312-123. De Segunda a Domingo
      das 08:00 hrs as 18:00 hrs.
    </p>
  </div>

  <div class="ligaia">
    <button type="button" class="btn-outline">
      Ligar <i class='bx bxl-whatsapp'></i>
    </button>
  </div>
  <div class="falafala">
    <form action="" class="orienta">
      <div class="parteum">
        <div class="nomeindi">
          <label class="text-gray" for="nome">Nome:</label>
          <input type="text" name="nome" id="nome" class="input-form" required>
        </div>
        <div class="sobreindivi">
          <label class="text-gray" for="sobrenome">Sobrenome:</label>
          <input type="text" name="sobrenome" id="sobrenome" class="input-form" required>
        </div>


      </div>
      <div class="partedois">
        <label class="text-gray" for="assunto">Assunto:</label>
        <textarea name="assunto" id="assunto" class="input-text-form" maxlength="500" cols="30" rows="10"></textarea>

      </div>
      <div class="partetres">
        <button type="submit">Enviar</button>
      </div>
    </form>

  </div>
</main>
</body>

</html>