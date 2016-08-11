<?php
 
    header('Content-Type: text/html; charset=utf-8');
    session_start();

    ob_start();
    include('./admin/dbcon/dbcon.php');

    include ("./classes/PHPExcel/IOFactory.php");  

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);


    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "Arquivo ". basename( $_FILES["fileToUpload"]["name"]). " atualizado.";
    } else {
        echo "<h3>É necessário carregar o arquivo antes de atualizar a base de dados.<br> <a href='http://www.esportes.co/painel.php'>Voltar</a></h3> ";
    }

    $copa = 1;
    $sqlcount_id = mysqli_query($mysqli,"select max(cup_player_id) as maximo from players where cup_id = ".$copa);
    $max_jogadores = mysqli_fetch_assoc($sqlcount_id)['maximo'];
    $sqlcount_id = mysqli_query($mysqli,"select max(match_cup_id) as maximo from matches where cup_id = ".$copa);
    $max_partidas = mysqli_fetch_assoc($sqlcount_id)['maximo'];
    $objPHPExcel = PHPExcel_IOFactory::load($target_file);  

    $jogadores = $objPHPExcel->getSheetByName("Jogadores"); 
    $html="<br>Jogadores:<br><table border='1'>";  
    $highestRow = $jogadores->getHighestRow();  
    for ($row=2; $row<=$highestRow; $row++)  
    {  
        $nome = mysqli_real_escape_string($mysqli, $jogadores->getCellByColumnAndRow(1, $row)->getValue()); 
        if ($nome <> null ){
            $id = mysqli_real_escape_string($mysqli, $jogadores->getCellByColumnAndRow(0, $row)->getValue()); 
            $team_name = mysqli_real_escape_string($mysqli, $jogadores->getCellByColumnAndRow(2, $row)->getValue());  
            $shirt = mysqli_real_escape_string($mysqli, $jogadores->getCellByColumnAndRow(3, $row)->getValue());  
            $goals = mysqli_real_escape_string($mysqli, $jogadores->getCellByColumnAndRow(4, $row)->getValue());  
            $goals_taken = mysqli_real_escape_string($mysqli, $jogadores->getCellByColumnAndRow(5, $row)->getValue());  
            $yellow_cards = mysqli_real_escape_string($mysqli, $jogadores->getCellByColumnAndRow(6, $row)->getValue());  
            $red_cards = mysqli_real_escape_string($mysqli, $jogadores->getCellByColumnAndRow(7, $row)->getValue()); 
            $html.="<tr>";  
            if ($id > $max_jogadores){
                $sql = "INSERT INTO players(players_name, players_team_id, shirt, goals, goals_taken, yellow_cards, red_cards, cup_player_id, cup_id) VALUES ('".$nome."', (select id_teams from teams where teams_name  = '".$team_name."'), '".$shirt."', '".$goals."', '".$goals_taken."', '".$yellow_cards."', '".$red_cards."', '".$id."', ".$copa.")";  
                mysqli_query($mysqli, $sql);  
                $html .= '<td>Inserido</td>';    
            }else{ 
                $sql = "UPDATE players SET players_name = '".$nome."', players_team_id = (select id_teams from teams where teams_name  = '".$team_name."'), shirt = '".$shirt."', goals = '".$goals."', goals_taken = '".$goals_taken."', yellow_cards = '".$yellow_cards."', red_cards = '".$red_cards."' where cup_player_id = ".$id." and cup_id =".$copa;  
                mysqli_query($mysqli, $sql);  
                $html .= '<td>Atualizado:</td>';     
            }
            $html .= '<td>'.$id.'</td>';  
            $html .= '<td>'.$nome.'</td>';  
            $html .= '<td>'.$team_name.'</td>';  
            $html .= '<td>Camisa:'.$shirt.'</td>';  
            $html .= '<td>Gols:'.$goals.'</td>';  
            $html .= '<td>Gols Sofridos:'.$goals_taken.'</td>';  
            $html .= '<td>Cartões amarelos:'.$yellow_cards.'</td>';  
            $html .= '<td>Cartões vermelhos:'.$red_cards.'</td>';  
            $html .= "</tr>";  
        }
    }

    $partidas = $objPHPExcel->getSheetByName("Partidas");
    $html .="</table><br>Partidas:<br><table border='1'>";  
    $highestRow = $partidas->getHighestRow();  
    for ($row=2; $row<=$highestRow; $row++)  
    {    
        $datetime = mysqli_real_escape_string($mysqli, $partidas->getCellByColumnAndRow(2, $row)->getValue());
        if ($datetime <> null ){
            $id = mysqli_real_escape_string($mysqli, $partidas->getCellByColumnAndRow(0, $row)->getValue()); 
            $field = mysqli_real_escape_string($mysqli, $partidas->getCellByColumnAndRow(1, $row)->getValue());  
            $team1 = mysqli_real_escape_string($mysqli, $partidas->getCellByColumnAndRow(3, $row)->getValue());  
            $score1 = mysqli_real_escape_string($mysqli, $partidas->getCellByColumnAndRow(4, $row)->getValue());  
            $team2 = mysqli_real_escape_string($mysqli, $partidas->getCellByColumnAndRow(5, $row)->getValue());  
            $score2 = mysqli_real_escape_string($mysqli, $partidas->getCellByColumnAndRow(6, $row)->getValue());
            $html.="<tr>";
            if ($id > $max_partidas){
                $sql = "INSERT INTO matches (cup_id, match_cup_id, datetime, field_id, team1, team2, score1, score2) VALUES (".$copa.", ".$id.", '".$datetime."', ".$field.", (select id_teams from teams where teams_name  = '".$team1."'), (select id_teams from teams where teams_name  = '".$team2."'), '".$score1."', '".$score2."')";  
                mysqli_query($mysqli, $sql);
                $html .= '<td>Inserido:</td>';    
            }else{ 
                $sql = "UPDATE matches SET datetime = '".$datetime."', field_id = '".$field."', team1 = (select id_teams from teams where teams_name  = '".$team1."'), team2 = (select id_teams from teams where teams_name  = '".$team2."'), score1 = '".$score1."', score2 = '".$score2."' where match_cup_id = ".$id." and cup_id=".$copa;  
                mysqli_query($mysqli, $sql);  
                $html .= '<td>Atualizado:</td>'; 
            } 
            $html .= '<td>'.$id.'</td>';  
            $html .= '<td>Campo:'.$field.'</td>';  
            $html .= '<td>Data hora: '.$datetime.'</td>';  
            $html .= '<td>'.$team1.'</td>';  
            $html .= '<td>Gols:'.$score1.'</td>';  
            $html .= '<td>'.$team2.'</td>';  
            $html .= '<td>Gols:'.$score2.'</td>';  
            $html .= "</tr>";             
        }
    }  
    $html .= '</table>';

    //Gambi pro futuro não ficar zerado 
    $futuro = "update matches m set m.score1 = null, m.score2 = null where datetime > now();";
    mysqli_query($mysqli, $futuro);

    $sqltimes = mysqli_query($mysqli,"select id_teams from teams where cup_id = ".$copa);
    while ($times = mysqli_fetch_assoc($sqltimes)) {
        $balance = "UPDATE teams SET goals_balance =
	       (SELECT SUM(gols) FROM
            ( 
                select sum(score1 - score2) gols from matches where team1 = ".$times['id_teams']."
                UNION ALL
                select sum(score2 - score1) gols from matches where team2 = ".$times['id_teams']."
            ) s) where id_teams = ".$times['id_teams'].";";
        mysqli_query($mysqli, $balance); 
        $goals = "UPDATE teams SET goals =
	       (SELECT SUM(gols) FROM
            ( 
                select sum(score1) gols from matches where team1 = ".$times['id_teams']."
                UNION ALL
                select sum(score2) gols from matches where team2 = ".$times['id_teams']."
            ) s) where id_teams = ".$times['id_teams'].";";
        mysqli_query($mysqli, goals); 
        $goals_taken = "UPDATE teams SET goals_taken =
	       (SELECT SUM(gols) FROM
            ( 
                select sum(score2) gols from matches where team1 = ".$times['id_teams']."
                UNION ALL
                select sum(score1) gols from matches where team2 = ".$times['id_teams']."
            ) s) where id_teams = ".$times['id_teams'].";";
        mysqli_query($mysqli, $goals_taken); 
        $victories = "UPDATE teams SET victories = (SELECT SUM(count) FROM  (  select count(1) count from matches where team1 = ".$times['id_teams']." and score1 > score2 UNION ALL select count(1) count from matches where team2 = ".$times['id_teams']." and score2 > score1 ) s) where id_teams = ".$times['id_teams'].";";
        mysqli_query($mysqli, $victories); 
        $draws = "UPDATE teams SET draws = (select count(1) count from matches where (team1 = ".$times['id_teams']." or team2 = ".$times['id_teams'].") and score1 = score2 and datetime < NOW() ) where id_teams = ".$times['id_teams'].";";
        mysqli_query($mysqli, $draws);     
        $losses = "UPDATE teams SET losses = (SELECT SUM(count) FROM  (  select count(1) count from matches where team1 = ".$times['id_teams']." and score1 < score2 UNION ALL select count(1) count from matches where team2 = ".$times['id_teams']." and score2 < score1 ) s) where id_teams = ".$times['id_teams'].";";
        mysqli_query($mysqli, $losses);      
    }
    $points = "UPDATE teams SET points = (victories * 3 + draws);";
    mysqli_query($mysqli, $points);
    $matches = "UPDATE teams SET matches = (victories + draws + losses);";
    mysqli_query($mysqli, $matches);
    $sqlgrupos = mysqli_query($mysqli,"select distinct groups from teams where cup_id = ".$copa);
    while ($times = mysqli_fetch_assoc($sqlgrupos)) {
        $position = "update teams t1 join (select @rownum:=@rownum+1 rank, p.id_teams
        from teams p, (SELECT @rownum:=0) r where p.groups = '".$times['groups']."' 
        order by points desc, goals_balance DESC) t2 on t1.id_teams = t2.id_teams set t1.rank = t2.rank;";
    mysqli_query($mysqli, $position);    
    }
    echo $html;   
    $redirect = "http://www.esportes.co/times/copa.php";
    #abaixo, chamamos a função header() com o atributo location: apontando para a variavel $redirect, que por 
    #sua vez aponta para o endereço de onde ocorrerá o redirecionamento
    header("location:$redirect");
?>