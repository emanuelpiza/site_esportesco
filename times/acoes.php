<?php
    # Evita o armazenamento em Cache
    @header('Content-Type: text/html; charset=iso-8859-1');
    @header("Cache-Control: no-cache, must-revalidate");  
    @header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  
    # Verifica se os dados foram enviados do form e retira o espaco em branco (trim)
     foreach ($_POST as $param_name => $param_val) {
        echo "Param: $param_name; Value: $param_val<br />\n";
    }
    $momento = escapeshellarg ($_POST['momento']); 
    $duracao = escapeshellarg ($_POST['radio_duracao']); 
    $campo = escapeshellarg ($_POST['radio_campo']); 
    $craque = "temp";
    #$command="./mode.sh ".escapeshellarg($_POST['ul_jogada']))." ".escapeshellarg($_POST['ul_jogada']));
    $cmd = './mode.sh "'.$momento.'" "'.$duracao.'" 2>&1';
    echo "<pre>".shell_exec($cmd)."</pre>";
?>