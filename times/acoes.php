<?php
    # Evita o armazenamento em Cache
    @header('Content-Type: text/html; charset=iso-8859-1');
    @header("Cache-Control: no-cache, must-revalidate");  
    @header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  

    $servername = "localhost";
    $username = "root";
    $password = "k1llersql";
    $dbname = "Esportes";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    $acao = $_POST['acao'];
    $video = $_POST['video'];

    if ($acao == "marcar") {
        
        $inicio = $_POST['momento']; 
        $lado = $_POST['radio_lado']; 
        $partida = $_POST['partida']; 
        $tempo = date("H:i:s");
        $campo =  $_POST['campo']; 
        $is_two_cameras =  $_POST['is_two_cameras']; 

        //$cmd = "./mode.sh o2wVpTDW15g 00:00:09 10 0 0 45 1 2>&1";// Duracao padrao agora é 10
        $cmd = './mode.sh '.$video.' '.$inicio.' 10 '.$lado.' 0 45 '.$partida.' '.$campo.' '.$is_two_cameras.' 2>&1';
        shell_exec($cmd);  
        
    } else if ($acao == "estatisticas"){
        
        $craque = $_POST['craque'];
        $tipo = $_POST['tipo']; 
        $assist = $_POST['assistencia']; 
        $time = $_POST['time'];
        
        //JOGADA EM SI
        $sql = "UPDATE plays SET plays_players_id=".$craque.", assistance=".$assist.", plays_play_types_id=".$tipo.", teams_id=".$time.", players_name=(select players_name from players where id_players = ".$craque."), assist_name=(select players_name from players where id_players = ".$assist."), available = 2 WHERE video_id='".$video."'";

        if ($conn->query($sql) === TRUE) {
            echo "";
        } else {
            echo "Erro na base de dados: " . $conn->error;
        }
       
        if ($tipo == 2 || $tipo == 3){
            $tipo = "3";
            $tipo_sql = "in (2,3)";
        } else {
            $tipo_sql = " = ".$tipo;
        }
        
        if ($tipo <> 5 && $tipo <> 0){// Bola mucha não tá contando nas stats
            //STATS BASE
            $stats = "
                UPDATE players AS t
                    LEFT JOIN 
                    #pega o máximo de jogadas para cada um
                    (SELECT plays_players_id,COUNT(*) maximo FROM plays where teams_id=".$time." and plays_players_id <> 45 and plays_play_types_id ".$tipo_sql." and available = 2 GROUP BY plays_players_id) t1 
                    #cruza de volta a tabela players
                    ON t.id_players = t1.plays_players_id
               #Atualiza      
               SET t.`players_stats".$tipo."`= (t1.maximo/(
                    #Pega o máximo geral da equipe
                    SELECT MAX(counted) FROM
                        (
                        SELECT COUNT(*) AS counted
                            FROM plays
                            WHERE  teams_id= ".$time." and plays_players_id <> 45 and plays_play_types_id ".$tipo_sql." and available = 2
                            GROUP BY plays_players_id) AS counts)
                    #Passa para a base 100
                    *100) where t.`players_team_id`= ".$time.";";

            if ($conn->query($stats) === TRUE) {
                echo "";
            } else {
                echo "Erro na base de dados: " . $conn->error;
            } 
        }
        
        //STATS 2 - PARTICIPAÇÕES - Para todo tipo de lance
        $stats2 = "
           UPDATE players AS t
                LEFT JOIN 
                #pega o máximo de jogadas para cada um
                (SELECT COUNT(*) maximo, assistance FROM plays where teams_id= ".$time." and plays_players_id <> 45 and available = 2 GROUP BY assistance) t1 
                #cruza de volta a tabela players
                ON t.id_players = t1.assistance
           #Atualiza      
           SET t.`players_stats2`= (t1.maximo/(
                #Pega o máximo geral da equipe
                SELECT MAX(counted) FROM
                    (
                    SELECT COUNT(*) AS counted
                        FROM plays
                        WHERE  teams_id= ".$time." and assistance <> 45 and available = 2
                        GROUP BY assistance
                    ) AS counts)
                #Passa para a base 100
                *100) where t.`players_team_id`= ".$time.";";

        if ($conn->query($stats2) === TRUE) {
            echo "";
        } else {
            echo "Erro na base de dados: " . $conn->error;
        }   
    } else if ($acao == "deletar"){
        $sql = "UPDATE plays SET available=0 WHERE video_id='".$video."'";

        if ($conn->query($sql) === TRUE) {
            echo "";
        } else {
            echo "Erro na base de dados: " . $conn->error;
        } 
    }
    $conn->close();
?>