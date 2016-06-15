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
        
        $craque = $_POST['craque']; 
        $inicio = $_POST['momento']; 
        $campo = $_POST['radio_campo']; 
        $equipe = $_POST['equipe']; 
        $tempo = date("H:i:s");

        //$cmd = "./mode.sh o2wVpTDW15g 00:00:09 10 0 0 45 1 2>&1";// Duracao padrao agora é 10
        $cmd = './mode.sh '.$video.' '.$inicio.' 10 '.$campo.' 0 45 '.$equipe.' 2>&1';
        shell_exec($cmd);  
        
    } else if ($acao == "estatisticas"){
        
        $craque = $_POST['craque']; 
        $tipo = $_POST['tipo']; 
        $assist = $_POST['assistencia']; 
        $time = $_POST['time'];
        
        //JOGADA EM SI
        $sql = "UPDATE plays SET plays_players_id=".$craque.", assistance=".$assist.", plays_play_types_id=".$tipo." WHERE video_id='".$video."'";

        if ($conn->query($sql) === TRUE) {
            echo "";
        } else {
            echo "Erro na base de dados: " . $conn->error;
        }
       
        //STATS 2 - ARTILHARIA
        $stats2 = "
            UPDATE players AS t
                INNER JOIN 
                (SELECT plays_players_id,COUNT(*) maximo FROM plays where teams_id=".$time." and plays_players_id <> 45 GROUP BY plays_players_id) t1 
                ON t.id_players = t1.plays_players_id 
	       SET t.`players_stats2`= (t1.maximo/(
                SELECT MAX(counted) FROM
                    (SELECT COUNT(*) AS counted
                        FROM plays
                        WHERE  teams_id= ".$time." and plays_players_id <> 45
                        GROUP BY plays_players_id) AS counts)
                *100) where t.`players_team_id`= ".$time.";";
                                 
        if ($conn->query($stats2) === TRUE) {
            echo "";
        } else {
            echo "Erro na base de dados: " . $conn->error;
        }
 
                                 
        $conn->close();
    } else if ($acao == "deletar"){
        $sql = "UPDATE plays SET available=0 WHERE video_id='".$video."'";

        if ($conn->query($sql) === TRUE) {
            echo "";
        } else {
            echo "Erro na base de dados: " . $conn->error;
        } 
    }
?>