<?php

	$servname = 'localhost';
	$username = 'root';
	$password = 'k1llersql';
	$database_name = 'esportes_co';

    $mysqli = new mysqli("localhost", "root", "k1llersql", "Esportes");

    /* check connection */
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
?>