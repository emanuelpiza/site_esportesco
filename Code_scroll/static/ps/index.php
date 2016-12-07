<?php
session_start();

ob_start();
include('../admin/dbcon/dbcon.php');
 
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

    <title>Peladeiros de Sexta - SportsTech.	</title>

    <!-- Bootstrap Core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="./css/stylish-portfolio.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
	<!-- FACEBOOK PLUGIN-->		
		<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3&appId=1579562045631845";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

       <!-- <div class="row">
            <?php
            include '../menu.php';
            ?>
        </div>-->
         

    <!-- Header -->
    <header id="top" class="header">
         <div style="text-align:center;">
				<br><br><br>            
            <h2 style="color:white; font-size:68px;">Peladeiros de <b>Sexta</b></h2>
            <br>
        </div>
    </header>
    
    <!-- ABAS -->
	
	<div class="bs-example">
    <ul class="nav nav-tabs  nav-justified" id="myTab">
        <li class="active" style="font-size:26px"><a href="#momentos">Melhores Momentos</a></li>
         <li style="font-size:26px"><a href="#downloads">Downloads</a></li> 
    </ul>
    <div class="tab-content">
        <div id="downloads" class="tab-pane fade">
   <section id="portfolio" class="portfolio">
        <div class="container">
                 <div class="row">
						<?php
                        $owner = "ps";
                             $sqlvideo = mysql_query("SELECT * FROM videos where owner='$owner'  and date > '0000-00-00' ORDER BY name DESC");
                    while ($data = mysql_fetch_assoc($sqlvideo)) {

                        echo ' <div class="col-lg-4 col-md-4 col-xs-12 thumb" style="margin-bottom:15px;" >
             			<video width="100%" height="auto" controls preload="none">
  								<source src="http://www.sportstech.com.br/ps/videos/' . $data['name'] . '" type="video/mp4">
								Your browser does not support the video tag.
							</video>
							<div class="fb-like" data-href="http://www.sportstech.com.br/ps/videos/' . $data['name'] . '"
								data-layout="button" data-action="like" data-show-faces="true" data-share="true"></div>
            				' . $data['name'] . '</div>';
                    }
                    ?>
        </div>
            </div>
    		</section>
		</div>
        
       <div id="momentos" class="tab-pane fade  in active">
        <section id="portfolio" class="portfolio">
        <div class="container">
            <div class="row">
					<div class="row img-responsive" id="bg" style="width: 100%; padding-left:20px;"> 
                    <div class="signform col-md-8 col-md-offset-2">

							<style>.embed-container { position: relative; padding-bottom: 56.25%; height: 0; overflow: 
							hidden; max-width: 100%; height: auto; } .embed-container iframe, .embed-container 
							object, .embed-container embed { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }</style>
							<div class='embed-container'>
								<iframe src='https://www.youtube.com/embed/videoseries?list=PLXOWQP5Jx-MiuvP_Ms3HBJEqWLlhNdKsp' 
									frameborder='0' allowfullscreen>
								</iframe>
							</div>
    
                      </div>
                </div>
                </div>
            </div>
    	</section>
        </div>
    </div>
	</div>

    <!-- Footer -->
   <footer>
        <div class="container" id="contact">
            <div class="row">            
                    <hr class="large">
                <div class="col-lg-10 col-lg-offset-1 text-center">                
                    <i class="fa fa-futbol-o fa-4x"></i>                    
                    <br>                    
                    <br>
                    <ul class="list-unstyled">
                        <li><i class="fa fa-envelope-o fa-fw"></i>  <a href="mailto:contato@sportstech.com.br">contato@sportstech.com.br</a>
                        </li>
                    </ul>
                    <hr class="small">
                    <p class="text-muted">Copyright © Sportstech 2015</p>
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

</body>

</html>
