<?php
 
    header('Content-Type: text/html; charset=utf-8');
    session_start();
    ini_set('upload_max_filesize', '50000M');
    ini_set('post_max_size', '50000M');
    ini_set('max_input_time', 60000);
    ini_set('max_execution_time', 60000);
    ob_start();
    include('./admin/dbcon/dbcon.php');

    include ("./classes/PHPExcel/IOFactory.php");  

    $match = $_POST['match']; 
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];
    $author_name = $_POST['author_name'];
    $author_link = $_POST['author_link'];
    $live_link = $_POST['live_link'];
    if (substr($author_link, 0, 3) <> "http"){
         $author_link = "http://".$author_link;
    }
    if (substr($live_link, 0, 3) <> "http"){
         $live_link = "http://".$live_link;
    }


    $msg = "Título não atualizado. <br>";

    // TÍTULO
    if (($title <> "")||($live_link <> "")) {
        $sql = "update matches set title = '$title', subtitle = '$subtitle', author_name = '$author_name', author_link = '$author_link', live_link = '$live_link', last_status = NOW() where id='$match';";  
        mysqli_query($mysqli, $sql);  
        $msg = "Informações atualizadas. <br>";
    }


    if ((pathinfo(basename($_FILES["fileToUpload1"]['name']), PATHINFO_EXTENSION) <> "")||(pathinfo(basename($_FILES["fileToUpload2"]['name']), PATHINFO_EXTENSION) <> "")||(pathinfo(basename($_FILES["fileToUpload3"]['name']), PATHINFO_EXTENSION) <> "")) {
        $dir = "../../videos/uploads/".$match."/";
        mkdir($dir, 0775);
        $dir = $dir."files/";
        mkdir($dir, 0775);
        $target_dir = $dir;
        $rand = uniqid();    
        $uploadOk = 0;
    }

    // ARQUIVO 1
    if (pathinfo(basename($_FILES["fileToUpload1"]['name']), PATHINFO_EXTENSION) <> "") {
        $target_file1 = $target_dir . $rand ."_1". "." . pathinfo(basename($_FILES["fileToUpload1"]['name']), PATHINFO_EXTENSION);
        if (move_uploaded_file($_FILES["fileToUpload1"]["tmp_name"], $target_file1)) {      
            $uploadOk = 1;
        }else{
            $uploadOk = 0;         
        }
    }

    // ARQUIVO 2
    if (pathinfo(basename($_FILES["fileToUpload2"]['name']), PATHINFO_EXTENSION) <> "") {
        $target_file2 = $target_dir . $rand ."_2". "." . pathinfo(basename($_FILES["fileToUpload2"]['name']), PATHINFO_EXTENSION);
        if (move_uploaded_file($_FILES["fileToUpload2"]["tmp_name"], $target_file2) && ($uploadOk == 1)) {      
            $uploadOk = 1;
        }else{
            $uploadOk = 0;         
        }
    }

    // ARQUIVO 3
    if (pathinfo(basename($_FILES["fileToUpload3"]['name']), PATHINFO_EXTENSION) <> "") {
        $target_file3 = $target_dir . $rand ."_3". "." . pathinfo(basename($_FILES["fileToUpload3"]['name']), PATHINFO_EXTENSION);
        if (move_uploaded_file($_FILES["fileToUpload3"]["tmp_name"], $target_file3) && ($uploadOk == 1)) {      
            $uploadOk = 1;
        }else{
            $uploadOk = 0;         
        }
    }

    // ARQUIVO 4
    if (pathinfo(basename($_FILES["fileToUpload4"]['name']), PATHINFO_EXTENSION) <> "") {
        $target_file4 = $target_dir . $rand ."_4". "." . pathinfo(basename($_FILES["fileToUpload4"]['name']), PATHINFO_EXTENSION);
        if (move_uploaded_file($_FILES["fileToUpload4"]["tmp_name"], $target_file4) && ($uploadOk == 1)) {      
            $uploadOk = 1;
        }else{
            $uploadOk = 0;         
        }
    }

    // ARQUIVO 5
    if (pathinfo(basename($_FILES["fileToUpload5"]['name']), PATHINFO_EXTENSION) <> "") {
        $target_file5 = $target_dir . $rand ."_5". "." . pathinfo(basename($_FILES["fileToUpload5"]['name']), PATHINFO_EXTENSION);
        if (move_uploaded_file($_FILES["fileToUpload5"]["tmp_name"], $target_file5) && ($uploadOk == 1)) {      
            $uploadOk = 1;
        }else{
            $uploadOk = 0;         
        }
    }


    if ($uploadOk == 1) {
        $sql = "update matches set status = 1, last_status = NOW() where id='$match';";  
        mysqli_query($mysqli, $sql);  
        echo "<h3>" . $msg . "Vídeos subidos com sucesso!<br> <a href='http://www.esportes.co/times/partida.php?id=".$match."'>Continuar</a></h3> "; 
    } else {
        echo "<h3>" . $msg . "Arquivos de vídeo não carregados.<br> <a href='http://www.esportes.co/cadastro/info_partida.php?match=".$match."'>Voltar</a></h3> ";
    }
?>