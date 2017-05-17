<?php

    header('Content-Type: text/html; charset=utf-8');
    session_start();

    ob_start();
    include('/var/www/html/site_esportesco/admin/dbcon/dbcon.php');

    // Campeonatos Ativos
    $sql = "
    insert into 
        active_cups_7d (log_date, total) 
    values 
        (NOW(),
        (select count(distinct(`cup_id`)) as copas_ativas_por_semana FROM (select cup_id, count(distinct(match_id)) as partidas from notes n left join matches m on n.match_id = m.id where n.datetime BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) and NOW() group by cup_id) s where s.partidas > 2));";   
     if ($mysqli->query($sql) === TRUE) {
         echo "";
     } else {
         echo "Erro na base de dados: " . $mysqli->error;
     }

    // Jogadores Ativos
    $sql = "
    insert into 
	   active_players_7d (log_date, total) 
    values
 	  (NOW(),
 	  (select count(distinct(player)) as players from notes n where n.datetime BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) and NOW()));";   
     if ($mysqli->query($sql) === TRUE) {
         echo "";
     } else {
         echo "Erro na base de dados: " . $mysqli->error;
     }

?>