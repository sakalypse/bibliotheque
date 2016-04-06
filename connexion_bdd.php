<?php
include("config.php");    //4 constantes : database ; hostname ; username ; password
$dsn = 'mysql:dbname='.database.';host='.hostname.";charset=utf8";
$ma_connexion_mysql = new PDO($dsn, username, password);
$ma_connexion_mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$ma_connexion_mysql->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);

//var_dump($ma_connexion_mysql);