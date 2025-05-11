<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: /aeroporto/login');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Meu Perfil</title>
    <link rel="stylesheet" href="assets/css/style.css"/>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;500;700&display=swap" rel="stylesheet"/>
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

<main class="perfil">
    <div class="perfil-header">
        <h1>Meu Perfil</h1>
    </div>

    <section class="reservas-section">
        <h2>Minhas Reservas</h2>
        <div id="lista-reservas"></div>
    </section>
</main>

<script>
    async function carregarReservas() {
        try {
            const response = await fetch('http://localhost/aeroporto/routes/reservaRoutes.php?perfil=true');
            if (!response.ok) throw new Error('Erro ao carregar reservas');
            const reservas = await response.json();

            const lista = document.getElementById('lista-reservas');

            if (reservas.length === 0) {
                lista.innerHTML = '<p class="nenhuma-reserva">Você ainda não possui nenhuma reserva.</p>';
                return;
            }

            reservas.forEach(reserva => {
                const agora = new Date();
                const horaFormatada = agora.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                const section = document.createElement('section');
                section.classList.add('informacoes');

                section.innerHTML = `
                <div class="lalala">
                    <div class="ticket-header">
                        <div>
                            <h3>Origem</h3>
                            <p>${reserva.nome_aeroporto_origem}</p>
                            <p>Terminal: ${reserva.nome_terminal}</p>
                        </div>
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
                        <span>${reserva.status_reserva}</span>
                    </div>
                    <div class="qr-code">
                        <img src="./assets/images/qrcode.jpg" alt="QR Code">
                    </div>
                </div>
                <div class="note">
                    Observação: Apresente o ticket no momento do embarque.
                    <br>
                    <small>Ticket gerado às ${horaFormatada}</small>
                </div>
                `;

                if (reserva.status_reserva !== 'Cancelada') {
                    section.innerHTML += `
                    <form action="routes/reservaRoutes.php" method="post" onsubmit="return confirmarCancelamento()">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id_reserva" value="${reserva.id_reserva}">
                        <input type="hidden" name="id_assento" value="${reserva.numero_assento}">
                        <button type="submit" class="botao-cancelar">Cancelar</button>
                    </form>
                    `;
                }

                lista.appendChild(section);
            });
        } catch (error) {
            console.error('Erro ao carregar reservas:', error);
        }
    }

    function confirmarCancelamento() {
        return confirm("Você tem certeza que deseja cancelar esta reserva?");
    }

    document.addEventListener('DOMContentLoaded', carregarReservas);
</script>

</body>
</html>
