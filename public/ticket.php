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
  <title>Ticket</title>
  <link rel="stylesheet" href="../assets/css/style.css">
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

<main class="ticket">
  <h1>Ticket</h1>
  <section class="informacoes">
    <div class="lalala">
      <div class="ticket-header">
        <div>
          <h3>Origem</h3>
          <p>GRU - Guarulhos</p>
          <p>08:00 hrs | Gate 0001</p>
        </div>
        <div>
          <h3>Destino</h3>
          <p>PPB - P. Prudente</p>
          <p>09:20 hrs</p>
        </div>
      </div>
    </div>
    <div class="ticket-details">
      <div class="info lalalala">
        <span>Nome:</span>
        José

        Oliveira
        <br>

      </div>
      <div class="info kakaka">

        <span>Assento:</span>
        1G
        <br>
        <span>Status:</span>
        Confirmado
      </div>
      <div class="qr-code">
        <img src="../assets/images/qrcode.jpg" alt="QR Code">
      </div>
    </div>
    <div class="note">
      Observação: Apresente o ticket no momento do embarque.
      <br>
      <small>Ticket gerado às 20:28 hrs</small>
    </div>
  </section>

</main>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const nome = localStorage.getItem('nome');
    const sobrenome = localStorage.getItem('sobrenome');
    const assento = localStorage.getItem('assento');
    const origem = localStorage.getItem('origem');
    const destino = localStorage.getItem('destino');

    const nomeElement = document.querySelector('.ticket-details .info.lalalala');
    const assentoElement = document.querySelector('.ticket-details .info.kakaka');
    const origemElemento = document.querySelector('.ticket-header div:nth-child(1) p');
    const destinoElemento = document.querySelector('.ticket-header div:nth-child(2) p');

    if (nome && sobrenome) {
      nomeElement.innerHTML = `
        <span>Nome:</span>
        ${nome} ${sobrenome}
      `;
    }

    if (assento) {
      assentoElement.innerHTML = `
        <span>Assento:</span>
        ${assento}
        <br>
        <span>Status:</span>
        Confirmado
      `;
    }

    if (origemElemento && origem) {
      origemElemento.innerHTML = `${origem} | Gate 0001`;
    }

    if (destinoElemento && destino) {
      destinoElemento.innerHTML = `${destino}`;
    }
  });
</script>

</body>

</html>