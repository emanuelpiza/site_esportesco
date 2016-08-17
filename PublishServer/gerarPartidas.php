<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();
    ob_start();

	$servname = 'localhost';
	$username = 'root';
	$password = 'k1llersql';
	$database = 'Esportes';


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
    $sql_partidas = mysqli_query($mysqli,"
        select 
            m.id, 
            m.field_id, 
            m.is_two_cameras, 
            m.datetime, 
            t1.teams_match_duration as duration, 
            m.status, 
            t1.`teams_name` as team1_name, 
            LEFT(t1.`teams_name`, 3) as team1_abrev, 
            t2.`teams_name` as team2_name, 
            LEFT(t2.`teams_name`, 3) as team2_abrev 
        from matches m 
            left join teams t1 on m.team1 = t1.id_teams 
            left join teams t2 on m.team2 = t2.id_teams 
        where match_video_id is null and datetime < NOW() 
        order by datetime;");
    while ($row = mysqli_fetch_assoc($sql_partidas)) {
        // Preparação 
        if ($row['team2_name'] == null){
            $title = $row['team1_name'];
        } else {
            $title = $row['team1_abrev'] . ' vs ' . $row['team2_abrev'];
        }
        $datahora = new DateTime($row['datetime']);
        $dia = $datahora->format('Y-m-d'); 
        $hora_ini = $datahora->format('Hi');
        $datahora->add(new DateInterval('PT' . $row['duration'] . 'M'));
        $hora_fim = $datahora->format('Hi');
        // Início do processo
        if ($row['status'] == null){
            $novo_status = 2;//Match - Enviado para recorte
            $sql = "UPDATE matches set status = '$novo_status', last_status = NOW() where id = ".$row['id'].";";
            if ($mysqli->query($sql) === TRUE) {
                echo "";
            } else {
                echo "Erro na base de dados: " . $mysqli->error;
            } 
            $cmd = '/var/www/videos/PublishServer/campo'.$row['field_id'].'.sh "'.$title.'" '.$dia.' '.$hora_ini.' '.$hora_fim.' '.$row['id'];
            shell_exec($cmd);
        
        // Para os casos em que a princípio deu erro no Youtube
        } else if ($row['status'] == 7){
            $cmd = '/var/www/videos/PublishServer/YTeUpdate.sh "'.$title.'" '.$dia.' '.$hora_ini.' '.$hora_fim.' '.$row['id'];
            shell_exec($cmd);          
        }
    } 
?>