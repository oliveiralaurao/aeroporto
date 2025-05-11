<?php
session_start();

if (!isset($_SESSION['email']) || (!($_SESSION['tipo_usuario'] === '1' || $_SESSION['tipo_usuario'] === '2'))) {
    header('Location: /aeroporto/login');
    exit();
}
require_once '../routes/terminalRoutes.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Cadastro de Terminais</title>
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
        <a href="../routes/aviaoRoutes.php" class="menu-item">
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
        <a href="../routes/terminalRoutes.php" class="menu-item active">
          <i class="fa-solid fa-signs-post"></i>
          <span>Terminais</span>
          </a>
          <a href="../routes/usuarioRoutes.php" class="menu-item">
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
<h1>Gerenciamento de Terminais</h1>

<!-- Mensagem de feedback (opcional) -->
    <?php if (isset($_GET['msg'])): ?>
        <p style="color: green;"><strong><?= htmlspecialchars($_GET['msg']) ?></strong></p>
    <?php endif; ?>
    <?php if (isset($_GET['msgP'])): ?>
        <div class="alert alert-warning">
            <strong>Atenção:</strong> <?= htmlspecialchars($_GET['msgP']) ?>

        </div>
    <?php endif; ?>

<!-- Formulário de Cadastro -->
<div class="form-container" id='formulario'>
  <h2>Cadastrar Terminal</h2>
  <form method="post" action="../routes/terminalRoutes.php">
    <input type="hidden" name="action" value="create">
    
    <label for="id_aeroporto">Aeroporto:</label>
    <select name="id_aeroporto" required>
      <?php while ($aeroporto = $aeroportos->fetch_assoc()): ?>
        <option value="<?= $aeroporto['id_aeroporto'] ?>"><?= $aeroporto['nome_aeroporto'] ?></option>
      <?php endwhile; ?>
    </select>

    <label for="nome_terminal">Nome do Terminal:</label>
    <input type="text" name="nome_terminal" required>

    <input type="submit" value="Cadastrar">
  </form>
</div>

<!-- Formulário de Edição -->
<div class="form-container" id='formulario'>
  <h2>Editar Terminal</h2>
  <form method="post" action="../routes/terminalRoutes.php">
    <input type="hidden" name="action" value="update">

    <label for="id_terminal">Selecione o Terminal:</label>
    <select name="id_terminal" required>
      <?php
      $terminais->data_seek(0);
      while ($terminal = $terminais->fetch_assoc()):
      ?>
        <option value="<?= $terminal['id_terminal'] ?>">
          <?= $terminal['nome_terminal'] ?> (<?= $terminal['nome_aeroporto'] ?>)
        </option>
      <?php endwhile; ?>
    </select>

    <label for="id_aeroporto_edit">Aeroporto:</label>
    <select name="id_aeroporto_edit" required>
      <?php
      $aeroportos->data_seek(0);
      while ($aeroporto = $aeroportos->fetch_assoc()):
      ?>
        <option value="<?= $aeroporto['id_aeroporto'] ?>"><?= $aeroporto['nome_aeroporto'] ?></option>
      <?php endwhile; ?>
    </select>

    <label for="update_nome_terminal">Nome do Terminal:</label>
    <input type="text" name="update_nome_terminal" required>

    <input type="submit" value="Atualizar">
  </form>
</div>

<!-- Lista de terminais com opção de exclusão -->
<div class="form-container" id="listar">
  <h2>Lista de Terminais</h2>
  <form method="post" action="../routes/terminalRoutes.php">
    <input type="hidden" name="action" value="delete">

    <div class="table-container">
      <table class="styled-table">
        <thead>
          <tr>
            <th>Excluir</th>
            <th>Terminal</th>
            <th>Aeroporto</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $terminais->data_seek(0);
          while ($terminal = $terminais->fetch_assoc()):
          ?>
            <tr>
              <td><input type="checkbox" name="ids[]" value="<?= $terminal['id_terminal'] ?>"></td>
              <td><?= $terminal['nome_terminal'] ?></td>
              <td><?= $terminal['nome_aeroporto'] ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <div class="button-wrapper">
      <input type="submit" value="Excluir Selecionados" class="btn-delete">
    </div>
  </form>
</div>


</main>
  
</body>
</html>
