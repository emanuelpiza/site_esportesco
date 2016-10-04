<?php
    session_start();

    ob_start();
    include('../../admin/dbcon/dbcon.php');

    $acao = $_POST['acao'];
    if ($acao == "marcar"){
        
        $player = $_POST['player'];
        $type = $_POST['type'];
        $match = $_POST['match'];
        $field = $_POST['field'];
        $side = $_POST['side'];
        $nome = $_POST['nome'];

        //JOGADA EM SI
        $sql = "INSERT INTO notes SET player=$player, type=$type, match_id=$match, field=$field, right_side=$side, datetime=now(), available=1";

        $sqlgeral = mysqli_query($mysqli,$sql);

        echo "<pre>";
        print_r(" Anotação realizada para: ".$nome."\n");
        echo "</pre>";

    }else if ($acao == "deletar"){
        $id = $_POST['id'];
        $sql = "UPDATE notes SET available=0 WHERE id='".$id."'";
        mysqli_query($mysqli, $sql); 
        
    } else if ($acao == "encerrar"){
        $id = $_POST['id'];
        $team1 = $_POST['team1'];
        $team2 = $_POST['team2'];
        
        // GOLS
        $sqlgols = "update matches set score1 = (select count(*) as total from notes n left join players p on n.`player` = p.`id_players` where available = 1 and match_id = '$id' and ((type = 1 and p.`players_team_id` = ".$team1.") or (type = 4 and p.`players_team_id` = ".$team2."))) where id = '$id';";
        mysqli_query($mysqli, $sqlgols); 
        
        $sqlgols = "update matches set score2 = (select count(*) as total from notes n left join players p on n.`player` = p.`id_players` where available = 1 and match_id = '$id' and ((type = 1 and p.`players_team_id` = ".$team2.") or (type = 4 and p.`players_team_id` = ".$team1."))) where id = '$id';";
        mysqli_query($mysqli, $sqlgols); 
        
        // FALTAS
        $sqlfaltas = "update matches set faults1 = (select count(*) as total from notes n left join players p on n.`player` = p.`id_players` where available = 1 and match_id = '$id' and type = 0 and p.`players_team_id` = ".$team1.") where id = '$id';";
        mysqli_query($mysqli, $sqlfaltas); 
        
        $sqlfaltas = "update matches set faults2 = (select count(*) as total from notes n left join players p on n.`player` = p.`id_players` where available = 1 and match_id = '$id' and type = 0 and p.`players_team_id` = ".$team2.") where id = '$id';";
        mysqli_query($mysqli, $sqlfaltas); 
        
        // CARTÕES
        $sqlcartoes = "update matches set cards1 = (select count(*) as total from notes n left join players p on n.`player` = p.`id_players` where available = 1 and match_id = '$id' and type in (2,3) and p.`players_team_id` = ".$team1.") where id = '$id';";
        mysqli_query($mysqli, $sqlcartoes); 
        
        $sqlcartoes = "update matches set cards2 = (select count(*) as total from notes n left join players p on n.`player` = p.`id_players` where available = 1 and match_id = '$id' and type in (2,3) and p.`players_team_id` = ".$team2.") where id = '$id';";
        mysqli_query($mysqli, $sqlcartoes); 
        
        //Atualização das tabelas do campeonato
        $copa = 1;
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
        
        //PARTIDAS JOGADAS
        $partidas_jogadas = "
        UPDATE players p
            left JOIN (select player, count(distinct(match_id)) as partidas_jogadas from notes where available = 1 group by player) AS n ON
                    n.`player` = p.`id_players`
            SET p.`matches` = IF(n.partidas_jogadas is null, 0, n.partidas_jogadas) where cup_id = 1;";
        mysqli_query($mysqli, $partidas_jogadas);
        
        //GOLS
        $gols = "
            UPDATE players p
                RIGHT JOIN (
                   select n.player, sum(1) as novos from notes n where available = 1 and type = 1 group by player) AS n ON
                n.`player` = p.`id_players`
            SET
                p.goals = n.novos;";
        mysqli_query($mysqli, $gols);
        
        //COMPROMETIMENTO
        $comprometimento = "
          UPDATE players p
            RIGHT JOIN (
                select *, IF(partidas_jogadas*15>99, 99, IF(partidas_jogadas*15<10, 10, partidas_jogadas*15)) as comprometimento from ( 
                    select players_team_id, id_players, t.matches as partidas_total, p.`matches` as partidas_jogadas from players p left join teams t on p.players_team_id = t.`id_teams`) t
                ) AS n ON
                    n.`id_players` = p.`id_players`
            SET
		  p.`players_stats3` = n.comprometimento where cup_id = 1;";
        mysqli_query($mysqli, $comprometimento);    
        
        // NA BOLA
        $na_bola = "
            UPDATE players p
            left JOIN (
	           select player, count(1) as contagem from notes where available = 1 and type in (0,2,3) group by player) AS n ON n.`player` = p.`id_players`
            SET
		      p.`players_stats4` = IF(contagem is null,p.`matches`*15,IF(p.`matches`*15-contagem*5<10, 10, IF(p.`matches`*15-contagem*5>99, 99, p.`matches`*15-contagem*5))) where p.cup_id = 1;";
        mysqli_query($mysqli, $na_bola);
        
        // COLETIVAS
        $sql = "
            UPDATE players p
             left JOIN teams t on p.players_team_id = t.`id_teams`
            SET
		      p.`players_stats0` = IF(t.victories*15>99, 99, IF(t.victories*15<10, 10, t.victories*15)), 
		      p.`players_stats1` = IF(t.goals*2.5>99, 99, IF(t.goals*2.5<10, 10, t.goals*2.5)),
		      p.`players_stats5` = IF(15*t.matches-2.5*t.goals_taken<10, 10, IF(15*t.matches-2.5*t.goals_taken>99, 99, 15*t.matches-2.5*t.goals_taken)),
		      p.`players_stats_average` = (players_stats0 + players_stats1 + players_stats2 + players_stats3 + players_stats4 + players_stats5)/6  where t.cup_id = 1;";
        mysqli_query($mysqli, $sql);
    }
        
?>