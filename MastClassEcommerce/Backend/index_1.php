<?php

require 'config/config.php';
require 'entity/userEntity.php';
require 'entity/categoryEntity.php';
require 'entity/productEntity.php';
require 'entity/ordersEntity.php';
require 'model/DataLayer.class.php';

// Initialisé DataLayer
$db = new DataLayer();

// $users = $db->getUsers();
// $categories = $db->getCategory();
// $products = $db->getProduct();
// $orders = $db->getOrders();

// var_dump($orders);

$user = new UserEntity();

// $user1->setSexe(1);
// $user1->setEmail("kodjo@gmail.com");
// $user1->setPseudo("Kodjo");
// $user1->setPassword("test2023");
// $user1->setFirstname("kodjo");
// $user1->setLastname("KODJO LA JOIE");
// $user1->setDateBirth("12/12/2023");
// $user->setAdresseFacturation("Adresse facturation");
// $user->setAdresseLivraison("Adresse liv");
// $user->setIdUser(2);

// $var = $db->updateUsers($user);
// $db->createUser($user1);

// $var = $db->deleteUsers($user);
// var_dump($var);



$user->setEmail("kodjo@gmail.com");
$user->setPassword("test2023");

$var = $db->authentifier($user);
var_dump($var);
// var_dump($var)


?>