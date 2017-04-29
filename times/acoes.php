<?php

    header('Content-Type: text/html; charset=utf-8');
    session_start();

    ob_start();
    include('../admin/dbcon/dbcon.php');

    $acao = $_POST['acao'];
    $video = $_POST['video'];

     if ($acao == "salvar") {
        
         $key = mysqli_real_escape_string($mysqli,$_POST['key']);
         $nome = mysqli_real_escape_string($mysqli,$_POST['nome']);
         $abrev = mysqli_real_escape_string($mysqli,$_POST['abrev']);
         $grupo = mysqli_real_escape_string($mysqli,$_POST['grupo']);
         $copa = mysqli_real_escape_string($mysqli,$_POST['copa']);
         
         $sql = "update teams set teams_name = UPPER('$nome'), short_name = UPPER('$abrev'), groups = UPPER('$grupo')  where admin_key = '$key';";
        
         if ($mysqli->query($sql) === TRUE) {
             echo "";
         } else {
             echo "Erro na base de dados: " . $mysqli->error;
         }
         
         //Ajuste de posicionamento dos times com a possível nova distribuição de grupos.
         $sqlgrupos = mysqli_query($mysqli,"select distinct groups from teams where cup_id = ".$copa);
         while ($times = mysqli_fetch_assoc($sqlgrupos)) {
             $position = "update teams t1 join (select @rownum:=@rownum+1 rank, p.id_teams
             from teams p, (SELECT @rownum:=0) r where p.groups = '".$times['groups']."' and cup_id = ".$copa." order by points desc, victories DESC, goals_balance DESC, goals_taken DESC) t2 on t1.id_teams = t2.id_teams set t1.rank = t2.rank;";
             mysqli_query($mysqli, $position);    
         }
         
    }else if ($acao == "marcar") {

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

        $match = $_POST['match'];
        $player = $_POST['player'];

        //JOGADA EM SI
        $sql = "INSERT INTO plays SET video_id='".$video."', datetime=NOW(), match_id=".$match.", plays_players_id=".$player.", plays_play_types_id=-1, available=1";
        //Setamos plays_play_types_id como -1 pra filtrar na hora de mostrar na página da partida, pra evitar mostrar repetido.

        if ($mysqli->query($sql) === TRUE) {
            echo "";
        } else {
            echo "Erro na base de dados: " . $mysqli->error;
        }

        //if ($tipo == 2 || $tipo == 3){
        //    $tipo = "3";
        //    $tipo_sql = "in (2,3)";
        //} else {
        //    $tipo_sql = " = ".$tipo;
        //}

        //if ($tipo <> 5 && $tipo <> 0){// Bola mucha não tá contando nas stats
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

           // if ($mysqli->query($stats) === TRUE) {
          //      echo "";
          //  } else {
           //     echo "Erro na base de dados: " . $mysqli->error;
           // } 
        //}

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

      //  if ($mysqli->query($stats2) === TRUE) {
       //     echo "";
      //  } else {
      //      echo "Erro na base de dados: " . $mysqli->error;
      //  }   
    } else if ($acao == "deletar"){
        $sql = "UPDATE plays SET available=0 WHERE video_id='".$video."'";

        if ($mysqli->query($sql) === TRUE) {
            echo "";
        } else {
            echo "Erro na base de dados: " . $mysqli->error;
        } 
    //Modelo de remoção genérico    
    } else if ($acao == "remover"){
        $table = $_POST['table'];
        $id_key = $_POST['id'];
        if ($table == "players"){
            $id_var = "id_players";
            $master = "players_team_id = players_team_id * -1";
        } else if ($table == "teams"){
            $id_var = "id_teams";
            $master = "cup_id = cup_id * -1";
        } else if ($table == "matches"){
            //No caso de partidas, temos que remover as marcações também
            $sql = "update notes set match_id = match_id * -1, player = player * -1 where match_id = '".$id_key."'";
            if ($mysqli->query($sql) === TRUE) {
                echo "";
            } else {
                echo "Erro na base de dados: " . $mysqli->error;
            }
            $id_var = "id";
            $master = "cup_id = cup_id * -1, team1 = team1 * -1, team2 = team2 * -1";
        }
        $sql = "update ".$table." set ".$master." where ".$id_var." = '".$id_key."'";

        if ($mysqli->query($sql) === TRUE) {
            echo "";
        } else {
            echo "Erro na base de dados: " . $mysqli->error;
        }

        //Atualizar caso seja delete de jogador
        $sql2 = " UPDATE teams t left JOIN (  select p.players_team_id, sum(1) as novos from players p group by players_team_id) AS p ON p.`players_team_id` = t.`id_teams`   SET  t.players_count = if(p.novos is null, 0 , p.novos);";
        if ($mysqli->query($sql2) === TRUE) {
            echo "";
        } else {
            echo "Erro na base de dados: " . $mysqli->error;
        }
    } 
    $mysqli->close();
?>