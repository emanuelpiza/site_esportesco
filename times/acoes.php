<?php
    # Evita o armazenamento em Cache
    @header('Content-Type: text/html; charset=iso-8859-1');
    @header("Cache-Control: no-cache, must-revalidate");  
    @header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  


    # PARA DEBUG: Verifica se os dados foram enviados do form e retira o espaco em branco (trim)
     foreach ($_POST as $param_name => $param_val) {
        echo "Param: $param_name; Value: $param_val<br />\n";
    }   
    #print_r($_POST);

    $video = $_POST['video'];
    $inicio = $_POST['momento']; 
    $duracao = $_POST['radio_duracao']; 
    $campo = $_POST['radio_campo']; 
    $jogada = $_POST['jogada']; 
    $craque = $_POST['craque']; 
    $equipe = $_POST['equipe']; 
    //$cmd = "./mode.sh R1QcMpSzkCM 00:00:05 10 0 2 27 2 2>&1";
    $cmd = './mode.sh '.$video.' '.$inicio.' '.$duracao.' '.$campo.' '.$jogada.'  '.$craque.'  '.$equipe.' 2>&1';
    echo "<pre>".shell_exec($cmd)."</pre>";
?>