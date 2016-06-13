<?php
    # Evita o armazenamento em Cache
    @header('Content-Type: text/html; charset=iso-8859-1');
    @header("Cache-Control: no-cache, must-revalidate");  
    @header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  
    # PARA DEBUG: Verifica se os dados foram enviados do form e retira o espaco em branco (trim)
   //  foreach ($_POST as $param_name => $param_val) {
    //    echo "Param: $param_name; Value: $param_val<br />\n";
   // }   
    #print_r($_POST);
    $video = $_POST['video'];
    $inicio = $_POST['momento']; 
    $campo = $_POST['radio_campo']; 
    //$jogada = $_POST['jogada']; 
    $craque = $_POST['craque']; 
    $equipe = $_POST['equipe']; 
    $tempo = date("H:i:s");
    $fp = fopen("log.txt", "a+");
    //$cmd = "./mode.sh o2wVpTDW15g 00:00:09 10 0 0 45 1 2>&1";// Duracao padrao agora é 10
    $cmd = './mode.sh '.$video.' '.$inicio.' 10 '.$campo.' 0  '.$craque.'  '.$equipe.' 2>&1';
    $escreve = fwrite($cmd);  
    fclose($fp);
    shell_exec($cmd);
    #abaixo, criamos uma variavel que terá como conteúdo o endereço para onde haverá o redirecionamento:  
    //$redirect = "http://ec2-54-191-247-48.us-west-2.compute.amazonaws.com/times/index.php?id=1";
    #abaixo, chamamos a função header() com o atributo location: apontando para a variavel $redirect, que por 
    #sua vez aponta para o endereço de onde ocorrerá o redirecionamento
   // header("location:$redirect");
?>