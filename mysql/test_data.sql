USE arion;

DELETE FROM Users;
DELETE FROM Tempusers;
DELETE FROM Restaurants;
DELETE FROM Transactions;
DELETE FROM Meals;

INSERT INTO Users VALUES ('111111111111', 'Admin', 'admin@admin.com', '$2y$10$/CcjjYWURdELgJ2TOyLDuuS8o2m9F5lf7f/TwG1pWUjvdDjPMaLcS', '00000000', 3, '0.00', '2017-05-25 12:09:00');
INSERT INTO Users VALUES ('123412341234', 'Pedro', 'pmantovani94@gmail.com', '$2y$10$/CcjjYWURdELgJ2TOyLDuuS8o2m9F5lf7f/TwG1pWUjvdDjPMaLcS', '20133893', 0, '87.00', '2017-05-25 12:09:00');
INSERT INTO Users VALUES ('432143214321', 'Erik', 'eriknayan@gmail.com', '$2y$10$/CcjjYWURdELgJ2TOyLDuuS8o2m9F5lf7f/TwG1pWUjvdDjPMaLcS', '20133894', 0, '2000.00', '2017-05-25 12:09:00');
INSERT INTO Users VALUES ('123443211234', 'Poor Guy', 'poor@guy.com', '$2y$10$/CcjjYWURdELgJ2TOyLDuuS8o2m9F5lf7f/TwG1pWUjvdDjPMaLcS', '20133895', 0, '1.00', '2017-05-25 12:09:00');

INSERT INTO Restaurants (restName, restAddr) VALUES ('Centro Politécnico', 'Av. Cel. Francisco H. dos Santos, 100');
INSERT INTO Restaurants (restName, restAddr) VALUES ('Agrárias', 'R. dos Funcionários, 1540');
INSERT INTO Restaurants (restName, restAddr) VALUES ('Reitoria', 'Rua XV de Novembro, 1299');
INSERT INTO Restaurants (restName, restAddr) VALUES ('Prédio Histórico', 'Praça Santos Andrade, 50');
INSERT INTO Restaurants (restName, restAddr) VALUES ('Recarga Online', 'N/A');

INSERT INTO Meals VALUES ('Breakfast', -0.50);
INSERT INTO Meals VALUES ('Lunch', -1.30);
INSERT INTO Meals VALUES ('Dinner', -1.30);

INSERT INTO Transactions (cardId, value, tranTime, restId) VALUES ('123412341234', '100', '2017-05-15 10:00:00', 5);
INSERT INTO Transactions (cardId, value, tranTime, restId) VALUES ('123412341234', '-1.30', '2017-05-16 12:00:00', 1);
INSERT INTO Transactions (cardId, value, tranTime, restId) VALUES ('123412341234', '-1.30', '2017-05-17 12:01:00', 2);
INSERT INTO Transactions (cardId, value, tranTime, restId) VALUES ('123412341234', '-1.30', '2017-05-18 12:02:00', 3);
INSERT INTO Transactions (cardId, value, tranTime, restId) VALUES ('123412341234', '-1.30', '2017-05-19 12:03:00', 4);
INSERT INTO Transactions (cardId, value, tranTime, restId) VALUES ('123412341234', '-1.30', '2017-05-20 12:04:00', 1);
INSERT INTO Transactions (cardId, value, tranTime, restId) VALUES ('123412341234', '-1.30', '2017-05-21 12:05:00', 2);
INSERT INTO Transactions (cardId, value, tranTime, restId) VALUES ('123412341234', '-1.30', '2017-05-22 12:06:00', 3);
INSERT INTO Transactions (cardId, value, tranTime, restId) VALUES ('123412341234', '-1.30', '2017-05-23 12:07:00', 4);
INSERT INTO Transactions (cardId, value, tranTime, restId) VALUES ('123412341234', '-1.30', '2017-05-24 12:08:00', 1);
INSERT INTO Transactions (cardId, value, tranTime, restId) VALUES ('123412341234', '-1.30', '2017-05-25 12:09:00', 2);

INSERT INTO Transactions (cardId, value, tranTime, restId) VALUES ('432143214321', '2013.00', '2017-05-15 10:00:00', 5);
INSERT INTO Transactions (cardId, value, tranTime, restId) VALUES ('432143214321', '-1.30', '2017-05-16 12:00:00', 1);
INSERT INTO Transactions (cardId, value, tranTime, restId) VALUES ('432143214321', '-1.30', '2017-05-17 12:01:00', 2);
INSERT INTO Transactions (cardId, value, tranTime, restId) VALUES ('432143214321', '-1.30', '2017-05-18 12:02:00', 3);
INSERT INTO Transactions (cardId, value, tranTime, restId) VALUES ('432143214321', '-1.30', '2017-05-19 12:03:00', 4);
INSERT INTO Transactions (cardId, value, tranTime, restId) VALUES ('432143214321', '-1.30', '2017-05-20 12:04:00', 1);
INSERT INTO Transactions (cardId, value, tranTime, restId) VALUES ('432143214321', '-1.30', '2017-05-21 12:05:00', 2);
INSERT INTO Transactions (cardId, value, tranTime, restId) VALUES ('432143214321', '-1.30', '2017-05-22 12:06:00', 3);
INSERT INTO Transactions (cardId, value, tranTime, restId) VALUES ('432143214321', '-1.30', '2017-05-23 12:07:00', 4);
INSERT INTO Transactions (cardId, value, tranTime, restId) VALUES ('432143214321', '-1.30', '2017-05-24 12:08:00', 1);
INSERT INTO Transactions (cardId, value, tranTime, restId) VALUES ('432143214321', '-1.30', '2017-05-25 12:09:00', 2);

INSERT INTO Transactions (cardId, value, tranTime, restId) VALUES ('123443211234', '1.00', '2017-05-25 12:09:00', 5);