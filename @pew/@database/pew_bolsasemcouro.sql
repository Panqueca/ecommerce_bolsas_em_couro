-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 12-Abr-2018 às 20:53
-- Versão do servidor: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pew_bolsasemcouro`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `pew_banners`
--

CREATE TABLE `pew_banners` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `posicao` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pew_banners`
--

INSERT INTO `pew_banners` (`id`, `titulo`, `descricao`, `imagem`, `link`, `posicao`, `status`) VALUES
(27, 'Bolsas em couro', 'Bolsas em couro', 'adesivos-mdf-banner-home-df97c.png', 'http://www.google.com', 4, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pew_carrinhos`
--

CREATE TABLE `pew_carrinhos` (
  `id` int(11) NOT NULL,
  `token_carrinho` varchar(255) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `nome_produto` varchar(255) NOT NULL,
  `quantidade_produto` int(11) NOT NULL,
  `preco_produto` varchar(255) NOT NULL,
  `data_controle` datetime NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pew_categorias`
--

CREATE TABLE `pew_categorias` (
  `id` int(11) NOT NULL,
  `categoria` varchar(255) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `ref` varchar(255) NOT NULL,
  `data_controle` datetime NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pew_categorias`
--

INSERT INTO `pew_categorias` (`id`, `categoria`, `descricao`, `ref`, `data_controle`, `status`) VALUES
(12, 'Mochilas masculinas', '', 'mochilas-masculinas', '2018-03-29 04:15:05', 1),
(13, 'Malas para viagem', '', 'malas-para-viagem', '2018-03-29 04:15:19', 1),
(14, 'AcessÃ³rios femininos', '', 'acessorios-femininos', '2018-03-29 04:15:32', 1),
(15, 'Linha exclusiva', '', 'linha-exclusiva', '2018-03-29 04:15:45', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pew_categorias_produtos`
--

CREATE TABLE `pew_categorias_produtos` (
  `id` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `titulo_categoria` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pew_categorias_produtos`
--

INSERT INTO `pew_categorias_produtos` (`id`, `id_produto`, `id_categoria`, `titulo_categoria`) VALUES
(14, 7, 13, 'Malas para viagem'),
(32, 18, 15, 'Linha exclusiva'),
(33, 19, 15, 'Linha exclusiva'),
(34, 20, 15, 'Linha exclusiva'),
(35, 21, 15, 'Linha exclusiva'),
(36, 22, 15, 'Linha exclusiva'),
(37, 23, 15, 'Linha exclusiva');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pew_categorias_vitrine`
--

CREATE TABLE `pew_categorias_vitrine` (
  `id` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `ref` varchar(255) NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `data_controle` datetime NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pew_categoria_destaque`
--

CREATE TABLE `pew_categoria_destaque` (
  `id` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `ref` varchar(255) NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `data_controle` datetime NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pew_categoria_destaque`
--

INSERT INTO `pew_categoria_destaque` (`id`, `id_categoria`, `titulo`, `ref`, `imagem`, `data_controle`, `status`) VALUES
(4, 13, 'Malas para viagem', 'malas-para-viagem', 'malas-para-viagem-categoria-destaque-refc2f4.png', '2018-03-29 06:01:38', 1),
(5, 12, 'Mochilas masculinas', 'mochilas-masculinas', 'mochilas-masculinas-categoria-destaque-ref05e5.png', '2018-03-29 05:56:30', 1),
(6, 15, 'Linha exclusiva', 'acessorios-femininos', 'linha-exclusiva-categoria-destaque-reffa24.png', '2018-03-29 04:38:12', 1),
(7, 14, 'AcessÃ³rios femininos', 'acessorios-femininos', 'acessorios-femininos-categoria-destaque-ref5c9d.png', '2018-03-29 04:38:23', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pew_config_orcamentos`
--

CREATE TABLE `pew_config_orcamentos` (
  `id` int(11) NOT NULL,
  `nome_empresa` varchar(255) NOT NULL,
  `cnpj_empresa` varchar(255) NOT NULL,
  `endereco_empresa` varchar(255) NOT NULL,
  `telefone_empresa` varchar(255) NOT NULL,
  `email_contato` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pew_contatos`
--

CREATE TABLE `pew_contatos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefone` varchar(255) NOT NULL,
  `assunto` varchar(255) NOT NULL,
  `mensagem` longtext NOT NULL,
  `data` datetime NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pew_contatos`
--

INSERT INTO `pew_contatos` (`id`, `nome`, `email`, `telefone`, `assunto`, `mensagem`, `data`, `status`) VALUES
(1, 'Rogerio Mendes', 'reyrogerio@hotmail.com', '30182477', 'Reclamação', 'É um fato conhecido de todos que um leitor se distrairá com o conteúdo de texto legível de uma página quando estiver examinando sua diagramação. ', '2017-11-08 11:12:14', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pew_cores`
--

CREATE TABLE `pew_cores` (
  `id` int(11) NOT NULL,
  `cor` varchar(255) NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `data_controle` datetime NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pew_cores`
--

INSERT INTO `pew_cores` (`id`, `cor`, `imagem`, `data_controle`, `status`) VALUES
(3, 'Preto', 'preto-ref1e30.jpg', '2018-04-12 02:38:47', 1),
(4, 'Vermelho antigo', '5a3d-ref5a3d.jpg', '2018-04-12 02:48:03', 1),
(5, 'Caramelo antigo', 'ef9e-refef9e.jpg', '2018-04-12 02:49:59', 1),
(6, 'Azul antigo', '748c-ref748c.jpg', '2018-04-12 02:50:36', 1),
(7, 'Azul croco', '9aaa-ref9aaa.jpg', '2018-04-12 02:52:17', 1),
(8, 'Azul mesclado', '8cc9-ref8cc9.jpg', '2018-04-12 02:52:31', 1),
(9, 'Marrom', '4a32-ref4a32.jpg', '2018-04-12 02:53:02', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pew_cores_produtos`
--

CREATE TABLE `pew_cores_produtos` (
  `id` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `cor` varchar(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pew_cores_relacionadas`
--

CREATE TABLE `pew_cores_relacionadas` (
  `id` int(11) NOT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `id_relacao` int(11) DEFAULT NULL,
  `data_controle` datetime DEFAULT NULL,
  `status` tinyint(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pew_cores_relacionadas`
--

INSERT INTO `pew_cores_relacionadas` (`id`, `id_produto`, `id_relacao`, `data_controle`, `status`) VALUES
(104, 20, 18, '2018-04-12 03:21:25', 1),
(105, 18, 20, '2018-04-12 03:21:25', 1),
(106, 19, 20, '2018-04-12 03:21:40', 1),
(107, 20, 19, '2018-04-12 03:21:40', 1),
(108, 19, 18, '2018-04-12 03:21:40', 1),
(109, 18, 19, '2018-04-12 03:21:40', 1),
(110, 23, 22, '2018-04-12 03:29:11', 1),
(111, 22, 23, '2018-04-12 03:29:11', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pew_departamentos`
--

CREATE TABLE `pew_departamentos` (
  `id` int(11) NOT NULL,
  `departamento` varchar(255) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `posicao` int(11) NOT NULL,
  `ref` varchar(255) NOT NULL,
  `data_controle` date NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pew_departamentos`
--

INSERT INTO `pew_departamentos` (`id`, `departamento`, `descricao`, `posicao`, `ref`, `data_controle`, `status`) VALUES
(13, 'BAZAR', '', 2, 'bazar', '2018-03-27', 1),
(14, 'FEMININO', '', 0, 'feminino', '2018-04-12', 1),
(15, 'MASCULINO', '', 4, 'masculino', '2018-03-27', 1),
(12, 'ACESSÃ“RIOS', '', 1, 'acessorios', '2018-04-12', 1),
(16, 'MOCHILAS', '', 5, 'mochilas', '2018-03-27', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pew_departamentos_produtos`
--

CREATE TABLE `pew_departamentos_produtos` (
  `id` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `id_departamento` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pew_departamentos_produtos`
--

INSERT INTO `pew_departamentos_produtos` (`id`, `id_produto`, `id_departamento`) VALUES
(99, 12, 13),
(104, 11, 13),
(95, 10, 13),
(94, 9, 13),
(90, 8, 14),
(96, 5, 14),
(100, 13, 13),
(101, 14, 13),
(102, 15, 13),
(103, 16, 13),
(105, 17, 13),
(106, 18, 14),
(115, 19, 14),
(114, 20, 14),
(109, 21, 14),
(113, 22, 14),
(116, 23, 14);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pew_dicas`
--

CREATE TABLE `pew_dicas` (
  `id` int(11) NOT NULL,
  `titulo` varchar(200) DEFAULT NULL,
  `subtitulo` varchar(255) NOT NULL,
  `descricao_curta` varchar(255) DEFAULT NULL,
  `descricao_longa` text NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `data_controle` datetime DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pew_enderecos`
--

CREATE TABLE `pew_enderecos` (
  `id` int(11) NOT NULL,
  `id_relacionado` int(11) NOT NULL,
  `ref_relacionado` int(11) NOT NULL,
  `cep` int(8) NOT NULL,
  `rua` varchar(255) NOT NULL,
  `numero` varchar(255) NOT NULL,
  `complemento` varchar(255) NOT NULL,
  `bairro` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL,
  `cidade` varchar(255) NOT NULL,
  `data_cadastro` datetime NOT NULL,
  `data_controle` datetime NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pew_enderecos`
--

INSERT INTO `pew_enderecos` (`id`, `id_relacionado`, `ref_relacionado`, `cep`, `rua`, `numero`, `complemento`, `bairro`, `estado`, `cidade`, `data_cadastro`, `data_controle`, `status`) VALUES
(13, 19, 1, 80230040, 'Rua Engenheiros RebouÃ§as', '2111', 'Apto 06', 'RebouÃ§as', 'PR', 'Curitiba', '2018-04-12 01:25:06', '2018-04-12 01:25:06', 1),
(14, 20, 1, 80230040, 'Rua Engenheiros RebouÃ§as', '2111', 'Apto 06', 'RebouÃ§as', 'PR', 'Curitiba', '2018-04-12 02:16:11', '2018-04-12 02:16:11', 1),
(15, 21, 1, 81200490, 'Rua Doutor Edemar Ernsen', '245', 'Apto 11', 'Campo Comprido', 'PR', 'Curitiba', '2018-04-12 02:25:36', '2018-04-12 02:25:36', 1),
(16, 22, 1, 80230040, 'Rua Engenheiros RebouÃ§as', '2111', 'Apto 06', 'RebouÃ§as', 'PR', 'Curitiba', '2018-04-12 02:26:53', '2018-04-12 02:26:53', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pew_especificacoes_produtos`
--

CREATE TABLE `pew_especificacoes_produtos` (
  `id` int(11) NOT NULL,
  `id_especificacao` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `descricao` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pew_especificacoes_tecnicas`
--

CREATE TABLE `pew_especificacoes_tecnicas` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `data_controle` datetime NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pew_especificacoes_tecnicas`
--

INSERT INTO `pew_especificacoes_tecnicas` (`id`, `titulo`, `data_controle`, `status`) VALUES
(10, 'Material externo', '2018-03-29 02:32:38', 1),
(11, 'Material interno', '2018-03-29 02:32:55', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pew_imagens_produtos`
--

CREATE TABLE `pew_imagens_produtos` (
  `id` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `posicao` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pew_imagens_produtos`
--

INSERT INTO `pew_imagens_produtos` (`id`, `id_produto`, `imagem`, `posicao`, `status`) VALUES
(2, 3, '97e491dbd424e33e1.jpg', 1, 1),
(3, 4, '97e491dbd424e33e1.jpg', 1, 1),
(7, 7, 'produto-teste-2-4cc1.jpg', 1, 1),
(12, 18, 'bolsa-angelica-preta-83c2.jpg', 1, 1),
(13, 18, 'bolsa-angelica-preta-cd7b.jpg', 2, 1),
(14, 19, 'bolsa-angelica-azul-ef19.jpg', 1, 1),
(15, 19, 'bolsa-angelica-azul-7089.jpg', 2, 1),
(16, 20, 'bolsa-angelica-marrom-591d.jpg', 1, 1),
(17, 20, 'bolsa-angelica-marrom-b81b.jpg', 2, 1),
(18, 21, 'bolsa-alamanda-azul-b928.jpg', 1, 1),
(19, 21, 'bolsa-alamanda-azul-7950.jpg', 2, 1),
(20, 22, 'bolsa-anturio-caramelo-123d.jpg', 1, 1),
(21, 22, 'bolsa-anturio-caramelo-b636.jpg', 2, 1),
(22, 23, 'bolsa-anturio-vermelha-b892.jpg', 1, 1),
(23, 23, 'bolsa-anturio-vermelha-d3a9.jpg', 2, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pew_links_menu`
--

CREATE TABLE `pew_links_menu` (
  `id` int(11) NOT NULL,
  `id_departamento` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pew_links_menu`
--

INSERT INTO `pew_links_menu` (`id`, `id_departamento`, `id_categoria`) VALUES
(25, 10, 5),
(26, 10, 9),
(27, 11, 8),
(28, 6, 8),
(29, 6, 9),
(30, 7, 5),
(31, 7, 6),
(32, 8, 5),
(33, 8, 6),
(36, 13, 8),
(39, 15, 5),
(40, 15, 6),
(43, 16, 5),
(44, 16, 6),
(48, 17, 6),
(49, 17, 8),
(61, 12, 15),
(62, 14, 15);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pew_marcas`
--

CREATE TABLE `pew_marcas` (
  `id` int(11) NOT NULL,
  `marca` varchar(255) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `ref` varchar(255) NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `data_controle` datetime NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pew_marcas`
--

INSERT INTO `pew_marcas` (`id`, `marca`, `descricao`, `ref`, `imagem`, `data_controle`, `status`) VALUES
(1, 'Maidi Grey', '', 'maidi-grey', '', '2018-03-27 04:01:04', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pew_minha_conta`
--

CREATE TABLE `pew_minha_conta` (
  `id` int(11) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `celular` varchar(255) NOT NULL,
  `telefone` varchar(255) NOT NULL,
  `cpf` varchar(255) NOT NULL,
  `data_nascimento` date NOT NULL,
  `sexo` varchar(255) NOT NULL,
  `data_cadastro` datetime NOT NULL,
  `data_controle` datetime NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pew_minha_conta`
--

INSERT INTO `pew_minha_conta` (`id`, `usuario`, `email`, `senha`, `celular`, `telefone`, `cpf`, `data_nascimento`, `sexo`, `data_cadastro`, `data_controle`, `status`) VALUES
(21, 'Juan Rangel', 'juan@efectusweb.com.br', 'dd4badecdaa9d972a8d9d77031bae1c0', '(41) 99753-6262', '', '09163977931', '1998-10-10', 'masculino', '2018-04-12 02:25:36', '2018-04-12 02:25:36', 1),
(22, 'Rogerio Mendes', 'reyrogerio@hotmail.com', '08541bb36f049db6004fd98457138485', '(41) 99753-6262', '', '05453531908', '1998-07-29', 'masculino', '2018-04-12 02:26:53', '2018-04-12 02:26:53', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pew_newsletter`
--

CREATE TABLE `pew_newsletter` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `data` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pew_newsletter`
--

INSERT INTO `pew_newsletter` (`id`, `nome`, `email`, `data`) VALUES
(1, 'Rogerio', 'reyrogerio@hotmail.com', '2018-03-04 03:54:25');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pew_orcamentos`
--

CREATE TABLE `pew_orcamentos` (
  `id` int(11) NOT NULL,
  `ref_orcamento` varchar(255) NOT NULL,
  `nome_cliente` varchar(255) NOT NULL,
  `telefone_cliente` varchar(255) NOT NULL,
  `email_cliente` varchar(255) NOT NULL,
  `rg_cliente` varchar(255) NOT NULL,
  `cpf_cliente` varchar(255) NOT NULL,
  `endereco_envio` varchar(255) NOT NULL,
  `produtos` text NOT NULL,
  `porcentagem_desconto` float NOT NULL,
  `preco_total` varchar(255) NOT NULL,
  `tempo_entrega` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `data_pedido` datetime NOT NULL,
  `data_vencimento` date NOT NULL,
  `data_controle` datetime NOT NULL,
  `modify_controle` varchar(255) NOT NULL,
  `status_orcamento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pew_orcamentos`
--

INSERT INTO `pew_orcamentos` (`id`, `ref_orcamento`, `nome_cliente`, `telefone_cliente`, `email_cliente`, `rg_cliente`, `cpf_cliente`, `endereco_envio`, `produtos`, `porcentagem_desconto`, `preco_total`, `tempo_entrega`, `id_vendedor`, `data_pedido`, `data_vencimento`, `data_controle`, `modify_controle`, `status_orcamento`) VALUES
(6, 'e9cbbc0e5be1f0ab', 'Rogerio', '(41) 3018-2477', 'rogerio@efectusweb.com.br', '121236830', '05453531908', '80230040||2111||Apto 06', '1572||2|#|1509||1', 2, '374.35', 30, 2, '2018-02-22 12:38:28', '2018-03-24', '2018-02-22 12:38:28', '2', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pew_pedidos`
--

CREATE TABLE `pew_pedidos` (
  `id` int(11) NOT NULL,
  `codigo_confirmacao` varchar(255) NOT NULL,
  `codigo_transacao` varchar(255) NOT NULL,
  `codigo_transporte` varchar(255) NOT NULL,
  `codigo_pagamento` tinyint(4) NOT NULL,
  `referencia` varchar(255) NOT NULL,
  `token_carrinho` varchar(255) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `nome_cliente` varchar(255) NOT NULL,
  `cpf_cliente` varchar(14) NOT NULL,
  `email_cliente` varchar(255) NOT NULL,
  `cep` varchar(9) NOT NULL,
  `rua` varchar(255) NOT NULL,
  `numero` varchar(255) NOT NULL,
  `complemento` varchar(255) NOT NULL,
  `bairro` varchar(255) NOT NULL,
  `cidade` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL,
  `data_controle` datetime NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pew_produtos`
--

CREATE TABLE `pew_produtos` (
  `id` int(11) NOT NULL,
  `sku` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `preco` varchar(255) NOT NULL,
  `preco_promocao` varchar(255) NOT NULL,
  `promocao_ativa` int(11) NOT NULL,
  `marca` varchar(255) NOT NULL,
  `id_cor` tinyint(4) NOT NULL,
  `estoque` int(11) NOT NULL,
  `estoque_baixo` int(11) NOT NULL,
  `tempo_fabricacao` int(11) NOT NULL,
  `descricao_curta` varchar(255) NOT NULL,
  `descricao_longa` text NOT NULL,
  `url_video` varchar(255) NOT NULL,
  `peso` varchar(255) NOT NULL,
  `comprimento` varchar(255) NOT NULL,
  `largura` varchar(255) NOT NULL,
  `altura` varchar(255) NOT NULL,
  `data` datetime NOT NULL,
  `visualizacoes` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pew_produtos`
--

INSERT INTO `pew_produtos` (`id`, `sku`, `nome`, `preco`, `preco_promocao`, `promocao_ativa`, `marca`, `id_cor`, `estoque`, `estoque_baixo`, `tempo_fabricacao`, `descricao_curta`, `descricao_longa`, `url_video`, `peso`, `comprimento`, `largura`, `altura`, `data`, `visualizacoes`, `status`) VALUES
(18, 'bo-ange-preta', 'Bolsa angÃ©lica preta', '298.00', '0.00', 0, 'Maidi Grey', 3, 5, 1, 0, 'Uma bolsa prÃ¡tica, charmosa, produzida em couro legÃ­timo, com vÃ¡rias texturas de couro preto. Couro liso, croco e verniz, com acabamento em metais prateados.', '<p>Uma bolsa pr&aacute;tica, charmosa, produzida em couro leg&iacute;timo, com v&aacute;rias texturas de couro preto. Couro liso, croco e verniz, com acabamento em metais prateados. Possui al&ccedil;as com regulagem de altura, bolso posterior para facilitar acesso a chaves e Smartphone. Internamente, forro estampado e bolso interno com z&iacute;per.&nbsp;</p><p>&nbsp;</p><ul><li>Produzida em couro leg&iacute;timo em v&aacute;rias texturas de preto</li><li>Couro floter preto</li><li>Couro verniz preto</li><li>Couro croco preto</li><li>Al&ccedil;as com regulagem de altura</li><li>Bolso externo posterior</li><li>Forro estampado</li><li>Bolso interno com z&iacute;per</li><li>Metais prateados</li></ul>', '', '0.3', '32', '10', '23', '2018-04-12 02:59:48', 0, 1),
(19, 'bo-ange-azul', 'Bolsa angÃ©lica azul', '298.00', '0.0', 0, 'Maidi Grey', 7, 5, 1, 1, 'Uma bolsa prÃ¡tica, charmosa, produzida em couro legÃ­timo, na cor azul. Produzida com couro croco e acabamento com couro liso.  Possui alÃ§as com regulagem de altura...', '<p>Uma bolsa pr&aacute;tica, charmosa, produzida em couro leg&iacute;timo, na cor azul. Produzida com couro croco e acabamento com couro liso. &nbsp;Possui al&ccedil;as com regulagem de altura, bolso posterior para facilitar acesso a chaves e Smartphone. Internamente, forro estampado e bolso interno com z&iacute;per. Acabamento com metais prateados.</p><p>&nbsp;</p><ul><li>Couro leg&iacute;timo</li><li>Corpo croco azul</li><li>Al&ccedil;as e laterias em couro liso azul</li><li>Bolso externo posterior</li><li>Forro estampado</li><li>Bolso interno com z&iacute;per</li><li>Metais prateados</li></ul>', '', '0.3', '32', '10', '23', '2018-04-12 03:21:40', 0, 1),
(20, 'bo-ange-marrom', 'Bolsa angÃ©lica marrom', '298.00', '0.0', 0, 'Maidi Grey', 9, 5, 1, 1, 'Uma bolsa prÃ¡tica, charmosa, produzida em couro legÃ­timo, em tons de marrom. Em caramelo, marrom e oncinha, com laterias e acabamento em couro marrom cafÃ©.', '<p>Uma bolsa pr&aacute;tica, charmosa, produzida em couro leg&iacute;timo, em tons de marrom. Em caramelo, marrom e oncinha, com laterias e acabamento em couro marrom caf&eacute;.&nbsp;Possui al&ccedil;as com regulagem de altura, bolso posterior para facilitar acesso a chaves e Smartphone. Internamente, forro estampado e bolso interno com z&iacute;per. Acabamento com metais prateados.</p><p>&nbsp;</p><ul><li>Produzida em couro leg&iacute;timo</li><li>Couro floter caramelo, marrom e marrom caf&eacute;</li><li>Couro leg&iacute;timo espampa oncinha com peluciada</li><li>Al&ccedil;as e laterias em couro&nbsp;marrom caf&eacute;</li><li>Bolso externo posterior</li><li>Forro estampado</li><li>Bolso interno com z&iacute;per</li><li>Metais prateados</li></ul>', '', '0.3', '32', '10', '23', '2018-04-12 03:21:25', 0, 1),
(21, 'bo-alamanda-az', 'Bolsa alamanda azul', '341.00', '0.00', 0, 'Maidi Grey', 6, 3, 1, 0, 'Bolsa Transversal mÃ©dia, na cor azul. Possui alÃ§as largas para conforto e com regulagem de altura, dois bolsos pequenos na frente e outro atrÃ¡s. AlÃ©m do fechamento com zÃ­per.', '<p>Bolsa Transversal m&eacute;dia, na cor azul. Possui al&ccedil;as largas para conforto e com regulagem de altura, dois bolsos pequenos na frente e outro atr&aacute;s. Al&eacute;m do fechamento com z&iacute;per, possui o fechamento por mosquet&atilde;o, deixando a bolsa mais segura.</p><p>&nbsp;</p><ul><li>Al&ccedil;a com regulagem de altura</li><li>Possui 2 bolsos independentes na frente</li><li>Possui um bolso na parte posterior</li><li>Bolso na parte interna</li><li>Forro estampado.</li><li>Metais dourados com verniz</li></ul>', '', '0.3', '30', '10', '32', '2018-04-12 03:08:12', 0, 1),
(22, 'bo-anturio-ca', 'Bolsa AntÃºrio caramelo', '355.50', '348.00', 1, 'Maidi Grey', 5, 5, 1, 1, 'Bolsa estilo saco, moderna, em couro legÃ­timo na cor caramelo. Possui alÃ§as fixas e alÃ§as transversais removiveis, com regulagem de altura.', '<p>Bolsa estilo saco, moderna, em couro leg&iacute;timo na cor caramelo. Possui al&ccedil;as fixas e al&ccedil;as transversais removiveis, com regulagem de altura. Al&eacute;m de um bolso na parte de tr&aacute;s, para maior facilidade e seguran&ccedil;a.</p><p>&nbsp;</p><ul><li>Couro leg&iacute;timo na cor caramelo</li><li>Al&ccedil;as transversais removiveis</li><li>Metais Dourados</li><li>Tamanho medio &agrave; grande</li><li>Bolso interno</li><li>Bolso externo, na parte de tr&aacute;s</li><li>Forro estampado</li><li>Metal dourados com verniz</li></ul>', '', '0.3', '12', '40', '35', '2018-04-12 03:20:50', 0, 1),
(23, 'bo-anturio-ver', 'Bolsa AntÃºrio vermelha', '355.00', '348.00', 1, 'Maidi Grey', 4, 5, 1, 1, 'Bolsa estilo saco, moderna, em couro legÃ­timo na cor vermelha mesclada. Possui alÃ§as fixas e alÃ§as transversais removÃ­veis, com regulagem de altura.', '<p>Bolsa estilo saco, moderna, em couro leg&iacute;timo na cor vermelha mesclada. Possui al&ccedil;as fixas e al&ccedil;as transversais remov&iacute;veis, com regulagem de altura. Al&eacute;m de um bolso na parte de tr&aacute;s, para maior facilidade e seguran&ccedil;a.</p><p>&nbsp;</p><ul><li>Couro leg&iacute;timo na cor vermelha mesclada</li><li>Al&ccedil;as transversais remov&iacute;veis</li><li>Metais Dourados</li><li>Tamanho medio &agrave; grande</li><li>Bolso interno</li><li>Bolso externo, na parte de tr&aacute;s</li><li>Forro estampado</li><li>Metal dourados com verniz</li></ul>', '', '0.3', '12', '40', '35', '2018-04-12 03:29:11', 0, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pew_produtos_relacionados`
--

CREATE TABLE `pew_produtos_relacionados` (
  `id` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `id_relacionado` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pew_subcategorias`
--

CREATE TABLE `pew_subcategorias` (
  `id` int(11) NOT NULL,
  `subcategoria` varchar(255) NOT NULL,
  `id_categoria` varchar(255) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `ref` varchar(255) NOT NULL,
  `data_controle` datetime NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pew_subcategorias_produtos`
--

CREATE TABLE `pew_subcategorias_produtos` (
  `id` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_subcategoria` int(11) NOT NULL,
  `titulo_subcategoria` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pew_usuarios_administrativos`
--

CREATE TABLE `pew_usuarios_administrativos` (
  `id` int(11) NOT NULL,
  `empresa` varchar(255) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nivel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pew_usuarios_administrativos`
--

INSERT INTO `pew_usuarios_administrativos` (`id`, `empresa`, `usuario`, `senha`, `email`, `nivel`) VALUES
(2, 'Bolsas em Couro', 'Bolsas', 'c54651f2de21332ffa1f3d5d0b05d836', 'contato@bolsasemcouro.com.br', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pew_banners`
--
ALTER TABLE `pew_banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pew_carrinhos`
--
ALTER TABLE `pew_carrinhos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pew_categorias`
--
ALTER TABLE `pew_categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pew_categorias_produtos`
--
ALTER TABLE `pew_categorias_produtos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pew_categorias_vitrine`
--
ALTER TABLE `pew_categorias_vitrine`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pew_categoria_destaque`
--
ALTER TABLE `pew_categoria_destaque`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pew_config_orcamentos`
--
ALTER TABLE `pew_config_orcamentos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pew_contatos`
--
ALTER TABLE `pew_contatos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pew_cores`
--
ALTER TABLE `pew_cores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pew_cores_produtos`
--
ALTER TABLE `pew_cores_produtos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pew_cores_relacionadas`
--
ALTER TABLE `pew_cores_relacionadas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pew_departamentos`
--
ALTER TABLE `pew_departamentos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pew_departamentos_produtos`
--
ALTER TABLE `pew_departamentos_produtos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pew_dicas`
--
ALTER TABLE `pew_dicas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pew_enderecos`
--
ALTER TABLE `pew_enderecos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pew_especificacoes_produtos`
--
ALTER TABLE `pew_especificacoes_produtos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pew_especificacoes_tecnicas`
--
ALTER TABLE `pew_especificacoes_tecnicas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pew_imagens_produtos`
--
ALTER TABLE `pew_imagens_produtos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pew_links_menu`
--
ALTER TABLE `pew_links_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pew_marcas`
--
ALTER TABLE `pew_marcas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pew_minha_conta`
--
ALTER TABLE `pew_minha_conta`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `cpf` (`cpf`);

--
-- Indexes for table `pew_newsletter`
--
ALTER TABLE `pew_newsletter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pew_orcamentos`
--
ALTER TABLE `pew_orcamentos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pew_pedidos`
--
ALTER TABLE `pew_pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pew_produtos`
--
ALTER TABLE `pew_produtos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pew_produtos_relacionados`
--
ALTER TABLE `pew_produtos_relacionados`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pew_subcategorias`
--
ALTER TABLE `pew_subcategorias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pew_subcategorias_produtos`
--
ALTER TABLE `pew_subcategorias_produtos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pew_usuarios_administrativos`
--
ALTER TABLE `pew_usuarios_administrativos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pew_banners`
--
ALTER TABLE `pew_banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `pew_carrinhos`
--
ALTER TABLE `pew_carrinhos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `pew_categorias`
--
ALTER TABLE `pew_categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `pew_categorias_produtos`
--
ALTER TABLE `pew_categorias_produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `pew_categorias_vitrine`
--
ALTER TABLE `pew_categorias_vitrine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pew_categoria_destaque`
--
ALTER TABLE `pew_categoria_destaque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `pew_config_orcamentos`
--
ALTER TABLE `pew_config_orcamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pew_contatos`
--
ALTER TABLE `pew_contatos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `pew_cores`
--
ALTER TABLE `pew_cores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `pew_cores_produtos`
--
ALTER TABLE `pew_cores_produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pew_cores_relacionadas`
--
ALTER TABLE `pew_cores_relacionadas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;
--
-- AUTO_INCREMENT for table `pew_departamentos`
--
ALTER TABLE `pew_departamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `pew_departamentos_produtos`
--
ALTER TABLE `pew_departamentos_produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;
--
-- AUTO_INCREMENT for table `pew_dicas`
--
ALTER TABLE `pew_dicas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pew_enderecos`
--
ALTER TABLE `pew_enderecos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `pew_especificacoes_produtos`
--
ALTER TABLE `pew_especificacoes_produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;
--
-- AUTO_INCREMENT for table `pew_especificacoes_tecnicas`
--
ALTER TABLE `pew_especificacoes_tecnicas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `pew_imagens_produtos`
--
ALTER TABLE `pew_imagens_produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `pew_links_menu`
--
ALTER TABLE `pew_links_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT for table `pew_marcas`
--
ALTER TABLE `pew_marcas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `pew_minha_conta`
--
ALTER TABLE `pew_minha_conta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `pew_newsletter`
--
ALTER TABLE `pew_newsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `pew_orcamentos`
--
ALTER TABLE `pew_orcamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `pew_pedidos`
--
ALTER TABLE `pew_pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `pew_produtos`
--
ALTER TABLE `pew_produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `pew_produtos_relacionados`
--
ALTER TABLE `pew_produtos_relacionados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;
--
-- AUTO_INCREMENT for table `pew_subcategorias`
--
ALTER TABLE `pew_subcategorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pew_subcategorias_produtos`
--
ALTER TABLE `pew_subcategorias_produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pew_usuarios_administrativos`
--
ALTER TABLE `pew_usuarios_administrativos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
