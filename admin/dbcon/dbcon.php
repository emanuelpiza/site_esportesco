<?php

	$servname = 'localhost';
	$username = 'root';
	$password = 'k1llersql';
	$database_name = 'esportes_co';

    $mysqli = new mysqli("localhost", "root", "k1llersql", "Esportes");
    $mysqli->query("SET NAMES 'utf8'");
    mysql_query("SET character_set_results=utf8", $mysqli);
    mb_language('uni'); 
    mb_internal_encoding('UTF-8');
    mysql_query("set names 'utf8'",$mysqli);

    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
?>