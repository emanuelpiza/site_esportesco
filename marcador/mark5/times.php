<?
    # Evita o armazenamento em Cache
    @header('Content-Type: text/html; charset=iso-8859-1');
    @header("Cache-Control: no-cache, must-revalidate");  
    @header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  
    # Verifica se os dados foram enviados do form e retira o espaco em branco (trim)
    if(trim($_POST['evento']) == "atualiza")
    {
        $time_es = $_POST['time_esq'];
        $time_di = $_POST['time_dir'];
        $tempo = date("H:i:s");
        $fp = fopen("log.txt", "a+");
        $escreve = fwrite($fp, "tempo:".$tempo.", time_esquerda, ".$time_es.";\n tempo:".$tempo.", time_direita,".$time_di.";\n");        
        fclose($fp);
        echo "<pre>";
        print_r(" Time Esquerda: ".$time_es."\nTime Direita: ".$time_di."\n");
        echo "</pre>";
        return;
    }else{
        if(trim($_POST['evento']) != ""){
        $equipe_gol = $_POST['equipe_gol'];
        $tempo = date("H:i:s");
        $fp = fopen("log.txt", "a+");
        $escreve = fwrite($fp, "tempo:".$tempo.", gol, ".$equipe_gol.";\n");        
        fclose($fp);
        echo "<pre>";
        print_r(" Gol: ".$equipe_gol."\n");
        echo "</pre>";
        return;
        } else{
            echo 1;
            return;
        }
    }
?>