<?php
session_start();

if (!isset($_SESSION['email']) || (!($_SESSION['tipo_usuario'] === '1' || $_SESSION['tipo_usuario'] === '2'))) {
    header('Location: /aeroporto/login');
    exit();
}



?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Passagens</title>
    <link rel="stylesheet" href="../../../assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;500;700&display=swap" rel="stylesheet">
</head>
<body id="adm">
<aside class="sidebar">
    <div class="sidebar-header">
        <h1>FlyAir<a href="#"><img src="../../../assets/images/fly-airplane.png" alt="Logo" class="logo"></a></h1>
    </div>
    <nav class="menu">
        <a href="../../../routes/aeroportoRoutes.php" class="menu-item"><i class="fa-solid fa-plane-departure"></i><span>Aeroportos</span></a>
        <a href="../../../routes/aviaoRoutes.php" class="menu-item"><i class="fas fa-plane"></i><span>Aviões</span></a>
        <a href="../../../routes/assentoRoutes.php" class="menu-item"><i class="fas fa-chair"></i><span>Assentos</span></a>
        <a href="../../../routes/companhiaRoutes.php" class="menu-item"><i class="fas fa-building"></i><span>Companhias</span></a>
         <a href="../../../routes/portaoRoutes.php" class="menu-item"><i class="fa-solid fa-cart-flatbed-suitcase"></i><span>Portões</span></a>
        <a href="../../../routes/passagemRoutes.php" class="menu-item"><i class="fas fa-tags"></i><span>Passagens</span></a>
        <a href="../../../routes/segmentoVooRoutes.php" class="menu-item"><i class="fas fa-route"></i><span>Segmento de Voo</span></a>
        <a href="../../../routes/terminalRoutes.php" class="menu-item"><i class="fa-solid fa-signs-post"></i><span>Terminais</span></a>
        <a href="../../../routes/usuarioRoutes.php" class="menu-item">
            <i class="fas fa-users"></i>
            <span>Usuários</span>
        </a>
        <a href="../routes/vooRoutes.php" class="menu-item">
            <i class="fas fa-plane-departure"></i>
            <span>Voos</span>
        </a>
        <a href="/aeroporto" class="menu-item">
            <i class="fa-solid fa-cart-flatbed-suitcase"></i>
            <span>Site</span>
        </a>
        <a href="/aeroporto/logout" class="menu-item">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Sair</span>
        </a>
    </nav>
</aside>

<main>
    <header class="main-header">
        <h2>Olá, seja bem-vindo <?= $_SESSION['usuario_nome'] ?></h2>
    </header>
    <section class="dashboard-content">
        <div class="dashboard-cards">
            <div class="cardaa">
                <h3>Total de Voos</h3>
                <p id="total_voos">Carregando...</p>
            </div>
            <div class="cardaa">
                <h3>Total de Passagens</h3>
                <p id="total_passagens">Carregando...</p>
            </div>
            <div class="cardaa">
                <h3>Total de Aeronaves</h3>
                <p id="total_aeronaves">Carregando...</p>
            </div>
            <div class="cardaa">
                <h3>Total de Assentos</h3>
                <p id="total_assentos">Carregando...</p>
            </div>
            <div class="cardaa">
                <h3>Total de Companhias</h3>
                <p id="total_companhias">Carregando...</p>
            </div>
            <div class="cardaa">
                <h3>Total de Aeroportos</h3>
                <p id="total_aeroportos">Carregando...</p>
            </div>
            <div class="cardaa">
                <h3>Mensagens de Contato Não Lidas</h3>
                <p id="mensagens_nao_lidas">Carregando...</p>
            </div>
            <div class="cardaa">
                <h3>Total de Usuários</h3>
                <p id="total_usuarios">Carregando...</p>
            </div>
            <div class="cardaa">
                <h3>Total de Portões</h3>
                <p id="total_portoes">Carregando...</p>
            </div>
            <div class="cardaa">
                <h3>Total de Escalas</h3>
                <p id="total_escala">Carregando...</p>
            </div>
        </div>
    </section>
    <section class="flight-board mt-5">
        <h3 style="margin-bottom: 20px;">Painel de Voos</h3>
        <div class="table-responsive">

            <table class="table table-hover table-bordered text-center align-middle">
                <thead class="table-dark">
                <tr>
                    <th>Nº Voo</th>
                    <th>Companhia</th>
                    <th>Origem</th>
                    <th>Destino</th>
                    <th>Saída</th>
                    <th>Chegada</th>
                    <th>Portão</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody id="flightTableBody">
                <!-- Linhas serão inseridas via JS -->
                </tbody>
            </table>
        </div>
    </section>

</main>
<script>
    fetch('../../../routes/vooRoutes.php?painel_voos=1')

            .then(res => res.json())
        .then(data => {
            const tbody = document.getElementById('flightTableBody');
            data.forEach(voo => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${voo.numero_voo}</td>
                    <td>${voo.companhia}</td>
                    <td>${voo.origem}</td>
                    <td>${voo.destino}</td>
                    <td>${voo.data_saida}</td>
                    <td>${voo.data_chegada}</td>
                    <td>${voo.portao}</td>
                    <td>${voo.status}</td>
                `;
                tbody.appendChild(row);
            });
        })
        .catch(error => console.error('Erro ao carregar painel de voos:', error));
</script>

<script>
    fetch('../../../routes/buscaRoutes.php')
        .then(response => response.text())
        .then(data => {
            console.log(data);
            try {
                const jsonData = JSON.parse(data);
                document.getElementById('total_voos').textContent = jsonData.total_voos;
                document.getElementById('total_passagens').textContent = jsonData.total_passagens;
                document.getElementById('total_aeronaves').textContent = jsonData.total_aeronaves;
                document.getElementById('total_assentos').textContent = jsonData.total_assentos;
                document.getElementById('total_companhias').textContent = jsonData.total_companhias;
                document.getElementById('total_aeroportos').textContent = jsonData.total_aeroportos;
                document.getElementById('mensagens_nao_lidas').textContent = jsonData.mensagens_nao_lidas;
                document.getElementById('total_usuarios').textContent = jsonData.total_usuarios;
                document.getElementById('total_portoes').textContent = jsonData.total_portoes;
                document.getElementById('total_escala').textContent = jsonData.total_escala;
            } catch (error) {
                console.error('Erro ao parsear JSON:', error);
            }
        })
        .catch(error => {
            console.error('Erro ao buscar dados:', error);
        });

</script>

</body>
</html>