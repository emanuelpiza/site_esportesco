<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();
    ob_start();

	$servname = 'localhost';
	$username = 'root';
	$password = 'k1llersql';
	$database = 'Esportes';
	$duracao = 20;
    $offset_inicio = 31;


    $mysqli = new mysqli($servname, $username, $password, $database);
    $mysqli->query("SET NAMES 'utf8'");
    mysqli_query($mysqli, "SET character_set_results=utf8");
    mb_language('uni'); 
    mb_internal_encoding('UTF-8');
    mysqli_query($mysqli, "set names 'utf8'");

    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    
    // Buscar todas as anotações novas da base e rodar o recorte pra elas
    $sql_matches = mysqli_query($mysqli,"select n.id as note, n.type, m.id as match_id, m.`field_id`, n.player, m.match_video_id, CAST((n.`datetime` - m.`datetime` - $offset_inicio) as UNSIGNED) as starttime, n.`right_side`, l.status, p.`players_team_id` from notes n left join matches m on n.`match_id` = m.id left join (select * from log order by status DESC) l on l.`item_id` = n.id left join players p on n.`player` = p.`id_players` where  status is null group by match_id, note;");
    while ($row = mysqli_fetch_assoc($sql_matches)) {
        $note_status = 19;//Note - Enviado para recorte
        $sql = "INSERT INTO log (item_id, datetime, status) VALUES (".$row['note'].",NOW(), $note_status)";
        if ($mysqli->query($sql) === TRUE) {
            echo "";
        } else {
            echo "Erro na base de dados: " . $mysqli->error;
        } 
        
        $cmd = '/var/www/videos/PublishServer/recorte.sh '.$row['match_video_id'].' '.$row['starttime'].' '.$duracao.'   '.$row['right_side'].' '.$row['type'].' '.$row['field_id'].' '.$row['note'].' '.$row['player'].' '.$row['players_team_id'];
        shell_exec($cmd);  
    }                     
?>