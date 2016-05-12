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

    //$cmd = "./mode.sh R1QcMpSzkCM 00:00:05 10 0 2 27 2 2>&1";
    $cmd = './mark.sh 2>&1';
    //echo '<script language="javascript">';
    //echo 'alert("Lance marcado com sucesso!")';
    //echo '</script>';
    echo"<pre>". shell_exec($cmd)."</pre>";
    #abaixo, criamos uma variavel que terá como conteúdo o endereço para onde haverá o redirecionamento:  
    
    $redirect = "http://www.esportes.co/marcador/";
    #abaixo, chamamos a função header() com o atributo location: apontando para a variavel $redirect, que por 
    #sua vez aponta para o endereço de onde ocorrerá o redirecionamento
    header("location:$redirect");
?>