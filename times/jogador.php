<?php
    session_start();

    ob_start();
    include('../admin/dbcon/dbcon.php');

    if (isset($_SESSION["logname"])) {
        $_SESSION["error1"] = "Please Sign in";
        header("Location: index.php");
    }
    $id = $_GET['id'];
    $sqlgeral = mysqli_query($mysqli,"SELECT *, (red_cards + yellow_cards) as cartoes FROM players where id_players='$id'");
    $dados = mysqli_fetch_assoc($sqlgeral);
    $jogador = $dados['id_players'];
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
    <link rel="icon" type="image/png" href="../img/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="../img/favicon-16x16.png" sizes="16x16" />
    <link href="https://fonts.googleapis.com/css?family=Denk+One" rel="stylesheet">
    
    <script src="./js/Chart.js"></script>
		<meta name = "viewport" content = "initial-scale = 1, user-scalable = no">
		<style>
			canvas{
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
    </style>
</head>

<body class="skin-blue" style="padding:10px; background-color:#F0F8FF; padding-top: 70px;">
    <?php 
        include_once("./admin/analyticstracking.php");
        include('../navbar.php');
    ?>
            <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-0 col-lg-4" style="max-width:450px">
              <!-- Widget: user widget style 1 -->
              <div class="box box-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-light-blue-gradient banner" style="color:white; text-align:center;">
                    <div class="col-xs-offset-5 col-xs-7">
                        <h3 class="widget-user-username"><?php echo $dados['players_name']; ?></h3>
                        <h2 style="font-family: 'Denk One', sans-serif; margin-top:0px;"><?php echo $dados['shirt']; ?></h2>
                        <!--<h5 class="widget-user-desc" style="text-decoration: underline;"><a href="./index.php?id=<?php echo $dados['players_team_id']; ?>">Equipe</a></h5>-->
                    </div>
                  </div>
                <div class="widget-user-image">
                  <img class="figurinha_img" style="margin-left:-10px; margin-top:-10px;" src="img/jogadores/<?php echo $dados['player_picture']; ?>">
                </div>
                <div class="box-footer">
                  <div class="row">
                    <div class="col-xs-3 col-xs-offset-6 border-right" style="margin-top:-20px;">
                      <div class="description-block">
                        <span class="description-text">Cartões</span>
                        <h5 class="description-header"><?php echo $dados['cartoes']; ?></h5>
                      </div><!-- /.description-block -->
                    </div><!-- /.col -->
                    <div class="col-xs-3 border-right" style="margin-top:-20px;">
                      <div class="description-block">
                        <span class="description-text">Gols</span>
                        <h5 class="description-header"><?php echo $dados['goals']; ?></h5> 
                      </div><!-- /.description-block -->
                    </div><!-- /.col -->
                  </div><!-- /.row -->
                </div>
              </div><!-- /.widget-user -->

            <!-- DONUT CHART -->
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Perfil</h3>
                </div>
                <div class="box-body">
                    <canvas id="canvas" style="height:250px"></canvas>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
 
            </div><!-- /.col -->
    
            <div class="col-md-8">
    

         <ul class="timeline">
             
                <?php $sqltime = mysqli_query($mysqli,"SELECT p.*, CONCAT(t1.`teams_name`, ' vs ', t2.`teams_name`, ' - ', date_format(m.datetime,'%d/%m')) as partida FROM plays p left join matches m on p.`match_id` = m.`id` left join teams t1 on m.`team1` = t1.`id_teams` left join teams t2 on m.team2 = t2.`id_teams` where ( assistance = '$id' or plays_players_id='$id') and available in (1,2) order by datetime DESC");
                    while ($data2 = mysqli_fetch_assoc($sqltime)) {
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
                ?>
                <li>
                  <i class="fa fa-clock-o bg-gray"></i>
                </li>
              </ul>        
      </div><!-- /.col -->
    
    <!-- Footer -->
   <footer>
        <div class="container" id="contact">
            <div class="row">            
                    <hr class="large">
                <div class="col-lg-10 col-lg-offset-1 text-center">  
                    <p class="text-muted">Copyright © Esportes.Company 2016 <i class="fa fa-envelope-o fa-fw" style="margin-left:10px;"></i>  <a href="mailto:contato@esportes.co">contato@esportes.co</a></p>
                </div>
            </div>
        </div>
    </footer>

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
		labels: ["Vitorias", "Ataque", "Lances", "Fair Play", "Defesa", "Participação"],
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
