<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();

    ob_start();
    include('../admin/dbcon/dbcon.php');

    if (isset($_SESSION["logname"])) {
        $_SESSION["error1"] = "Please Sign in";
        header("Location: index.php");
    }
    $id = 8;
    $sqlgeral = mysqli_query($mysqli,"SELECT * FROM teams where id_teams='$id'");
    $dados = mysqli_fetch_assoc($sqlgeral);
    $sqlcount_players = mysqli_query($mysqli,"SELECT count(*) as total FROM players  where players_team_id='$id'");
    $count_players = mysqli_fetch_assoc($sqlcount_players);
    $sqlcount_videos = mysqli_query($mysqli,"SELECT count(*) as total FROM videos  where team_id='$id'");
    $count_videos = mysqli_fetch_assoc($sqlcount_videos);
    $nome = $dados['teams_name'];
    $sqlcount_plays = mysqli_query($mysqli,"SELECT count(*) as total FROM plays where available = 1 and teams_name LIKE '%".$nome."%' ");
    $count_plays = mysqli_fetch_assoc($sqlcount_plays);
    $sql_jogadores = mysqli_query($mysqli,"SELECT * FROM players where players_team_id = '$id' order by players_name");
    $sql_jogadores2 = mysqli_query($mysqli,"SELECT * FROM players where players_team_id = '$id' order by players_name");
    while ($data4 = mysqli_fetch_assoc($sql_jogadores2)) {
        $selecoes .= "<option value=".$data4['id_players'].">".$data4['players_name']."</option>" ;
    }

    $sqlstatus = mysqli_query($mysqli,"SELECT rank FROM teams where id_teams=8");
    $geral2 = mysqli_fetch_assoc($sqlstatus);
    $status = $geral2['rank']; 

    if ($status == '1') {
        $status = "Aberta";
        $cor = "green";
    } else{
        $status = "Fechada";
        $cor = "red";
    }

?>


<!DOCTYPE html>
<html lang="en" content="text/html; charset=utf-8">

