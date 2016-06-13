<?php

	$host = 'localhost';
	$user = 'root';
	$pass = 'k1llersql';
	$base = 'Esportes';

$conn = mysqli_connect($host, $user, $pass, $base) or die(mysqli_error());

$query = "SELECT video_id, plays_players_id, players_name, teams_name, datetime FROM plays where available = 1 order by id_plays DESC LIMIT 15" or die(mysqli_error());

$result = $conn->query($query);

//Declare uma array para colecionar todos os $rows
$end_result = array();

/*
   Aqui, em vez de usar mysqli_fetch_array(), que devolve ambos
    arrays associativas e arrays numericais, usa mysqli_fetch_assoc -
    assim, consegue pegar uma array associativa assim:
    ['matricula'=>'182354X', 'nome'=>'RAFAEL CAMPOS PIMENTEL']
*/
while ($row = mysqli_fetch_assoc($result)) {
    //adicione essa array associativa à array normal
    $end_result[] = $row;
}

//specifique-se que o conteúdo é do JSON - AngularJS vai gostar disso :D
header('Content-Type: application/json');

//Por fim, transforme o array em JSON e termina a execução.
echo json_encode($end_result);
die();
?>