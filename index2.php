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

<body class="skin-blue" style="padding:10px; background-color:#F0F8FF; padding-top: 70px;">
    <?php 
        include_once("./admin/analyticstracking.php");
        include('./navbar.php');
    ?>

  <div class="row">
              <div class="col-md-6">
                <h1 class="section-title "
                data-delay="0">
                  Prepare seus equipamentos
                </h1>
                <p class="section-sub-title "
                data-delay="50">
                 Futebol society nunca mais será o mesmo.
                 <li>Grave e transmita suas partidas.</li>
                 <li>Assista e compartilhe os melhores momentos.</li>
                 <li>Conecte seu time, faça história.</li>
                    <br>
                 Veja os times que já estão participando:    
                </p>
              </div>
                <div class="col-md-6">
              <div>
      					<!--<style>.embed-container { position: relative; padding-bottom: 56.25%; height: 0; overflow: 
							hidden; max-width: 100%; height: auto; } .embed-container iframe, .embed-container 
							object, .embed-container embed { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }</style>
							<div class='embed-container'><iframe src="https://www.youtube.com/embed/yzXyyvr5hAk" frameborder='0' 
							allowfullscreen></iframe></div>
							<br>-->
                   <p class="section-sub-title" data-delay="50">Amigos de Quinta</p>
                    <a href="./times/index.php?id=1"><img src="img/amigos2.jpg" class="img-responsive img-thumbnail" style="width:60%; margin:auto; margin-top:-20px;margin-bottom:15px;"></a>
                   <p class="section-sub-title" data-delay="50">Poka Yoke</p>
                    <a href="./times/index.php?id=3"><img src="img/pokayoke2.jpg" class="img-responsive img-thumbnail" style="width:60%; margin:auto; margin-top:-20px;margin-bottom:15px;"></a>
                 </div>
              </div>
            </div>


</body>

</html>
