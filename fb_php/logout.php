<?php 
session_start();
session_unset();
    $_SESSION['FBID'] = NULL;
    $_SESSION['FULLNAME'] = NULL;
    $_SESSION['EMAIL'] =  NULL;
header("Location: http://www.esportes.co/1353/index.php");        // you can enter home page here ( Eg : header("Location: " ."http://www.krizna.com"); 
?>