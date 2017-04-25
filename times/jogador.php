<?php
    session_start();

    ob_start();
    include('../admin/dbcon/dbcon.php');

    if (isset($_SESSION["logname"])) {
        $_SESSION["error1"] = "Please Sign in";
        header("Location: index.php");
    }
    $id = $_GET['id'];
    $sqlgeral = mysqli_query($mysqli,"SELECT p.*, players_stats_average, t.`teams_picture` FROM players p left join teams t on p.`players_team_id` = t.`id_teams` where id_players='$id'");
    $dados = mysqli_fetch_assoc($sqlgeral);
    $jogador = $dados['id_players'];
    $time = $dados['players_team_id'];

    $sqlcup = mysqli_query($mysqli,"SELECT c.id from cups c left join teams t on c.id = t.cup_id where t.id_teams = '$time'");
    $cup_id = mysqli_fetch_assoc($sqlcup)['id'];

// Lances
    $sqllances = mysqli_query($mysqli,"SELECT p.*, CONCAT(t1.`teams_name`, ' vs ', t2.`teams_name`, ' - ', date_format(m.datetime,'%d/%m')) as partida FROM plays p left join matches m on p.`match_id` = m.`id` left join teams t1 on m.`team1` = t1.`id_teams` left join teams t2 on m.team2 = t2.`id_teams` where ( assistance = '$id' or plays_players_id='$id') and available in (1,2) order by datetime DESC");

    $sql_count = mysqli_query($mysqli,"SELECT count(1) as total FROM plays p left join matches m on p.`match_id` = m.`id` left join teams t1 on m.`team1` = t1.`id_teams` left join teams t2 on m.team2 = t2.`id_teams` where ( assistance = '$id' or plays_players_id='$id') and available in (1,2)");
    $dados3 = mysqli_fetch_assoc($sql_count);
    $count = $dados3['total'];
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Emanuel Piza" >

    <title><?php echo $dados['players_name']; ?> - EsportesCo</title>

   <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../css/AdminLTE.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../css/_all-skins.min.css">
    <!-- Ícones -->
    <link rel="shortcut icon" href="../img/favicon-trophy.ico" />
    <link href="https://fonts.googleapis.com/css?family=Denk+One" rel="stylesheet">
    
    <script src="./js/Chart.js"></script>
		<meta name = "viewport" content = "initial-scale = 1, user-scalable = no">
		<style>
			canvas{
			}
            .estrela {
                width:50%;
            }
            #estrela_content{
                font-size:50px; color:#CCC; opacity: 0.8; filter: alpha(opacity=80); 
                display:-moz-box;
                -moz-box-pack:center;
                -moz-box-align:center;
                display:-webkit-box;
                -webkit-box-pack:center;
                -webkit-box-align:center;
                display:box;
                box-pack:center;
                box-align:center;
                margin-left: -50px;
            }
		</style>
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <style>
        .banner {
        padding: 100px 0;
        color: #f8f8f8;
        background: url(../img/pedra.jpg) no-repeat center center;
        background-size: cover;
        }

        .banner a:link {
            color: #f8f8f8;
        }

        /* visited link */
        .banner a:visited {
            color: #f8f8f8;
        }

        /* mouse over link */
        .banner a:hover {
            color: #f8f8f8;
        }

        /* selected link */
        .banner a:active {
            color: #f8f8f8;
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
    </style>
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
    <?php 
        include_once("./admin/analyticstracking.php");
    ?> 
    
    <header id="masthead" class="navbar navbar-sticky navbar-stuck swatch-red-white" role="banner" style="margin-left:-13px;margin-right:-13px;">
        <div class="container">
            <div class="navbar-header">
                <a href="./copa.php?id=<?php echo $cup_id; ?>">       
                    <span style="font-size:35px; margin-left:10px; position:absolute;"><i class="fa fa-trophy" aria-hidden="true"></i></span> 
                </a>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".main-navbar"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
                </button>
            </div>
            <nav class="navbar-collapse main-navbar collapse" role="navigation" aria-expanded="false" style="height: 1px;">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="http://www.esportes.co/index.php" class="dropdown-toggle"><i class="fa fa-newspaper-o" aria-hidden="true"></i> Notícias
                        </a>
                    </li>
                    <li class="dropdown menu-item-object-oxy_mega_menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                             <i class="fa fa-trophy" aria-hidden="true"></i> Campeonatos Atuais
                        </a>
                        <ul class="dropdown-menu row">
                            <li class="dropdown col-md-4 menu-item-object-oxy_mega_columns">
                                <strong>Futebol de Campo</strong>
                                <ul role="menu">
                                    <li>
                                        <a href="../times/copa.php?id=17">Série - A</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown col-md-4 menu-item-object-oxy_mega_columns"><strong>Futebol Society</strong>
                                <ul role="menu">
                                    <li>
                                        <a href="../times/copa.php?id=1">15º Copa Benteler</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown col-md-4 menu-item-object-oxy_mega_columns">
                                <strong>Futsal</strong>
                                <ul role="menu">
                                    <li>
                                        <a href="../times/copa.php?id=23">Liga Futsal Rioclarense Masculino</a>
                                    </li>
                                    <li>
                                        <a href="../times/copa.php?id=24">Liga Futsal Rioclarense Feminino</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="http://www.esportes.co/novo.php" class="dropdown-toggle">
                            <i class="fa fa-plus" aria-hidden="true"></i> Criar Novo
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="http://www.esportes.co/anuncie.php" class="dropdown-toggle">
                            <i class="fa fa-heartbeat" aria-hidden="true"></i> Anuncie
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Fórmulas</h4>
      </div>
      <div class="modal-body">
        <p><b>Vitórias:</b> Coletivo. Aumenta em 15 pontos para cada vitória da equipe.</p>
        <p><b>Ataque:</b> Coletivo. Aumenta em 2,5 pontos para cada gol da equipe.</p>
        <p><b>Defesa:</b> Coletivo. Aumenta em 15 pontos para cada partida disputada. Diminui em 2,5 pontos para cada gol sofrido pela equipe.</p>
        <p><b>Futebol arte:</b> Individual. Aumenta em 10 pontos para cada lance atribuído ao jogador.</p>
        <p><b>Na bola:</b> Individual. Aumenta em 15 pontos para cada partida disputada. Diminui em 5 pontos para cada infração (faltas ou cartões).</p>
        <p><b>Comprometimento:</b> Individual. É a base para os demais. Aumenta em 20 pontos para cada partida da equipe em que o jogador esteve presente (em campo ou no banco).</p>
        <p>Obs.: Valores entre 10 e 99, atualizados no encerramento de cada partida, com base nas anotações da arbitragem.</p>  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>

  </div>
</div>
    
    
        <div class="col-md-4">
            <div class="row">
            <div class="center-block" style="max-width:450px;">
              <!-- Widget: user widget style 1 -->
              <div class="box box-widget widget-user" style=" overflow: hidden;">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-light-blue-gradient banner" style="color:white; text-align:center; margin-bottom:3px;">
                    <a href="./index.php?id=<?php echo $dados['players_team_id']; ?>">
                    <img src="../cadastro/uploads/<?php echo $dados['teams_picture']; ?>" style="
                        position: absolute; top: -10px; right:-70px; width:150px;   opacity: 0.5; filter: alpha(opacity=50); -webkit-filter: grayscale(100%); filter:grayscale(100%);  -ms-transform: rotate(10deg); -webkit-transform: rotate(10deg); transform: rotate(10deg);">
                    <div class="col-xs-offset-5 col-xs-7">
                        <h3 class="widget-user-username"><?php echo $dados['players_name']; ?></h3>
                        <h2 style="font-family: 'Denk One', sans-serif; margin-top:0px;"><?php echo $dados['shirt']; ?></h2>
                    </div></a>
                  </div>
                <div class="widget-user-image">
                  <img class="figurinha_img" style="margin-left:-10px; margin-top:-10px; height:184px; width:138px;" src="img/jogadores/<?php echo $dados['player_picture']; ?>">
                </div>
                <div class="box-footer">
                  <div class="row">
                    <div class="col-xs-2 col-xs-offset-6 border-right" style="margin-top:-20px;">
                      <div class="description-block">
                        <span class="description-text">Gols</span>
                        <h5 class="description-header"><?php echo $dados['goals']; ?></h5>
                      </div><!-- /.description-block -->
                    </div><!-- /.col -->
                      <div class="col-xs-2 border-right" style="margin-top:-20px;">
                          <div class="description-block">
                            <span class="description-text">C.A.</span>
                              <h5 class="description-header"><?php echo $dados['yellow_cards']; ?></h5>
                          </div><!-- /.description-block -->
                      </div><!-- /.col -->
                      <div class="col-xs-2" style="margin-top:-20px;">
                          <div class="description-block">
                            <span class="description-text">C.V.</span>
                              <h5 class="description-header"><?php echo $dados['red_cards']; ?></h5>
                          </div><!-- /.description-block -->
                      </div><!-- /.col -->
                      
                   <!-- <div class="col-xs-4 border-right" style="margin-top:-20px;">
                      <div class="description-block">
                        <span class="description-text">NOTA MÉDIA</span>
                        <h5 class="description-header">?php echo intval($dados['players_stats_average']); ?></h5>
                      </div><
                    </div><!-- /.col -->
                  </div><!-- /.row -->
                </div>
              </div><!-- /.widget-user -->

            <!-- DONUT CHART -->
              <div class="box">
                <div class="box-header with-border">
                    <a data-toggle="modal" data-target="#myModal" style="color:#666; cursor:pointer;"><span style="float:right; width:20px; text-align:center; margin-right:-4px;"><i class="fa fa-info" aria-hidden="true"></i></span></a>
                  <h3 class="box-title">Notas</h3>
                </div>
                <div class="box-body">
                    <canvas id="canvas" style="height:250px"></canvas>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
            </div><!-- /.col -->
    </div>
            <div class="col-md-8" style="margin-left:20px; margin-right:-20px;">
    

        <div class="row">
            
                <?php
                      
                    if ($count == 0){
                        echo '
                        <div class="col-xl-offset-5 col-xl-2 center-block">
                            <span id="estrela_content">
                            <i class="fa fa-star" aria-hidden="true" class="estrela"></i>
                            <i class="fa fa-star" aria-hidden="true" class="estrela"></i>
                            <i class="fa fa-star" aria-hidden="true" class="estrela"></i>
                            <i class="fa fa-star" aria-hidden="true" class="estrela"></i>
                            <i class="fa fa-star-half-o" aria-hidden="true" class="estrela"></i>
                            </span>
                            <h4 style="color:#CCC; opacity: 0.8; filter: alpha(opacity=80); width:90%;" align="center">
                                Para completar este perfil, <a href="./index.php?id='.$dados['players_team_id'].'" style="color:#CCC; text-decoration: underline;">assista as partidas</a> e indique lances para este jogador.
                            </h4>
                        </div>';
                    }else {
                        echo ' <section class="content-header" style="margin-bottom:10px; margin-top:-10px;">
                          <h1>
                            Lances
                          </h1>
                        </section>
                         <ul class="timeline">';
                        while ($data2 = mysqli_fetch_assoc($sqllances)) {
                            if ($partida <> $data2['match_id']){
                                echo '
                                    <li class="time-label">
                                    <span class="bg-light-blue">
                                        <a href="./partida.php?id=' . $data2['match_id'] . '"   style="color:white">' . $data2['partida'] . '</a>
                                    </span>
                                    </li>';    
                            }
                            echo '
                             <li>
                              <i class="fa fa-video-camera bg-gray"></i>
                              <div class="timeline-item">
                                <div class="timeline-body">
                                  <div class="embed-responsive embed-responsive-16by9">
                                    <video width="100%" loop onclick="this.paused?this.play():this.pause();">
                                      <source src="lances/' . $data2['video_id'] . '.mp4" type="video/mp4" />
                                      Seu navegador não suporta este formato de vídeos. Atualize seu navegador.
                                        </video>
                                  </div>
                                </div>
                              </div>
                            </li>';
                        $partida = $data2['match_id'];}
                        echo '
                    <li>
                      <i class="fa fa-clock-o bg-gray"></i>
                    </li>
                  </ul>        
                </div>';
                    }?>
        </div><!-- /.col -->
    </div>
    <!-- jQuery -->
    <script src="../js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script>
    // Closes the sidebar menu
    $("#menu-close").click(function(e) {
        e.preventDefault();
        $("#sidebar-wrapper").toggleClass("active");
    });

    // Opens the sidebar menu
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#sidebar-wrapper").toggleClass("active");
    });

    // Scrolls to the selected menu item on the page
    $(function() {
        $("#myTab a").click(function(e){
    		e.preventDefault();
    		$(this).tab('show');
    		});
    });
    
    </script>
    <script>
	var radarChartData = {
		labels: ["Vitórias", "Ataque", "Futebol arte", "Comprometimento", "Na bola", "Defesa"],
		datasets: [
		{
				label: "My Second dataset",
				fillColor: "rgba(151,187,205,0.2)",
				strokeColor: "rgba(151,187,205,1)",
				pointColor: "rgba(151,187,205,1)",
				pointStrokeColor: "#fff",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgba(151,187,205,1)",
				data: [<?php echo $dados['players_stats0']; ?>,<?php echo $dados['players_stats1']; ?>,<?php echo $dados['players_stats2']; ?>,<?php echo $dados['players_stats3']; ?>,<?php echo $dados['players_stats4']; ?>,<?php echo $dados['players_stats5']; ?>]
			}
		]
	};

	window.onload = function(){
		window.myRadar = new Chart(document.getElementById("canvas").getContext("2d")).Radar(radarChartData, {
			responsive: true
		});
	}

	</script>

</body>

</html>
