<?php
    session_start();

    ob_start();
    include('../../admin/dbcon/dbcon.php');

    $player = $_POST['player'];
    $type = $_POST['type'];
    $match = $_POST['match'];
    $field = $_POST['field'];
    $side = $_POST['side'];
    $nome = $_POST['nome'];

    //JOGADA EM SI
    $sql = "INSERT INTO notes SET player=$player, type=$type, match_id=$match, field=$field, side=$side, datetime=now()";

    $sqlgeral = mysqli_query($mysqli,$sql);
       
    echo "<pre>";
    print_r(" Anotação realizada para: ".$nome."\n");
    echo "</pre>";
?>