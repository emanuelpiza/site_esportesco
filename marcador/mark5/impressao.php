<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();

    ob_start();
    include('../../admin/dbcon/dbcon.php');

    if (isset($_SESSION["logname"])) {
        $_SESSION["error1"] = "Please Sign in";
        header("Location: index.php");
    }
    $id = $_GET['id'];
    $sqlgeral = mysqli_query($mysqli,"SELECT *, 
                                    t1.teams_picture as t1_picture,
                                    t1.teams_name as t1_name,
                                    t2.teams_name as t2_name,
                                    t2.teams_picture as t2_picture,
                                    date_format(m.datetime, '%hh%i') as hour, 
                                    date_format(m.datetime,'%d/%m') as date 
                                    FROM matches as m 
                                    left join teams t1 
                                        on m.team1 = t1.`id_teams` 
                                    left join teams as t2 
                                    on m.team2 = t2.id_teams where m.id='$id'");
    $dados = mysqli_fetch_assoc($sqlgeral);
    $id_team1 = $dados['team1'];
    $id_team2 = $dados['team2'];
    $sqlgols = mysqli_query($mysqli,"select IF((select score1 from matches where id = '$id') is not null, (select score1 from matches where id = '$id'), (select count(*) from notes n left join players p on n.`player` = p.`id_players` where available = 1 and match_id = '$id' and ((type = 1 and p.`players_team_id` = ".$id_team1.") or (type = 4 and p.`players_team_id` = ".$id_team2.")))) as total;");
    $gols1 = mysqli_fetch_assoc($sqlgols);    
    $sqlgols = mysqli_query($mysqli,"select IF((select score2 from matches where id = '$id') is not null, (select score2 from matches where id = '$id'), (select count(*) from notes n left join players p on n.`player` = p.`id_players` where available = 1 and match_id = '$id' and ((type = 1 and p.`players_team_id` = ".$id_team2.") or (type = 4 and p.`players_team_id` = ".$id_team1.")))) as total;");
    $gols2 = mysqli_fetch_assoc($sqlgols);

    $sqlfaltas = mysqli_query($mysqli,"select count(*) as total from notes n left join players p on n.`player` = p.`id_players` where available = 1 and match_id = '$id' and type in (0,2,3) and p.`players_team_id` = ".$id_team1." and datetime < (select if(EXISTS( SELECT * FROM notes n where match_id = '$id' and type = 11), (select datetime from notes where match_id = '$id' and type = 11), NOW()));");
    $faltas1 = mysqli_fetch_assoc($sqlfaltas);    
    $sqlfaltas = mysqli_query($mysqli,"select count(*) as total from notes n left join players p on n.`player` = p.`id_players` where available = 1 and match_id = '$id' and type in (0,2,3) and p.`players_team_id` = ".$id_team2." and datetime < (select if(EXISTS( SELECT * FROM notes n where match_id = '$id' and type = 11), (select datetime from notes where match_id = '$id' and type = 11), NOW()));");
    $faltas2 = mysqli_fetch_assoc($sqlfaltas);

    $sqlfaltas = mysqli_query($mysqli,"select count(*) as total from notes n left join players p on n.`player` = p.`id_players` where available = 1 and match_id = '$id' and type in (0,2,3) and p.`players_team_id` = ".$id_team1." and datetime > (select datetime from notes where match_id = '$id' and type = 11);");
    $faltas1_seg = mysqli_fetch_assoc($sqlfaltas);    
    $sqlfaltas = mysqli_query($mysqli,"select count(*) as total from notes n left join players p on n.`player` = p.`id_players` where available = 1 and match_id = '$id' and type in (0,2,3) and p.`players_team_id` = ".$id_team2." and datetime > (select datetime from notes where match_id = '$id' and type = 11);");
    $faltas2_seg = mysqli_fetch_assoc($sqlfaltas);


    $sql_inicio_fim = mysqli_query($mysqli,"select count(*) as total from notes n left join players p on n.`player` = p.`id_players` where available = 1 and match_id = '$id' and type = 0 and p.`players_team_id` = ".$id_team1.";");
    $inicio_fim = mysqli_fetch_assoc($sql_inicio_fim);  

    $sqlteam1 = mysqli_query($mysqli,"SELECT * FROM players where players_team_id=".$id_team1);
    $sqlteam2 = mysqli_query($mysqli,"SELECT * FROM players where players_team_id=".$id_team2);
    $sql_notes = mysqli_query($mysqli,"select p1.*, p2.`players_name` from (
	SELECT t1.`id`, t1.`match_id`,
        DATE_FORMAT(t1.`datetime`,'%H:%i:%s') as datetime,
        t1.`type`,
        t1.`player`,
        t1.`available`, 
        '' as detail
    FROM notes t1
    LEFT JOIN plays t2 ON t2.`datetime` = t1.`datetime`
    UNION
    SELECT 
        t2.`id_plays` as id,
        t2.`match_id`,
        DATE_FORMAT(t2.`datetime`,'%H:%i:%s') as datetime,
        (6) as type , 
        t2.`plays_players_id` as player,
        t2.`video_id` as detail,
        t2.`available`
    FROM notes t1
    RIGHT JOIN plays t2 ON t2.`datetime` = t1.`datetime` where t2.`available` in (1,2) ) p1 left join players p2 on p1.player = p2.`id_players` where match_id ='$id' and available = 1  order by p1.`datetime` DESC;");

    $sql_fase = mysqli_query($mysqli,"select IF(MAX(type) is null, 0, MAX(type)) as maximo from notes n where match_id = '$id';");
    $fase = mysqli_fetch_assoc($sql_fase)['maximo'];

    if ($fase < 10){
        $estilo_btn_fase = "btn-success";
        $texto_btn_fase = "Iniciar partida";
        $momento = "inicio_1";
        $botao_wo_t1 =   "<button type='button' class='btn btn-danger' style='width:120px; margin-bottom:50px;' title='Encerrar' onclick='encerrar_wo($id_team1)'>Equipe Ausente.<br>Indicar W.O.</button>";
        $botao_wo_t2 =   "<button type='button' class='btn btn-danger' style='width:120px; margin-bottom:50px;' title='Encerrar' onclick='encerrar_wo($id_team2)'>Equipe Ausente.<br>Indicar W.O.</button>";
    }else if ($fase == 10){
        $estilo_btn_fase = "btn-danger";
        $texto_btn_fase = "Encerrar primeiro tempo";
        $momento = "fim_1";
    } else if ($fase == 11){
        $estilo_btn_fase = "btn-success";
        $texto_btn_fase = "Iniciar segundo tempo";
        $momento = "inicio_2";
    } else {
        $estilo_btn_fase = "btn-danger";
        $texto_btn_fase = "Encerrar partida e Atualizar Classificações";
        $momento = "encerrar";
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br" dir="ltr">
<head>
	<title>Esportes.co - <?php echo $id;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Javascript - Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
      
    <!-- Javascript - Bootstrap -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    
    <!-- Javascript - Nosso -->
    <script src="actions.js" type="text/javascript"></script>

    <!-- CSS - Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    
    <!-- CSS - FontAwesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    
    <!-- CSS - Nosso -->    
	<link href="style.css" type="text/css" rel="stylesheet" />    
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Emanuel Piza" >

    <!-- Javascript - Nosso 
    <script src="marcador.js" type="text/javascript"></script>-->
    
    <!-- Sweet Alert -->
    <script src="../../../js/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../../css/sweetalert.css">
    
    <title><?php echo $dados['team1_name']; ?> vs <?php echo $dados['team2_name']; ?> - EsportesCo</title>

   <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../../css/AdminLTE.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../../../css/_all-skins.min.css">
    <!-- Ícones -->
    <link rel="icon" type="image/png" href="../../img/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="../../img/favicon-16x16.png" sizes="16x16" />
     <!-- jQuery -->
    <style>
            .rubber_stamp {
              font-family: 'Vollkorn', serif;
              font-size: 12px;
              line-height: 12px;
              text-transform: uppercase;
              font-weight: bolder;
              color: white;
              border: 2px solid white;
              padding: 10px 7px;
              border-radius: 10px;

              opacity: 0.8;
              -webkit-transform: rotate(-10deg);
              -o-transform: rotate(-10deg);
              -moz-transform: rotate(-10deg);
              -ms-transform: rotate(-10deg);
              position:absolute;
              margin-top:-30px;
              margin-left: auto; 
              margin-right: auto;
              margin-left:100px;
              text-align:center;
              filter:alpha(opacity=80);
              opacity:0.8;
              box-shadow: 0 0 2px white;
                background-color: black;
            }
            .rubber_stamp::after {
              position: absolute;
              content: " ";
              width: 100%;
              height: auto;
              min-height: 100%;
              padding: 10px;
            }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 5px;
            text-align: left;
        }
    </style>
</head>
<body id="<?php echo $id;?>">
    
    <div class="row">
        
        <div class="col-lg-5">
            <span>
                Competição: Copa Metropolitana
                <br>Local: Campo Cadastrado
                <br>Auxiliar 1:
                <br>Auxiliar 2: 
            </span>
            
         <button class="btn-success hidden-print" onclick="myFunction()" style="margin-top:20px; margin-left:20px; width:80px;">Imprimir</button>
        </div>
        <div class="col-lg-5">
            <span>Árbitro:<br>Observador:</span>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6 col-md-offset-3" style="margin-top:-20px; margin-bottom:-10px;">

            <div class="col-xs-5" style="text-align:right;">
                <h3 style="margin-right:-30px;"><?php echo $dados['t1_name']; ?></h3>
            </div>

            <div class="col-xs-2 center-block" style="text-align:center;">
                <span style="font-family: Roboto, Arial, serif; font-size:10px;"><?php echo $dados['date']; ?> às <?php echo $dados['hour']; ?></span>
                <br>X
            </div>
            
            <div class="col-xs-5">
                <h3 style="margin-left:-30px;"><?php echo $dados['t2_name']; ?></h3></div>
        </div>
    </div>
    
    <div class="row" style="margin-top:0px;">
        <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1" style="text-align:center;">
            <div class="row">
            <table style="width:95%; margin-left:20px; font-size:11px;">
              <tr>
                <th style="width:50px;">Número</th>
                <th>Atleta</th>
                <th style="width:50px;">Registro</th>
                <th style="width:50px;">Número</th>
                <th>Atleta</th>
                <th style="width:50px;">Registro</th>
              </tr>
             
                <?php 
                    for($i = 0; $i < 25; $i++)
                    { 
                        echo "<tr>";
                        if($team1 = $sqlteam1 -> fetch_assoc())
                            {
                                if  ($team1['situation'] != "Apto"){
                                      echo "<td>Suspenso</td>"; 
                                        }
                                else {
                                      echo "<td>".$team1["shirt"]."</td>"; 
                                }
                                echo "<td style='padding-top: 0px; height:30px;'>".$team1["players_name"]."</td>"; 
                                echo "<td>".$team1["id_players"]."</td>"; 
                            }
                        else{
                            echo "
                                    <td style='height:30px;'>
                                    <td></td>
                                    <td></td>";
                        };
                        if($team2 = $sqlteam2 -> fetch_assoc())
                            {
                                if  ($team2['situation'] != "Apto"){
                                      echo "<td>Suspenso</td>"; 
                                        }
                                else {
                                      echo "<td>".$team1["shirt"]."</td>"; 
                                }
                                echo "<td style='padding-top: 0px; height:30px;'>".$team2["players_name"]."</td>"; 
                                echo "<td>".$team2["id_players"]."</td>"; 
                            }
                        else{
                            echo "
                                    <td style='height:30px;'></td>
                                    <td></td>
                                    <td></td>";
                        };
                        echo "</tr>";
                    }
                ?>
            </table>
            </div>
        </div>
    </div>
    
     <div class="row" style="margin-top:0px;">
        <div class="col-md-6 col-md-offset-3">

            <div class="col-xs-5">
                <hr>
                <hr>
                <hr>
                <hr>
                <hr>
                <hr>
            </div>

            <div class="col-xs-2 center-block" style="text-align:center; font-size:15px;">
                <span style="font-family: Roboto, Arial, serif;">
                    Diretor<br>R.G.<br>Treinador<br>R.G.<br>Massagista<br>R.G.</span>
            </div>
            
             <div class="col-xs-5">
                <hr>
                <hr>
                <hr>
                <hr>
                <hr>
                <hr>
            </div>
        </div>
    </div>
    

<script>
function myFunction() {
    window.print();
}
</script>
</body>
</html>
