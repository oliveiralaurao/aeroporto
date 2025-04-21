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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;500;700&display=swap" rel="stylesheet">

  <title>Checkin</title>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var url = location.search;
      var urlParams = new URLSearchParams(url);

      let assento = urlParams.get('assento');
      let voo = urlParams.get('voo');

      console.log(assento);
      console.log(voo);

      var cassento = document.getElementById("Caassento");
      if (assento) {
        cassento.innerHTML = `
                <h3>Assento:</h3>
                <p>${assento}</p>
            `;
      } else {
        cassento.innerHTML = `
                <h3>Assento:</h3>
                <p>Não disponível</p>
            `;
      }
    });

  </script>

  <link rel="stylesheet" href="../assets/css/style.css">
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
<main class="finabj">
  <section id="dadoscada">
    <div>
      <div>
        <p class="checap">
          Check in.
        </p>
        <br>
        Confirme/preencha os dados abaixo para continuar sua reserva.

      </div>
      <div id="nnome" class="Cnonome">
        <div class="ccoluna">
          <label for="Cnome">Nome:</label>
          <input type="text" id="Cnome">
        </div>
        <div class="ccoluna" id="ssobrenome">
          <label for="Csobrenome">Sobrenome:</label>
          <input type="text" id="Csobrenome">
        </div>
      </div>
      <div id="cidade" class="cidade">
        <label for="idade">Data de nascimento:</label>
        <input type="date" id="idade">
      </div>
      <div id="ctelefone" class="ctelefone">
        <label for="telefone">Telefone:</label>
        <input type="number" id="telefone">
      </div>
      <div id="cendereco" class="cendereco">
        <label for="endereco">Endereço:</label>
        <input type="text" id="endereco">
      </div>
    </div>



  </section>
  <aside id="informa">
    <form class="Cdesti" action="ticket.php" >
      <div class="Corigem">
        <h3>Origem</h3>
        <input type="text" value="PPB - P.Prudente - 08:00hrs" disabled id="origem">
        <p></p>
      </div>
      <div class="Corigem">
        <h3>Destino</h3>
        <input type="text" value="CGH - Congonhas - 09:20 hrs" disabled id="destino">
        <p></p>
      </div>
      <div id="Caassento" class="Corigem">
        <h3>Assento:</h3>
        <p >...</p>
      </div>
      <div class="Ccomfirma">
        <a href="ticket.php"><button>Confirmar</button></a>
      </div>
    </form>
  </aside>
</main>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var url = location.search;
    var urlParams = new URLSearchParams(url);

    let assento = urlParams.get('assento');
    let voo = urlParams.get('voo');

    console.log(assento);
    console.log(voo);

    var cassento = document.getElementById("Caassento");
    if (assento) {
      cassento.innerHTML = `
        <h3>Assento:</h3>
        <p>${assento}</p>
      `;
    } else {
      cassento.innerHTML = `
        <h3>Assento:</h3>
        <p>Não disponível</p>
      `;
    }

    // Ao submeter o formulário de check-in
    const formCheckin = document.querySelector(".Cdesti");
    formCheckin.addEventListener("submit", function(e) {
      e.preventDefault();


      const nome = document.getElementById("Cnome").value;
      const sobrenome = document.getElementById("Csobrenome").value;
      const idade = document.getElementById("idade").value;
      const telefone = document.getElementById("telefone").value;
      const endereco = document.getElementById("endereco").value;
      const origem = document.getElementById("origem").value;
      const destino = document.getElementById("destino").value;


      localStorage.setItem('origem', origem);
      localStorage.setItem('destino', destino);

      localStorage.setItem('nome', nome);
      localStorage.setItem('sobrenome', sobrenome);
      localStorage.setItem('idade', idade);
      localStorage.setItem('telefone', telefone);
      localStorage.setItem('endereco', endereco);
      localStorage.setItem('assento', assento);  // Assento
      localStorage.setItem('voo', voo);  // Voo


      window.location.href = 'ticket.php';
    });
  });
</script>


</body>