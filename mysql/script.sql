/*  

Script de criação de Base de Dados - Acesso UFPR 

Erik Nayan & Pedro Mantovani

Versão 1.0 - set 2016 

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
         status		  ENUM('Ativo',"Inativo") DEFAULT 'Ativo' NOT NULL,
         expiration	  DATE DEFAULT '2100-01-01' NOT NULL,
         PRIMARY KEY  (cardID)
 );

CREATE TABLE IF NOT EXISTS client (
		 cardID		  BIGINT(12) UNSIGNED NOT NULL,
		 balance	  DECIMAL(6,2) NOT NULL,
		 status		  ENUM('Ativo',"Inativo") DEFAULT 'Ativo' NOT NULL,
		 lasttr		  TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
		 PRIMARY KEY  (cardID)
);

CREATE TABLE IF NOT EXISTS transactions (
		 id 		  BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
		 cardID	      BIGINT(12) UNSIGNED NOT NULL,
		 ttime		  TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
		 campus		  ENUM('Politecnico','Botanico','Agrarias','Reitoria') NOT NULL,
		 PRIMARY KEY  (id)
)



