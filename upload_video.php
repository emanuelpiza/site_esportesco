<?php
 
    header('Content-Type: text/html; charset=utf-8');
    session_start();

    ob_start();
    include('./admin/dbcon/dbcon.php');

    include ("./classes/PHPExcel/IOFactory.php");  

    $match = $_POST['match']; 
    $dir = "../../videos/uploads/".$match."/";
    mkdir($dir, 0775);
    $target_dir = $dir;
    $rand = rand();    
    $target_file1 = $target_dir . "1_". $rand . "." . pathinfo(basename($_FILES["fileToUpload1"]['name']), PATHINFO_EXTENSION);
    $target_file2 = $target_dir . "2_". $rand . "." . pathinfo(basename($_FILES["fileToUpload2"]['name']), PATHINFO_EXTENSION);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);


    //if (move_uploaded_file($_FILES["fileToUpload1"]["tmp_name"], $target_file1) && move_uploaded_file($_FILES["fileToUpload2"]["tmp_name"], $target_file2) ) {
      //  echo "Arquivos movidos.";
        //$sql = "update matches set status = 6, last_status = NOW() where id='$match';";  
        //mysqli_query($mysqli, $sql);  
         
    //} else {
   //     echo "<h3>É necessário carregar o arquivo antes de atualizar a base de dados.<br> <a href='http://www.esportes.co/painel_video.php?match=".$match."'>Voltar</a></h3> ";
    //}
    //$redirect = "http://www.esportes.co/times/partida.php?id=$match";
    #abaixo, chamamos a função header() com o atributo location: apontando para a variavel $redirect, que por 
    #sua vez aponta para o endereço de onde ocorrerá o redirecionamento
    //header("location:$redirect");
?>