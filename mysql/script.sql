/*
Script de criação de Base de Dados - Acesso UFPR
Erik Nayan & Pedro Mantovani
*/

DROP DATABASE arion; -- USE WITH EXTRA CAREFUL
CREATE DATABASE IF NOT EXISTS arion;

USE arion;

CREATE TABLE IF NOT EXISTS Users (
    cardId      BIGINT(12) UNSIGNED NOT NULL,
    name        VARCHAR(50) NOT NULL,
    email       VARCHAR(50) NOT NULL,
    password    VARCHAR(32) NOT NULL,
    grr         INT(8) UNSIGNED NOT NULL,
    type        TINYINT UNSIGNED NOT NULL,-- 0: Estudante, 1: Professor, 2: Servidor
    regdate	    DATE DEFAULT CURDATE() NOT NULL,
    status      BIT DEFAULT 1 NOT NULL, -- 1=Ativo, 0=Inativo;
    expiration  DATE DEFAULT DATE_ADD(CURDATE(), INTERVAL 10 YEARS) NOT NULL,
    balance     DECIMAL(6,2) DEFAULT 0.00 NOT NULL,
    PRIMARY KEY (cardID)
);

CREATE TABLE IF NOT EXISTS Tempusers (
    cardId      BIGINT(12) UNSIGNED NOT NULL,
    name        VARCHAR(50) NOT NULL,
    email       VARCHAR(50) NOT NULL,
    password    VARCHAR(32) NOT NULL,
    grr         INT(8) UNSIGNED NOT NULL,
    type        TINYINT UNSIGNED NOT NULL,-- 0: Estudante, 1: Professor, 2: Servidor
    regdate     DATE DEFAULT CURDATE() NOT NULL,
    confirmkey  VARCHAR(32) NOT NULL,
    PRIMARY KEY (cardID)
);

CREATE TABLE IF NOT EXISTS Restaurants (
    restId    INT AUTO_INCREMENT,
    restName  VARCHAR(50) NOT NULL,
    restAddr  VARCHAR(250) NOT NULL,
    PRIMARY KEY (restId)
);

CREATE TABLE IF NOT EXISTS Recharges (
    rechId      BIGINT(12) AUTO_INCREMENT,
    cardId      BIGINT(12) UNSIGNED NOT NULL,
    value       DECIMAL(6,2) NOT NULL,
    rectime     TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    PRIMARY KEY (rechId),
    FOREIGN KEY (cardId)
        REFERENCES Users(cardId)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS Transactions (
    tranId      BIGINT(12) UNSIGNED AUTO_INCREMENT,
    cardID      BIGINT(12) UNSIGNED NOT NULL,
    value       DECIMAL(6,2) NOT NULL,
    trantime    TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    restId      INT,
    PRIMARY KEY (tranId),
    FOREIGN KEY (restId)
        REFERENCES Restaurants(restId)
        ON DELETE SET NULL
        ON UPDATE CASCADE,
    FOREIGN KEY (cardId)
        REFERENCES Users(cardId)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

/* Create event to auto-delete temporary users after 3 days of registration */
CREATE EVENT IF NOT EXISTS arion.DeleteTemp
ON SCHEDULE
EVERY 1 DAY
COMMENT 'Deletes temporary users if they dont activate their accounts'
DO
BEGIN

DELETE FROM arion.Tempusers WHERE DATEDIFF(CURDATE(), regdate) > 3;

END

/* Enables events of database */
SET GLOBAL event_scheduler = ON;

/*
CREATE USER IF NOT EXISTS 'read'@'%' IDENTIFIED BY '***PASSWD***'; -- read access only, '%' guarantees access from any computer
GRANT SELECT ON arion.Users to 'read'@'%';
GRANT SELECT ON arion.Transactions to 'read'@'%';
GRANT SELECT ON arion.Recharges to 'read'@'%';
GRANT SELECT ON arion.Restaurants to 'read'@'%';

CREATE USER IF NOT EXISTS 'form'@'%' IDENTIFIED BY '***PASSWD***'; -- db access for new user manipulation
GRANT SELECT, INSERT, UPDATE ON arion.Users to 'form'@'%';
GRANT SELECT, INSERT, UPDATE ON arion.Tempusers to 'form'@'%';

CREATE USER IF NOT EXISTS 'scanner'@'%' IDENTIFIED BY '***PASSWD***'; -- inserts new transactions in db
GRANT SELECT, INSERT ON arion.Transactions to 'scanner'@'%';
GRANT SELECT ON arion.Users to 'scanner'@'%';
GRANT SELECT ON arion.Restaurants to 'scanner'@'%';

FLUSH PRIVILEGES;
*/