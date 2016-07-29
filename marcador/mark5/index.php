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
    $sqlteam1 = mysqli_query($mysqli,"SELECT * FROM players where players_team_id=".$dados['team1']);
    $sqlteam2 = mysqli_query($mysqli,"SELECT * FROM players where players_team_id=".$dados['team2']);

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
    
</head>
<body id="<?php echo $id;?>">
    <form name="f" id="f" onSubmit="return false">
		<div class="col-xs-12 col-sm-12 col-md-offset-3 col-md-6 cfeature infos col-lg-offset-3 col-lg-6">
            <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <img src="../../times/img/equipes/<?php echo $dados['team1'];?>.png" style="width:100px; display: block; margin-left: auto; margin-right: auto;"><br>
                <ul class="options" id="ul_esq">
                </ul>
                <select onchange="time_esquerda(this);">
                    <option value="Selecionar">Selecionar</option>
                    <?php while ($team1 = mysqli_fetch_assoc($sqlteam1)) {
                    echo "<option value='" . $team1['id_players'] . "'>" . $team1['shirt'] . " - " . $team1['players_name'] ."</option>";} ?>
                </select>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                   <img src="../../times/img/equipes/<?php echo $dados['team2'];?>.png" style="width:100px; display: block; margin-left: auto; margin-right: auto;"><br>
                <ul class="options" id="ul_dir">
                </ul>
                    <select onchange="time_direita(this);">
                    <option value="Selecionar">Selecionar</option>
                    <?php while ($team2 = mysqli_fetch_assoc($sqlteam2)) {
                    echo "<option value='" . $team2['id_players'] . "'>" . $team2['shirt'] . " - " . $team2['players_name'] ."</option>";} ?>
                </select>
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
        <button id="envia_amarelo" class="btn btn-warning" data-dismiss="modal">Cartão Amarelo</button>
        <button id="envia_vermelho" class="btn btn-danger" data-dismiss="modal">Cartão Vermelho</button>
        <button id="envia_contra" class="btn btn-primary" data-dismiss="modal">Gol Contra</button>
        <button id="remover" class="btn btn-primary" data-dismiss="modal">Substituído</button>
        <div id="d_modal" class="row" style="margin-left:20px"></div>	
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
    <script>
        var global_id = <?php echo $id; ?>;
    </script>
</body>
</html>
