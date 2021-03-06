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

    $sql = "insert into log (datetime) ;";
    if ($mysqli->query($sql) === TRUE) {
        echo "";
    } else {
        echo "Erro na base de dados: " . $mysqli->error;
    } 

    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
  // Após arquivos ok, inicia o processamento, um por vez
  $sql_processamento = mysqli_query($mysqli,"
       select 
            m.id, 
            m.status, 
            m.field_id, 
            m.is_two_cameras, 
            m.datetime, 
            c.match_duration as duration, 
            t1.`teams_name` as team1_name, 
            t1.`short_name` as team1_abrev, 
            t2.`teams_name` as team2_name, 
            t2.`short_name` as team2_abrev 
        from matches m 
            left join teams t1 on m.team1 = t1.id_teams 
            left join teams t2 on m.team2 = t2.id_teams 
            left join cups c on t1.cup_id = c.id
        where datetime < NOW() and m.status in (1, 2)
        order by m.status DESC, datetime LIMIT 1;");
    while ($row = mysqli_fetch_assoc($sql_processamento)) {
        if ($row['status'] == 1){
            
            $novo_status = 2;//Match - Enviado para recorte
            $sql = "UPDATE matches set status = '$novo_status', last_status = NOW() where id = ".$row['id'].";";
            if ($mysqli->query($sql) === TRUE) {
                echo "";
            } else {
                echo "Erro na base de dados: " . $mysqli->error;
            } 
            
            $cmd = '/var/www/videos/PublishServer/celular_processamento.sh '.$row['id'];
            shell_exec($cmd);
        }
    }
        
    // Publicação das partidas completas no Youtube, uma por vez
    $sql_publicarYT = mysqli_query($mysqli,"
        select 
            m.id, 
            m.status, 
            m.field_id, 
            m.is_two_cameras, 
            m.datetime, 
            c.match_duration as duration, 
            t1.`teams_name` as team1_name, 
            t1.`short_name` as team1_abrev, 
            t2.`teams_name` as team2_name, 
            t2.`short_name` as team2_abrev 
        from matches m 
            left join teams t1 on m.team1 = t1.id_teams 
            left join teams t2 on m.team2 = t2.id_teams 
            left join cups c on t1.cup_id = c.id
        where datetime < NOW() and m.status in (6, 7)
        order by m.status DESC, datetime LIMIT 1;");
    while ($row = mysqli_fetch_assoc($sql_publicarYT)) {
        if ($row['status'] == 6){
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
            $parametros = ' "'.$title.'" '.$dia.' '.$hora_ini.' '.$hora_fim.' 0 '.$row['id'].' 0';
           
            $novo_status = 7;//Match - Enviado para recorte
            $sql = "UPDATE matches set status = '$novo_status', last_status = NOW() where id = ".$row['id'].";";
            if ($mysqli->query($sql) === TRUE) {
                echo "";
            } else {
                echo "Erro na base de dados: " . $mysqli->error;
            } 
            $cmd = '/var/www/videos/PublishServer/publicarYT.sh '.$parametros;
            shell_exec($cmd);          
        }
    } 


    // Publicação dos melhores momentos no Youtube, uma por vez. Removi por hora
    $sql_Melhores = mysqli_query($mysqli,"
        select 
            m.id, 
            m.status, 
            m.field_id, 
            m.is_two_cameras, 
            m.datetime,
            c.match_duration as duration, 
            t1.`teams_name` as team1_name, 
            t1.`short_name` as team1_abrev, 
            t2.`teams_name` as team2_name, 
            t2.`short_name` as team2_abrev 
        from matches m 
            left join teams t1 on m.team1 = t1.id_teams 
            left join teams t2 on m.team2 = t2.id_teams 
            left join cups c on t1.cup_id = c.id
        where m.`datetime` < ADDDATE(NOW(), -4) and m.status in (8, 9)
        order by m.status DESC, datetime DESC LIMIT 1");
    //while ($row = mysqli_fetch_assoc($sql_Melhores)) {
    //    if ($row['status'] == 8){
    //        $sql_count = mysqli_query($mysqli,"
    //            select count(1) as total from plays where match_id in (".$row['id'].") and available in (1,2)");
      //      $fetch_count = mysqli_fetch_assoc($sql_count);       
      //      $count = $fetch_count['total'];
            
            // Só rodamos caso mais de 4 momentos foram marcados
     //       if ($count < 4){
     //           $novo_status = 11;//Fim - Não houve mais que 3 marcações em um espaço de 3 dias após a publicação. Não será gerado vídeo de melhores momentos.
     //           $sql = "UPDATE matches set status = '$novo_status', last_status = NOW() where id = ".$row['id'].";";
     //           if ($mysqli->query($sql) === TRUE) {
     //               echo "";
      //          } else {
      //              echo "Erro na base de dados: " . $mysqli->error;
      //          } 
     //       }else {
                // Preparação 
      //          if ($row['team2_name'] == null){
     //               $title = 'Melhores Momentos - '.$row['team1_name'];
       //         } else {
       //             $title = 'Melhores Momentos - '.$row['team1_abrev'] . ' vs ' . $row['team2_abrev'];
       //         }
        //        $datahora = new DateTime($row['datetime']);
        //        $dia = $datahora->format('Y-m-d'); 
       //         $hora_ini = $datahora->format('Hi');
        //        $datahora->add(new DateInterval('PT' . $row['duration'] . 'M'));
        //        $hora_fim = $datahora->format('Hi');
         //       $parametros = ' "'.$title.'" '.$dia.' '.$hora_ini.' '.$hora_fim.' '.$row['field_id'].' '.$row['id'].' '.$row['is_two_cameras'];

       //         $novo_status = 9;//Match - Publicando seleção de lances no Youtube
        //        $sql = "UPDATE matches set status = '$novo_status', last_status = NOW() where id = ".$row['id'].";";
        //        if ($mysqli->query($sql) === TRUE) {
        //            echo "";
         //       } else {
         //           echo "Erro na base de dados: " . $mysqli->error;
          //      } 
         //       $cmd = '/var/www/videos/PublishServer/melhores.sh '.$parametros;
         //       shell_exec($cmd);     
         //   }
       // }
    //} 
?>