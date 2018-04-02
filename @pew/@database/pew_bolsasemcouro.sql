-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 02-Abr-2018 às 16:01
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
(16, 9, 12, 'Mochilas masculinas');

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
(2, 'Cor teste', 'd68e-refd68e.jpg', '2018-03-31 11:39:00', 1);

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
(14, 'FEMININO', '', 0, 'feminino', '2018-03-29', 1),
(15, 'MASCULINO', '', 4, 'masculino', '2018-03-27', 1),
(12, 'ACESSÃ“RIOS', '', 1, 'acessorios', '2018-03-29', 1),
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
(94, 9, 13),
(90, 8, 14),
(93, 5, 14);

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
(9, 15, 1, 80230040, 'Rua Engenheiros RebouÃ§as', '2111', 'Apto 06', 'RebouÃ§as', 'Curitiba', 'PR', '2018-03-20 01:13:29', '2018-03-20 01:13:29', 1),
(10, 16, 1, 80230040, 'Rua Engenheiros RebouÃ§as', '2111', '', 'RebouÃ§as', 'Curitiba', 'PR', '2018-03-29 02:46:03', '2018-03-29 02:46:03', 1);

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

--
-- Extraindo dados da tabela `pew_especificacoes_produtos`
--

INSERT INTO `pew_especificacoes_produtos` (`id`, `id_especificacao`, `id_produto`, `descricao`) VALUES
(82, 7, 5, 'Pequena');

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
(4, 5, '97e491dbd424e33e1.jpg', 1, 1),
(7, 7, 'produto-teste-2-4cc1.jpg', 1, 1),
(9, 9, 'produto-teste-fcc3.jpg', 1, 1);

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
(53, 14, 8),
(54, 14, 9),
(59, 12, 5),
(60, 12, 9);

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
(15, 'Rogerio Mendes', 'reyrogerio@hotmail.com', '08541bb36f049db6004fd98457138485', '(41) 99753-6262', '', '05453531908', '1998-07-29', 'masculino', '2018-03-20 01:13:29', '2018-03-20 01:13:29', 1),
(16, 'Rogerio Lucas', 'rogerio@efectusweb.com.br', '49b1c02523650909cb7ef5be6629cde2', '(41) 99753-6262', '', '72991534915', '1998-07-29', 'masculino', '2018-03-29 02:46:03', '2018-03-29 02:46:03', 0);

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
(5, 'bo-angelicas', 'Bolsa angÃ©lica', '298.00', '265.65', 1, 'Maidi Grey', 2, 5, 1, 30, 'Lorem Ipsum Ã© simplesmente uma simulaÃ§Ã£o de texto da indÃºstria tipogrÃ¡fica e de impressos, e vem sendo utilizado desde o sÃ©culo XVI.', '<p>Lorem Ipsum &eacute; simplesmente uma simula&ccedil;&atilde;o de texto da ind&uacute;stria tipogr&aacute;fica e de impressos, e vem sendo utilizado desde o s&eacute;culo XVI.</p><p>Lorem Ipsum &eacute; simplesmente uma simula&ccedil;&atilde;o de texto da ind&uacute;stria tipogr&aacute;fica e de impressos, e vem sendo utilizado desde o s&eacute;culo XVI.</p><p>Lorem Ipsum &eacute; simplesmente uma simula&ccedil;&atilde;o de texto da ind&uacute;stria tipogr&aacute;fica e de impressos, e vem sendo utilizado desde o s&eacute;culo XVI.</p>', 'http://<iframe width=\'560\' height=\'315\' src=\'https://www.youtube.com/embed/3O9EMwTE7xo?rel=0&controls=0&showinfo=0\' frameborder=\'0\' allow=\'autoplay; encrypted-media\' allowfullscreen></iframe>', '500', '20', '20', '20', '2018-03-31 11:34:17', 0, 1),
(9, '212121', 'Produto teste', '12', '0', 0, 'Maidi Grey', 0, 1, 1, 0, 'asdasadsdsaasdasadsdsaasdasadsdsaasdasadsdsaasdasadsdsaasdasadsdsaasdasadsdsaasdasadsdsaasdasadsdsaasdasadsdsaasdasadsdsaasdasadsdsaasdasadsdsaasdasadsdsaasdasadsdsaasdasadsdsa', '<p>asdasadsdsaasdasadsdsaasdasadsdsaasdasadsdsaasdasadsdsaasdasadsdsaasdasadsdsaasdasadsdsaasdasadsdsaasdasadsdsaasdasadsdsaasdasadsdsaasdasadsdsaasdasadsdsaasdasadsdsaasdasadsdsaasdasadsdsaasdasadsdsaasdasadsdsaasdasadsdsa</p>', '', '21212121', '122121', '21212121', '212121', '2018-04-01 02:17:06', 0, 1);

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
-- AUTO_INCREMENT for table `pew_categorias`
--
ALTER TABLE `pew_categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `pew_categorias_produtos`
--
ALTER TABLE `pew_categorias_produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `pew_cores_produtos`
--
ALTER TABLE `pew_cores_produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pew_departamentos`
--
ALTER TABLE `pew_departamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `pew_departamentos_produtos`
--
ALTER TABLE `pew_departamentos_produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;
--
-- AUTO_INCREMENT for table `pew_enderecos`
--
ALTER TABLE `pew_enderecos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `pew_links_menu`
--
ALTER TABLE `pew_links_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
--
-- AUTO_INCREMENT for table `pew_marcas`
--
ALTER TABLE `pew_marcas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `pew_minha_conta`
--
ALTER TABLE `pew_minha_conta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
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
-- AUTO_INCREMENT for table `pew_produtos`
--
ALTER TABLE `pew_produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
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
