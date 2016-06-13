<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();

    ob_start();
    include('../admin/dbcon/dbcon.php');

    $sqlgeral = mysqli_query($mysqli,"SELECT teams_formation FROM teams where id_teams=8");
    $geral = mysqli_fetch_assoc($sqlgeral);
    $status = $geral['teams_formation']; 

    if ($status == '1') {
        $status = "Aberta";
        $cor = "danger";
        $acao = "Fechar";
    } else{
        $status = "Fechada";
        $cor = "success";
        $acao = "Abrir";
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br" dir="ltr">
<head>
	<title>Esportes.co</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Javascript - Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
      
    <!-- Javascript - Bootstrap -->
    <script src="../times/js/bootstrap.min.js"></script>
    
    <!-- CSS - Bootstrap -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    
    <!-- CSS - FontAwesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css"> 
    
    <!-- Sweet Alerts -->
    <script src="../js/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/sweetalert.css">
</head>
<body>
    <?php include_once("../admin/analyticstracking.php") ?>
    <form action="marcador.php" method="POST">
        <input type="hidden" name="status" value="<?php echo $status;?>">
		<div class="col-xs-12 col-sm-12 col-md-offset-3 col-md-6 col-lg-offset-3 col-lg-6" style="text-align:center; margin-top:50px;">
            <h1>Escola <?php echo $status;?>
 </h1>
            <button class="btn btn-lg  btn-<?php echo $cor;?>" type="submit"><?php echo $acao;?> Escola</button>
        </div>
</form>   
    
</body>
</html>
