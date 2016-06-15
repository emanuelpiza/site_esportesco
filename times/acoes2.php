
<?php
  
# Evita o armazenamento em Cache
    @header('Content-Type: text/html; charset=iso-8859-1');
    @header("Cache-Control: no-cache, must-revalidate");  
    @header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  

    $acao = $_POST['acao'];
    $video = $_POST['video'];
    $craque = $_POST['craque']; 
    $tipo = $_POST['tipo']; 
    $assist = $_POST['assistencia']; 

    $servername = "localhost";
    $username = "root";
    $password = "k1llersql";
    $dbname = "Esportes";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    $sql = "UPDATE plays SET plays_players_id=45 WHERE plays_players_id=126";

    if ($conn->query($sql) === TRUE) {
        echo "<div style='text-align:center;'><h1>Escola ".$acao." com sucesso!<h1> <br> <a href='./ligio.php'><button class='btn btn-lg  btn-info' onclick='myFunction()'>Voltar</button></a></div>";
    } else {
        echo "Erro na base de dados: " . $conn->error;
    }

    $conn->close();
?>