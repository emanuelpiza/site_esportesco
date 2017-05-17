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
    $sqlgeral = mysqli_query($mysqli,"
        SELECT 
            m.*, t1.`teams_name` as team1_name, f.fields_coordinates,
            f.fields_name, t1.`teams_name` as team1_full_name, t2.`teams_name` as team2_name, t1.teams_picture as t1_picture, t2.teams_picture as t2_picture, date_format(m.datetime, '%Hh%i') as hour, date_format(m.datetime,'%d/%m') as date 
        FROM matches m left join teams t1 on m.team1 = t1.`id_teams` left join teams t2 on      m.`team2` = t2.id_teams left join fields as f on f.id_fields = m.field_id 
        WHERE id = '$id'");
    $dados = mysqli_fetch_assoc($sqlgeral);
    $sqlcount_players = mysqli_query($mysqli,"SELECT points FROM teams where id_teams='$id'");

    $sqlcup = mysqli_query($mysqli,"SELECT c.id, c.name, sport, sponsor, sponsor_url from cups c left join matches m on c.id = m.cup_id where m.id = '$id'");
    $cup = mysqli_fetch_assoc($sqlcup);
    $sport = $cup['sport'];
    $copa = $cup['id'];
    $sponsor = $cup['sponsor'];
    $sponsor_url = $cup['sponsor_url'];
    $nome_copa = $cup['name'];

    if ($sport == "Futebol de Salão"){
        $arena = "futsal.jpeg";
    } else {
        $arena = "gramado.jpg";
    }

    $count_players = mysqli_fetch_assoc($sqlcount_players);
    $sqlcount_videos = mysqli_query($mysqli,"SELECT goals_balance FROM teams where id_teams='$id'");
    $count_videos = mysqli_fetch_assoc($sqlcount_videos);
    $nome = $dados['teams_name'];
    $team1 = $dados['team1'];
    $team2 = $dados['team2'];
    $title = $dados['title'];
    $subtitle = $dados['subtitle'];
    $author_name = $dados['author_name'];
    $author_link = $dados['author_link'];
    $live_link = $dados['live_link'];

    $sqlcount_plays = mysqli_query($mysqli,"SELECT count(*) as total FROM plays where available in (1,2) and teams_name LIKE '%".$nome."%' ");
    $count_plays = mysqli_fetch_assoc($sqlcount_plays);
    $sql_anos = mysqli_query($mysqli,"SELECT YEAR(teams_schedule_date) as year FROM teams WHERE id_teams='$id'");
    $anos = mysqli_fetch_assoc($sql_anos);
    $sql_jogadores = mysqli_query($mysqli,"SELECT * FROM players where players_team_id in ('$team1', '$team2') order by players_name");
    while ($data4 = mysqli_fetch_assoc($sql_jogadores)) {
        $selecoes .= "<option value=".$data4['id_players'].">".$data4['players_name']."</option>" ;
    }

    $sql_notes = mysqli_query($mysqli,"
    select p1.*, p2.`players_name`, t3.teams_picture from (
        SELECT  t1.`id`,
        	t1.`match_id`,
            t1.`initial_time`,
            t1.`type`,
            t1.`player`,
            t1.available,
            '' as detail
        FROM notes t1
        LEFT JOIN plays t2 ON t2.`datetime` = t1.`datetime` where t1.match_id ='$id'
        UNION
        SELECT   t2.`id_plays` as id,
         	t2.`match_id`,
            t2.`initial_time`,
            (6) as type , 
            t2.`plays_players_id` as player,
            t2.available,
            t2.`video_id` as detail
        FROM notes t1
        RIGHT JOIN plays t2 ON t2.`datetime` = t1.`datetime` where plays_play_types_id > -1 and t2.match_id ='$id'  ) p1 
    left join players p2 on p1.player = p2.`id_players` left join teams t3 on p2.players_team_id = t3.id_teams  where p1.`available` in (1,2) and match_id ='$id' order by p1.`initial_time` DESC;");
    $titulo = $dados['team1_name'] . ' vs ' . $dados['team2_name'] . ' - EsportesCo';
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
    
    <title><?php echo $titulo ?></title>

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
    <link rel="shortcut icon" href="../img/favicon-trophy.ico" />
     <!-- jQuery -->
    <script src="./js/jquery.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Chivo" rel="stylesheet">
    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/app.js"></script>
    <script src="../js/Chart.js"></script>
    <link rel="stylesheet" type="text/css" href="./countdown/jquery.countdown.css"> 
    <script type="text/javascript" src="./countdown/jquery.plugin.js"></script> 
    <script type="text/javascript" src="./countdown/jquery.countdown.js"></script> 
    <script type="text/javascript" src="./countdown/jquery.countdown-pt-BR.js"></script>
    
    <link href='https://fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Oleo+Script:400,700" rel="stylesheet">
    
		<meta name = "viewport" content = "initial-scale = 1, user-scalable = no">
    
    <!-- Include Mask plugin -->
    <script src="http://oss.maxcdn.com/jquery.mask/1.11.4/jquery.mask.min.js"></script>
    <style>
        .scrolloff {
            pointer-events: none;
        }
        /* --------- */
        /* MEGA MENU */
        /* --------- */
        .menu-item-object-oxy_mega_menu {
          position: static !important;
        }
        .menu-item-object-oxy_mega_menu .dropdown-menu {
          left: 0px !important;
          right: 0px !important;
          overflow: hidden;
          background-position: center;
          background-size: cover;
        }
        .menu-item-object-oxy_mega_menu .dropdown-menu > li {
          position: relative;
          padding-left: 0;
          padding-right: 0;
        }
        .menu-item-object-oxy_mega_menu .dropdown-menu > li:before {
          content: "";
          position: absolute;
          height: 1000px;
          width: 1px;
          left: 0;
          top: 3px;
        }
        .menu-item-object-oxy_mega_menu .dropdown-menu > li:first-child:before {
          display: none;
        }
        .menu-item-object-oxy_mega_menu .dropdown-menu > li > ul {
          list-style-type: none;
          padding: 0px;
          overflow: hidden;
        }
        .menu-item-object-oxy_mega_menu .dropdown-menu > li > ul > li {
          padding-bottom: 0px;
          margin-left: 30px;
        }
        .menu-item-object-oxy_mega_menu .dropdown-menu > li > ul > li > a {
          padding: 8px 20px;
          display: block;
          font-size: 14px;
          -moz-transition: color 0.1s;
          -o-transition: color 0.1s;
          -webkit-transition: color 0.1s;
          transition: color 0.1s;
          position: relative;
        }
        .menu-item-object-oxy_mega_menu .dropdown-menu > li > strong {
          text-indent: 20px;
          line-height: 37px;
          display: block;
        }
        .menu-item-object-oxy_mega_menu .dropdown-menu > li > strong a {
          padding: 0;
          line-height: 37px;
          display: block;
        }
        .menu-item-object-oxy_mega_menu .dropdown-menu > li .fa {
          text-indent: 0;
        }
        .menu-item-object-oxy_mega_menu .dropdown-menu > li .menu-widget {
          padding: 8px 20px;
        }
        .menu-item-object-oxy_mega_menu .dropdown-menu > li > p {
          font-size: 14px;
          font-style: italic;
          padding-bottom: 12px;
          margin-bottom: 0px;
          border-bottom: 1px solid;
        }

        .container-fullwidth .menu-item-object-oxy_mega_menu .dropdown-menu {
          margin-left: 15px !important;
          margin-right: 15px !important;
        }

        .oxy_mega_menu-no-dividers > ul > li:before {
          display: none;
        }

        .oxy_mega_menu-no-dividers > ul > li > p {
          border: 0 !important;
        }

        @media (max-width: 992px) {
          .menu-item-object-oxy_mega_menu {
            position: relative !important;
          }

          .menu-item-object-oxy_mega_menu .dropdown-menu {
            background-image: none !important;
          }

          .menu-item-object-oxy_mega_menu .dropdown-menu > li > ul > li > a {
            padding-left: 0px;
            padding-right: 0px;
          }
        }
        .rec_button {
            width: 35px;
            height: 35px;
            font-size: 0;
            background-color: red;
            border: 0;
            border-radius: 35px;
            margin: 18px;
            outline: none;
        }

        .notRec{
            background-color: darkred;
        }

        .Rec{
            animation-name: pulse;
            animation-duration: 1.5s;
            animation-iteration-count: infinite;
            animation-timing-function: linear;
        }

        @keyframes pulse{
            0%{
                box-shadow: 0px 0px 5px 0px rgba(173,0,0,.3);
            }
            65%{
                box-shadow: 0px 0px 5px 13px rgba(173,0,0,.3);
            }
            90%{
                box-shadow: 0px 0px 5px 13px rgba(173,0,0,0);
            }
        }
    </style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('#timer').countdown({
            until: new Date(2020, 8 - 1, 8),
            compact: true
        });
        $('#map').addClass('scrolloff');                // set the mouse events to none when doc is ready
        
        $('#overlay').on("mouseup",function(){          // lock it when mouse up
            $('#map').addClass('scrolloff'); 
            //somehow the mouseup event doesn't get call...
        });
        $('#overlay').on("mousedown",function(){        // when mouse down, set the mouse events free
            $('#map').removeClass('scrolloff');
        });
        $("#map").mouseleave(function () {              // becuase the mouse up doesn't work... 
            $('#map').addClass('scrolloff');            // set the pointer events to none when mouse leaves the map area
                                                        // or you can do it on some other event
        });
        
    });
