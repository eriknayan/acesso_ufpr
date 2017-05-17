<?php

require_once('../rest.php');

$rest = new REST();

var_dump('getUser test');
var_dump($rest->getUser('123412341234'));
var_dump($rest->getUser('999999999999'));

var_dump('getRestaurant test');
var_dump($rest->getRestaurant('1'));
var_dump($rest->getRestaurant());
var_dump($rest->getRestaurant('7'));

var_dump('getTransaction test');
var_dump($rest->getTransaction('123412341234'));
var_dump($rest->getTransaction(null, '2017-05-19', '2017-05-20'));
var_dump($rest->getTransaction('70'));

var_dump('getCurrentMealValue test');
var_dump($rest->getCurrentMealValue());

var_dump('insertUser test');
var_dump($rest->insertUser('121212121212', 'Test', 'test@test', '1234', '12341234', 1));
var_dump($rest->insertUser('121212121212', 'Test', 'test@test', '1234', '12341234', 1));

var_dump('insertRestaurant test');
var_dump($rest->insertRestaurant('My Restaurant', 'Test addr'));

var_dump('insertTransaction test');
var_dump($rest->insertTransaction('123412341234', '-1.30', '1'));
var_dump($rest->insertTransaction('444444444', '-1.30', '1'));
var_dump($rest->insertTransaction('123412341234', '-1.30', '70'));
var_dump($rest->insertTransaction('123443211234', '-1.30', '1'));
    

var_dump('updateUser test');
var_dump($rest->updateUser('123412341234', 'MyNew Name'));
var_dump($rest->updateUser('4444', 'aaaa'));



?>