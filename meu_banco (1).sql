-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 15/10/2024 às 17:09
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `meu_banco`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `texto` text DEFAULT NULL,
  `foto` varchar(255) NOT NULL,
  `video` varchar(255) DEFAULT NULL,
  `data_postagem` timestamp NULL DEFAULT NULL,
  `usuario_id` int(11) NOT NULL,
  `nomes_usuario` varchar(100) DEFAULT NULL,
  `fotos_perfil` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `posts`
--

INSERT INTO `posts` (`id`, `texto`, `foto`, `video`, `data_postagem`, `usuario_id`, `nomes_usuario`, `fotos_perfil`) VALUES
(1, 'fsafasfsa', 'wu.jpg', '', NULL, 0, '', ''),
(2, 'meu deus, eu amo isso', 'chrome.jpg', '', NULL, 0, '', ''),
(3, 'dasdsa', 'chrome.jpg', '', NULL, 0, '', ''),
(4, 'meu deus', 'red.jpg', '', NULL, 0, '', ''),
(5, 'oi', '', '', NULL, 0, '', ''),
(6, 'ACABA LOGO', '', '', NULL, 0, '', ''),
(7, 'TCC ACABA LOGO', '', '', NULL, 0, '', ''),
(8, 'JESUS', '', '', NULL, 4, '0', 'default_profile_picture.png'),
(9, 'eu cansei', 'Infográfico minimalista produtividade neutro bege e preto.png', '', NULL, 4, '0', 'Brasão_de_Franco_da_Rocha (1).png'),
(10, 'aaaaaaaaaaaa', 'game day (5).png', '', NULL, 4, '0', 'Brasão_de_Franco_da_Rocha (1).png'),
(11, 'BBBBBBBBBBB', 'game day (5).png', '', NULL, 4, '0', 'Brasão_de_Franco_da_Rocha (1).png'),
(12, 'CCCCCCCCCCCCCCC', 'game day (4).png', '', NULL, 4, '0', 'Brasão_de_Franco_da_Rocha (1).png'),
(13, 'DDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDD', 'Brasão_de_Franco_da_Rocha.png', '', NULL, 4, '0', 'Brasão_de_Franco_da_Rocha (1).png'),
(14, 'teste imagem2', 'game day (4).png', '', NULL, 4, '0', 'default_profile_picture.png'),
(15, 'teste imagem 6', 'pack.png', '', NULL, 4, '0', 'default_profile_picture.png'),
(16, 'TESTE IMAGEM AAAAAAAAAAAA', '1.png', '', NULL, 4, '0', 'default_profile_picture.png'),
(17, 'teste rolim', '', '', NULL, 5, '0', '7887dd44367b53ac.png'),
(18, 'teste imagem', 'Conceitual_1.png', '', NULL, 5, '0', '7887dd44367b53ac.png'),
(19, 'bbbbb', '7887dd44367b53ac.png', NULL, NULL, 5, NULL, NULL),
(20, 'CCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCC', 'etec.jpg', NULL, NULL, 5, NULL, NULL),
(21, 'DDDDDDDDDDDDDDDDDDDDDDDDDDD', '8a5073745f1afa84.png', NULL, NULL, 5, NULL, NULL),
(22, 'ffffffffffffffffffffffffffff', '7887dd44367b53ac.png', NULL, NULL, 5, NULL, NULL),
(23, 'GGGGGGGGGGGGGGGGGGGGGGGGGGG', 'Brasão_de_Franco_da_Rocha.png', NULL, NULL, 5, '0', '7887dd44367b53ac.png'),
(24, 'GGGGGGGGGGGGGGGGGGGGGGGGGGG', 'Brasão_de_Franco_da_Rocha.png', NULL, NULL, 5, '0', '7887dd44367b53ac.png'),
(25, 'GGGGGGGGGGGGGGGGGGGGGGGGGGG', 'Brasão_de_Franco_da_Rocha.png', NULL, NULL, 5, '0', '7887dd44367b53ac.png'),
(26, 'GGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGG', 'Brasão_de_Franco_da_Rocha.png', NULL, NULL, 5, '0', '7887dd44367b53ac.png'),
(27, 'SACSACASCSACA', '7887dd44367b53ac.png', NULL, NULL, 5, '0', '7887dd44367b53ac.png'),
(28, 'EU USO RICK OWENSSSSSSSSSSSSSSSS', 'Mr_T.png', NULL, NULL, 5, '0', 'default_profile_picture.png'),
(29, 'JJJJJJJJJJJJJJJJJ', 'b72effd9b6b6993aee8559131cd6835d.jpg', NULL, NULL, 5, NULL, NULL),
(30, 'dsadadada', 'b5179db3e6c0ddf33434f2938e8c24c3.jpg', NULL, NULL, 5, 'rolim', NULL),
(31, 'dsadsadasdagvcbxbxbxbxbx', 'int.jpeg', NULL, NULL, 5, 'rolim', NULL),
(32, 'cansei', 'game day (5).png', NULL, NULL, 5, 'rolim', NULL),
(33, 'dsadsadas', 'aeshyma.png', NULL, NULL, 5, 'rolim', NULL),
(34, 'sadsada', '7887dd44367b53ac.png', NULL, NULL, 5, 'rolim', NULL),
(35, 'dasasdsad', 'game day (5).png', NULL, NULL, 5, 'rolim', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` text NOT NULL,
  `img` varchar(255) NOT NULL,
  `preco` decimal(6,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `img`, `preco`) VALUES
(1, 'Hormonio do AMOR', 'https://encrypted-tbn3.gstatic.com/shopping?q=tbn:ANd9GcSiyDA1DRXsPpARGz0AYACQ0cXxRN3UlOmYjM9xwQ5U588K9DOt29izugcraiDYXttqOAI-LWaesC03yAq0EF1Q4nVDCkF8vxM4CCYjaeBrC1HfFS0kMY1n&usqp=CAE', 200),
(2, 'lean', 'https://d22e6amj3mws2b.cloudfront.net/158912/c21a71de91ad24e8edda421264037109.jpg', 16);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `sit` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `email`, `senha`, `sit`) VALUES
(1, 'rolim', 'rolim@rolim', '123', 0),
(2, 'gio', 'gio@gio', '$2y$10$9uG5Fj5cSvZKwsOtsiEiD.6.hkANJk347tVpH96vTO5MTvWUuBVDq', 0),
(3, 'roberto', 'robertinho@fino', '12345fino', 0),
(4, 'maria', 'maria@maria.com', '$2y$10$W4g4ECCsnHOUyTLalBz.lO7PzNEmXZVAvowxZxd5QLtA24cWIxapm', 0),
(5, 'rolim', 'rolim@amandinhatorres.com', '$2y$10$GghevPceN5h67x7WpTKjMuvIFJLINoUdjxRa/538eOnVeAoU6ol8y', 0),
(6, 'rolim', 'rolim@amandinhatorres.com', '$2y$10$wkQPAqtSrCGbmKAbbQ/iou9xNg3mbIkgbpKTged9iXCopr2TUE.s6', 0),
(7, 'breno', 'breno@catia.com', '$2y$10$KdIbRA71pH7gDpvO1BO9SuadoQlgeSK7Lq2Pxii3D88z2dtme.EHy', 0),
(8, 'pri', 'prigigabi@gmail.com', '$2y$10$CK/XsUwZXwTOjjrN7OIQDeM11NkvJOCQwpZkN9CaXuvvNDqvin0Ei', 0),
(9, 'gi', 'gi@gi.com', '$2y$10$Uln0/cm2aiwBY8Jj/YAHueetOrPhyKgq51BbW1l8rqCmWT9BNhZBS', 0),
(10, 'gio', 'giovanni.grego@etec.sp.gov.br', '$2y$10$hYkVCZ2ZuSlZeQ2UryqSCeXnW89Y.hV0psvimU7XJBfRsOH0ZRLKe', 0),
(11, 'gi', 'gio@gio.com', '$2y$10$45JsUs8lWzequ/wns484B.eKPLvLk4MVhkjMzfruv7txwKtaJfN42', 0),
(12, 'gi', 'gio@gio.com', '$2y$10$.p5e5oq3whHMhrYSBVDhAuqdX9r1iQkvtBVeSihIbqmscsr4iR0b6', 0),
(13, 'pri', 'pri@pri.com', '$2y$10$WSbn5SjMYCn8OHxA.T1lMePPm1XFQV3zuQVBFfaGz/qixstVgFdtS', 0),
(14, 'marcos', 'marcos@gmail.com', '$2y$10$eaEGPW30R1P1oVlSWkND4uiM/MnfM5n5ikHtfxIGQFfQ2W8bpo4Xm', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `pic_perfil` varchar(255) DEFAULT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `pic_perfil`, `data_cadastro`) VALUES
(1, 'Giovanni Caramello Grego', 'giocaramello@gmail.com', '$2y$10$MTTXLf.u3t1jGlsEjcKdSeFJVmQa7WKcp35Ybp0bKAvebAtQqiWCm', 'aeshyma.png', '2024-10-12 12:33:55'),
(2, 'marcos', 'marcos@gmail.com', '$2y$10$kBo7fNNdb1/u.n2BsvNb5OU/FiHdOIz1fU.HFabGUOtfSK8bPhnca', NULL, '2024-10-12 12:36:45'),
(3, 'sdadas', 'dsada@gmai.com', '$2y$10$mXDpJZYCXUPHkjtrexL5Neq1YnaYgn77NMfl4kmJEpuf4mk8/MUdi', NULL, '2024-10-12 12:38:40'),
(4, 'pri', 'prigigabi@gmail.com', '$2y$10$Pb5RDEZlwmJtvV7BH41nFu9QmqjheJsFap5GFbSXQGKgHKXPBiqvi', 'Brasão_de_Franco_da_Rocha (1).png', '2024-10-12 12:40:34'),
(5, 'rolim', 'rolim@gmail.com', '$2y$10$joEm2rvyvv2TnKnpIcX.j.KlOFnTW9TVxfgy1BswioxKpmsMo2iXm', 'pack.png', '2024-10-15 14:08:56');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
