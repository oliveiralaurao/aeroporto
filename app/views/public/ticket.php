<?php
session_start();


$iduser = $_SESSION['usuario_id'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Ticket</title>
    <link rel="stylesheet" href="../../../assets/css/style.css">
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

<main class="ticket">
    <h1>Ticket</h1>
    <section class="informacoes">
        <div class="lalala">
            <div class="ticket-header">
                <div>
                    <h3>Origem</h3>
                    <p id="origem"></p>
                    <p id="terminal"></p>
                </div>
                <div>
                    <h3>Destino</h3>
                    <p id="destino"></p>
                </div>
            </div>
        </div>
        <div class="ticket-details">
            <div class="info lalalala">
                <span>Nome:</span>
                <p id="nome"></p>
                <br>
            </div>
            <div class="info kakaka">
                <span>Assento:</span>
                <p id="assento"></p>
                <br>
                <span>Status:</span>
                Confirmado
            </div>
            <div class="qr-code">
                <img src="../../../assets/images/qrcode.jpg" alt="QR Code">
            </div>
        </div>
        <div class="note">
            Observação: Apresente o ticket no momento do embarque.
            <br>
            <small>Ticket gerado às <span id="hora"></span></small>
        </div>
    </section>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const params = new URLSearchParams(window.location.search);
        const passagensIds = params.get('ids_passagens') ? params.get('ids_passagens').split(',') : [];
        const ids = params.get('ids');
        const ids_passagens = params.get('ids_passagens');

        fetch(`../../../routes/reservaRoutes.php?ids=${ids}&ids_passagens=${ids_passagens}`)
            .then(response => response.json())
            .then(data => {
                console.log(data)
                if (data.length > 0) {
                    const container = document.querySelector('.informacoes');
                    container.innerHTML = '';
                    console.log(data)
                    data.forEach((reserva, index) => {

                        const ticketHTML = `
                        <div class="lalala">
                            <div class="ticket-header">
                                <div>
                                    <h3>Origem</h3>
                                    <p>${reserva.nome_aeroporto_origem}</p>
                                    <p>Terminal: ${reserva.nome_terminal}</p>
                                </div>
                                ${reserva.escalas ? `
                                    <div>
                                        <h3>Escala</h3>
                                        <p>${reserva.escalas}</p>
                                    </div>
                                ` : ''}
                                <div>
                                    <h3>Destino</h3>
                                    <p>${reserva.nome_aeroporto_destino}</p>
                                </div>
                            </div>
                        </div>
                        <div class="ticket-details">
                            <div class="info lalalala">
                                <span>Nome:</span>
                                <p>${reserva.nome_passageiro}</p>
                                <br>
                            </div>
                            <div class="info kakaka">
                                <span>Assento:</span>
                                <p>${reserva.numero_assento}</p>
                                <br>
                                <span>Status:</span>
                                ${reserva.status_reserva}
                            </div>
                            <div class="qr-code">
                                <img src="../../../assets/images/qrcode.jpg" alt="QR Code">
                            </div>
                        </div>
                        <div class="note">
                            Observação: Apresente o ticket no momento do embarque.
                            <br>
                            <small>Ticket gerado às <span>${new Date().toLocaleTimeString()}</span></small>
                        </div>
                        <hr>
                    `;
                        container.insertAdjacentHTML('beforeend', ticketHTML);
                    });
                } else {
                    alert('Você não possui reservas.');
                }
            })
            .catch(error => console.error('Erro ao buscar dados:', error));
    });

</script>


</body>
</html>
