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
    $sqlcount_players = mysqli_query($mysqli,"SELECT count(*) as total FROM players  where players_team_id > 9 and players_team_id < 24");
    $count_players = mysqli_fetch_assoc($sqlcount_players);
    $sqlcount_videos = mysqli_query($mysqli,"SELECT count(*) as total FROM videos where team_id > 9 and team_id < 24 and type='v'");
    $count_videos = mysqli_fetch_assoc($sqlcount_videos);
    $sqlcount_plays = mysqli_query($mysqli,"SELECT count(*) as total FROM plays p join teams t on t.`teams_name` = p.`teams_name` where available in (1,2) and id_teams between 9 and 24;");
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
    <link href='https://fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
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
    </section>
    
        <div class="row" style="background-color:#003366; text-align:center; margin:-25px -10px 25px -10px;">
        <h1 style="color:white; margin-top:5px; font-size: 40px;"><b>15ª COPA</b> <img src="./img/benteler.png" style="width:200px; margin-top:-7px;"></h1><h1 style=" color:white; margin-top:-10px;">de Futebol Society</h1>
        </div>
            <div class="row">
            <div class="col-sm-6">
            <div class="box">
                <div class="box-header">
                  <h1 class="box-title" style="float:middle;">Classificatórias Grupo A</h1>
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                    <div class="col-md-10 col-md-offset-1">
                        <?php $matchesA = mysqli_query($mysqli,"SELECT m.`team1`, left(t1.`teams_name`,3) as 'team1_name', m.`team2`, m.`score1`, m.`score2`, left(t2.`teams_name`,3) as 'team2_name', t1.`teamd_fields_id` as 'teams_field', date_format(m.datetime, '%hh%i') as hour, date_format(m.datetime,'%d/%m') as date FROM matches as m left join teams t1 on m.team1 = t1.`id_teams` left join teams as t2 on m.team2 = t2.id_teams where t1.`teamd_fields_id` = 1 order by m.datetime LIMIT 3;");
                        while ($data5 = mysqli_fetch_assoc($matchesA)) {  
                        echo '<hr style="margin-top:0px;"></hr>
                        <div class="row">
                            <div class="col-xl-offset-5 col-xl-2 center-block" style="text-align:center; margin-bottom:0px;margin-top:-15px;">
                                <span style="font-family: Roboto, Arial, serif; font-size:12px;">'.$data5['date'].' às '.$data5['hour'].'</span>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:10px;">
                              <a href="./index.php?id='.$data5['team1'].'">
                              
                                    <div class="col-xs-4" style="text-align:right; padding:0;">
                                        <span style="font-family: \'Poiret One\', Arial, serif; font-size:25px; margin-right:10px; color:black;">'.$data5['team1_name'].'</span>
                                        
                                        <img src="./img/equipes/'.$data5['team1'].'.png" style="width:30px; margin-top: -10px; margin-right:5px;">
                                    </div>
                                
                                    <div  class="col-xs-1" style="text-align:center; font-size:15px;padding:0;">
                                        <span style="font-family: Arial, serif; font-size:25px;text-align:left; margin-right:-25px; color:black;font-weight:bolder;">'.$data5['score1'].'</span>
                                    </div>
                                </a>
                                
                              <div  class="col-xs-2 center-block" style="text-align:center; font-size:15px; margin-top:10px;"><i class="fa fa-times" aria-hidden="true"></i></div>
                              
                              
                              <a href="./index.php?id='.$data5['team2'].'">
                                    <div  class="col-xs-1" style="text-align:center; font-size:15px; padding:0;">
                                        <span style="font-family: Arial, serif; font-size:25px;text-align:left; margin-left:-25px; color:black;font-weight:bolder;">'.$data5['score2'].'</span>
                                    </div>
                                    
                                    <div  class="col-xs-4" style="padding:0;">
                                        <img src="./img/equipes/'.$data5['team2'].'.png" style="width:30px; margin-top: -10px; margin-left:5px">
                                        
                                        <span style="font-family: \'Poiret One\', Arial, serif; font-size:25px ;text-align:left; margin-left:10px; color:black;">'.$data5['team2_name'].'</span>
                                  </div>
                              </a>
                            </div>';}?>
                    </div><!-- /.box-body -->
                </div>
              </div><!-- /.box -->
            </div>
                
<div class="col-sm-6">
            <div class="box">
                <div class="box-header">
                  <h1 class="box-title" style="float:middle;">Classificatórias Grupo B</h1>
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                    <div class="col-md-10 col-md-offset-1">
                        <?php $matchesA = mysqli_query($mysqli,"SELECT m.`team1`, left(t1.`teams_name`,3) as 'team1_name', m.`team2`, m.`score1`, m.`score2`, left(t2.`teams_name`,3) as 'team2_name', t1.`teamd_fields_id` as 'teams_field', date_format(m.datetime, '%hh%i') as hour, date_format(m.datetime,'%d/%m') as date FROM matches as m left join teams t1 on m.team1 = t1.`id_teams` left join teams as t2 on m.team2 = t2.id_teams where t1.`teamd_fields_id` = 2 order by m.datetime LIMIT 3;");
                        while ($data5 = mysqli_fetch_assoc($matchesA)) {
                        echo '<hr style="margin-top:0px;"></hr>
                        <div class="row">
                            <div class="col-xl-offset-5 col-xl-2 center-block" style="text-align:center; margin-bottom:0px;margin-top:-15px;">
                                <span style="font-family: Roboto, Arial, serif; font-size:12px;">'.$data5['date'].' às '.$data5['hour'].'</span>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:10px;">
                              <a href="./index.php?id='.$data5['team1'].'">
                              
                                    <div class="col-xs-4" style="text-align:right; padding:0;">
                                        <span style="font-family: \'Poiret One\', Arial, serif; font-size:25px; margin-right:10px; color:black;">'.$data5['team1_name'].'</span>
                                        
                                        <img src="./img/equipes/'.$data5['team1'].'.png" style="width:30px; margin-top: -10px; margin-right:5px;">
                                    </div>
                                
                                    <div  class="col-xs-1" style="text-align:center; font-size:15px;padding:0;">
                                        <span style="font-family: Arial, serif; font-size:25px;text-align:left; margin-right:-25px; color:black;font-weight:bolder;">'.$data5['score1'].'</span>
                                    </div>
                                </a>
                                
                              <div  class="col-xs-2 center-block" style="text-align:center; font-size:15px; margin-top:10px;"><i class="fa fa-times" aria-hidden="true"></i></div>
                              
                              
                              <a href="./index.php?id='.$data5['team2'].'">
                                    <div  class="col-xs-1" style="text-align:center; font-size:15px; padding:0;">
                                        <span style="font-family: Arial, serif; font-size:25px;text-align:left; margin-left:-25px; color:black;font-weight:bolder;">'.$data5['score2'].'</span>
                                    </div>
                                    
                                    <div  class="col-xs-4" style="padding:0;">
                                        <img src="./img/equipes/'.$data5['team2'].'.png" style="width:30px; margin-top: -10px; margin-left:5px">
                                        
                                        <span style="font-family: \'Poiret One\', Arial, serif; font-size:25px ;text-align:left; margin-left:10px; color:black;">'.$data5['team2_name'].'</span>
                                  </div>
                              </a>
                            </div>';}?>
                    </div><!-- /.box-body -->
                </div>
              </div><!-- /.box -->
            </div>
                
                
                
                
                
        </div>
    
        <div class="row">
            <div class="col-md-6">
            <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Tabela Grupo A</h3>
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
                        <?php $sqlgrupoa = mysqli_query($mysqli,"SELECT * FROM teams where teams_match_duration = 40 and teamd_fields_id = 1 order by points DESC, goals_balance DESC");
                        $posicao = 1;
                    while ($data4 = mysqli_fetch_assoc($sqlgrupoa)) {
                    echo '
                    <tr>
                      <td>'.$posicao.'</td>
                      <td><a href="./index.php?id=' . $data4['id_teams'] . '"><span style="font-family: \'Source Sans Pro\', Arial, serif; font-size:16px; color:black;">'.$data4['teams_name'].'</span></a></td>
                      <td><b>'.$data4['points'].'</b></td>
                      <td>'.$data4['victories'].'</td>
                      <td>'.$data4['draws'].'</td>
                      <td>'.$data4['losses'].'</td>
                      <td>'.$data4['goals_balance'].'</td>
                    </tr>';
                    $posicao = $posicao+1;}?>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
            
            <div class="col-md-6">
            <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Tabela Grupo B</h3>
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
                        <?php $sqlgrupob = mysqli_query($mysqli,"SELECT * FROM teams where teams_match_duration = 40 and teamd_fields_id = 2 order by points DESC, goals_balance DESC");
                       $posicao = 1;
                    while ($data5 = mysqli_fetch_assoc($sqlgrupob)) {
                    echo '
                    <tr>
                      <td>'.$posicao.'</td>
                      <td><a href="./index.php?id=' . $data5['id_teams'] . '"><span style="font-family: \'Source Sans Pro\', Arial, serif; font-size:16px; color:black;">'.$data5['teams_name'].'</span></a></td>
                      <td><b>'.$data5['points'].'</b></td>
                      <td>'.$data5['victories'].'</td>
                      <td>'.$data5['draws'].'</td>
                      <td>'.$data5['losses'].'</td>
                      <td>'.$data5['goals_balance'].'</td>
                    </tr>';
                    $posicao = $posicao+1;}?>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
    
    
    <!--<div class="row">
        
        <div class="col-md-6">
                php $sqlpartida = mysqli_query($mysqli,"SELECT * FROM videos where team_id = 5 and type = 'v' order by date DESC LIMIT 1");
                    while ($data3 = mysqli_fetch_assoc($sqlpartida)) {
                    echo '
                    <form name="f" id="f" onSubmit="return false">
                    <input type="hidden" name="video" value="' . $data3['webaddress'] . '">
                    <input type="hidden" id="'.$data3['webaddress'].'_equip" name="equipe" value="' . $id . '">
                    
                        <div style="width: 100%; margin:10px auto; 20px; auto;" ><iframe type="text/html" id="video_iframe" width="100%" src="https://www.youtube.com/embed/' . $data3['webaddress'] . '?enablejsapi=1&version=3" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </form>';}?>
        </div><!-- /.col -
        
         <div class="col-md-6">
                php $sqlpartida = mysqli_query($mysqli,"SELECT * FROM videos where team_id = 5 and type = 'v' order by date DESC LIMIT 1");
                    while ($data3 = mysqli_fetch_assoc($sqlpartida)) {
                    echo '
                    <form name="f" id="f" onSubmit="return false">
                    <input type="hidden" name="video" value="' . $data3['webaddress'] . '">
                    <input type="hidden" id="'.$data3['webaddress'].'_equip" name="equipe" value="' . $id . '">
                    
                        <div style="width: 100%; margin:10px auto; 20px; auto;" ><iframe type="text/html" id="video_iframe" width="100%" src="https://www.youtube.com/embed/' . $data3['webaddress'] . '?enablejsapi=1&version=3" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </form>';}?>
        </div><!-- /.col 
    </div>--> 
    
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
                      <th>Equipe</th>
                      <th style="width: 50px">Gols</th>
                    </tr>
                    <?php $sqlartilharia = mysqli_query($mysqli,"SELECT p.goals, p.players_name, id_players, t.teams_name, t.id_teams FROM players p left join teams t on p.`players_team_id` = t.id_teams where goals > 0 order by goals DESC LIMIT 10");
                        $posicao = 1;
                    while ($data8 = mysqli_fetch_assoc($sqlartilharia)) {
                    echo '
                    <tr>
                      <td>'.$posicao.'</td>
                      <td><a href="./jogador.php?id='.$data8['id_players'].'"><span style="color:black;">'.$data8['players_name'].'<span></a></td>
                      <td><a href="./index.php?id='.$data8['id_teams'].'"><span style="color:black;">'.$data8['teams_name'].'<span></a></td>
                      <td><span>'.$data8['goals'].'</span></td>
                    </tr>';
                    $posicao = $posicao+1;}?>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
        </div><!-- /.col --> 
        
    <div class="col-md-6">
                       <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Goleiros Menos Vazados</h3>
                </div>
                <div class="box-body">
                  <table class="table table-bordered">
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Nome</th>
                      <th>Equipe</th>
                      <th style="width: 50px">Gols Sof.</th>
                    </tr>
                    <?php $sqlartilharia = mysqli_query($mysqli,"SELECT p.goals_taken, p.players_name, t.teams_name, id_players, t.id_teams FROM players p left join teams t on p.`players_team_id` = t.id_teams where goals_taken > 0 order by goals_taken LIMIT 10");
                        $posicao = 1;
                    while ($data8 = mysqli_fetch_assoc($sqlartilharia)) {
                        
                    echo '
                    <tr>
                      <td>'.$posicao.'</td>
                      <td><a href="./jogador.php?id='.$data8['id_players'].'"><span style="color:black;">'.$data8['players_name'].'<span></a></td>
                      <td><a href="./index.php?id='.$data8['id_teams'].'"><span style="color:black;">'.$data8['teams_name'].'<span></a></td>
                      <td><span>'.$data8['goals_taken'].'</span></td>
                    </tr>';
                    $posicao = $posicao+1;}?>
                  </table>
                </div>
              </div>
        </div><!-- /.col --> 
    </div>
    
    <div class="row" style="margin-top:15px;">
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
                <h3><?php echo $count_videos['total']/2; ?></h3>
                <p>Jogos Publicados</p>
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
                    <h3><?php echo $count_plays['total']; ?></h3>
                    <p>Marcações</p>
                </div>
                <div class="icon">
                    <i class="ion ion-checkmark-round"></i>
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
