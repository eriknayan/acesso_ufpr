/*  

Script de criação de Base de Dados - Acesso UFPR 

Erik Nayan & Pedro Mantovani

Versão 1.0 - 10 set 2016 

*/

CREATE DATABASE IF NOT EXISTS arion;

USE arion;

CREATE TABLE IF NOT EXISTS users (
         cardID    	  BIGINT(12) UNSIGNED NOT NULL,
         name         VARCHAR(50) NOT NULL,
         email        VARCHAR(50) NOT NULL,
         password	  VARCHAR(20) NOT NULL,
         grr          INT(8) UNSIGNED NOT NULL,
         type         ENUM('Estudante','Professor','Servidor') NOT NULL,
         regdate	  DATE DEFAULT '2017-01-01' NOT NULL,
         status		  BIT DEFAULT 1 NOT NULL, -- 1=Ativo, 0=Inativo;
         expiration	  DATE DEFAULT '2100-01-01' NOT NULL,
         PRIMARY KEY  (cardID)
 );

CREATE TABLE IF NOT EXISTS clients (
		 cardID    	  BIGINT(12) UNSIGNED NOT NULL,
		 balance	  DECIMAL(6,2) NOT NULL,
		 status		  BIT DEFAULT 1 NOT NULL, -- 1=Ativo, 0=Inativo;
		 PRIMARY KEY  (cardID)
 );

CREATE TABLE IF NOT EXISTS transactions (
		 id 		  BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
		 cardID	      BIGINT(12) UNSIGNED NOT NULL,
		 value        DECIMAL(2,2) NOT NULL,
		 type		  BIT NOT NULL, -- 1=Crédito, 0=Desconto;
		 ttime		  TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
		 campus		  ENUM('Politecnico','Botanico','Agrarias','Reitoria') NOT NULL,
		 PRIMARY KEY  (id)
 );

CREATE USER IF NOT EXISTS 'scan'@'%' IDENTIFIED BY 'scan@acesso_ufpr16!'; -- o scan pode acessar de qualquer máquina a DB

GRANT SELECT, INSERT, UPDATE ON arion.transactions to 'scan'@'%'; -- acesso somente a tabela apropriada

GRANT SELECT, INSERT, UPDATE ON arion.clients to 'scan'@'%'; -- acesso somente a tabela apropriada

CREATE USER IF NOT EXISTS 'form'@'%' IDENTIFIED BY 'form@acesso_ufpr16!'; -- o form pode acessar de qualquer máquina a DB

GRANT SELECT, INSERT, UPDATE ON arion.users to 'form'@'%'; -- acesso somente a tabela apropriada

FLUSH PRIVILEGES;