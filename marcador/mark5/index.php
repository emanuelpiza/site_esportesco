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
    $sqlgeral = mysqli_query($mysqli,"SELECT * FROM matches where id='$id'");
    $dados = mysqli_fetch_assoc($sqlgeral);
    $sqlgols = mysqli_query($mysqli,"select count(*) as total from notes n left join players p on n.`player` = p.`id_players` where available = 1 and match_id = '$id' and ((type = 1 and p.`players_team_id` = ".$dados['team1'].") or (type = 4 and p.`players_team_id` = ".$dados['team2']."));");
    $gols1 = mysqli_fetch_assoc($sqlgols);    
    $sqlgols = mysqli_query($mysqli,"select count(*) as total from notes n left join players p on n.`player` = p.`id_players` where available = 1 and match_id = '$id' and ((type = 1 and p.`players_team_id` = ".$dados['team2'].") or (type = 4 and p.`players_team_id` = ".$dados['team1']."));");
    $gols2 = mysqli_fetch_assoc($sqlgols);

    $sqlfaltas = mysqli_query($mysqli,"select count(*) as total from notes n left join players p on n.`player` = p.`id_players` where available = 1 and match_id = '$id' and type = 0 and p.`players_team_id` = ".$dados['team1'].";");
    $faltas1 = mysqli_fetch_assoc($sqlfaltas);    
    $sqlfaltas = mysqli_query($mysqli,"select count(*) as total from notes n left join players p on n.`player` = p.`id_players` where available = 1 and match_id = '$id' and type = 0 and p.`players_team_id` = ".$dados['team2'].";");
    $faltas2 = mysqli_fetch_assoc($sqlfaltas);


    $sqlteam1 = mysqli_query($mysqli,"SELECT * FROM players where players_team_id=".$dados['team1']);
    $sqlteam2 = mysqli_query($mysqli,"SELECT * FROM players where players_team_id=".$dados['team2']);
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
    RIGHT JOIN plays t2 ON t2.`datetime` = t1.`datetime` where t2.`available` in (1,2) ) p1 left join players p2 on p1.player = p2.`id_players` where match_id ='$id' and available = 1 and type < 6 order by p1.`datetime` DESC;");
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
</head>
<body id="<?php echo $id;?>">
       <div class="row" style="margin-bottom:10px;">
         <div class="col-md-6 col-md-offset-3">
      <a href="./index.php?id=<?php echo $dados['team1']; ?>">

            <div class="col-xs-4" style="text-align:right; padding:0;">
                <img src="../../times/img/equipes/<?php echo $dados['team1']; ?>.png" style="width:80px; margin-right:5px;">
            </div>

            <div  class="col-xs-1" style="text-align:center; font-size:15px;padding:0;">
                <span style="font-family: Arial, serif; font-size:60px;text-align:left; margin-right:-25px; margin-left:-15px; color:black;font-weight:bolder;"><?php echo $gols1['total']; ?></span>
            </div>
        </a>

      <div  class="col-xs-2 center-block" style="text-align:center; font-size:30px; margin-top:20px;">X</div>

      <a href="./index.php?id=<?php echo $dados['team2']; ?>">
            <div  class="col-xs-1" style="text-align:center; font-size:15px; padding:0;">
                <span style="font-family: Arial, serif; font-size:60px;text-align:left; margin-left:-25px; color:black;font-weight:bolder;"><?php echo $gols2['total']; ?></span>
            </div>

            <div  class="col-xs-4" style="padding:0;">
                <img src="../../times/img/equipes/<?php echo $dados['team2']; ?>.png" style="width:80px; margin-left:5px">
          </div>
      </a>
    </div>
    </div>
    
    
           <div class="row" style="margin-bottom:10px;">
         <div class="col-md-6 col-md-offset-3">

            <div  class="col-xs-1 col-xs-offset-2" style="text-align:center; font-size:15px;padding:0;">
                <span style="font-family: Arial, serif; font-size:12px;text-align:left; margin-right:-25px; margin-left:-15px; color:black;font-weight:bolder;">Faltas: <?php echo $faltas1['total']; ?></span>
            </div>

            <div  class="col-xs-2 col-xs-offset-6" style="text-align:center; font-size:15px; padding:0;">
                <span style="font-family: Arial, serif; font-size:12px;text-align:left; margin-left:-25px; color:black;font-weight:bolder; margin-left:-15px; ">Faltas: <?php echo $faltas2['total']; ?></span>
            </div>
    </div>
    </div>
    
    <div class="row">
        <form name="f" id="f" onSubmit="return false">
            <div class="col-xs-12 col-sm-12 col-md-offset-3 col-md-6 cfeature infos col-lg-offset-3 col-lg-6">
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <ul class="options" id="ul_esq">
                            <?php while ($team1 = mysqli_fetch_assoc($sqlteam1)) {
                            echo "<li onclick=\x22selecionar_jogador(&quot;" . $team1['id_players'] . "&quot;)\x22 id='" . $team1['id_players'] . "' value='" . $team1['id_players'] . "'>" . $team1['shirt'] . " - " . $team1['players_name'] ."</option>";} ?>
                        </ul>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                         <ul class="options" id="ul_esq">
                            <?php while ($team2 = mysqli_fetch_assoc($sqlteam2)) {
                            echo "<li onclick=\x22selecionar_jogador(&quot;" . $team2['id_players'] . "&quot;)\x22 id='" . $team2['id_players'] . "' value='" . $team2['id_players'] . "'>" . $team2['shirt'] . " - " . $team2['players_name'] ."</option>";} ?>
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
                            <h3 class="timeline-header">Falta de <a href="./jogador.php?id='.$detail.$notes['player'].'">'.$detail.$notes['players_name'].'</a></h3>
                            </div>
                            </li>';
                    } else if ($notes['type'] == 1){
                        echo '<li><i class="fa fa-soccer-ball-o bg-white" style="color:black;"></i>
                            <div class="timeline-item">
                             <button type="button" class="btn btn-box-tool" style="width:10px;float:right; margin-top:-5px; margin-right:10px;" onclick=\'deletar("' . $notes['id'] . '")\' title="Remover"><i class="fa fa-times"></i></button>
                            <span class="time"><i class="fa fa-clock-o"></i> '.$detail.$notes['datetime'].'</span>
                            <h3 class="timeline-header">Gol de <a href="./jogador.php?id='.$detail.$notes['player'].'">'.$detail.$notes['players_name'].'</a></h3>
                            </div>
                            </li>';
                    } else if ($notes['type'] == 2){
                        echo ' <li>
                            <i class="fa fa-square  bg-gray" style="color:#ffb606;"></i>
                            <div class="timeline-item">
                             <button type="button" class="btn btn-box-tool" style="width:10px;float:right; margin-top:-5px; margin-right:10px;" onclick=\'deletar("' . $notes['id'] . '")\' title="Remover"><i class="fa fa-times"></i></button>
                            <span class="time"><i class="fa fa-clock-o"></i> '.$detail.$notes['datetime'].'</span>
                            <h3 class="timeline-header">Cartão amarelo para <a href="./jogador.php?id='.$detail.$notes['player'].'">'.$detail.$notes['players_name'].'</a></h3>
                            </div>
                            </li>';
                    } else if ($notes['type'] == 3){
                        echo ' <li>
                        <i class="fa fa-square  bg-gray" style="color:red;"></i>
                        <div class="timeline-item">
                         <button type="button" class="btn btn-box-tool" style="width:10px;float:right; margin-top:-5px; margin-right:10px;" onclick=\'deletar("' . $notes['id'] . '")\' title="Remover"><i class="fa fa-times"></i></button>
                        <h3 class="timeline-header">Cartão vermelho para <a href="./jogador.php?id='.$detail.$notes['player'].'">'.$detail.$notes['players_name'].'</a></h3>
                        </div>
                        </li>';
                    } else if ($notes['type'] == 4){
                        echo '<li><i class="fa fa-soccer-ball-o bg-white" style="color:black;"></i>
                            <div class="timeline-item">
                             <button type="button" class="btn btn-box-tool" style="width:10px;float:right; margin-top:-5px; margin-right:10px;" onclick=\'deletar("' . $notes['id'] . '")\' title="Remover"><i class="fa fa-times"></i></button>
                            <span class="time"><i class="fa fa-clock-o"></i> '.$detail.$notes['datetime'].'</span>
                            <h3 class="timeline-header">Gol contra de <a href="./jogador.php?id='.$detail.$notes['player'].'">'.$detail.$notes['players_name'].'</a></h3>
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
    
    <div  class="col-md-4 text-center col-md-offset-4" style="text-align:center; font-size:30px; margin-top:20px;">
        <button type="button" class="btn btn-danger" onclick='encerrar()' style="width:270px; margin-bottom:50px;" title="Encerrar">Encerrar partida e atualizar classificação</button>
    </div>
    
    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
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
            <button id="envia_banco" class="btn btn-primary" data-dismiss="modal">Começou no banco</button>
            <div id="d_modal" class="row" style="margin-left:20px"></div>	
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>
    
    <!--
      <form name="f2" id="f2" onSubmit="return false">
		<h3>Times em Campo</h3>
        <h3>Esquerda</h3>
        <ul class="options" id="ul2_esq">
        </ul>
        <select onchange="time_esquerda(this);">
            <option value="Diego">Selecionar</option>
            <option value="Diego">Diego</option>
            <option value="Emanuel">Emanuel</option>
            <option value="Hermando">Hermando</option>
            <option value="Joinha">Joiinha</option>
            <option value="Juninho">Juninho</option>
            <option value="Marquinho">Marquinho</option>
            <option value="Digao">Digao</option>
            <option value="Luciano">Luciano</option>
            <option value="Leandro">Leandro</option>
            <option value="Giba">Giba</option>
            <option value="Edson">Edson</option>
            <option value="Kanu">Kanu</option>
            <option value="Miguel">Miguel</option>
            <option value="DJ">DJ</option>
        </select>
        
        <h3>Direita</h3>
        <ul class="options" id="ul2_dir">
        </ul>
        <select onchange="time_direita(this);">
            <option value="Diego">Selecionar</option>
            <option value="Diego">Diego</option>
            <option value="Emanuel">Emanuel</option>
            <option value="Hermando">Hermando</option>
            <option value="Joinha">Joiinha</option>
            <option value="Juninho">Juninho</option>
            <option value="Marquinho">Marquinho</option>
            <option value="Digao">Digao</option>
            <option value="Luciano">Luciano</option>
            <option value="Leandro">Leandro</option>
            <option value="Giba">Giba</option>
            <option value="Edson">Edson</option>
            <option value="Kanu">Kanu</option>
            <option value="Miguel">Miguel</option>
            <option value="DJ">DJ</option>
        </select>
        <br><br>
		<button id="atualiza">Atualizar</button>
    </form>
    
		<p>&nbsp;</p>
	<div id="d2"></div>	
    
    -->
    <script>
        var global_id = <?php echo $id; ?>;
        var global_team1 = <?php echo $dados['team1']; ?>;
        var global_team2 = <?php echo $dados['team2']; ?>;
            
        function deletar(strId) {
           if (confirm('Tem certeza que deseja deletar esta marcação?')) {
                $.post("acoes.php",{acao: "deletar",id: strId},function(data){});
            }
        }
        function encerrar() {
           if (confirm('Tem certeza que deseja encerrar esta partida?')) {
                $.post("acoes.php",{acao: "encerrar",id: global_id, team1: global_team1, team2: global_team2},function(data){});
            }
        }
    </script>
</body>
</html>
