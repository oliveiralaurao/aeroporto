-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 12/05/2025 às 00:47
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `airport3`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `aeronaves`
--

DROP TABLE IF EXISTS `aeronaves`;
CREATE TABLE `aeronaves` (
  `id_aeronave` int(11) NOT NULL,
  `modelo_aeronave` varchar(255) NOT NULL,
  `capacidade_aeronave` int(11) NOT NULL,
  `quantidade_fileiras` int(11) NOT NULL,
  `quantidade_assentos_por_fileira` int(11) NOT NULL,
  `id_companhia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `aeronaves`
--

INSERT INTO `aeronaves` (`id_aeronave`, `modelo_aeronave`, `capacidade_aeronave`, `quantidade_fileiras`, `quantidade_assentos_por_fileira`, `id_companhia`) VALUES
(1, 'Boeing 787-8', 200, 25, 8, 1),
(2, 'Airbus A320', 180, 30, 6, 1);


-- --------------------------------------------------------

--
-- Estrutura stand-in para view `aeronaveview`
-- (Veja abaixo para a visão atual)
--
DROP VIEW IF EXISTS `aeronaveview`;
CREATE TABLE `aeronaveview` (
`id_aeronave` int(11)
,`modelo_aeronave` varchar(255)
,`quantidade_fileiras` int(11)
,`quantidade_assentos_por_fileira` int(11)
,`nome_companhia` varchar(255)
,`id_companhia` int(11)
);

-- --------------------------------------------------------

--
-- Estrutura para tabela `aeroportos`
--

DROP TABLE IF EXISTS `aeroportos`;
CREATE TABLE `aeroportos` (
  `id_aeroporto` int(11) NOT NULL,
  `nome_aeroporto` varchar(255) NOT NULL,
  `codigo_aeroporto` varchar(10) NOT NULL,
  `localizacao_aeroporto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `aeroportos`
--

INSERT INTO `aeroportos` (`id_aeroporto`, `nome_aeroporto`, `codigo_aeroporto`, `localizacao_aeroporto`) VALUES
(1, 'Aeroporto Internacional de São Paulo', 'GRU', 'São Paulo, SP, Brasil'),
(2, 'Aeroporto de São Paulo/Congonhas–Deputado Freitas Nobre', 'CGH, SBSP', 'São Paulo, SP, Brasil');

-- --------------------------------------------------------

--
-- Estrutura para tabela `assentos`
--

DROP TABLE IF EXISTS `assentos`;
CREATE TABLE `assentos` (
  `id_assento` int(11) NOT NULL,
  `numero_assento` varchar(10) NOT NULL,
  `status_assento` enum('Disponível','Ocupado','Corredor') NOT NULL,
  `id_voo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `assentos`
--

INSERT INTO `assentos` (`id_assento`, `numero_assento`, `status_assento`, `id_voo`) VALUES
(1, 'A1', 'Disponível', 1),
(2, 'B1', 'Disponível', 1);


-- --------------------------------------------------------

--
-- Estrutura para tabela `companhias`
--

DROP TABLE IF EXISTS `companhias`;
CREATE TABLE `companhias` (
  `id_companhia` int(11) NOT NULL,
  `nome_companhia` varchar(255) NOT NULL,
  `codigo_companhia` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `companhias`
--

INSERT INTO `companhias` (`id_companhia`, `nome_companhia`, `codigo_companhia`) VALUES
(1, 'Gol Linhas Aéreas Inteligentes', 'G3'),
(2, 'Latam Airlines', 'LA');


-- --------------------------------------------------------

--
-- Estrutura para tabela `passageiros`
--

DROP TABLE IF EXISTS `passageiros`;
CREATE TABLE `passageiros` (
  `id_passageiros` int(11) NOT NULL,
  `nome_passageiro` varchar(255) NOT NULL,
  `email_passageiro` varchar(255) NOT NULL,
  `senha_passageiro` varchar(255) NOT NULL,
  `telefone_passageiro` varchar(15) NOT NULL,
  `pais_passageiro` varchar(100) NOT NULL,
  `documento_passageiro` varchar(20) NOT NULL,
  `datanasc_passageiro` date NOT NULL,
  `tipo_passageiro` enum('0','1','2') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `passageiros`
--

INSERT INTO `passageiros` (`id_passageiros`, `nome_passageiro`, `email_passageiro`, `senha_passageiro`, `telefone_passageiro`, `pais_passageiro`, `documento_passageiro`, `datanasc_passageiro`, `tipo_passageiro`) VALUES
(1, 'teste', 'teste@teste.com', 'teste', '(99) 99999-9999', 'teste', '999.999.999-99', '0000-00-00', '1');

-- --------------------------------------------------------

--
-- Estrutura para tabela `passagens`
--

DROP TABLE IF EXISTS `passagens`;
CREATE TABLE `passagens` (
  `id_passagem` int(11) NOT NULL,
  `valor_passagem` int(11) NOT NULL,
  `assentos_id_assento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `passagens`
--

INSERT INTO `passagens` (`id_passagem`, `valor_passagem`, `assentos_id_assento`) VALUES
(2, 400, 2),
(3, 300, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `portoes`
--

DROP TABLE IF EXISTS `portoes`;
CREATE TABLE `portoes` (
  `id_portao` int(11) NOT NULL,
  `numero_portao` varchar(10) NOT NULL,
  `id_terminal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `portoes`
--

INSERT INTO `portoes` (`id_portao`, `numero_portao`, `id_terminal`) VALUES

(1, 'D4', 1),
(2, 'E5', 1),
(3, 'F6', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `reservas`
--

DROP TABLE IF EXISTS `reservas`;
CREATE TABLE `reservas` (
  `id_reserva` int(11) NOT NULL,
  `status_reserva` enum('Confirmada','Cancelada') NOT NULL,
  `id_passageiro` int(11) NOT NULL,
  `id_voo` int(11) NOT NULL,
  `passagens_id_passagem` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `reservas`
--

INSERT INTO `reservas` (`id_reserva`, `status_reserva`, `id_passageiro`, `id_voo`, `passagens_id_passagem`) VALUES
(1, 'Cancelada', 1, 1, 1),
(2, 'Confirmada', 1, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `segmentovoo`
--

DROP TABLE IF EXISTS `segmentovoo`;
CREATE TABLE `segmentovoo` (
  `id_segmento` int(11) NOT NULL,
  `id_voo` int(11) NOT NULL,
  `destino` int(11) NOT NULL,
  `hora_partida` datetime NOT NULL,
  `hora_chegada` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `segmentovoo`
--

INSERT INTO `segmentovoo` (`id_segmento`, `id_voo`, `destino`, `hora_partida`, `hora_chegada`) VALUES
(1, 1, 2, '2024-12-14 19:20:00', '2024-12-19 19:20:00'),
(1, 2, 1, '2004-01-26 14:50:00', '2222-01-26 14:51:00'),


-- --------------------------------------------------------

--
-- Estrutura para tabela `terminais`
--

DROP TABLE IF EXISTS `terminais`;
CREATE TABLE `terminais` (
  `id_terminal` int(11) NOT NULL,
  `id_aeroporto` int(11) NOT NULL,
  `nome_terminal` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `terminais`
--

INSERT INTO `terminais` (`id_terminal`, `id_aeroporto`, `nome_terminal`) VALUES

(1, 1, 'Terminal 2 - Aeroporto Internacional São Paulo'),
(2, 2, 'Terminal 1 - Aeroporto Internacional Rio de Janeiro');

-- --------------------------------------------------------

--
-- Estrutura para tabela `voos`
--

DROP TABLE IF EXISTS `voos`;
CREATE TABLE `voos` (
  `id_voo` int(11) NOT NULL,
  `numero_voo` varchar(50) NOT NULL,
  `id_aeronave` int(11) NOT NULL,
  `id_portao` int(11) NOT NULL,
  `data_chegada` datetime NOT NULL,
  `data_saida` datetime NOT NULL,
  `origem_voo` int(11) NOT NULL,
  `destino_voo` int(11) NOT NULL,
  `tipo_voo` enum('Direto','Escala') NOT NULL,
  `status_voo` enum('Atrasado','No horário','Embarcando','Decolando','Cancelado','Pousando','Taxiando','Finalizado','Aguardando Autorização','Desembarcando','Manutenção','Reprogramado','Fechado','Suspenso','Em Rota','Desviado','Check-in Aberto','Portão Fechado') NOT NULL,
  `localizacao_voo` enum('Nacional','Internacional') NOT NULL DEFAULT 'Nacional'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `voos`
--

INSERT INTO `voos` (`id_voo`, `numero_voo`, `id_aeronave`, `id_portao`, `data_chegada`, `data_saida`, `origem_voo`, `destino_voo`, `tipo_voo`, `status_voo`, `localizacao_voo`) VALUES
(1, 'AA1234', 2, 1, '2024-12-30 14:30:00', '2024-12-30 16:45:00', 1, 2, 'Escala', 'Reprogramado', 'Internacional'),
(2, 'AA9012', 1, 2, '2024-12-12 04:15:00', '2024-12-17 05:15:00', 2, 1, 'Direto', 'Finalizado', 'Nacional');


-- --------------------------------------------------------

--
-- Estrutura para view `aeronaveview`
--
DROP TABLE IF EXISTS `aeronaveview`;

DROP VIEW IF EXISTS `aeronaveview`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `aeronaveview`  AS SELECT `a`.`id_aeronave` AS `id_aeronave`, `a`.`modelo_aeronave` AS `modelo_aeronave`, `a`.`quantidade_fileiras` AS `quantidade_fileiras`, `a`.`quantidade_assentos_por_fileira` AS `quantidade_assentos_por_fileira`, `c`.`nome_companhia` AS `nome_companhia`, `c`.`id_companhia` AS `id_companhia` FROM (`aeronaves` `a` join `companhias` `c` on(`a`.`id_companhia` = `c`.`id_companhia`)) ;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `aeronaves`
--
ALTER TABLE `aeronaves`
  ADD PRIMARY KEY (`id_aeronave`),
  ADD KEY `id_companhia` (`id_companhia`);

--
-- Índices de tabela `aeroportos`
--
ALTER TABLE `aeroportos`
  ADD PRIMARY KEY (`id_aeroporto`);

--
-- Índices de tabela `assentos`
--
ALTER TABLE `assentos`
  ADD PRIMARY KEY (`id_assento`),
  ADD KEY `id_voo` (`id_voo`);

--
-- Índices de tabela `companhias`
--
ALTER TABLE `companhias`
  ADD PRIMARY KEY (`id_companhia`);

--

-- Índices de tabela `passageiros`
--
ALTER TABLE `passageiros`
  ADD PRIMARY KEY (`id_passageiros`);

--
-- Índices de tabela `passagens`
--
ALTER TABLE `passagens`
  ADD PRIMARY KEY (`id_passagem`),
  ADD KEY `fk_passagens_assentos1_idx` (`assentos_id_assento`);

--
-- Índices de tabela `portoes`
--
ALTER TABLE `portoes`
  ADD PRIMARY KEY (`id_portao`),
  ADD KEY `id_terminal` (`id_terminal`);

--
-- Índices de tabela `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `id_passageiro` (`id_passageiro`),
  ADD KEY `id_voo` (`id_voo`),
  ADD KEY `fk_reservas_passagens1_idx` (`passagens_id_passagem`);

--
-- Índices de tabela `segmentovoo`
--
ALTER TABLE `segmentovoo`
  ADD PRIMARY KEY (`id_segmento`),
  ADD KEY `id_voo` (`id_voo`),
  ADD KEY `destino` (`destino`);

--
-- Índices de tabela `terminais`
--
ALTER TABLE `terminais`
  ADD PRIMARY KEY (`id_terminal`),
  ADD KEY `id_aeroporto` (`id_aeroporto`);

--
-- Índices de tabela `voos`
--
ALTER TABLE `voos`
  ADD PRIMARY KEY (`id_voo`),
  ADD KEY `id_aeronave` (`id_aeronave`),
  ADD KEY `id_portao` (`id_portao`),
  ADD KEY `voos_ibfk_3` (`origem_voo`),
  ADD KEY `voos_ibfk_4` (`destino_voo`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `aeronaves`
--
ALTER TABLE `aeronaves`
  MODIFY `id_aeronave` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `aeroportos`
--
ALTER TABLE `aeroportos`
  MODIFY `id_aeroporto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `assentos`
--
ALTER TABLE `assentos`
  MODIFY `id_assento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=294;

--
-- AUTO_INCREMENT de tabela `companhias`
--
ALTER TABLE `companhias`
  MODIFY `id_companhia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `passageiros`
--
ALTER TABLE `passageiros`
  MODIFY `id_passageiros` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT de tabela `passagens`
--
ALTER TABLE `passagens`
  MODIFY `id_passagem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `portoes`
--
ALTER TABLE `portoes`
  MODIFY `id_portao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de tabela `segmentovoo`
--
ALTER TABLE `segmentovoo`
  MODIFY `id_segmento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `terminais`
--
ALTER TABLE `terminais`
  MODIFY `id_terminal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `voos`
--
ALTER TABLE `voos`
  MODIFY `id_voo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `aeronaves`
--
ALTER TABLE `aeronaves`
  ADD CONSTRAINT `aeronaves_ibfk_1` FOREIGN KEY (`id_companhia`) REFERENCES `companhias` (`id_companhia`);

--
-- Restrições para tabelas `assentos`
--
ALTER TABLE `assentos`
  ADD CONSTRAINT `assentos_ibfk_1` FOREIGN KEY (`id_voo`) REFERENCES `voos` (`id_voo`);

--

--
-- Restrições para tabelas `passagens`
--
ALTER TABLE `passagens`
  ADD CONSTRAINT `fk_passagens_assentos1` FOREIGN KEY (`assentos_id_assento`) REFERENCES `assentos` (`id_assento`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `portoes`
--
ALTER TABLE `portoes`
  ADD CONSTRAINT `portoes_ibfk_1` FOREIGN KEY (`id_terminal`) REFERENCES `terminais` (`id_terminal`);

--
-- Restrições para tabelas `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `fk_reservas_passagens1` FOREIGN KEY (`passagens_id_passagem`) REFERENCES `passagens` (`id_passagem`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`id_passageiro`) REFERENCES `passageiros` (`id_passageiros`),
  ADD CONSTRAINT `reservas_ibfk_4` FOREIGN KEY (`id_voo`) REFERENCES `voos` (`id_voo`);

--
-- Restrições para tabelas `segmentovoo`
--
ALTER TABLE `segmentovoo`
  ADD CONSTRAINT `segmentovoo_ibfk_1` FOREIGN KEY (`id_voo`) REFERENCES `voos` (`id_voo`),
  ADD CONSTRAINT `segmentovoo_ibfk_3` FOREIGN KEY (`destino`) REFERENCES `aeroportos` (`id_aeroporto`);

--
-- Restrições para tabelas `terminais`
--
ALTER TABLE `terminais`
  ADD CONSTRAINT `terminais_ibfk_1` FOREIGN KEY (`id_aeroporto`) REFERENCES `aeroportos` (`id_aeroporto`) ON DELETE CASCADE;

--
-- Restrições para tabelas `voos`
--
ALTER TABLE `voos`
  ADD CONSTRAINT `voos_ibfk_1` FOREIGN KEY (`id_aeronave`) REFERENCES `aeronaves` (`id_aeronave`),
  ADD CONSTRAINT `voos_ibfk_2` FOREIGN KEY (`id_portao`) REFERENCES `portoes` (`id_portao`),
  ADD CONSTRAINT `voos_ibfk_3` FOREIGN KEY (`origem_voo`) REFERENCES `aeroportos` (`id_aeroporto`) ON DELETE CASCADE,
  ADD CONSTRAINT `voos_ibfk_4` FOREIGN KEY (`destino_voo`) REFERENCES `aeroportos` (`id_aeroporto`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
