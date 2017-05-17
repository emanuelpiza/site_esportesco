<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();

    ob_start();
    include('../admin/dbcon/dbcon.php');

    // TRATAMENTO DA FOTO
    $target_dir = "../times/img/jogadores/";
    $tmp_name = $_FILES["croppedImage"]["tmp_name"];
    $image_name = mysqli_real_escape_string($mysqli,$_POST['image_name']);

    if ($tmp_name <> ""){
        $target_file = uniqid() . ".jpg";
        move_uploaded_file($tmp_name, $target_dir . $target_file);
    }else{
        $target_file = $image_name;        
    }

    // ATRIBUINDO OUTROS PARÂMETROS
    $name = mysqli_real_escape_string($mysqli,$_POST['name']);
    $rg = mysqli_real_escape_string($mysqli,$_POST['rg']);
    $cpf =  mysqli_real_escape_string($mysqli,$_POST['cpf']);
    $contact_name =  mysqli_real_escape_string($mysqli,$_POST['contact_name']);
    $contact_email =  mysqli_real_escape_string($mysqli,$_POST['contact_email']);
    $contact_telefone =  mysqli_real_escape_string($mysqli,$_POST['contact_telefone']);  
    $date =  mysqli_real_escape_string($mysqli,str_replace('/', '-', $_POST['datepicker']));
    $birthdate =  mysqli_real_escape_string($mysqli,date('Y-m-d', strtotime($date)));
    $player_strongfoot = mysqli_real_escape_string($mysqli,$_POST['player_strongfoot']);
    $player_height = mysqli_real_escape_string($mysqli,$_POST['player_height']);
    $shirt = mysqli_real_escape_string($mysqli,$_POST['shirt']);
    $player_position =  mysqli_real_escape_string($mysqli,$_POST['player_position']);
    $admin_key =  mysqli_real_escape_string($mysqli,$_POST['admin_key']);

    //SQL
    $sql = "UPDATE `players` set player_picture = '".$target_file."', rg = '".$rg."', cpf = '".$cpf."', birthdate = IF('".$birthdate."' = '1969-12-31', NULL, '".$birthdate."'), email = '".$contact_email."', phone = '".$contact_telefone."', name_responsible = UC_Words('".$contact_name."'), players_name = UC_Words('".$name."'), player_strongfoot = '".$player_strongfoot."', player_height = '".$player_height."', shirt = '".$shirt."', player_position = UC_Words('".$player_position."'), datahora_edit = NOW() where admin_key = '".$admin_key."'";

    mysqli_query($mysqli, $sql);
    $mysqli->close();

?>