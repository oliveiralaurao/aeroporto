<?php
require_once '../routes/pageRoutes.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FlyAir - Sua Viagem Começa Aqui</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body id="public">
<header class="hero">
    <nav class="nav container">
        <a href="/aeroporto" class="logo">FlyAir</a>
        <ul class="nav-links">
            <li><a href="/aeroporto#listavoos">Voos</a></li>
            <li><a href="/aeroporto/sac">Atendimento</a></li>
        </ul>
        <li>
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <a href="/aeroporto/logout" class="login-btn">Sair</a>
            <?php else: ?>
                <a href="/aeroporto/login" class="login-btn">Entrar</a>
            <?php endif; ?>
        </li>

    </nav>

    <div class="hero-content container">
        <h1>Ganhe <span>15% OFF</span> na sua primeira viagem</h1>
        <p>Descubra novos destinos e embarque com a FlyAir.</p>
        <a href="/aeroporto/sac" class="confira">Confira Agora<i class="fa-solid fa-arrow-down"></i></a>
    </div>
</header>

<main class="benefits">
    <h2>Por que viajar com a FlyAir?</h2>
    <div class="benefit-grid">
        <div class="item">
            <h3>✈️ Destinos incríveis</h3>
            <p>Explore mais de 120 cidades pelo mundo.</p>
        </div>
        <div class="item">
            <h3>💳 Ofertas exclusivas</h3>
            <p>Descontos semanais para você viajar pagando menos.</p>
        </div>
        <div class="item">
            <h3>📱 Tudo na palma da mão</h3>
            <p>Reserve, consulte e embarque pelo celular.</p>
        </div>
        <div class="item">
            <h3>🛡️ Segurança em 1º lugar</h3>
            <p>Viagens com confiança e suporte dedicado.</p>
        </div>
    </div>

    <div class="hero-content container">

        <form action="" method="POST" class="search-form">
            <input type="search" name="pesquisar_destino" id="pesquisar_destino" placeholder="Ex: Canadá, Paris..." list="destino" required />
            <datalist id="destino">
                <option value="Canadá">
                <option value="Paris">
                <option value="Porto de Galinhas">
            </datalist>
            <button type="submit">Pesquisar</button>
        </form>
    </div>

    <?php if (isset($_SESSION['voos_busca'])) : ?>
        <h1 class="section-title">Resultados da Busca</h1>

        <?php if (empty($_SESSION['voos_busca'])) : ?>
            <p class="text-center">Nenhum voo encontrado para o destino informado.</p>
        <?php else : ?>
            <?php foreach ($_SESSION['voos_busca'] as $voo) : ?>
                <div class="flight-card">
                    <div class="vumvum">
                        <div class="details">
                            <div>
                                <h3>Origem: <?= htmlspecialchars($voo['nome_cidade']) ?></h3>
                                <p>Aeroporto: <?= htmlspecialchars($voo['origem_nome']) ?></p>
                                <p><?= date('d/m/Y H:i', strtotime($voo['data_saida'])) ?> hrs - Gate <?= $voo['id_portao'] ?></p>
                            </div>
                        </div>
                        <div class="details">
                            <div>
                                <h3>Destino: <?= htmlspecialchars($voo['nome_cidade_volta']) ?></h3>
                                <p>Aeroporto: <?= htmlspecialchars($voo['destino_nome']) ?></p>
                                <p><?= date('d/m/Y H:i', strtotime($voo['data_chegada'])) ?> hrs</p>
                            </div>
                        </div>
                    </div>
                    <p>Tipo de voo: <?= htmlspecialchars($voo['tipo_voo']) ?></p>
                    <a href="mapa_assentos.php?id_voo=<?= $voo['id_voo'] ?>">Ver mapa de assentos</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endif; ?>

    <h1 class="section-title">Voos Nacionais</h1>

    <?php if (empty($voosNacionais)) : ?>
        <p class="text-center">Nenhum voo nacional disponível no momento.</p>
    <?php else : ?>
        <?php foreach ($voosNacionais as $voo) : ?>
            <div class="flight-card" id="listavoos">
                <div class="vumvum">
                    <div class="details">
                        <div>
                            <h3>Origem: <?= htmlspecialchars($voo['nome_cidade']) ?></h3>
                            <p>Aeroporto: <?= htmlspecialchars($voo['origem_nome']) ?></p>
                            <p><?= date('d/m/Y H:i', strtotime($voo['data_saida'])) ?> hrs - Gate <?= $voo['id_portao'] ?></p>
                        </div>
                    </div>
                    <div class="details">
                        <div>
                            <h3>Destino: <?= htmlspecialchars($voo['nome_cidade_volta']) ?></h3>
                            <p>Aeroporto: <?= htmlspecialchars($voo['destino_nome']) ?></p>
                            <p><?= date('d/m/Y H:i', strtotime($voo['data_chegada'])) ?> hrs</p>
                        </div>
                    </div>
                </div>
                <p>Tipo de voo: <?= htmlspecialchars($voo['tipo_voo']) ?></p>
                <a href="public/mapa_assentos.php?id_voo=<?= $voo['id_voo'] ?>">Ver mapa de assentos</a>

            </div>
        <?php endforeach; ?>
    <?php endif; ?>


    <h1 class="section-title">Voos Internacionais</h1>

    <?php if (empty($voosInternacionais)) : ?>
        <p class="text-center">Nenhum voo internacional disponível no momento.</p>
    <?php else : ?>
        <?php foreach ($voosInternacionais as $voo) : ?>
            <div class="flight-card">
                <div class="vumvum">
                    <div class="details">
                        <div>
                            <h3>Origem: <?= htmlspecialchars($voo['nome_cidade']) ?></h3>
                            <p>Aeroporto: <?= htmlspecialchars($voo['origem_nome']) ?></p>
                            <p><?= date('d/m/Y H:i', strtotime($voo['data_saida'])) ?> hrs - Gate <?= $voo['id_portao'] ?></p>
                        </div>
                    </div>
                    <div class="details">
                        <div>
                            <h3>Destino: <?= htmlspecialchars($voo['nome_cidade_volta']) ?></h3>
                            <p>Aeroporto: <?= htmlspecialchars($voo['destino_nome']) ?></p>
                            <p><?= date('d/m/Y H:i', strtotime($voo['data_chegada'])) ?> hrs</p>
                        </div>
                    </div>
                </div>
                <p>Tipo de voo: <?= htmlspecialchars($voo['tipo_voo']) ?></p>
                <a href="/aeroporto/mapaVoos?id_voo=<?= $voo['id_voo'] ?>">Ver mapa de assentos</a>

            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</main>
<footer>
    <p>&copy; 2025 FlyAir. Todos os direitos reservados.</p>
    <ul>
        <li><a href="#">Política de Privacidade</a></li>
        <li><a href="#">Termos de Uso</a></li>
    </ul>
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>