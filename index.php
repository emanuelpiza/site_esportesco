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

    <title>EsportesCo</title>

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
    
  <link type='text/css' href='css/style.css' rel='stylesheet'>
    
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
        <link rel="stylesheet" href="/fancybox/jquery.fancybox.css" type="text/css" media="screen" />
    <script type="text/javascript" src="/fancybox/jquery.fancybox.pack.js"></script>
    
    <!-- Ícones -->
    <link rel="icon" type="image/png" href="img/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="img/favicon-16x16.png" sizes="16x16" />

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

<body style="padding:10px;padding-top: 70px;
    background: #000 url(./img/bola.jpg) no-repeat center; background-size: cover;">
    <?php 
        include_once("./admin/analyticstracking.php");
    ?>
    <div class="row" >
        <div class="col-md-6" style="text-align:center; margin-top:-50px;">
            <br><br><br>
            <h1 class="section-title"style="text-shadow: 1px 1px #000; ">
              Sua plataforma esportiva
            </h1>
              <a href="http://www.esportes.co/times/copa.php"><button type="button" class="btn btn-primary btn-lg">Entrar</button></a>
            <p class="section-sub-title"style="color:#fa225b; text-shadow: 1px 1px #000;">
             Tudo sobre seus esportes em um só lugar.
             <li style="color:#fa225b; text-shadow: 1px 1px #000; font-weight: bold; ">Receba os vídeos de suas partidas.</li>
             <li style="color:#fa225b; text-shadow: 1px 1px #000; font-weight: bold; ">Salve e compartilhe seus momentos.</li>
             <li style="color:#fa225b; text-shadow: 1px 1px #000; font-weight: bold; ">Acompanhe suas estatísticas e de sua equipe.</li> 
            </p>
        </div>
        <div class="col-md-6" style="margin-top:50px;">
                <style>.embed-container { position: relative; padding-bottom: 56.25%; height: 0; overflow: 
                    hidden; max-width: 100%; height: auto; } .embed-container iframe, .embed-container 
                    object, .embed-container embed { position: absolute; top: 0; left: 1%; width: 98%; height: 98%;}
                </style>
                <div class='embed-container'><iframe src="https://www.youtube.com/embed/yzXyyvr5hAk" frameborder='1' 
                    allowfullscreen></iframe>
                </div>
        </div>
    </div>
 

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
