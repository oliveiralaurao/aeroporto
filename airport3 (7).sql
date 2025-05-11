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
(2, 'Airbus A320', 180, 30, 6, 1),
(3, 'Boeing 737-800', 160, 27, 6, 1),
(4, 'Embraer E190', 110, 22, 5, 4),
(5, 'Boeing 777-300ER', 396, 33, 12, 7),
(6, 'Airbus A350', 300, 50, 6, 9),
(7, 'Boeing 787-9', 296, 37, 8, 2),
(8, 'Airbus A330', 277, 34, 8, 1),
(9, 'Bombardier CRJ-900', 90, 18, 5, 6),
(10, 'ATR 72-600', 70, 14, 5, 1),
(11, 'Cessna Citation X', 12, 4, 3, 5),
(13, 'Boeing 737', 6, 2, 3, 4),
(14, '221', 45, 9, 5, 7);

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
(2, 'Aeroporto de São Paulo/Congonhas–Deputado Freitas Nobre', 'CGH, SBSP', 'São Paulo, SP, Brasil'),
(3, 'Aeroporto Internacional Tom Jobim', 'GIG', 'Rio de Janeiro, RJ'),
(4, 'Aeroporto Internacional de Brasília', 'BSB', 'Brasília, DF'),
(5, 'Aeroporto Internacional de Confins', 'CNF', 'Belo Horizonte, MG'),
(6, 'Aeroporto Internacional de Salvador', 'SSA', 'Salvador, BA'),
(7, 'Aeroporto Internacional de Porto Alegre', 'POA', 'Porto Alegre, RS'),
(8, 'Aeroporto Internacional de Recife', 'REC', 'Recife, PE'),
(9, 'Aeroporto Internacional de Fortaleza', 'FOR', 'Fortaleza, CE'),
(10, 'Aeroporto Internacional de Manaus', 'MAO', 'Manaus, AM'),
(11, 'Aeroporto Internacional Tom Jobim', 'GIG', 'Rio de Janeiro, Brasil'),
(12, 'Aeroporto Internacional de Brasília', 'BSB', 'Brasília, Brasil'),
(13, 'Aeroporto Internacional de Los Angeles', 'LAX', 'Los Angeles, EUA'),
(14, 'Aeroporto Internacional de Londres Heathrow', 'LHR', 'Londres, Reino Unido'),
(15, 'Aeroporto Internacional de Tóquio', 'HND', 'Tóquio, Japão'),
(16, 'Aeroporto Internacional de Frankfurt', 'FRA', 'Frankfurt, Alemanha'),
(17, 'Aeroporto Internacional de Paris-Charles de Gaulle', 'CDG', 'Paris, França'),
(18, 'Aeroporto Internacional de Dubai', 'DXB', 'Dubai, Emirados Árabes'),
(19, 'Aeroporto Internacional de Sydney', 'SYD', 'Sydney, Austrália');

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
(1, 'A1', 'Disponível', 5),
(2, 'B1', 'Disponível', 5),
(3, 'C1', 'Corredor', 5),
(4, 'D1', 'Disponível', 5),
(5, 'F1', 'Ocupado', 5),
(6, 'H1', 'Corredor', 5),
(7, 'J1', 'Disponível', 5),
(8, 'K1', 'Disponível', 5),
(9, 'A2', 'Disponível', 5),
(10, 'B2', 'Disponível', 5),
(11, 'C2', 'Corredor', 5),
(12, 'D2', 'Disponível', 5),
(13, 'F2', 'Disponível', 5),
(14, 'H2', 'Corredor', 5),
(15, 'J2', 'Disponível', 5),
(16, 'K2', 'Disponível', 5),
(17, 'A3', 'Disponível', 5),
(18, 'B3', 'Disponível', 5),
(19, 'C3', 'Corredor', 5),
(20, 'D3', 'Disponível', 5),
(21, 'F3', 'Disponível', 5),
(22, 'H3', 'Corredor', 5),
(23, 'J3', 'Disponível', 5),
(24, 'K3', 'Disponível', 5),
(25, 'A4', 'Disponível', 5),
(26, 'B4', 'Disponível', 5),
(27, 'C4', 'Corredor', 5),
(28, 'D4', 'Disponível', 5),
(29, 'F4', 'Disponível', 5),
(30, 'H4', 'Corredor', 5),
(31, 'J4', 'Disponível', 5),
(32, 'K4', 'Disponível', 5),
(33, 'A5', 'Disponível', 5),
(34, 'B5', 'Disponível', 5),
(35, 'C5', 'Corredor', 5),
(36, 'D5', 'Disponível', 5),
(37, 'F5', 'Disponível', 5),
(38, 'H5', 'Corredor', 5),
(39, 'J5', 'Disponível', 5),
(40, 'K5', 'Disponível', 5),
(41, 'A6', 'Disponível', 5),
(42, 'B6', 'Disponível', 5),
(43, 'C6', 'Corredor', 5),
(44, 'D6', 'Disponível', 5),
(45, 'F6', 'Disponível', 5),
(46, 'H6', 'Corredor', 5),
(47, 'J6', 'Disponível', 5),
(48, 'K6', 'Disponível', 5),
(49, 'A7', 'Disponível', 5),
(50, 'B7', 'Disponível', 5),
(51, 'C7', 'Corredor', 5),
(52, 'D7', 'Disponível', 5),
(53, 'F7', 'Disponível', 5),
(54, 'H7', 'Corredor', 5),
(55, 'J7', 'Disponível', 5),
(56, 'K7', 'Disponível', 5),
(57, 'A8', 'Disponível', 5),
(58, 'B8', 'Disponível', 5),
(59, 'C8', 'Corredor', 5),
(60, 'D8', 'Disponível', 5),
(61, 'F8', 'Disponível', 5),
(62, 'H8', 'Corredor', 5),
(63, 'J8', 'Disponível', 5),
(64, 'K8', 'Disponível', 5),
(65, 'A9', 'Disponível', 5),
(66, 'B9', 'Disponível', 5),
(67, 'C9', 'Corredor', 5),
(68, 'D9', 'Disponível', 5),
(69, 'F9', 'Disponível', 5),
(70, 'H9', 'Corredor', 5),
(71, 'J9', 'Disponível', 5),
(72, 'K9', 'Disponível', 5),
(73, 'A10', 'Disponível', 5),
(74, 'B10', 'Disponível', 5),
(75, 'C10', 'Corredor', 5),
(76, 'D10', 'Disponível', 5),
(77, 'F10', 'Disponível', 5),
(78, 'H10', 'Corredor', 5),
(79, 'J10', 'Disponível', 5),
(80, 'K10', 'Disponível', 5),
(81, 'A11', 'Disponível', 5),
(82, 'B11', 'Disponível', 5),
(83, 'C11', 'Corredor', 5),
(84, 'D11', 'Disponível', 5),
(85, 'F11', 'Disponível', 5),
(86, 'H11', 'Corredor', 5),
(87, 'J11', 'Disponível', 5),
(88, 'K11', 'Disponível', 5),
(89, 'A12', 'Disponível', 5),
(90, 'B12', 'Disponível', 5),
(91, 'C12', 'Corredor', 5),
(92, 'D12', 'Disponível', 5),
(93, 'F12', 'Disponível', 5),
(94, 'H12', 'Corredor', 5),
(95, 'J12', 'Disponível', 5),
(96, 'K12', 'Disponível', 5),
(97, 'A13', 'Disponível', 5),
(98, 'B13', 'Disponível', 5),
(99, 'C13', 'Corredor', 5),
(100, 'D13', 'Disponível', 5),
(101, 'F13', 'Disponível', 5),
(102, 'H13', 'Corredor', 5),
(103, 'J13', 'Disponível', 5),
(104, 'K13', 'Disponível', 5),
(105, 'A14', 'Disponível', 5),
(106, 'B14', 'Disponível', 5),
(107, 'C14', 'Corredor', 5),
(108, 'D14', 'Disponível', 5),
(109, 'F14', 'Disponível', 5),
(110, 'H14', 'Corredor', 5),
(111, 'J14', 'Disponível', 5),
(112, 'K14', 'Disponível', 5),
(113, 'A15', 'Disponível', 5),
(114, 'B15', 'Disponível', 5),
(115, 'C15', 'Corredor', 5),
(116, 'D15', 'Disponível', 5),
(117, 'F15', 'Disponível', 5),
(118, 'H15', 'Corredor', 5),
(119, 'J15', 'Disponível', 5),
(120, 'K15', 'Disponível', 5),
(121, 'A16', 'Disponível', 5),
(122, 'B16', 'Disponível', 5),
(123, 'C16', 'Corredor', 5),
(124, 'D16', 'Disponível', 5),
(125, 'F16', 'Disponível', 5),
(126, 'H16', 'Corredor', 5),
(127, 'J16', 'Disponível', 5),
(128, 'K16', 'Disponível', 5),
(129, 'A17', 'Disponível', 5),
(130, 'B17', 'Disponível', 5),
(131, 'C17', 'Corredor', 5),
(132, 'D17', 'Disponível', 5),
(133, 'F17', 'Disponível', 5),
(134, 'H17', 'Corredor', 5),
(135, 'J17', 'Disponível', 5),
(136, 'K17', 'Disponível', 5),
(137, 'A18', 'Disponível', 5),
(138, 'B18', 'Disponível', 5),
(139, 'C18', 'Corredor', 5),
(140, 'D18', 'Disponível', 5),
(141, 'F18', 'Disponível', 5),
(142, 'H18', 'Corredor', 5),
(143, 'J18', 'Disponível', 5),
(144, 'K18', 'Disponível', 5),
(145, 'A19', 'Disponível', 5),
(146, 'B19', 'Disponível', 5),
(147, 'C19', 'Corredor', 5),
(148, 'D19', 'Disponível', 5),
(149, 'F19', 'Disponível', 5),
(150, 'H19', 'Corredor', 5),
(151, 'J19', 'Disponível', 5),
(152, 'K19', 'Disponível', 5),
(153, 'A20', 'Disponível', 5),
(154, 'B20', 'Disponível', 5),
(155, 'C20', 'Corredor', 5),
(156, 'D20', 'Disponível', 5),
(157, 'F20', 'Disponível', 5),
(158, 'H20', 'Corredor', 5),
(159, 'J20', 'Disponível', 5),
(160, 'K20', 'Disponível', 5),
(161, 'A21', 'Disponível', 5),
(162, 'B21', 'Disponível', 5),
(163, 'C21', 'Corredor', 5),
(164, 'D21', 'Disponível', 5),
(165, 'F21', 'Disponível', 5),
(166, 'H21', 'Corredor', 5),
(167, 'J21', 'Disponível', 5),
(168, 'K21', 'Disponível', 5),
(169, 'A22', 'Disponível', 5),
(170, 'B22', 'Disponível', 5),
(171, 'C22', 'Corredor', 5),
(172, 'D22', 'Disponível', 5),
(173, 'F22', 'Disponível', 5),
(174, 'H22', 'Corredor', 5),
(175, 'J22', 'Disponível', 5),
(176, 'K22', 'Disponível', 5),
(177, 'A23', 'Disponível', 5),
(178, 'B23', 'Disponível', 5),
(179, 'C23', 'Corredor', 5),
(180, 'D23', 'Disponível', 5),
(181, 'F23', 'Disponível', 5),
(182, 'H23', 'Corredor', 5),
(183, 'J23', 'Disponível', 5),
(184, 'K23', 'Disponível', 5),
(185, 'A24', 'Disponível', 5),
(186, 'B24', 'Disponível', 5),
(187, 'C24', 'Corredor', 5),
(188, 'D24', 'Disponível', 5),
(189, 'F24', 'Disponível', 5),
(190, 'H24', 'Corredor', 5),
(191, 'J24', 'Disponível', 5),
(192, 'K24', 'Disponível', 5),
(193, 'A25', 'Disponível', 5),
(194, 'B25', 'Disponível', 5),
(195, 'C25', 'Corredor', 5),
(196, 'D25', 'Disponível', 5),
(197, 'F25', 'Disponível', 5),
(198, 'H25', 'Corredor', 5),
(199, 'J25', 'Disponível', 5),
(200, 'K25', 'Disponível', 5),
(278, 'A1', 'Disponível', 2),
(279, 'B1', 'Disponível', 2),
(280, 'C1', 'Corredor', 2),
(281, 'A2', 'Disponível', 2),
(282, 'B2', 'Disponível', 2),
(283, 'C2', 'Corredor', 2),
(284, 'A3', 'Disponível', 2),
(285, 'B3', 'Disponível', 2),
(286, 'C3', 'Corredor', 2),
(287, 'A4', 'Disponível', 2),
(288, 'B4', 'Disponível', 2),
(289, 'C4', 'Corredor', 2),
(293, 'B12', 'Disponível', 1);

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
(2, 'Latam Airlines', 'LA'),
(3, 'Azul Linhas Aéreas', 'AD'),
(4, 'American Airlines', 'AA'),
(5, 'Delta Airlines', 'DL'),
(6, 'United Airlines', 'UA'),
(7, 'Air France', 'AF'),
(8, 'Lufthansa', 'LH'),
(9, 'Qatar Airways', 'QR'),
(10, 'Emirates', 'EK'),
(11, 'British Airways', 'BA');

