<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();

    ob_start();
    include('../admin/dbcon/dbcon.php');

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
    $sql = "INSERT INTO `players` (players_team_id, whole_name, player_picture, rg, cpf, birthdate, email, phone, name_responsible, players_name, datahora) VALUES ('".$team."', UC_Words('".$name."'), '".$target_file."', '".$rg."', '".$cpf."', '".$birthdate."', '".$contact_email."', '".$contact_telefone."', '".$contact_name."', UC_Words(CONCAT_WS(' ', substring_index('".$name."', ' ', 1), substring_index('".$name."', ' ', -1))), NOW());";
    mysqli_query($mysqli, $sql);

    //Atualiza contagem de jogadores
    $sql2 = " UPDATE teams t
                left JOIN (
                   select p.players_team_id, sum(1) as novos from players p group by players_team_id) AS p ON
                p.`players_team_id` = t.`id_teams`
            SET
                t.players_count = if(p.novos is null, 0 , p.novos);";
    mysqli_query($mysqli, $sql2);

    $sqlredirect = mysqli_query($mysqli,"SELECT admin_key, id_players FROM players where players_name='".$name."' and players_team_id='".$team."' order by datahora DESC LIMIT 1");
    $redir = mysqli_fetch_assoc($sqlredirect);
    $key = $redir['admin_key'];
    $id_players = $redir['id_players'];

    //Email com chave
        
    include ('../admin/PHPMailer_config.php');
    $sUrl = 'http://www.esportes.co/cadastro/template_1.php';
    $params = array('http' => array(
        'method' => 'POST',
        'content' => 'title='.$name.'&key='.$key.'&id='.$id_players.'&tipo=jogador'
    ));

    $ctx = stream_context_create($params);
    $fp = @fopen($sUrl, 'rb', false, $ctx);
    if (!$fp)
    {
        throw new Exception("Problem with $sUrl, $php_errormsg");
    }

    $response = @stream_get_contents($fp);
    if ($response === false) 
    {
    throw new Exception("Problem reading data from $sUrl, $php_errormsg");
    }
    $mail->Subject = 'Perfil de '.$name.' disponível para edição! Esportes.Co';
    $mail->Body = $response;
    $mail->addAddress($contact_email, '');     // Add a recipient
    if(!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
       $success = true;
    }

    $mysqli->close();
?>