<head>

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
    
    <title><?php echo $dados['teams_name']; ?> - EsportesCo</title>

   <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../../css/_all-skins.min.css">
    <!-- Ícones -->
    <link rel="icon" type="image/png" href="../img/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="../img/favicon-16x16.png" sizes="16x16" />
     <!-- jQuery -->
    <script src="./js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/app.js"></script>
    <script src="../js/Chart.js"></script>
		<meta name = "viewport" content = "initial-scale = 1, user-scalable = no">
		<style>
			canvas{
			}
		</style>
    
    <!-- Include Mask plugin -->
    <script src="http://oss.maxcdn.com/jquery.mask/1.11.4/jquery.mask.min.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="skin-blue" style="padding:10px; background-color:#F0F8FF; padding-top: 70px;">
    <?php 
        include_once("../admin/analyticstracking.php");
        include('../navbar.php');
    ?>
   <section class="content-header">
      <h1>
        <?php echo $dados['teams_name']; ?>
      </h1>
    </section>
    
    <div class="row" style="margin-top:15px;">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-blue">
                <div class="inner">
                    <h3><?php echo $count_players['total']; ?></h3>
                    <p>Alunos</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-light-blue">
                <div class="inner">
                    <h3><?php echo $count_plays['total']; ?></h3>
                    <p>Pinturas</p>
                </div>
                <div class="icon">
                    <i class="ion ion-easel"></i>
                </div>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3><?php echo $count_videos['total']; ?></h3>
                    <p>Publicações</p>
                </div>
                <div class="icon">
                    <i class="ion ion-videocamera"></i>
                </div>
            </div>
            </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-<?php echo $cor; ?>">
                <div class="inner">
                    <p>Escola</p>
                    <h3><?php echo $status; ?></h3>
                </div>
            </div>
        </div><!-- ./col -->
    </div><!-- /.row -->
    
    <div class="row">
         <div class="col-md-6">
          <!-- USERS LIST -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Alunos</h3>
            </div><!-- /.box-header -->
            <div class="box-body no-padding">
              <ul class="users-list clearfix">
                <?php while ($data2 = mysqli_fetch_assoc($sql_jogadores)) {
                    echo '
                    <li>
                        <a class="users-list-name" href="../times/jogador.php?id=' . $data2['id_players'] . '">
                      <img class="img-circle" src="img/jogadores/' . $data2['player_picture'] . '" alt="User Image" style="height:80px; width:80px;"></a>
                      <a class="users-list-name" href="../times/jogador.php?id=' . $data2['id_players'] . '">' . $data2['players_name'] . '</a>
                      <span class="users-list-date">' . $data2['player_position'] . '</span>
                    </li>';}
                ?>
              </ul><!-- /.users-list -->
            </div><!-- /.box-body -->
          </div><!--/.box -->
        </div><!-- /.col -->

        <div class="col-md-6">
          <!-- USERS LIST -->
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Publicações</h3>
            </div><!-- /.box-header -->
            <div class="box-body no-padding">
                <?php $sqltime = mysqli_query($mysqli,"SELECT * FROM videos where team_id = '$id' order by date DESC LIMIT 5");
                    while ($data3 = mysqli_fetch_assoc($sqltime)) {
                      if ($data3['type'] != 'p') {
                        if ($data3['available'] != 1) {
                            $marcador = ""; // Vídeo não está disponível
                        } else{
                            $marcador = '
                             <div class="row">
                     <div class="form-group col-xs-4 col-md-4">
                        <input type="text" name="momento" id="'.$data3['webaddress'].'_mom" class="form-control col-xs-2 col-md-2" placeholder="Momento: (hh:mm:ss)" style="margin-top:20px;" />
                      </div>
                    
                        <!-- radio -->
                        <div class="form-group col-xs-4 col-md-4">
                          <div class="radio">
                            <label>
                              <input class="col-xs-4 col-md-4" type="radio" name="radio_campo" value="1" checked>
                              Gol do Bar
                              </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input class="form-group col-xs-3 col-md-3 control-label" type="radio" name="radio_campo" id="'.$data3['webaddress'].'_campEsq" value="0">
                              Gol do Fundo
                            </label>
                          </div>
                        </div>
                        <div class="col-xs-3 col-md-3" style="margin-top:20px;">
                            <select id="'.$data3['webaddress'].'_craq" class="form-control">
                                <option value="45">Craque</option>
                                '. $selecoes .'
                            </select>
                        </div>
                    </div>
                    
                    <div class=row" style="text-align:center;">
                        <button class="btn btn-sm btn-success"  style="margin: 10 auto;" onclick=\'marcacao("'.$data3['webaddress'].'")\'>Salvar Marcação</button>
                    </div>';};
                    echo '
                    <form name="f" id="f" onSubmit="return false">
                    <input type="hidden" name="video" value="' . $data3['webaddress'] . '">
                    <input type="hidden" id="'.$data3['webaddress'].'_equip" name="equipe" value="' . $id . '">
                    
                        <div style="width: 95%; margin:10px auto; 10px; auto;" ><iframe width="100%" src="https://www.youtube.com/embed/' . $data3['webaddress'] . '" frameborder="0" allowfullscreen></iframe>
                    
                        '.$marcador.'
                        </div>
                    </form>';}
                    else {
                        echo'
                        <div style="width: 95%; margin:10px auto; 10px; auto;" >
                        <img src="../times/img/' . $data3['webaddress'] . '" style="width:100%;">
                        </div>';
                    }
                }?>
            </div><!-- /.box-body -->
          </div><!--/.box -->
        </div><!-- /.col -->
    </div>
    <!--<div class="row">  
        php if (isset($dados['manager_picture'])){echo '
        <div class="col-md-3">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Técnico</h3>
            </div>
            <div class="box-body no-padding">
                <ul class="users-list clearfix">
                    <li>
                        <img class="img-circle" src="img/jogadores/' . $dados['manager_picture'] . '.png" alt="User Image" style="height:80px; width:80px;">'. $dados['manager_name'] . '
                    </li>
              </ul>
            </div>
          </div>
        </div>';
        }?>
    </div>-->
    
    
    <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <!-- Box Comment -->
        
        <?php 

        $query_plays = mysqli_query($mysqli, "SELECT * FROM plays where available = 1 and teams_name = '".$dados['teams_name']."' order by id_plays DESC LIMIT 15") or die(mysqli_error($mysqli)); 
        
        while ($plays = mysqli_fetch_assoc($query_plays)) {
            echo '
                <div class="box box-widget" id="'. $plays['video_id'] .'">
                    <div class="box-header with-border">
                     <button class="btn btn-box-tool" onclick=\'deletar("'. $plays['video_id'] .'")\' data-widget="remove" style="float:right; margin-top:-5px;"><i class="fa fa-remove"></i></button>
                     <button class="btn btn-box-tool" data-widget="collapse" style="float:right; margin-top:-5px;"><i class="fa fa-minus"></i></button>
                      <div class="user-block">
                        <img class="img-circle" src="img/jogadores/0.png" alt="user image">
                        <span class="username"><a href="jogador.php?id=' . $plays['plays_players_id'] . '">' . $plays['players_name'] . '</a></span>
                        <span class="description">' . $plays['teams_name'] . ' - ' . $plays['date'] . '</span></div><!-- /.user-block -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <video width="100%" loop onclick="this.paused?this.play():this.pause();">
                          <source src="lances/' . $plays['video_id'] . '.mp4" type="video/mp4" />
                            Seu navegador não suporta este formato de vídeos. Atualize seu navegador.
                        </video>
                    </div><!-- /.box-body -->
                  </div><!-- /.box -->';}
        ?>
    </div><!-- /.col -->
    </div>
    
    <script>
    function marcacao(strVideo) {
        swal("Marcação realizada!", "Vídeo em processamento.\nO resultado será exibido na página principal e na página do jogador.", "success");

        var craq = document.getElementById(strVideo + "_craq");
        var strCraq = craq.options[craq.selectedIndex].value;
        var camp_esq = 0;
        if (document.getElementById(strVideo + "_campEsq").checked) {
            camp_esq = 1;
        }
        var strMomento = (document.getElementById(strVideo + "_mom").value); 

        $.post("acoes.php",{acao: "marcar",video: strVideo, momento: strMomento, radio_campo: camp_esq, jogada: 0, craque: strCraq, equipe: document.getElementById(strVideo + "_equip").value},function(data){})
    }
        
    //function deletar(strVideo) {    
        
       // swal({   title: "Are you sure?",   text: "You will not be able to recover this imaginary file!",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Yes, delete it!",   closeOnConfirm: false }, function(){   swal("Deleted!", "Your imaginary file has been deleted.", "success"); });
       //swal({   title: "Deseja deletar o arquivo permanentemente?",   text: "Ele será removido da base de dados!",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Sim, deletar!",   cancelButtonText: "Não, cancelar!",   closeOnConfirm: false }, function(isConfirm){   if (isConfirm) {
        //   $.post("acoes.php",{acao: "deletar", video: strVideo, equipe: $id},function(data){});
       //} else {     swal("Cancelado", "O arquivo continua na base :)", "error");   } });
    //}
    </script>
</body>

</html>
