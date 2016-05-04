<?php
session_start();
ob_start();

include('dbcon/dbcon.php');

	if(isset($_POST["signin"]))
	{
		$unam = mysql_real_escape_string($_POST["user"]);
		$upwd = mysql_real_escape_string($_POST["pass"]);
		
		$signinResult = mysql_query("SELECT * FROM user WHERE email='$unam' AND password='$upwd' AND sysstate='admin' LIMIT 1");
		
		if(mysql_num_rows($signinResult) == 1)
		{
			$_SESSION["signin"] = "Autenticação efetuada com sucesso";
			header("Location: admin.php");
		}
		else
		{
			$_SESSION["error"] = "Usuário ou senha incorretos ";
		}
	}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Domotica Projects</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  
  </head>
  <body>
    
    <div class="container-fluid"> 
    
    	<div class="row">
        	<nav class="navbar navbar-inverse navbar-static-top" role="navigation">
            	<div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation1">
                            <span class="sr-only">Navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                         </button>
                          <a class="navbar-brand" href="#">Admin Panel Login</a>
                    </div> <!-- end navbar-header -->
                    
                    <div class="collapse navbar-collapse" id="navigation1">
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="../index.php">Home</a></li>
                        </ul>
                        
                    </div> <!-- end collapse navbar-collapse -->
            	</div> <!-- end container -->
            </nav> <!-- end navbar navbar-fixed-top -->
        </div>
        
        <div class="row" style="margin-top:4%; ">
        	<div class="container">
            	<div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12">
            	<div class="panel panel-primary">
                	<div class="panel-heading">
                    	<h3 class="panel-title"><strong>Sport PRO</strong></h3>
                    </div> <!-- end panel-heading -->
                	<div class="panel-body">

                        <form action="" method="post">
                            <div class="form-group">
                                <label>User Name</label>
                                <input type="text" name="user" class="form-control" placeholder="Enter UserName">
                            </div>
                            <div class="form-group">
                                <label>Password </label>
                                <input type="password" name="pass" class="form-control" placeholder="Enter Password">
                            </div>

                            <div class="form-group">
                                <button type="submit" name="signin" class="btn btn-primary pull-right">Sign in</button>
                            </div>
                        </form>
                        
                        <?php
						if(isset($_SESSION["sout"]))
						{
							echo '<div class="alert alert-success col-md-12">'.$_SESSION["sout"].'<span class="glyphicon glyphicon-ok"></span></div>';
							unset($_SESSION["sout"]);
						}
						if(isset($_SESSION["error"]))
						{
							echo '<div class="alert alert-danger col-md-12">'.$_SESSION["error"].'<span class="glyphicon glyphicon-remove"></span></div>';
							unset($_SESSION["error"]);
						}
						
						if(isset($_SESSION["error1"]))
						{
							echo '<div class="alert alert-danger col-md-12">'.$_SESSION["error1"].'<span class="glyphicon glyphicon-remove"></span></div>';
							unset($_SESSION["error1"]);
						}
					?>
                    </div> <!-- end panel-body -->
                </div> <!-- end panel -->
                </div>
            </div> <!-- end container -->
        </div> <!-- end row -->
        
        <div class="row" >
            <div class="navbar navbar-inverse navbar-fixed-bottom">
            
            </div> <!-- end navbar footer -->
       </div> <!-- end row -->
    </div> <!-- end container-fluid -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>