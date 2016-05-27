<?php
    # Evita o armazenamento em Cache
    @header('Content-Type: text/html; charset=iso-8859-1');
    @header("Cache-Control: no-cache, must-revalidate");  
    @header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  

    session_start();
    ob_start();
    include('../admin/dbcon/dbcon.php');

    $acao = $_POST['acao'];
    $video = $_POST['video']
    $equipe = $_POST['equipe']; 

    if ($acao == "marcar") {
        
        $inicio = $_POST['momento']; 
        $campo = $_POST['radio_campo']; 
        //$jogada = $_POST['jogada']; 
        $craque = $_POST['craque']; 
        $tempo = date("H:i:s");

        $cmd = './mode.sh '.$video.' '.$inicio.' 10 '.$campo.' 0  '.$craque.'  '.$equipe.' 2>&1';
        shell_exec($cmd);
    } else {
        
        $cmd = './mode.sh "4pC16C-vT9I" "00:00:07" 10 1 0  27  3 2>&1';
        shell_exec($cmd);
        $sql_update = "UPDATE plays SET available = 1 WHERE available = 2";
        $sqlgeral = mysqli_query($mysqli,$sql_update);
    }
?>