-- --------------------------------------------------------

--
-- Estrutura para tabela `mensagem_contato`
--

DROP TABLE IF EXISTS `mensagem_contato`;
CREATE TABLE `mensagem_contato` (
  `id_mensagem` int(11) NOT NULL,
  `conteudo_mensagem` text NOT NULL,
  `email_mensagem` varchar(255) NOT NULL,
  `data_envio` datetime NOT NULL,
  `status_mensagem` enum('Lida','Não lida','Respondida') NOT NULL,
  `passageiros_id_passageiros` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(71, 'Laura Pimenta de Oliveira', 'laura.p@hotmail.com', '$2y$10$7sVF5QNWVewdKbWEjrjh..0dzDsrFcUjpwTnHBB4Xj4O41vmNLn5K', '(18) 99777-8384', 'Brasil', '463.100.198-48', '2005-10-21', '1');

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
(2, 400, 5),
(3, 300, 1),
(4, 15, 282),
(5, 15, 283),
(6, 15, 284),
(7, 15, 285),
(8, 5, 281),
(9, 5, 282),
(10, 2147483647, 279),
(11, 12, 142),
(14, 499, 278),
(15, 48, 293),
(16, 87998, 280),
(17, 87998, 286);

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
(1, '2', 1),
(3, 'C3', 2),
(4, 'D4', 2),
(5, 'E5', 3),
(6, 'F6', 3),
(7, 'G7', 4),
(8, 'H8', 4),
(9, 'I9', 5),
(10, 'J10', 5),
(11, 'A1', 1);

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
(46, 'Cancelada', 71, 5, 3),
(47, 'Confirmada', 71, 5, 2);

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
(4, 54, 10, '2004-01-26 14:50:00', '2222-01-26 14:51:00'),
(5, 7, 18, '2025-04-14 14:37:00', '2025-04-14 14:38:00');

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
(1, 2, '14'),
(2, 1, 'Terminal 2 - Aeroporto Internacional São Paulo'),
(3, 2, 'Terminal 1 - Aeroporto Internacional Rio de Janeiro'),
(4, 2, 'Terminal 2 - Aeroporto Internacional Rio de Janeiro'),
(5, 3, 'Terminal 1 - Aeroporto Internacional Brasília'),
(6, 4, 'Terminal 3'),
(7, 4, 'Terminal 1 - Aeroporto Internacional Salvador'),
(8, 4, 'Terminal 2 - Aeroporto Internacional Salvador'),
(9, 5, 'Terminal 1 - Aeroporto Internacional Recife'),
(10, 5, 'Terminal 2 - Aeroporto Internacional Recife'),
(11, 1, 'Terminal 1 - Aeroporto Internacional São Paulo'),
(13, 1, 'bgvfcd'),
(20, 19, 'eu consigoo voarrr\r\n');

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
(1, 'AA1234', 1, 1, '2024-12-30 14:30:00', '2024-12-30 16:45:00', 1, 14, 'Escala', 'Reprogramado', 'Internacional'),
(2, '744', 11, 1, '2024-12-12 04:15:00', '2024-12-17 05:15:00', 1, 19, 'Direto', 'Finalizado', 'Internacional'),
(3, 'AA9012', 3, 3, '2024-12-24 10:00:00', '2024-12-24 07:00:00', 3, 4, 'Direto', 'Decolando', 'Nacional'),
(4, 'DL3456', 4, 4, '2024-12-25 17:00:00', '2024-12-25 14:00:00', 4, 5, 'Escala', 'Cancelado', 'Nacional'),
(5, '7445', 1, 1, '2024-12-27 18:40:00', '2024-12-12 19:40:00', 2, 8, 'Direto', 'Em Rota', 'Nacional'),
(6, 'AF1234', 6, 6, '2024-12-27 14:00:00', '2024-12-27 11:00:00', 6, 7, 'Escala', 'Pousando', 'Nacional'),
(7, 'LH5678', 7, 7, '2024-12-28 15:45:00', '2024-12-28 12:45:00', 7, 8, 'Direto', 'Atrasado', 'Nacional'),
(8, 'QR9012', 8, 8, '2024-12-29 16:00:00', '2024-12-29 13:00:00', 8, 9, 'Escala', 'Reprogramado', 'Nacional'),
(9, 'EK3456', 9, 9, '2024-12-30 13:30:00', '2024-12-30 10:30:00', 9, 10, 'Direto', 'Finalizado', 'Nacional'),
(10, 'BA7890', 10, 10, '2024-12-31 12:00:00', '2024-12-31 09:00:00', 10, 11, 'Escala', 'Suspenso', 'Nacional'),
(11, 'LA1234', 1, 1, '2024-12-22 11:00:00', '2024-12-22 08:00:00', 5, 2, 'Direto', 'No horário', 'Nacional'),
(51, 'UA7890', 5, 5, '2024-12-26 19:30:00', '2024-12-26 16:30:00', 5, 6, 'Direto', 'Taxiando', 'Nacional'),
(52, '744', 8, 9, '2000-04-17 11:07:00', '2025-04-17 11:56:00', 17, 18, 'Direto', 'Suspenso', 'Nacional'),
(54, 'lalalalalalal', 13, 9, '1998-04-17 16:07:00', '2025-04-17 14:07:00', 14, 6, 'Direto', 'Desviado', 'Nacional'),
(57, '48', 10, 7, '2025-04-21 19:42:00', '2025-04-21 20:42:00', 17, 14, 'Direto', 'Desviado', 'Nacional'),
(59, 'gg', 14, 3, '2025-05-12 00:07:52', '2025-05-12 00:07:52', 15, 15, 'Direto', 'Em Rota', 'Nacional');

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
-- Índices de tabela `mensagem_contato`
--
ALTER TABLE `mensagem_contato`
  ADD PRIMARY KEY (`id_mensagem`),
  ADD KEY `fk_mensagem_contato_passageiros1_idx` (`passageiros_id_passageiros`);

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
-- AUTO_INCREMENT de tabela `mensagem_contato`
--
ALTER TABLE `mensagem_contato`
  MODIFY `id_mensagem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
-- Restrições para tabelas `mensagem_contato`
--
ALTER TABLE `mensagem_contato`
  ADD CONSTRAINT `fk_mensagem_contato_passageiros1` FOREIGN KEY (`passageiros_id_passageiros`) REFERENCES `passageiros` (`id_passageiros`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
