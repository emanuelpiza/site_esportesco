<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br" dir="ltr">
<head>
	<title>Esportes.co</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Javascript - Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
      
    <!-- Javascript - Bootstrap -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    
    <!-- CSS - Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    
    <!-- CSS - FontAwesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    
    <!-- CSS - Nosso -->    
	<link href="style.css" type="text/css" rel="stylesheet" />    
    
    <!-- Sweet Alerts -->
    <script src="../../js/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../css/sweetalert.css">
</head>
<body>
    <?php include_once("../admin/analyticstracking.php") ?>
    <form action="marcador.php" method="POST">
		<div class="col-xs-12 col-sm-12 col-md-offset-3 col-md-6 col-lg-offset-3 col-lg-6" style="text-align:center;">
            <button class="btn btn-lg  btn-success" onclick='myFunction()'>Marcar Lance</button>
        </div>
        
    <script>
    function myFunction(strVideo) {
        swal("Sucesso!", "", "success");
        $.post("marcador.php",{},function(data){})
    }
    </script>
</form>   
    
</body>
</html>
