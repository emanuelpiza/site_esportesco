<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();

    ob_start();
    include('../admin/dbcon/dbcon.php');

    if (isset($_SESSION["logname"])) {
        $_SESSION["error1"] = "Please Sign in";
        header("Location: index.php");
    }
    $id = $_GET['id'];
    $sqlgeral = mysqli_query($mysqli,"SELECT * FROM teams where id_teams='$id'");
    $dados = mysqli_fetch_assoc($sqlgeral);
    $sqlcount_players = mysqli_query($mysqli,"SELECT count(*) as total FROM players  where players_team_id='$id'");
    $count_players = mysqli_fetch_assoc($sqlcount_players);
    $sqlcount_videos = mysqli_query($mysqli,"SELECT count(*) as total FROM videos  where team_id='$id'");
    $count_videos = mysqli_fetch_assoc($sqlcount_videos);
    $sqlcount_plays = mysqli_query($mysqli,"SELECT count(*) as total FROM plays where available in (1,2) and teams_id > 7;");
    $count_plays = mysqli_fetch_assoc($sqlcount_plays);
    $sql_anos = mysqli_query($mysqli,"SELECT YEAR(teams_schedule_date) as year FROM teams WHERE id_teams='$id'");
    $anos = mysqli_fetch_assoc($sql_anos);
    $sql_jogadores = mysqli_query($mysqli,"SELECT * FROM players where players_team_id = '$id' order by players_name");
    $sql_jogadores2 = mysqli_query($mysqli,"SELECT * FROM players where players_team_id = '$id' order by players_name");
    while ($data4 = mysqli_fetch_assoc($sql_jogadores2)) {
        $selecoes .= "<option value=".$data4['id_players'].">".$data4['players_name']."</option>" ;
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
    
    <title>Copa Benteler - EsportesCo</title>

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
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.6&appId=1510121465959695";
        fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    <?php 
        include_once("../admin/analyticstracking.php");
        include('../navbar.php');
    ?>
   <section class="content-header">
      <h1>
        <?php echo $dados['teams_name']; ?>
      </h1>
    </section>
    
        <div class="row" style="background-color:#003366; text-align:center; margin:-25px -10px 25px -10px;">
        <h1 style="color:white; margin-top:5px;">15ª COPA BENTELER<br>de Futebol Society</h1>
        </div>
    
    
    
    
    
        <div class="row">
            <div class="col-md-6">
            <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Grupo A</h3>
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                  <table class="table table-striped">
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Equipe</th>
                      <th style="width: 50px">P</th>
                      <th style="width: 50px">V</th>
                      <th style="width: 50px">E</th>
                      <th style="width: 50px">D</th>
                      <th style="width: 50px">SG</th>
                    </tr>
                        <?php $sqlgrupoa = mysqli_query($mysqli,"SELECT * FROM teams where teams_match_duration = 40 and teamd_fields_id = 1 order by teams_formation");
                    while ($data4 = mysqli_fetch_assoc($sqlgrupoa)) {
                    echo '
                    <tr>
                      <td>'.$data4['teams_formation'].'</td>
                      <td><a href="./index.php?id=' . $data4['id_teams'] . '">'.$data4['teams_name'].'</a></td>
                      <td><b>'.$data4['points'].'</b></td>
                      <td>'.$data4['victories'].'</td>
                      <td>'.$data4['draws'].'</td>
                      <td>'.$data4['losses'].'</td>
                      <td>'.$data4['goals_balance'].'</td>
                    </tr>';}?>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
            
            <div class="col-md-6">
            <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Grupo B</h3>
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                  <table class="table table-striped">
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Equipe</th>
                      <th style="width: 70px">P</th>
                      <th style="width: 70px">V</th>
                      <th style="width: 70px">E</th>
                      <th style="width: 70px">D</th>
                      <th style="width: 70px">SG</th>
                    </tr>
                        <?php $sqlgrupob = mysqli_query($mysqli,"SELECT * FROM teams where teams_match_duration = 40 and teamd_fields_id = 2 order by teams_formation");
                    while ($data5 = mysqli_fetch_assoc($sqlgrupob)) {
                    echo '
                    <tr>
                      <td>'.$data5['teams_formation'].'</td>
                      <td><a href="./index.php?id=' . $data5['id_teams'] . '">'.$data5['teams_name'].'</a></td>
                      <td><b>'.$data5['points'].'</b></td>
                      <td>'.$data5['victories'].'</td>
                      <td>'.$data5['draws'].'</td>
                      <td>'.$data5['losses'].'</td>
                      <td>'.$data5['goals_balance'].'</td>
                    </tr>';}?>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
    
    
    <div class="row">
        
        <div class="col-md-6">
                <?php $sqlpartida = mysqli_query($mysqli,"SELECT * FROM videos where team_id = 5 and type = 'v' order by date DESC LIMIT 1");
                    while ($data3 = mysqli_fetch_assoc($sqlpartida)) {
                    echo '
                    <form name="f" id="f" onSubmit="return false">
                    <input type="hidden" name="video" value="' . $data3['webaddress'] . '">
                    <input type="hidden" id="'.$data3['webaddress'].'_equip" name="equipe" value="' . $id . '">
                    
                        <div style="width: 100%; margin:10px auto; 20px; auto;" ><iframe type="text/html" id="video_iframe" width="100%" src="https://www.youtube.com/embed/' . $data3['webaddress'] . '?enablejsapi=1&version=3" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </form>';}?>
        </div><!-- /.col -->
        
         <div class="col-md-6">
                <?php $sqlpartida = mysqli_query($mysqli,"SELECT * FROM videos where team_id = 5 and type = 'v' order by date DESC LIMIT 1");
                    while ($data3 = mysqli_fetch_assoc($sqlpartida)) {
                    echo '
                    <form name="f" id="f" onSubmit="return false">
                    <input type="hidden" name="video" value="' . $data3['webaddress'] . '">
                    <input type="hidden" id="'.$data3['webaddress'].'_equip" name="equipe" value="' . $id . '">
                    
                        <div style="width: 100%; margin:10px auto; 20px; auto;" ><iframe type="text/html" id="video_iframe" width="100%" src="https://www.youtube.com/embed/' . $data3['webaddress'] . '?enablejsapi=1&version=3" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </form>';}?>
        </div><!-- /.col --> 
    </div>
    
    <div class="row">    
         <div class="col-md-6">
                       <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Artilharia</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered">
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Nome</th>
                      <th>Time</th>
                      <th style="width: 40px">Gols</th>
                    </tr>
                    <tr>
                       <!--<td>1.</td>
                      <td>João</td>
                      <td>
                          <span>INDEPENDIENTE</span>
                        </td>
                      <td><span>0.2</span></td>-->
                    </tr>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
        </div><!-- /.col --> 
        
        <div class="col-md-6">
                       <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Goleiros Menos Vazados</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered">
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Nome</th>
                      <th>Time</th>
                      <th style="width: 40px">Índice</th>
                    </tr>
                    <tr>
                      <!--<td>1.</td>
                      <td>João</td>
                      <td>
                          <span>INDEPENDIENTE</span>
                        </td>
                      <td><span>0.2</span></td>-->
                    </tr>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
        </div><!-- /.col --> 
    </div>
    
        <div class="row" style="margin-top:15px;">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-light-blue-active">
                <div class="inner">
                    <h3><?php echo $count_players['total']; ?></h3>
                    <p>Jogadores</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-light-blue-active">
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
            <div class="small-box bg-light-blue-active">
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
            <div class="small-box bg-light-blue-active">
                <div class="inner">
                    <h3>2016</h3>
                    <p>Edição</p>
                </div>
                <div class="icon">  
                    <i class="ion ion-ios-calendar"></i>
                </div>
            </div>
        </div><!-- ./col -->
    </div><!-- /.row -->
    
    <script>
        //import YouTube API script
        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
        
         //create the YouTube Player
          var player;

          function onYouTubeIframeAPIReady() {
            console.log("API  is Ready");
            player = new YT.Player("video_iframe", { 
            events : {
              'onReady': onPlayerReady(),
              'onStateChange': onStateChangeEvent()
              } 
            });
          }
          function onPlayerReady() {
            console.log("My plaer is onReady" );

          }
          function onStateChangeEvent(){
            setInterval(function(){
               var time = player.getCurrentTime();
              //var volume = player.getVolume();
              console.log("Get Current Time: " + time);
            },1000); 

          }
        
    function marcacao(strVideo, camp_esq) {
        var time = player.getCurrentTime();
        if (time < 9){
            swal("Não foi possível identificar o momento.", "Pressione o botão apenas quando assistir algum lance no vídeo acima.", "warning");
        } else{
        var hours = parseInt( time / 3600 ) % 24;
        var minutes = parseInt( time / 60 ) % 60;
        var seconds = (time % 60).toFixed(0);
        var strMomento = hours+":"+minutes+":"+seconds;
        
        swal("Marcação Realizada em "+strMomento, "Vídeo em processamento. Isso pode levar alguns minutos.", "success");
        
        $.post("acoes.php",{acao: "marcar",video: strVideo, momento: strMomento, radio_campo: camp_esq, jogada: 0, equipe: document.getElementById(strVideo + "_equip").value},function(data){});    
        }
    }
        
    function estatisticas(strVideo) {
        swal("Categorização realizada!", "As estatísticas dos jogadores envolvidos estão sendo atualizadas.", "success");
        
        var craq = document.getElementById(strVideo + "_craq");
        var strCraq = craq.options[craq.selectedIndex].value;
        var assist = document.getElementById(strVideo + "_assist");
        var strAssist = assist.options[assist.selectedIndex].value;
        var tipo = document.getElementById(strVideo + "_tipo");
        var strTipo = tipo.options[tipo.selectedIndex].value;
        
        $.post("acoes.php",{acao: "estatisticas",video: strVideo, craque: strCraq, assistencia: strAssist, tipo: strTipo, time: <?php echo $id?>},function(data){});
        $(document.getElementById(strVideo)).hide(500);
    }
        
    function deletar(strVideo) {
       if (confirm('Tem certeza que deseja deletar esta marcação?')) {
            $(document.getElementById(strVideo)).hide(500);
            $.post("acoes.php",{acao: "deletar",video: strVideo},function(data){});
        }
    }
    function toggleDiv(divId) {
       $("#"+divId).toggle(500);
    }
    </script>
</body>

</html>
