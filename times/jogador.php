<?php
    session_start();

    ob_start();
    include('../admin/dbcon/dbcon.php');

    if (isset($_SESSION["logname"])) {
        $_SESSION["error1"] = "Please Sign in";
        header("Location: index.php");
    }
    $id = $_GET['id'];
    $sqlgeral = mysqli_query($mysqli,"SELECT * FROM players where id_players='$id'");
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
    <link rel="stylesheet" href="../css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../css/_all-skins.min.css">
    <!-- Ícones -->
    <link rel="icon" type="image/png" href="../img/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="../img/favicon-16x16.png" sizes="16x16" />
    
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

<body class="skin-blue" style="padding:10px; background-color:#F0F8FF;">
    <?php include_once("../admin/analyticstracking.php") ?>
            <div class="col-md-4">
              <!-- Widget: user widget style 1 -->
              <div class="box box-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-aqua-active banner" style="color:white;">
                  <h3 class="widget-user-username"><?php echo $dados['players_name']; ?></h3>
                  <h5 class="widget-user-desc" style="text-decoration: underline;"><a href="./index.php?id=<?php echo $dados['players_team_id']; ?>">Time</a></h5>
                </div>
                <div class="widget-user-image">
                  <img class="img-circle" src="img/jogadores/<?php echo $dados['player_picture']; ?>.png" alt="User Avatar" style="max-height:100px;">
                </div>
                <div class="box-footer">
                  <div class="row">
                    <div class="col-sm-4 border-right">
                      <div class="description-block">
                        <span class="description-text">Altura</span>
                        <h5 class="description-header"><?php echo $dados['player_height']; ?></h5>
                      </div><!-- /.description-block -->
                    </div><!-- /.col -->
                    <div class="col-sm-4 border-right">
                      <div class="description-block">
                        <span class="description-text">Idade</span>
                        <h5 class="description-header"><?php echo $dados['player_age']; ?></h5> 
                      </div><!-- /.description-block -->
                    </div><!-- /.col -->
                    <div class="col-sm-4">
                      <div class="description-block">
                        <div class="embed-responsive" style="width:100%; height:100%;">
                          <img src="img/chuteiras_<?php echo $dados['player_strongfoot']; ?>.png" class="img-responsive" style="display:block;margin:auto;">
                        </div>
                      </div><!-- /.description-block -->
                    </div><!-- /.col -->
                  </div><!-- /.row -->
                </div>
              </div><!-- /.widget-user -->

            <!-- DONUT CHART -->
              <div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title">Estilo de Jogo</h3>
                </div>
                <div class="box-body">
                    <canvas id="canvas" style="height:250px"></canvas>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
 
            </div><!-- /.col -->
    
            <div class="col-md-8">
    

         <ul class="timeline">
             
                <?php $sqltime = mysqli_query($mysqli,"SELECT * FROM plays where available = 1 and plays_players_id='$jogador' order by date DESC");
                    while ($data2 = mysqli_fetch_assoc($sqltime)) {
                        echo '
                         <li class="time-label">
                            <span class="bg-red">
                               ' . $data2['date'] . '
                            </span>
                        </li>
                         <li>
                          <i class="fa fa-video-camera bg-maroon"></i>
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
                        </li>';}
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
    <script src="./js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="./js/bootstrap.min.js"></script>

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
		labels: ["Vitorias", "Artilharia", "Assistencia", "Resistencia", "Defesa", "Disciplina"],
		datasets: [
		{
				label: "My Second dataset",
				fillColor: "rgba(151,187,205,0.2)",
				strokeColor: "rgba(151,187,205,1)",
				pointColor: "rgba(151,187,205,1)",
				pointStrokeColor: "#fff",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgba(151,187,205,1)",
				data: [0,0,0,0,0,0]
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
