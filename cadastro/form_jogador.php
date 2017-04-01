<?php
    # Evita o armazenamento em Cache
    @header('Content-Type: text/html; charset=iso-8859-1');
    @header("Cache-Control: no-cache, must-revalidate");  
    @header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  

    $servername = "localhost";
    $username = "root";
    $password = "k1llersql";
    $dbname = "Esportes";

    // Create and test connection
    $mysqli = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    // TRATAMENTO DA FOTO
    $target_dir = "../times/img/jogadores/";
    $tmp_name = $_FILES["croppedImage"]["tmp_name"];
    if ($tmp_name <> ""){
        $target_file = uniqid() . ".jpg";
        move_uploaded_file($tmp_name, $target_dir . $target_file);
    }else {
        $target_file = "0.jpg";
    }

    // ATRIBUINDO OUTROS PARÂMETROS
    $name = mysqli_real_escape_string($mysqli,$_POST['name']);
    $team = mysqli_real_escape_string($mysqli,$_POST['team']);
    $rg = mysqli_real_escape_string($mysqli,$_POST['rg']);
    $cpf =  mysqli_real_escape_string($mysqli,$_POST['cpf']);
    $contact_name =  mysqli_real_escape_string($mysqli,$_POST['contact_name']);
    $contact_email =  mysqli_real_escape_string($mysqli,$_POST['contact_email']);
    $contact_telefone =  mysqli_real_escape_string($mysqli,$_POST['contact_telefone']);  
    $date =  mysqli_real_escape_string($mysqli,str_replace('/', '-', $_POST['datepicker']));
    $birthdate =  mysqli_real_escape_string($mysqli,date('Y-m-d', strtotime($date)));

    //SQL
    $sql = "INSERT INTO `players` (players_team_id, whole_name, player_picture, rg, cpf, birthdate, email, phone, name_responsible, players_name) VALUES ('".$team."', '".$name."', '".$target_file."', '".$rg."', '".$cpf."', '".$birthdate."', '".$contact_email."', '".$contact_telefone."', '".$contact_name."', UC_Words(CONCAT_WS(' ', substring_index('".$name."', ' ', 1), substring_index('".$name."', ' ', -1))));";

    mysqli_query($mysqli, $sql);
    $mysqli->close();

    $redirect = "http://www.esportes.co/times/admintime.php?key=$key";
    header("location:$redirect");
?>