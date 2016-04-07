<?php
    session_start();

    ob_start();
    include('./admin/dbcon/dbcon.php');

    if (isset($_SESSION["logname"])) {
        $_SESSION["error1"] = "Please Sign in";
        header("Location: index.php");
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Emanuel Piza" >

    <title>Esportes.Co</title>

   <link rel="stylesheet" href="./css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="./css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="./css/_all-skins.min.css">
    
    <script src="./times/js/Chart.js"></script>
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
</head>

<body class="skin-blue" style="padding:10px; background-color:#F0F8FF;">
    
    
    <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <!-- Box Comment -->
        
        <?php 

        $query = mysqli_query($mysqli, "SELECT * FROM plays where id_plays > 1 order by date DESC") or die(mysqli_error($mysqli)); 
        
        while ($data2 = mysqli_fetch_assoc($query)) {
            echo '
                <div class="box box-widget">
                    <div class="box-header with-border">
                      <div class="user-block">
                        <img class="img-circle" src="times/img/jogadores/' . $data2['plays_players_id'] . '.png" alt="user image">
                        <span class="username"><a href="times/jogador.php?id=' . $data2['plays_players_id'] . '">' . $data2['players_name'] . '</a></span>
                        <span class="description">' . $data2['teams_name'] . ' - ' . $data2['date'] . '</span>
                      </div><!-- /.user-block -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <video width="100%" loop onclick="this.paused?this.play():this.pause();">
                          <source src="times/img/' . $data2['id_plays'] . '.mp4#t=2" type="video/mp4" />
                            Seu navegador não suporta este formato de vídeos. Atualize seu navegador.
                        </video>
                    </div><!-- /.box-body -->
                  </div><!-- /.box -->';}
        ?>
    </div><!-- /.col -->
    </div>
    <!-- Footer -->
   <footer>
        <nav class="navbar navbar-static-top">
          <div class="container">
            <div class="navbar-header">
              <a href="landing.html" class="navbar-brand"><b>Esportes.Co</b></a>
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                <i class="fa fa-bars"></i>
              </button>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
              <ul class="nav navbar-nav">
                <li class="active"><a href="http://www.esportes.co/times/index2.php?id=1">Amigos de Quinta</a></li>
                <li><a href="http://www.esportes.co/times/index2.php?id=3">Poka Yoke</a></li>
              </ul>
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>
        <div class="row">   
            <div class="container" id="contact">
                <hr class="large">
                <div class="col-lg-10 col-lg-offset-1 text-center">  
                    <p class="text-muted"><b><i class="fa fa-whatsapp" style="margin-left:10px;"></i> (19)99975-0044</b><i class="fa fa-envelope-o fa-fw" style="margin-left:10px;"></i>  <b><a href="mailto:contato@esportes.co">contato@esportes.co</a></b></p>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="./times/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="./times/js/bootstrap.min.js"></script>

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
