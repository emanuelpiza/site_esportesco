<?php
    # Evita o armazenamento em Cache
    @header('Content-Type: text/html; charset=iso-8859-1');
    @header("Cache-Control: no-cache, must-revalidate");  
    @header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  

    session_start();
    ob_start();
    include('../admin/dbcon/dbcon.php');
    # PARA DEBUG: Verifica se os dados foram enviados do form e retira o espaco em branco (trim)
      foreach ($_POST as $param_name => $param_val) {
        echo "Param: $param_name; Value: $param_val<br />\n";
     }   
    print_r($_POST);

    $acao = $_POST['acao'];
    $video = $_POST['video'];
    $equipe = $_POST['equipe']; 
    //$fp = fopen("log.txt", "a+");

    if ($acao == "marcar") {
        $inicio = $_POST['momento']; 
        $campo = $_POST['radio_campo']; 
        //$jogada = $_POST['jogada']; 
        $craque = $_POST['craque']; 
        $tempo = date("H:i:s");

        $cmd = './mode.sh '.$video.' '.$inicio.' 10 '.$campo.' 0  '.$craque.'  '.$equipe.' 2>&1';
        //$escreve = fwrite($cmd);  
        shell_exec($cmd);
    }else {
        $sql_update = "UPDATE plays SET available = 0 WHERE video_id = ".$video;
        //$escreve = fwrite($sql_update);  
        $sqlgeral = mysqli_query($mysqli,$sql_update);
        
        #Aqui, criamos uma variavel que terá como conteúdo o endereço para onde haverá o redirecionamento:  
        $redirect = "http://www.esportes.co/times/index.php?id=".$equipe;
        #abaixo, chamamos a função header() com o atributo location: apontando para a variavel $redirect, que por 
        #sua vez aponta para o endereço de onde ocorrerá o redirecionamento
        header("location:$redirect");
    }
    //fclose($fp);
?>