<?php
    session_start();

    ob_start();
    include('../../admin/dbcon/dbcon.php');

    $acao = $_POST['acao'];
    $copa = $_POST['copa'];
    if (isset($_POST['match']))
    {
        $id = $_POST['match'];
    } else{
        $id = '';
    }

    if ($acao == "marcar"){
        
        $player = $_POST['player'];
        $type = $_POST['type'];
        $field = $_POST['field'];
        $side = $_POST['side'];
        $nome = $_POST['nome'];
        $camisa = $_POST['camisa'];
        $atualiza = $_POST['atualiza'];
        
        
        if ($atualiza == 1){
            $sql = "UPDATE players SET shirt = $camisa where id_players = $player";
            $sqlgeral = mysqli_query($mysqli,$sql);
        }

        //JOGADA EM SI
        $sql = "INSERT INTO notes SET player=$player, type=$type, match_id=$id, field=$field, right_side=$side, datetime=now(), available=1";

        $sqlgeral = mysqli_query($mysqli,$sql);
        
        $sqlgols = "update matches m set score1 = (select count(*) as total from notes n left join players p on n.`player` = p.`id_players` where available = 1 and match_id = '$id' and ((type = 1 and p.`players_team_id` = m.`team1`) or (type = 4 and p.`players_team_id` = m.team2))) where id = '$id';";
        mysqli_query($mysqli, $sqlgols); 
        
        $sqlgols = "update matches m set score2 = (select count(*) as total from notes n left join players p on n.`player` = p.`id_players` where available = 1 and match_id = '$id' and ((type = 1 and p.`players_team_id` = m.team2) or (type = 4 and p.`players_team_id` = m.team1))) where id = '$id';";
        mysqli_query($mysqli, $sqlgols); 

        echo "<pre>";
        print_r(" Anotação realizada para: $nome\n");
        echo "</pre>";

    }else if ($acao == "deletar"){
        $nota = $_POST['nota'];
        $sql = "UPDATE notes SET available=0 WHERE id='".$nota."'";
        mysqli_query($mysqli, $sql); 
        
        $sqlgols = "update matches m set score1 = (select count(*) as total from notes n left join players p on n.`player` = p.`id_players` where available = 1 and match_id = '$id' and ((type = 1 and p.`players_team_id` = m.`team1`) or (type = 4 and p.`players_team_id` = m.team2))) where id = '$id';";
        mysqli_query($mysqli, $sqlgols); 
        
        $sqlgols = "update matches m set score2 = (select count(*) as total from notes n left join players p on n.`player` = p.`id_players` where available = 1 and match_id = '$id' and ((type = 1 and p.`players_team_id` = m.team2) or (type = 4 and p.`players_team_id` = m.team1))) where id = '$id';";
        mysqli_query($mysqli, $sqlgols); 
    } else if ($acao == "encerrar_wo"){
        
        $perdedor_wo = $_POST['perdedor_wo'];
        $sql = "INSERT INTO notes SET type=13, match_id=$id, detail=$perdedor_wo, datetime=now(), available=1;";
        mysqli_query($mysqli, $sql); 
        
    } else if ($acao == "penalidade_equipe"){
        
        $penalidade_equipe = $_POST['penalidade_equipe'];
        $penalidade_pontos = $_POST['penalidade_pontos'];
        $sql = "delete from notes where type = 7 and detail = $penalidade_equipe and match_id = $id;";
        mysqli_query($mysqli, $sql); 
        $sql = "INSERT INTO notes SET type=7, match_id=$id, detail=$penalidade_equipe, right_side = $penalidade_pontos, datetime=now(), available=1;";
        mysqli_query($mysqli, $sql); 
        
    } else if ($acao == "encerrar"){
        
        //Só faz caso a partida ainda exista.
        if ($id <> ''){
            // GOLS CONSIDERANDO W.O.
            $sqlgols = "update matches m set score1 = IF((select distinct count(*) as total from notes n where type = 13 and available = 1 and match_id = '$id' and n.detail = m.team2) > 0, 3,(select count(*) as total from notes n left join players p on n.`player` = p.`id_players` where available = 1 and match_id = '$id' and ((type = 1 and p.`players_team_id` = m.team1) or (type = 4 and p.`players_team_id` = m.team2)))) where id = '$id';";
            mysqli_query($mysqli, $sqlgols); 

            $sqlgols = "update matches m set score2 = IF((select distinct count(*) as total from notes n where type = 13 and available = 1 and match_id = '$id' and n.detail = m.team1) > 0, 3,(select count(*) as total from notes n left join players p on n.`player` = p.`id_players` where available = 1 and match_id = '$id' and ((type = 1 and p.`players_team_id` = m.team2) or (type = 4 and p.`players_team_id` = m.team1)))) where id = '$id';";
            mysqli_query($mysqli, $sqlgols); 

            // FALTAS
            $sqlfaltas = "update matches m set faults1 = (select count(*) as total from notes n left join players p on n.`player` = p.`id_players` where available = 1 and match_id = '$id' and type = 0 and p.`players_team_id` = m.team1) where id = '$id';";
            mysqli_query($mysqli, $sqlfaltas); 

            $sqlfaltas = "update matches m set faults2 = (select count(*) as total from notes n left join players p on n.`player` = p.`id_players` where available = 1 and match_id = '$id' and type = 0 and p.`players_team_id` = m.team2) where id = '$id';";
            mysqli_query($mysqli, $sqlfaltas); 

            // CARTÕES
            $sqlcartoes = "update matches m set cards1 = (select count(*) as total from notes n left join players p on n.`player` = p.`id_players` where available = 1 and match_id = '$id' and type in (2,3) and p.`players_team_id` = m.team1) where id = '$id';";
            mysqli_query($mysqli, $sqlcartoes); 

            $sqlcartoes = "update matches m set cards2 = (select count(*) as total from notes n left join players p on n.`player` = p.`id_players` where available = 1 and match_id = '$id' and type in (2,3) and p.`players_team_id` = m.team2) where id = '$id';";
            mysqli_query($mysqli, $sqlcartoes); 
        }
        
        //Atualização das tabelas do campeonato
        $sqltimes = mysqli_query($mysqli,"select id_teams from teams where cup_id = ".$copa);
        while ($times = mysqli_fetch_assoc($sqltimes)) {
            $balance = "UPDATE teams SET goals_balance =
               (SELECT SUM(gols) FROM
                ( 
                    select sum(score1 - score2) gols from matches where team1 = ".$times['id_teams']." and phase = 0
                    UNION ALL
                    select sum(score2 - score1) gols from matches where team2 = ".$times['id_teams']." and phase = 0
                ) s) where id_teams = ".$times['id_teams'].";";
            mysqli_query($mysqli, $balance); 
            $balance2 = " update teams set goals_balance = 0 where goals_balance is null;";
            mysqli_query($mysqli, $balance2); 

            $goals_taken = "UPDATE teams SET goals_taken =
               (SELECT SUM(gols) FROM
                ( 
                    select sum(score2) gols from matches where team1 = ".$times['id_teams']." and phase = 0
                    UNION ALL
                    select sum(score1) gols from matches where team2 = ".$times['id_teams']." and phase = 0
                ) s) where id_teams = ".$times['id_teams'].";";
            mysqli_query($mysqli, $goals_taken); 
            $goals_taken2 = " update teams set goals_taken = 0 where goals_taken is null;";
            mysqli_query($mysqli, $goals_taken2); 
            
            $goals = "UPDATE teams SET goals =
               (SELECT SUM(gols) FROM
                ( 
                    select sum(score1) gols from matches where team1 = ".$times['id_teams']." and phase = 0
                    UNION ALL
                    select sum(score2) gols from matches where team2 = ".$times['id_teams']." and phase = 0
                ) s) where id_teams = ".$times['id_teams'].";";
            mysqli_query($mysqli, $goals); 
            $goals2 = " update teams set goals = 0 where goals is null;";
            mysqli_query($mysqli, $goals2); 
            
            $victories = "UPDATE teams SET victories = (SELECT SUM(count) FROM  (  select count(1) count from matches where team1 = ".$times['id_teams']." and score1 > score2 and phase = 0 UNION ALL select count(1) count from matches where team2 = ".$times['id_teams']." and score2 > score1  and phase = 0) s) where id_teams = ".$times['id_teams'].";";
            mysqli_query($mysqli, $victories); 
            $draws = "UPDATE teams SET draws = (select count(1) count from matches where (team1 = ".$times['id_teams']." or team2 = ".$times['id_teams'].") and score1 = score2 and datetime < NOW() and phase = 0 ) where id_teams = ".$times['id_teams'].";";
            mysqli_query($mysqli, $draws);     
            $losses = "UPDATE teams SET losses = (SELECT SUM(count) FROM ( select count(1) count from matches where team1 = ".$times['id_teams']." and score1 < score2 and phase = 0 UNION ALL select count(1) count from matches where team2 = ".$times['id_teams']." and score2 < score1  and phase = 0) s) where id_teams = ".$times['id_teams'].";";
            mysqli_query($mysqli, $losses);      
        }
        $points = "update teams t left join notes n on t.id_teams = n.detail set points = (t.victories*3 + t.`draws` - IF(n.right_side is null, 0, n.right_side)) where t.cup_id = ".$copa;
        mysqli_query($mysqli, $points);
        $matches = "UPDATE teams SET matches = (victories + draws + losses);";
        mysqli_query($mysqli, $matches);
        $sqlgrupos = mysqli_query($mysqli,"select distinct groups from teams where cup_id = ".$copa);
        while ($times = mysqli_fetch_assoc($sqlgrupos)) {
            $position = "update teams t1 join (select @rownum:=@rownum+1 rank, p.id_teams
            from teams p, (SELECT @rownum:=0) r where p.groups = '".$times['groups']."' and cup_id = ".$copa." order by points desc, victories DESC, goals_balance DESC, goals_taken) t2 on t1.id_teams = t2.id_teams set t1.rank = t2.rank;";
        mysqli_query($mysqli, $position);    
        }
        
        //PARTIDAS JOGADAS
        $partidas_jogadas = "
        UPDATE players p
            left JOIN (select player, count(distinct(match_id)) as partidas_jogadas from notes where available = 1 group by player) AS n ON
                    n.`player` = p.`id_players`
            left JOIN
                teams t on p.players_team_id = t.id_teams
            SET p.`matches` = IF(n.partidas_jogadas is null, 0, n.partidas_jogadas) where t.cup_id = ".$copa;
        mysqli_query($mysqli, $partidas_jogadas);
        
        //GOLS
        $gols = "
             UPDATE players p
                left JOIN (
                   select n.player, sum(1) as novos from notes n where available = 1 and type = 1 group by player) AS n ON
                n.`player` = p.`id_players`
            SET
                p.goals = if(n.novos is null, 0 , n.novos);";
        mysqli_query($mysqli, $gols);
        
        //Cartões Amarelos
        $amarelos = "
            UPDATE players p
                left JOIN (
                   select n.player, sum(1) as novos from notes n where available = 1 and type = 2 group by player) AS n ON
                n.`player` = p.`id_players`
            SET
                p.yellow_cards = if(n.novos is null, 0 , n.novos);";
        mysqli_query($mysqli, $amarelos);
        
        //Cartões Vermelhos
        $vermelhos = "
            UPDATE players p
                left JOIN (
                   select n.player, sum(1) as novos from notes n where available = 1 and type = 3 group by player) AS n ON
                n.`player` = p.`id_players`
            SET
                p.red_cards = if(n.novos is null, 0 , n.novos);";
        mysqli_query($mysqli, $vermelhos);
        
        //SUSPENSÕES
        $situation = "
            UPDATE players p SET situation = 
            IF (
                (p.red_cards > 0) and
                    (
                    (select date(n.datetime) from notes n where player = p.`id_players` and n.`type` = 3 order by n.datetime DESC limit 1) = 
                    (select date(m.datetime) from matches m where (m.`team1` = p.`players_team_id` or m.`team2` = p.`players_team_id`) and datetime < NOW() limit 1)
                ), 
                'Suspenso Vermelho', 
                IF(
                    (p.`yellow_cards` % 3 = 0) and 
                    (
                        (select date(n.datetime) from notes n where player = p.`id_players` and n.`type` = 2 order by n.datetime DESC limit 1) = 
                        (select date(m.datetime) from matches m where (m.`team1` = p.`players_team_id` or m.`team2` = p.`players_team_id`) and datetime < NOW() limit 1)
                    ),
                    'Suspenso Amarelo',
                    'Apto'
                )
            );";
        mysqli_query($mysqli, $situation);
        
        //COMPROMETIMENTO
        $comprometimento = "
          UPDATE players p
            RIGHT JOIN (
                select *, IF(partidas_jogadas*15>99, 99, IF(partidas_jogadas*15<10, 10, partidas_jogadas*15)) as comprometimento from ( 
                    select players_team_id, id_players, t.matches as partidas_total, p.`matches` as partidas_jogadas from players p left join teams t on p.players_team_id = t.`id_teams`) t
                ) AS n ON
                    n.`id_players` = p.`id_players`
            left JOIN
                teams t on p.players_team_id = t.id_teams
            SET
		  p.`players_stats3` = n.comprometimento where t.cup_id = ".$copa;
        mysqli_query($mysqli, $comprometimento);    
        
        // NA BOLA
        $na_bola = "
            UPDATE players p
            left JOIN (
	           select player, count(1) as contagem from notes where available = 1 and type in (0,2,3) group by player) AS n ON n.`player` = p.`id_players`
            left JOIN
                teams t on p.players_team_id = t.id_teams
            SET
		      p.`players_stats4` = IF(contagem is null,p.`matches`*15,IF(p.`matches`*15-contagem*5<10, 10, IF(p.`matches`*15-contagem*5>99, 99, p.`matches`*15-contagem*5))) where t.cup_id = ".$copa;
        mysqli_query($mysqli, $na_bola);
        
        // COLETIVAS
        $sql = "
            UPDATE players p
             left JOIN teams t on p.players_team_id = t.`id_teams`
            SET
		      p.`players_stats0` = IF(t.victories*15>99, 99, IF(t.victories*15<10, 10, t.victories*15)), 
		      p.`players_stats1` = IF(t.goals*2.5>99, 99, IF(t.goals*2.5<10, 10, t.goals*2.5)),
		      p.`players_stats5` = IF(15*t.matches-2.5*t.goals_taken<10, 10, IF(15*t.matches-2.5*t.goals_taken>99, 99, 15*t.matches-2.5*t.goals_taken)),
		      p.`players_stats_average` = (players_stats0 + players_stats1 + players_stats2 + players_stats3 + players_stats4 + players_stats5)/6  where t.cup_id = ".$copa;
        mysqli_query($mysqli, $sql);
    } 
?>