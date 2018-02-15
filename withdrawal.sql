-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 15/02/2018 às 15:48
-- Versão do servidor: 5.5.55
-- Versão do PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `dogeminer`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `withdrawal`
--

CREATE TABLE `withdrawal` (
  `cod_withdrawal` int(11) NOT NULL,
  `nom_txid` varchar(8000) NOT NULL,
  `dta_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nom_coin` varchar(50) NOT NULL DEFAULT 'DOGECOIN',
  `num_total` double NOT NULL,
  `nom_wallet` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `withdrawal`
--
ALTER TABLE `withdrawal`
  ADD PRIMARY KEY (`cod_withdrawal`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `withdrawal`
--
ALTER TABLE `withdrawal`
  MODIFY `cod_withdrawal` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
