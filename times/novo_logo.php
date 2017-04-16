<?php
 
    header('Content-Type: text/html; charset=utf-8');
    session_start();

    ob_start();
    include('../admin/dbcon/dbcon.php');

    include ("../classes/PHPExcel/IOFactory.php");  

    $key = $_POST['key'];
    $rand = uniqid();
    $target_dir = "../cadastro/uploads/";
    $campo_img = basename($_FILES["fileToUpload"]["name"]);
    if ($campo_img <> ""){
        $target_file_bd = $rand . "." . pathinfo(basename($_FILES["fileToUpload"]['name']), PATHINFO_EXTENSION);
    }else {
        $target_file_bd = "0.png";
    }
    $target_file = $target_dir . $target_file_bd;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);

    //SQL
    $sql = "UPDATE teams SET teams_picture='".$target_file_bd."' where admin_key = '".$key."'";
    mysqli_query($mysqli, $sql);
    $mysqli->close();

    $redirect = "http://www.esportes.co/times/admintime.php?key=$key";
	#abaixo, chamamos a função header() com o atributo location: apontando para a variavel $redirect, que por 
    #sua vez aponta para o endereço de onde ocorrerá o redirecionamento
    header("location:$redirect");
?>