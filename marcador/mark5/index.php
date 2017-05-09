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
                                    t1.short_name as t1_short, 
                                    t2.teams_picture as t2_picture,
                                    t2.short_name as t2_short,
                                    n1.right_side as t1_penalty, 
                                    n2.right_side as t2_penalty 
                                    FROM matches as m 
                                    left join teams t1 
                                        on m.team1 = t1.`id_teams` 
                                    left join teams t2 
                                    on m.team2 = t2.id_teams left join
                                    cups c on m.cup_id = c.id left join notes n1 on m.team1 = n1.detail and m.id = n1.match_id left join notes n2 on m.team2 = n2.detail and m.id = n2.match_id where m.id='$id'");

    $dados = mysqli_fetch_assoc($sqlgeral);
    $id_team1 = $dados['team1'];
    $id_team2 = $dados['team2'];
    $penalty_team1 = $dados['t1_penalty'];
    $penalty_team2 = $dados['t2_penalty'];
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

    $sqlteam1 = mysqli_query($mysqli,"SELECT *, LEFT(whole_name , 20) as whole_name FROM players where players_team_id=".$id_team1." order by whole_name, shirt");
    $sqlteam2 = mysqli_query($mysqli,"SELECT *, LEFT(whole_name , 20) as whole_name FROM players where players_team_id=".$id_team2." order by whole_name, shirt");
    $sql_notes = mysqli_query($mysqli,"select p1.*, p2.`whole_name` from (
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

    //Gestão da partida.
    $botao_wo_t1 =   "<button type='button btn-sm' class='btn btn-danger' style='width:120px; margin-bottom:50px;' title='Encerrar' onclick='encerrar_wo($id_team1)'>Indicar W.O.</button>";
    $botao_wo_t2 =   "<button type='button btn-sm' class='btn btn-danger' style='width:120px; margin-bottom:50px;' title='Encerrar' onclick='encerrar_wo($id_team2)'>Indicar W.O.</button>";

    //Contagem de faltas por tempo?
    if ($dados['real_time'] == 0){
        $estilo_btn_fase = "btn-danger";
        $texto_btn_fase = "Encerrar partida e Atualizar Classificações";
        $momento = "encerrar";
    }else{
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
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br" dir="ltr">
<head>
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
    <script src="../../js/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../css/sweetalert.css">
    
    <title><?php echo $dados['t1_short']; ?> vs <?php echo $dados['t2_short']; ?> - EsportesCo</title>

   <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../css/AdminLTE.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../../css/_all-skins.min.css">
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
        
            .modal { 
                  width: 100%;
                  left: 0;
                  right: 0;
                  top: 800px;
                  bottom: 0;
                  margin: auto;
                  position: absolute;
                  background-color: transparent;
            }

            .modal-body { 
                  display: inline-block; 
                  background-color: #FFF;
            }

            .modal img { min-width: none!important;
            }
		</style>
    
</head>
<body id="<?php echo $id;?>">
       <div class="row" style="margin-bottom:10px;">
         <div class="col-md-6 col-md-offset-3">

            <div class="col-xs-4" style="text-align:right; padding:0;">
                <img src="../../cadastro/uploads/<?php echo $dados['t1_picture']; ?>" style="width:80px; margin-right:5px;">
            </div>

            <div  class="col-xs-1" style="text-align:center; font-size:15px;padding:0;">
                <span style="font-family: Arial, serif; font-size:60px;text-align:left; margin-right:-25px; margin-left:-15px; color:black;font-weight:bolder;"><?php echo $gols1['total']; ?></span>
            </div>

      <div  class="col-xs-2 center-block" style="text-align:center; font-size:30px; margin-top:20px;">X</div>

            <div  class="col-xs-1" style="text-align:center; font-size:15px; padding:0;">
                <span style="font-family: Arial, serif; font-size:60px;text-align:left; margin-left:-25px; color:black;font-weight:bolder;"><?php echo $gols2['total']; ?></span>
            </div>

            <div  class="col-xs-4" style="padding:0;">
                <img src="../../cadastro/uploads/<?php echo $dados['t2_picture']; ?>" style="width:80px; margin-left:5px">
          </div>
    </div>
    </div>
    <div class="row" style="text-align:center;">
        <a id="button" class="btn btn-sm btn-secondary" href="#" style="margin: 0 auto;">Penalizações</a>
    </div>
    
    
    
    <div class="row hiders" style="
    display: none;">
        <div class="col-md-6 col-md-offset-3">
            <div  class="col-xs-1 col-xs-offset-1" style="text-align:center; font-size:15px;padding:0;">
                <?php echo $botao_wo_t1; ?>
            </div>
            <div  class="col-xs-1 col-xs-offset-5" style="text-align:center; font-size:15px;padding:0;">
                <?php echo $botao_wo_t2; ?>
            </div>
        </div>
    </div>
    <div class="row hiders" style="margin-bottom:10px;
    display: none;">
         <div class="col-md-6 col-md-offset-3">

            <div  class="col-xs-1 col-xs-offset-2" style="text-align:center; font-size:15px;padding:0;">
                <span style="font-family: Arial, serif; font-size:12px;text-align:center; margin-right:-25px; margin-left:-15px; color:black;font-weight:bolder;">
                    Penalizar Equipe<br></span>
                    <input type="text" id="team1_penalty" value="<?php echo $penalty_team1; ?>"  style="width:80px;" onkeydown="alterar('team1_pen')" placeholder="x pontos">
                <button type="button" id="team1_pen_btn" class="btn btn-success btn-xs" style="display: none; width:60px; margin-top:0px;" onclick="salvar_penalidade('team1', '<?php echo $id_team1;?>')"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
            </div>

            <div  class="col-xs-1 col-xs-offset-5" style="text-align:center; font-size:15px; padding:0;">
                <span style="font-family: Arial, serif; font-size:12px;text-align:center; margin-right:-25px; margin-left:-15px; color:black;font-weight:bolder;">
                    Penalizar Equipe<br></span>
                    <input type="text" style="width:80px;"  id="team2_penalty" value="<?php echo $penalty_team2 ?>"  style="padding-left:5px;padding-right:0px;" onkeydown="alterar('team2_pen')"  placeholder="x pontos">
                <button type="button" id="team2_pen_btn" class="btn btn-success btn-xs" style="display: none; width:60px; margin-top:0px;" onclick="salvar_penalidade('team2', '<?php echo $id_team2;?>')"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
            </div>
        </div>
    </div>
    
    <div class="row" style="margin-bottom:10px;">
         <div class="col-md-6 col-md-offset-3">

            <div  class="col-xs-1 col-xs-offset-2" style="text-align:center; font-size:15px;padding:0;">
                <span style="font-family: Arial, serif; font-size:12px;text-align:center; margin-right:-25px; margin-left:-15px; color:black;font-weight:bolder;">
                    Faltas<br>
                    T1: <?php echo $faltas1['total']; ?><br>
                    T2: <?php echo $faltas1_seg['total']; ?><br></span>
            </div>

            <div  class="col-xs-1 col-xs-offset-5" style="text-align:center; font-size:15px; padding:0;">
                <span style="font-family: Arial, serif; font-size:12px;text-align:left; margin-right:-25px; color:black;font-weight:bolder; margin-left:-15px; ">
                    Faltas<br>
                    T1: <?php echo $faltas2['total']; ?><br>
                    T2: <?php echo $faltas2_seg['total']; ?><br></span>
            </div>
    </div>
    </div>
    <div class="row">
        <form name="f" id="f" onSubmit="return false">
            <div class="col-xs-12 col-sm-12 col-md-offset-3 col-md-6 cfeature infos col-lg-offset-3 col-lg-6">
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <ul class="options" id="ul_esq" style=" text-align:center;">
                            <?php 
                            while ($team1 = mysqli_fetch_assoc($sqlteam1)) {
                            if  ($team1['situation'] != "Apto"){
                                $enfeite = '<div class="rubber_stamp">Suspenso</div></i>';
                                    }
                            else {
                                $enfeite = '';
                            }
                            echo "<button type='button' class='btn btn-primary btn-sm' style='width:150px;' onclick=\x22selecionar_jogador(&quot;" . $team1['id_players'] . "&quot;, &quot;" . $team1['shirt'] . "&quot;)\x22 id='" . $team1['id_players'] . "' value='" . $team1['id_players'] . "'>" . $team1['shirt'] . " - " . $team1['whole_name'].$enfeite;
                            } ?>
                        </ul>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                         <ul class="options" id="ul_esq" style="text-align:center;">
                            <?php while ($team2 = mysqli_fetch_assoc($sqlteam2)) {
                                if  ($team2['situation'] != "Apto"){
                                    $enfeite = '<div class="rubber_stamp">Suspenso</div></i>';
                                        }
                                else {
                                    $enfeite = '';
                                }
                            echo "<button type='button' class='btn btn-primary btn-sm'  style='width:150px;'  onclick=\x22selecionar_jogador(&quot;" . $team2['id_players'] . "&quot;, &quot;" . $team2['shirt'] . "&quot;)\x22 id='" . $team2['id_players'] . "' value='" . $team2['id_players'] . "'>" . $team2['shirt'] . " - " . $team2['whole_name'].$enfeite;
                            } ?>
                        </ul>
                    </div>
                </div>

                <div class="row" class="col-xs-6 col-sm-offset-5 col-sm-2 col-md-offset-5 col-md-3" style="text-align:center;">
                   <!-- <button id="atualiza" class="btn btn-lg btn-success">Atualizar Times</button>-->
                </div>
                <div class="row" class="col-xs-6 col-sm-offset-5 col-sm-2 col-md-offset-5 col-md-3" style="text-align:center;">
                    <div id="d" class="row" style="margin-left:20px"></div>	
                </div>
            </div>
        </form>   
    </div>
    
      <div  class="col-md-4 text-center col-md-offset-4" style="text-align:center; font-size:30px; margin-top:20px;">
        <button type="button" class="btn <?php echo $estilo_btn_fase ?>" style="width:270px; margin-bottom:50px;" title="Encerrar" onclick='<?php echo $momento ?>()'><?php echo $texto_btn_fase ?></button>
    </div>
    
    <div class="row">  
        <div class="col-md-8 col-md-offset-2">
             <section class="content-header">
          <h1>
            Lances
          </h1>
        </section>

        <!-- Main content -->
        <section class="content">

          <!-- row -->
          <div class="row">
            <div class="col-md-12">
              <!-- The time line -->
              <ul class="timeline">
                <!-- timeline time label -->
                <li class="time-label">
                  <span class="bg-gray">
                    Fim de Jogo
                  </span>
                </li>
                  <?php while ($notes = mysqli_fetch_assoc($sql_notes)) {
                    if ($notes['type'] == 0){
                        echo '<li><i class="fa fa-square-o bg-white" style="color:black;"></i>
                            <div class="timeline-item">
                             <button type="button" class="btn btn-box-tool" style="width:10px;float:right; margin-top:-5px; margin-right:10px;" onclick=\'deletar("' . $notes['id'] . '")\' title="Remover"><i class="fa fa-times"></i></button>
                            <span class="time"><i class="fa fa-clock-o"></i> '.$detail.$notes['datetime'].'</span>
                            <h3 class="timeline-header">Falta de <a href="./jogador.php?id='.$detail.$notes['player'].'">'.$detail.$notes['whole_name'].'</a></h3>
                            </div>
                            </li>';
                    } else if ($notes['type'] == 1){
                        echo '<li><i class="fa fa-soccer-ball-o bg-white" style="color:black;"></i>
                            <div class="timeline-item">
                             <button type="button" class="btn btn-box-tool" style="width:10px;float:right; margin-top:-5px; margin-right:10px;" onclick=\'deletar("' . $notes['id'] . '")\' title="Remover"><i class="fa fa-times"></i></button>
                            <span class="time"><i class="fa fa-clock-o"></i> '.$detail.$notes['datetime'].'</span>
                            <h3 class="timeline-header">Gol de <a href="./jogador.php?id='.$detail.$notes['player'].'">'.$detail.$notes['whole_name'].'</a></h3>
                            </div>
                            </li>';
                    } else if ($notes['type'] == 2){
                        echo ' <li>
                            <i class="fa fa-square  bg-gray" style="color:#ffb606;"></i>
                            <div class="timeline-item">
                             <button type="button" class="btn btn-box-tool" style="width:10px;float:right; margin-top:-5px; margin-right:10px;" onclick=\'deletar("' . $notes['id'] . '")\' title="Remover"><i class="fa fa-times"></i></button>
                            <span class="time"><i class="fa fa-clock-o"></i> '.$detail.$notes['datetime'].'</span>
                            <h3 class="timeline-header">Cartão amarelo para <a href="./jogador.php?id='.$detail.$notes['player'].'">'.$detail.$notes['whole_name'].'</a></h3>
                            </div>
                            </li>';
                    } else if ($notes['type'] == 3){
                        echo ' <li>
                        <i class="fa fa-square  bg-gray" style="color:red;"></i>
                        <div class="timeline-item">
                         <button type="button" class="btn btn-box-tool" style="width:10px;float:right; margin-top:-5px; margin-right:10px;" onclick=\'deletar("' . $notes['id'] . '")\' title="Remover"><i class="fa fa-times"></i></button>
                        <h3 class="timeline-header">Cartão vermelho para <a href="./jogador.php?id='.$detail.$notes['player'].'">'.$detail.$notes['whole_name'].'</a></h3>
                        </div>
                        </li>';
                    } else if ($notes['type'] == 4){
                        echo '<li><i class="fa fa-soccer-ball-o bg-white" style="color:black;"></i>
                            <div class="timeline-item">
                             <button type="button" class="btn btn-box-tool" style="width:10px;float:right; margin-top:-5px; margin-right:10px;" onclick=\'deletar("' . $notes['id'] . '")\' title="Remover"><i class="fa fa-times"></i></button>
                            <span class="time"><i class="fa fa-clock-o"></i> '.$detail.$notes['datetime'].'</span>
                            <h3 class="timeline-header">Gol contra de <a href="./jogador.php?id='.$detail.$notes['player'].'">'.$detail.$notes['whole_name'].'</a></h3>
                            </div>
                            </li>';
                    } else if ($notes['type'] == 5){
                        echo '<li>
                  <i class="fa fa-exchange bg-gray"></i>
                  <div class="timeline-item">
                   <button type="button" class="btn btn-box-tool" style="width:10px;float:right; margin-top:-5px; margin-right:10px;" onclick=\'deletar("' . $notes['id'] . '")\' title="Remover"><i class="fa fa-times"></i></button>
                    <h3 class="timeline-header no-border">Lucas Moura saiu para a entrada de <a href="#">Joaquim Barbosa</a></h3>
                      
                    <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>
                  </div>
                </li>';
                    } else if ($notes['type'] == 6){
                        echo ' <li>
                          <i class="fa fa-video-camera bg-gray"></i>
                          <div class="timeline-item">
                            <span class="time"><i class="fa fa-clock-o"></i> '.$detail.$notes['datetime'].'</span>
                            <h3 class="timeline-header">Vídeo</h3>
                            <div class="timeline-body">
                              <div class="embed-responsive embed-responsive-16by9">
                               <video width="100%" loop onclick="this.paused?this.play():this.pause();">
                                  <source src="lances/'.$detail.$notes['detail'].'.mp4" type="video/mp4" />
                                    Seu navegador não suporta este formato de vídeos. Atualize seu navegador.
                                </video>
                              </div>
                            </div>
                          </div>
                        </li>';
                    } else if ($notes['type'] == 8){
                        echo '<li><i class="fa fa-exchange bg-white" style="color:black;"></i>
                            <div class="timeline-item">
                             <button type="button" class="btn btn-box-tool" style="width:10px;float:right; margin-top:-5px; margin-right:10px;" onclick=\'deletar("' . $notes['id'] . '")\' title="Remover"><i class="fa fa-times"></i></button>
                            <span class="time"><i class="fa fa-clock-o"></i> '.$detail.$notes['datetime'].'</span>
                            <h3 class="timeline-header"><a href="./jogador.php?id='.$detail.$notes['player'].'">'.$detail.$notes['whole_name'].'</a> presente, iniciou no banco.</h3>
                            </div>
                            </li>';
                    } else if ($notes['type'] == 9){
                         echo '<li><i class="fa fa-exchange bg-white" style="color:black;"></i>
                            <div class="timeline-item">
                             <button type="button" class="btn btn-box-tool" style="width:10px;float:right; margin-top:-5px; margin-right:10px;" onclick=\'deletar("' . $notes['id'] . '")\' title="Remover"><i class="fa fa-times"></i></button>
                            <span class="time"><i class="fa fa-clock-o"></i> '.$detail.$notes['datetime'].'</span>
                            <h3 class="timeline-header"><a href="./jogador.php?id='.$detail.$notes['player'].'">'.$detail.$notes['whole_name'].'</a> presente, iniciou jogando.</h3>
                            </div>
                            </li>';
                    }
                }?>
                <li class="time-label">
                  <span class="bg-gray">
                    Início de jogo
                  </span>
                </li>
              </ul>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section>
            </div>
    </div>
    
  
    
    <!-- Modal -->
    <div id="myModal" class="modal fade">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body">
            <button id="envia_gol" class="btn btn-success" data-dismiss="modal">Gol</button>
            <button id="envia_falta" class="btn btn-primary" data-dismiss="modal">Falta</button>
            <button id="envia_amarelo" class="btn btn-warning" data-dismiss="modal">Cartão Amarelo</button>
            <button id="envia_vermelho" class="btn btn-danger" data-dismiss="modal">Cartão Vermelho</button>
            <button id="envia_contra" class="btn btn-primary" data-dismiss="modal">Gol Contra</button>
            <button id="remover" class="btn btn-primary" data-dismiss="modal">Substituído</button>
            <button id="envia_campo" class="btn btn-success" data-dismiss="modal">Começou jogando</button>
            <button id="envia_banco" class="btn btn-primary" data-dismiss="modal">Começou no banco</button><br>
            <label for="usr"><h4>Camisa:</h4></label>
            <input type="text" class="form-control" id="camisa" style="width:100px;"> 
            <div id="d_modal" class="row" style="margin-left:20px"></div>	
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>
    <script>
        $(function() {
            $( "#button" ).click(function() {
                $( ".hiders" ).toggle();
            });
        });
    </script>
    <script>
        var global_copa = <?php echo $dados['cup_id']; ?>;
        var global_id = <?php echo $id; ?>;
            
        function deletar(strId) {
           if (confirm('Tem certeza que deseja deletar esta marcação?')) {
                $.post("acoes.php",{acao: "deletar",nota: strId, match: global_id},function(data){});
            }
        }
        function inicio_1() {
           if (confirm('Tem certeza que iniciar a partida?')) {
                $.post("acoes.php",{acao:"marcar", type: 10, player: 0, match: global_id, field:0, side:0, nome:"", camisa:0, atualiza:0},
                   function(data)
                   {
                        // se nao retornou 1 entao os dados foram enviados
                        // remove a classe error da div
                        $("#d").removeClass("error");
                        // adiciona a classe sucess na div 
                        $("#d").addClass("sucess");
                        // insere o conteudo vindo do data.php na div
                        $("#d").html("Partida iniciada.");
                        console.log(data);
                        //}
                        // torna a div invisivel
                        $("#d").css("display","none");
                        // torna a div visivel usando o efeito show com a slow de parametro
                        $("#d").show("slow");
                    }
                )
            }
        }
        function fim_1() {
            if (confirm('Tem certeza que encerrar o primeiro tempo?')) {
                $.post("acoes.php",{acao:"marcar", type: 11, player: 0, match: global_id, field:0, side:0, nome:"", camisa:0, atualiza:0},
                   function(data)
                   {
                        // se nao retornou 1 entao os dados foram enviados
                        // remove a classe error da div
                        $("#d").removeClass("error");
                        // adiciona a classe sucess na div 
                        $("#d").addClass("sucess");
                        // insere o conteudo vindo do data.php na div
                        $("#d").html("Primeiro tempo encerrado.");
                        console.log(data);
                        //}
                        // torna a div invisivel
                        $("#d").css("display","none");
                        // torna a div visivel usando o efeito show com a slow de parametro
                        $("#d").show("slow");
                    }
                )
            }
        }
        function inicio_2() {
           if (confirm('Tem certeza que deseja iniciar o segundo tempo?')) {
                $.post("acoes.php",{acao:"marcar", type: 12, player: 0, match: global_id, field:0, side:0, nome:"", camisa:0, atualiza:0},
                   function(data)
                   {
                        // se nao retornou 1 entao os dados foram enviados
                        // remove a classe error da div
                        $("#d").removeClass("error");
                        // adiciona a classe sucess na div 
                        $("#d").addClass("sucess");
                        // insere o conteudo vindo do data.php na div
                        $("#d").html("Segundo tempo iniciado.");
                        console.log(data);
                        //}
                        // torna a div invisivel
                        $("#d").css("display","none");
                        // torna a div visivel usando o efeito show com a slow de parametro
                        $("#d").show("slow");
                    }
                )
            }
        }
        function encerrar() {
           if (confirm('Tem certeza que deseja encerrar esta partida?')) {
                $.post("acoes.php",{acao: "encerrar", match: global_id, copa: global_copa},function(data){
                        // se nao retornou 1 entao os dados foram enviados
                        // remove a classe error da div
                        $("#d").removeClass("error");
                        // adiciona a classe sucess na div 
                        $("#d").addClass("sucess");
                        // insere o conteudo vindo do data.php na div
                        $("#d").html("Partida encerrada com sucesso!");
                        console.log(data);
                        //}
                        // torna a div invisivel
                        $("#d").css("display","none");
                        // torna a div visivel usando o efeito show com a slow de parametro
                        $("#d").show("slow");
                    });
            }
        }
        function encerrar_wo(perdedor_wo){
            $.post("acoes.php",{acao: "encerrar_wo", match: global_id, copa: global_copa, perdedor_wo: perdedor_wo},function(data){}); 
            encerrar();
        }
        
        function alterar(key) {
            //document.getElementById(key + "_span").style.display = "none";
            document.getElementById(key + "_btn").style.display = "block";
        };
        
        function salvar_penalidade(key, id_equipe) {
            var penalidade_pontos = document.getElementById(key + "_penalty").value;
            
            swal({
                title: "Aplicar penalização?",
                text: "O time ficará com " +  penalidade_pontos + " ponto(s) a menos em relação ao seu número de vítorias e empates.",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Sim, aplicar!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm){
                if (isConfirm) {
                   $.post("acoes.php",{acao: "penalidade_equipe", match: global_id, copa: global_copa, penalidade_equipe: id_equipe, penalidade_pontos: penalidade_pontos},function(data){}); 
                    swal({
                        title: "Concluído!",
                        text: "A penalização será aplicada quando a partida for encerrada.",
                        type: "success",
                        showCancelButton: false,
                        closeOnConfirm: false,
                    });
              } else {
                swal("Cancelado", ":)", "error");
              }  
                document.getElementById(key + "_span").style.display = "block";
                document.getElementById(key + "_btn").style.display = "none";
            });
        };
    </script>
</body>
</html>
