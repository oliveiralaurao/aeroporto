<?php
session_start();
if (isset($_GET['id_voo'])) {
    $id_voo = $_GET['id_voo'];
} else {
    $id_voo = null;
}


?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleção de Assento - Voo </title>
    <link rel="stylesheet" href="assets/css/style.min.css">
    <link rel="stylesheet" href="assets/css/seat-selection.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;500;700&display=swap" rel="stylesheet">
    <style>
        h1 {
            color: #2c3e50;
            margin-bottom: 30px;
            text-align: center;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
    </style>
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
<main id="assentos">


<div class="seat-selection-container">
    <h1>Escolha seu Assento</h1>

    <div class="legend">
        <div class="legend-item">
            <span class="legend-color available"></span> Disponível
        </div>
        <div class="legend-item">
            <span class="legend-color occupied"></span> Ocupado
        </div>
        <div class="legend-item">
            <span class="legend-color selected"></span> Selecionado
        </div>
        <div class="legend-item">
            <span class="legend-color aisle"></span> Corredor
        </div>
    </div>

    <div class="aircraft-layout" id="aircraftLayout">
        Carregando mapa de assentos...
    </div>

    <div id="selectedSeatsDisplay">
        Assentos Selecionados: <span id="selectedSeatsList">Nenhum</span>
    </div>

    <form method="post" id="confirmSeatsForm">
        <input type="hidden" name="flight_id" id="flightIdInput" value="<?php echo $id_voo; ?>">
        <input type="hidden" name="chosen_seats" id="chosenSeatsInput" value="">
        <button type="submit" id="confirmSeatsButton" disabled>Confirmar Assentos</button>
    </form>
</div>
</main>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const aircraftLayout = document.getElementById('aircraftLayout');
        const selectedSeatsList = document.getElementById('selectedSeatsList');
        const chosenSeatsInput = document.getElementById('chosenSeatsInput');
        const confirmSeatsButton = document.getElementById('confirmSeatsButton');
        const confirmSeatsForm = document.getElementById('confirmSeatsForm');
        const flightId = document.getElementById('flightIdInput').value;
        let selectedSeats = [];


        async function carregarMapaAssentos() {
            try {
                const response = await fetch(`http://localhost/aeroporto/routes/assentoGetRoutes.php?id_voo=${flightId}`);
                const data = await response.json();

                if (data.error) {
                    aircraftLayout.innerHTML = `<p>${data.error}</p>`;
                    return;
                }

                const assentos = data.assentos.assentos;

                renderizarMapa(assentos);
            } catch (error) {
                aircraftLayout.innerHTML = `<p>Erro ao carregar dados: ${error.message}</p>`;
            }
        }

        function renderizarMapa(assentos) {
            aircraftLayout.innerHTML = '';
            const columnsSet = new Set();
            assentos.forEach(seat => {
                columnsSet.add(seat.numero_assento.charAt(0));
            });
            const columns = Array.from(columnsSet).sort();

            const rowsSet = new Set();
            assentos.forEach(seat => {
                const rowNumberStr = seat.numero_assento.slice(1);
                if (!isNaN(parseInt(rowNumberStr))) {
                    rowsSet.add(parseInt(rowNumberStr));
                }
            });
            const rows = Array.from(rowsSet).sort((a, b) => a - b);

            aircraftLayout.style.gridTemplateColumns = `auto repeat(${columns.length}, 36px)`;

            rows.forEach(rowNumber => {
                const rowNumberDiv = document.createElement('div');
                rowNumberDiv.classList.add('row-number');
                rowNumberDiv.textContent = rowNumber;
                aircraftLayout.appendChild(rowNumberDiv);

                columns.forEach(columnLetter => {
                    const seatInfo = assentos.find(seat => seat.numero_assento === `${columnLetter}${rowNumber}`);

                    if (seatInfo) {
                        const seatDiv = document.createElement('div');
                        seatDiv.textContent = seatInfo.numero_assento;
                        seatDiv.dataset.seatNumber = seatInfo.numero_assento;

                        if (seatInfo.status_assento === 'Corredor') {
                            seatDiv.classList.add('seat', 'aisle');
                            seatDiv.textContent = '';
                        } else {
                            seatDiv.classList.add('seat');
                            if (seatInfo.status_assento === 'Ocupado') {
                                seatDiv.classList.add('occupied');
                            } else {
                                seatDiv.addEventListener('click', function() {
                                    const seatNumber = this.dataset.seatNumber;
                                    if (this.classList.contains('selected')) {
                                        this.classList.remove('selected');
                                        selectedSeats = seatNumber;

                                    } else {
                                        this.classList.add('selected');
                                        selectedSeats.push(seatNumber);
                                        console.log(selectedSeats)

                                    }
                                    selectedSeatsList.textContent = selectedSeats.join(', ') || 'Nenhum';

                                    chosenSeatsInput.value = selectedSeats.join(',');
                                    confirmSeatsButton.disabled = selectedSeats.length === 0;
                                });
                            }
                        }
                        aircraftLayout.appendChild(seatDiv);
                    } else {
                        const emptyDiv = document.createElement('div');
                        aircraftLayout.appendChild(emptyDiv);
                    }
                });
            });
        }

        carregarMapaAssentos();

        confirmSeatsForm.addEventListener('submit', (event) => {
            event.preventDefault();

            if (selectedSeats.length > 0) {
                const assentoSelecionado = selectedSeats.join(',');
                const urlRedirecionamento = `checkin.php?assento=${encodeURIComponent(assentoSelecionado)}&voo=${encodeURIComponent(flightId)}`;
                window.location.href = urlRedirecionamento;
            } else {
                alert('Por favor, selecione pelo menos um assento antes de confirmar.');
            }
        });
    });
</script>
</body>
</html>