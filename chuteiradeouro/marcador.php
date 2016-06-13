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

<?php
   
    $servername = "localhost";
    $username = "root";
    $password = "k1llersql";
    $dbname = "Esportes";

    $status = $_POST['status'];

    if ($status == 'Fechada') {
        $new_status = "1";
        $acao = "aberta";
    } else{
        $new_status = "0";
        $acao = "fechada";
    }
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    $sql = "UPDATE teams SET teams_formation=".$new_status." WHERE id_teams=8";

    if ($conn->query($sql) === TRUE) {
        echo "<div style='text-align:center;'><h1>Escola ".$acao." com sucesso!<h1> <br> <a href='./ligio.php'><button class='btn btn-lg  btn-info' onclick='myFunction()'>Voltar</button></a></div>";
    } else {
        echo "Erro na base de dados: " . $conn->error;
    }

    $conn->close();
?>