</script>
    <!-- Hotjar Tracking Code for http://www.esportes.co -->
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:280196,hjsv:5};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'//static.hotjar.com/c/hotjar-','.js?sv=');
</script>
    <link rel="stylesheet" href="http://www.esportes.co/novo/assets/css/swatch-red-white.min.css">
</head>

<body class="skin-blue" style="padding-left:10px; padding-right:10px; background-color:#F0F8FF;">
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
        include("../navbar.php");
    ?>
    
    <!--
    Botão do Local, quando tinha coordenadas<a href="#" data-toggle="modal" data-target="#myModal">'.$dados['fields_name'].'.</a>
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Local</h4>
            </div>
            <div class="modal-body">
                <div style="width: 95%; height:95%; margin:10px auto; 10px; auto;" >
                    <div id="overlay" class="map">
                        <iframe id="map" src="php echo $dados['fields_coordinates'] ?>" width="100%" height="350" frameborder="0" ></iframe>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>--> 
  <?php 
        if ($dados['cup_id'] <> 0) {
        echo '
            <div class="row">
                <div class="col-xl-offset-5 col-xl-2 center-block" style="text-align:center; margin-bottom:0px;">
                    <span style="font-family: Roboto, Arial, serif; font-size:12px;">'. $dados['date'].' às '.$dados['hour'].'
                    <br>'.$dados['fields_name'].'.</span>
                </div>
            </div>
         <div class="row" style="margin-bottom:10px;">
             <div class="col-md-6 col-md-offset-3">
          <a href="./index.php?id='.$dados['team1'].'">

                <div class="col-xs-4" style="text-align:right; padding:0;">
                    <img src="../cadastro/uploads/'.$dados['t1_picture'].'" style="width:80px; margin-right:5px;">
                </div>

                <div  class="col-xs-1" style="text-align:center; font-size:15px;padding:0;">
                    <span style="font-family: Arial, serif; font-size:60px;text-align:left; margin-right:-25px; margin-left:-15px; color:black;font-weight:bolder;">'.$dados['score1'].'</span>
                </div>
            </a>

          <div  class="col-xs-2 center-block" style="text-align:center; font-size:30px; margin-top:20px;">X</div>

          <a href="./index.php?id='.$dados['team2'].'">
                <div  class="col-xs-1" style="text-align:center; font-size:15px; padding:0;">
                    <span style="font-family: Arial, serif; font-size:60px;text-align:left; margin-left:-25px; color:black;font-weight:bolder;">'.$dados['score2'].'</span>
                </div>

                <div  class="col-xs-4" style="padding:0;">
                    <img src="../cadastro/uploads/'.$dados['t2_picture'].'" style="width:80px; margin-left:5px">
              </div>
          </a>
        </div>
        </div>';} 
        else {
            echo '
                <div class="col-sm-6 col-sm-offset-3" style="text-align:center; height: 80px; line-height: 80px; margin-bottom:10px;">
                     <a href="./index.php?id='.$dados['team1'].'"><span style="font-family: \'Poiret One\', Arial, serif; font-size:40px; color:black;">'.$dados['team1_full_name'].' - '. $dados['date'].' </span> </a>
                </div> ';
        } ?>
   
    <div class="row"> 
        <div class="col-md-12" style="margin-bottom:20px;">
          <h1 style="text-align:center;">
              <?php if ($title <> "") { echo $title."<br>";}?>
            <small><?php echo $subtitle; ?></small><br>
          </h1>
            <?php 
                if ($live_link <> "") {
                    echo '<h5 style="text-align:center;">Acompanhe <a href="'.$live_link.'" target="_blank">ao vivo</a>.</h5>';}
                if ($author_name <> "") {
                    echo '<h5 style="text-align:center;">Informações e imagens por: <a href="'.$author_link.'">'.$author_name.'</a>.</h5>';}
            ?>
        </div>
    </div>
    <div class="row"> 
        <div class="col-md-8 col-md-offset-2">
             
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Vídeos</h3>
                </div><!-- /.box-header -->
                   
                <?php $sqlpartida = mysqli_query($mysqli,"SELECT * FROM matches where id = '$id'");
                    while ($data3 = mysqli_fetch_assoc($sqlpartida)) {
                        
                        if ($data3['status'] <> null) {
                            $msg_video = "VÍDEO EM <BR>PROCESSAMENTO.<BR>DISPONÍVEL<BR> EM BREVE.";
                            
                        } else {
                            $msg_video = "<a href='../cadastro/info_partida.php?match=".$id."'><button type='button' class='btn btn-success btn-lg'>Subir Vídeos</button></a>";
                        }
                        if ($data3['match_video_id'] == null) {
                            $cover = " 
                            <div style=\" -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;background-image: url(./img/".$arena.");\">
                                <div style=\"height: 460px; margin:10px auto; 10px; auto;\" >
                                    <div class\"embed-responsive embed-responsive-16by9\" style=\"text-align:center; margin:-25px -10px 25px -10px; color:white;padding-top:10px;\">
                                        <h1 style=\"font-family: 'Chivo', sans-serif;\">".$msg_video."</h1>
                                        <div id=\"timer\"></div>
                                    </div>
                                </div>
                            </div>
                        "; // Vídeo não está disponível
                        } else{
                            $cover = '
                        <iframe type="text/html" id="video_iframe" width="100%" src="https://www.youtube.com/embed/' . $data3['match_video_id'] . '?enablejsapi=1&version=3" frameborder="0" allowfullscreen></iframe>
                        </div>
                         <div class="row">
                            <div class"col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4" style="padding:8px; margin:14px; 
                            border: 1px solid gray;">
                            <h4 style="text-align:center; margin-top:0px;font-family: Roboto, Arial, serif; font-size:15px;">Recortar Últimos 10s </h4>
                                 <div class="btn-group btn-group-justified">
                                  <a class="btn btn-success"  onclick=\'marcacao("'.$data3['match_video_id'].'", "0"," '.$data3['field_id'].'")\'>Lado Esquerdo</a>
                                  <a class="btn btn-success"  onclick=\'marcacao("'.$data3['match_video_id'].'", "1"," '.$data3['field_id'].'")\'>Lado Direito</a>
                                </div>
                            </div>
                         </div>
                         <!--<div class="row">
                            <div class="col-xs-6 col-md-6" style="margin-top:20px;">
                                <button class="btn btn-sm btn-success"  style="margin: 10 auto; float:right; width:140px;" onclick=\'marcacao("'.$data3['match_video_id'].'", "0"," '.$data3['field_id'].'")\'>Recortar 10s<br>Lado Esquerdo</button>
                                <button id="recButton" class="rec_button"><span style="color:white;" class="glyphicon glyphicon-record">A</span></button>
                            </div>
                            <div class="col-xs-6 col-md-6" style="margin-top:20px;float:right;">
                                <button class="btn btn-sm btn-success"  style="margin: 10 auto; width:140px;" onclick=\'marcacao("'.$data3['match_video_id'].'", "1"," '.$data3['field_id'].'")\'>Recortar 10s<br>Lado Direito</button>
                            </div>
                        </div>  -->
                        ';};
                    echo '
                    <form name="f" id="f" onSubmit="return false">
                    <input type="hidden" name="video" value="' . $dados['match_video_id']  . '">
                    <input type="hidden" id="'.$dados['match_video_id'] .'_equip" name="equipe" value="' . $id . '">
                        <div style="width: 95%; margin:10px auto; 10px; auto;" > <div class="embed-responsive embed-responsive-16by9">
                        '.$cover.'
                        </div>
                    </form>';}?>
                         
                          <div class="box-body no-padding">
                        <div class="fb-comments" data-href="http://www.esportes.co/times/partida.php?id=<?php echo $id ?>" data-width="100%" data-numposts="5"></div>
                    </div><!-- /.box-body -->
                </div>
            <?php $sqlfoto = mysqli_query($mysqli,"SELECT * FROM videos where team_id = '$id' and type = 'p' order by date DESC LIMIT 1");
                while ($datafoto = mysqli_fetch_assoc($sqlfoto)) {
                    echo'
                <!-- Fotos LIST -->
                  ';
            }?>
            
            
              <?php $sqlmelhores = mysqli_query($mysqli,"SELECT * FROM videos where team_id = '$id' and type = 'm' order by date DESC LIMIT 1");
                while ($datamelhores = mysqli_fetch_assoc($sqlmelhores)) {
                    echo'
                <!-- Fotos LIST -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Melhores Momentos</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                          <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/'. $datamelhores['webaddress'] . '" frameborder="0" allowfullscreen></iframe>

                    </div><!-- /.box-body -->
                </div><!--/.box -->    ';
            }?>
          
        </div><!-- /.col --> 
    </div>
    

    <div class="row">  
        <div class="col-md-8 col-md-offset-2">
             <section class="content-header">
          <h1>
            Linha do Tempo
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
                  <?php if ($dados['interview'] <> ""){
                    echo '
                  <li>
                      <i class="fa fa-video-camera bg-gray"></i>
                      <div class="timeline-item">
                        <h3 class="timeline-header">Entrevistas</h3>
                        <div class="timeline-body">
                          <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/'.$dados['interview'].'" frameborder="0" allowfullscreen=""></iframe>
                          </div>
                        </div>
                      </div>
                  </li> ';} ?>
                  <li class="time-label">
                      <span class="bg-gray">
                        Fim de Jogo
                      </span>
                  </li>
                  <?php while ($notes = mysqli_fetch_assoc($sql_notes)) {
                    if ($notes['type'] == 1){
                        echo '<li><i class="fa fa-soccer-ball-o bg-white" style="color:black;"></i>
                            <div class="timeline-item">
                            <span class="time"><i class="fa fa-clock-o"></i> '.$detail.$notes['initial_time'].'</span>
                            <h3 class="timeline-header"><img src="../cadastro/uploads/'.$notes['teams_picture'].'" style="max-width:30px; max-height:30px; margin-left:5px;"> Gol de <a href="./jogador.php?id='.$detail.$notes['player'].'">'.$detail.$notes['players_name'].'</a></h3>
                            </div>
                            </li>';
                    } else if ($notes['type'] == 2){
                        echo ' <li>
                            <i class="fa fa-square  bg-gray" style="color:#ffb606;"></i>
                            <div class="timeline-item">
                            <span class="time"><i class="fa fa-clock-o"></i> '.$detail.$notes['initial_time'].'</span>
                            <h3 class="timeline-header"><img src="../cadastro/uploads/'.$notes['teams_picture'].'" style="max-width:30px; max-height:30px; margin-left:5px;"> Cartão amarelo para <a href="./jogador.php?id='.$detail.$notes['player'].'">'.$detail.$notes['players_name'].'</a></h3>
                            </div>
                            </li>';
                    } else if ($notes['type'] == 3){
                        echo ' <li>
                        <i class="fa fa-square  bg-gray" style="color:red;"></i>
                        <div class="timeline-item">
                         <span class="time"><i class="fa fa-clock-o"></i> '.$detail.$notes['initial_time'].'</span>
                        <h3 class="timeline-header"><img src="../cadastro/uploads/'.$notes['teams_picture'].'" style="max-width:30px; max-height:30px; margin-left:5px;"> Cartão vermelho para <a href="./jogador.php?id='.$detail.$notes['player'].'">'.$detail.$notes['players_name'].'</a></h3>
                        </div>
                        </li>';
                    } else if ($notes['type'] == 4){
                        echo '<li><i class="fa fa-soccer-ball-o bg-white" style="color:black;"></i>
                            <div class="timeline-item">
                            <span class="time"><i class="fa fa-clock-o"></i> '.$detail.$notes['initial_time'].'</span>
                            <h3 class="timeline-header"><img src="../cadastro/uploads/'.$notes['teams_picture'].'" style="max-width:30px; max-height:30px; margin-left:5px;"> Gol contra de <a href="./jogador.php?id='.$detail.$notes['player'].'">'.$detail.$notes['players_name'].'</a></h3>
                            </div>
                            </li>';
                    } else if ($notes['type'] == 5){
                        echo '<li>
                  <i class="fa fa-exchange bg-gray"></i>
                  <div class="timeline-item">
                    <h3 class="timeline-header no-border">Lucas Moura saiu para a entrada de <a href="#">Joaquim Barbosa</a></h3>
                      
                    <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>
                  </div>
                </li>';
                    } else if ($notes['type'] == 6){
                        echo ' <li id="'. $notes['detail'] .'">
                    <i class="fa fa-video-camera bg-gray"></i>
                    <div class="timeline-item">
                  
                        <button type="button" class="btn btn-box-tool" style="float:right; margin-top:4px;" onclick=\'deletar("' . $notes['detail'] . '")\' title="Remover"><i class="fa fa-times"></i></button>
                            
                        <a href="lances/' .$detail. $notes['detail'] . '.mp4" download="Lance ' . $titulo .'.mp4"> <button class="btn btn-box-tool" style="float:right; margin-top:4px;"  title="Download"><i class="fa fa-download"></i></button></a>
                          
                        <span class="time"><i class="fa fa-clock-o"></i>
                        '.$detail.$notes['initial_time'].'
                        </span>
                        
                    <h3 class="timeline-header">Vídeo</h3>
                    <div class="timeline-body">
                      <div class="embed-responsive embed-responsive-16by9">
                               <video width="100%" loop onclick="this.paused?this.play():this.pause();">
                                  <source src="lances/'.$detail.$notes['detail'].'.mp4" type="video/mp4" />
                                    Seu navegador não suporta este formato de vídeos. Atualize seu navegador.
                                </video>
                              </div>
                    </div>
                    <div class="timeline-footer" style="height:30px;">

                        
                        <div class="form-group col-xs-6" style="float:right; width:100%; margin-top:-5px;" id="' . $notes['detail'] . '_categ">
                            <div class="form-group">
                                <a class="btn btn-xs btn-success" style="float:right; width:60px; margin-top:-7px;  margin-right:-10px;" onclick=\'estatisticas("' . $notes['detail'] . '")\'>Salvar</a>
                                <select id="' . $notes['detail'] . '_craq" class="form-control bg-white" style="float:right; margin-top:-7px; width:120px; margin-right:10px; height: auto; line-height: 14px;">
                                    <option value="45">Atribuir</option>
                                    '. $selecoes .'
                                </select>
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
               <?php 
        if ($sponsor <> ""){
            echo '
        <div class="row" style="margin-bottom:20px;">
        <div class="col-xl-offset-5 col-xl-2 center-block" style="text-align:center">
            <h4 style="color:#555;">Oferecimento:</h4>
            <a href="'.$sponsor_url.'" target="_blank">
            <img src="../img/'.$sponsor.'" style="display: block; margin-left: auto; margin-right: auto; width:150px;">
            </a>
        </div>
        </div>';
        }
    ?>
        
        </section>
            </div>
    </div>
    <script>
        $('#recButton').addClass("notRec");

        $('#recButton').click(function(){
            if($('#recButton').hasClass('notRec')){
                $('#recButton').removeClass("notRec");
                $('#recButton').addClass("Rec");
            }
            else{
                $('#recButton').removeClass("Rec");
                $('#recButton').addClass("notRec");
            }
        });	
    </script>
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
        
    function marcacao(strVideo, lado_esq, campo) {
        var time = player.getCurrentTime();
        if (time < 9){
            swal("Não foi possível identificar o momento.", "Pressione o botão assim que assistir algum lance no vídeo acima.", "warning");
        } else{
        var hours = parseInt( time / 3600 ) % 24;
        var minutes = parseInt( time / 60 ) % 60;
        var seconds = (time % 60).toFixed(0);
        var strMomento = hours+":"+minutes+":"+seconds;
        
        swal("Marcação Realizada em "+strMomento, "Vídeo em processamento. Isso pode levar alguns minutos.", "success");
        
        $.post("acoes.php",{acao: "marcar",video: strVideo, momento: strMomento, radio_lado: lado_esq, jogada: 0, partida: <?php echo $id?>, campo: campo, is_two_cameras: <?php echo $dados['is_two_cameras'];?> },function(data){});    
        }
    }
        
    function estatisticas(strVideo) {
        
        var craq = document.getElementById(strVideo + "_craq");
        var strPlayer = craq.options[craq.selectedIndex].value;
        
        if (strPlayer == 45){
            swal("Quem participou desta jogada?", "Pressione 'Salvar' após atribuir um jogador.", "warning");
        } else{
            
        swal("Atribuição Realizada!", "Você ainda pode escolher mais de um jogador para a mesma jogada.", "success");
        
        $.post("acoes.php",{acao: "estatisticas",video: strVideo, player: strPlayer, match: <?php echo $id;?>},function(data){});
        }
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
