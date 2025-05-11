<?php
session_start();

$nome = $_SESSION['usuario_nome'];
$iduser = $_SESSION['usuario_id'];
$datanasci = $_SESSION['data_nasc'];
$telefone = $_SESSION['telefone'];
$documento = $_SESSION['doc'];

include '../../../startup/connectBD.php';

$assentosSelecionados = $_GET['assento'];
$voosSelecionados = $_GET['voo'];



$assentosArray = explode(',', $assentosSelecionados);



$valorTotal = 0;

foreach ($assentosArray as $assento) {
    $query = "SELECT id_passagem, valor_passagem, id_assento FROM passagens 
              INNER JOIN assentos ON passagens.assentos_id_assento = assentos.id_assento 
              WHERE numero_assento = ? AND id_voo = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("si", $assento, $voosSelecionados);
    $stmt->execute();
    $stmt->bind_result($idPassagem, $valorAssento, $assentoid);
    $stmt->fetch();
    $stmt->close();

    $valorTotal += $valorAssento;
    $passagensIds[] = $idPassagem;
    $idassentoV[] = $assentoid;
}

$value = implode(',', $passagensIds);
$valueArray = implode(',', $idassentoV);



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

  <link rel="stylesheet" href="../../../assets/css/style.css">
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
                  <a href="/aeroporto/perfil" class="login-btn active">Meu Perfil</a>
              <?php else: ?>
                  <a href="/aeroporto/login" class="login-btn">Entrar</a>
              <?php endif; ?>
          </li>
          <li>
              <?php if (isset($_SESSION['usuario_id'])): ?>
                  <a href="/aeroporto/logout" class="login-btn">Sair</a>
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
          <input type="text" id="cnome" name="cnome" value="<?= htmlspecialchars($nome) ?>">
        </div>

      </div>
      <div id="cidade" class="cidade">
        <label for="idade">Data de nascimento:</label>
        <input type="date" id="idade" name="idade" value="<?= htmlspecialchars($datanasci) ?>">
      </div>
      <div id="ctelefone" class="ctelefone">
        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone" value="<?= htmlspecialchars($telefone) ?>">
      </div>
      <div id="doc" class="doc">
        <label for="doc">Documento:</label>
        <input type="text" id="doc" name="doc" value="<?= htmlspecialchars($documento) ?>">
      </div>
    </div>



  </section>
  <aside id="informa">
    <form class="Cdesti" action="../../../routes/reservaRoutes.php" method="post">
        <input type="hidden" name="origem" id="inputOrigem" value="<?= htmlspecialchars($voosSelecionados) ?>">

        <input type="hidden" name="passagensS" id="passagensS" value='<?= htmlspecialchars(json_encode($passagensIds)) ?>'>
        <input type="hidden" name="assentoS" id="assentoS" value='<?= htmlspecialchars(json_encode($idassentoV)) ?>'>

        <input type="hidden" name="id_passageiroR" id="id_passageiroR" value="<?= htmlspecialchars($iduser) ?>">



        <div class="Corigem">
        <h3>Origem</h3>
          <p id="origem"></p>

          <p id="portao">Portão: ...</p>

      </div>
        <div class="Escala">
            <h3>Escala</h3>
            <p id="escala"></p>



        </div>
      <div class="Corigem">
        <h3>Destino</h3>
          <p id="destino"></p>
        <p></p>
      </div>
      <div id="Caassento" class="Corigem">
        <h3>Assento:</h3>
        <p >...</p>
      </div>
        <div id="valor" class="Corigem">
            <h3>Valor:</h3>
            <p>R$ <?= number_format($valorTotal, 2, ',', '.') ?></p>
        </div>
      <div class="Ccomfirma">
          <button type="submit">Confirmar</button>

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

        fetch(`../../../routes/vooRoutes.php?id_voo=${voo}`)
            .then(response => response.json())
            .then(data => {
                const origemText = `${data.nome_origem} - ${new Date(data.data_saida).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}`;
                const destinoText = `${data.nome_destino} - ${new Date(data.data_chegada).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}`;

                // Exibe a origem, destino e portão
                document.getElementById('origem').textContent = origemText;
                document.getElementById('destino').textContent = destinoText;
                document.getElementById('portao').textContent = `Portão: ${data.numero_portao} - Terminal ${data.nome_terminal}`;

                // Exibe as escalas, se houver
                if (data.escalas && data.escalas.length > 0) {
                    const escalasText = data.escalas.join(', '); // Junta os nomes das escalas com vírgula
                    document.getElementById('escala').textContent = `Escala(s): ${escalasText}`;
                } else {
                    document.getElementById('escala').textContent = 'Sem escalas';
                }
            })
            .catch(error => {
                console.error('Erro ao buscar dados do voo:', error);
            });

        // Exibe o assento
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


</body>