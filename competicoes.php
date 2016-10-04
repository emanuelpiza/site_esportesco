<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();

    ob_start();
    include('./admin/dbcon/dbcon.php');

    if (isset($_SESSION["logname"])) {
        $_SESSION["error1"] = "Please Sign in";
        header("Location: index.php");
    }

    $sql_cups = mysqli_query($mysqli,"select * from cups order by `date_limit`;");
    while ($row = mysqli_fetch_assoc($sql_cups)) {
        $cups[] = $row;
    }

    // Total de jogadores
    $sqlcount_players = mysqli_query($mysqli,"SELECT count(*) as total FROM players  where players_team_id > 9 and players_team_id < 24");
    $count_players = mysqli_fetch_assoc($sqlcount_players);

    $mons = array(1 => "Janeiro", 2 => "Fevereiro", 3 => "Março", 4 => "Abril", 5 => "Maio", 6 => "Junho", 7 => "Julho", 8 => "Agosto", 9 => "Setembro", 10 => "Outubro", 11 => "Novembro", 12 => "Dezembro");
                          
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <title>Competições - Esportes.Co</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/1-col-portfolio.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    
   <?php 
        include_once("./admin/analyticstracking.php");
        include('./navbar.php');
    ?>
    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Competições em Andamento<br>
                </h1>
            </div>
        </div>
        <!-- /.row -->

        
         <?php foreach($cups as $row){
            if ($row['is_active'] == 1) {
                if ($row['match_fee'] > 0 ){
                    $match_fee = '<p><b>Custo por partida:</b>  R$'.$row['match_fee'].'</p> ';
                } 
               echo '
                    <!-- Project One -->
                    <div class="row">
                        <div class="col-md-7">
                            <a href="./times/copa.php?id='.$row['id'].'">
                                <img class="img-responsive" src="./img/competicoes/'.$row['id'].'.jpg" alt="">
                            </a>
                        </div>
                        <div class="col-md-5">
                            <h3>'.$row['name'].'</h3>
                            <h4>'.$row['location'].'</h4>
                            <p><b>Categorias: </b>'.$row['cathegory'].'</p>
                            <p><b>Inscrições: </b>Encerradas</p>
                            <p><b>Jogos: </b>'.$row['matches_timeofweek'].'</p>
                            <p><b>Custo de inscrição:</b>  R$'.$row['entry_fee'].'</p>  
                            '.$match_fee.' 
                            <a class="btn btn-primary" href="./times/copa.php?id='.$row['id'].'">Acompanhar</a>
                        </div>
                    </div>
                    <hr>';
                    }
                }
        ?>  

        
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Próximas<br>
                </h1>
            </div>
        </div>
        <!-- /.row -->
        
     <?php foreach($cups as $row){
            if ($row['is_active'] == 0) {
                $month = date_parse_from_format('Y-m-d', $row['date_limit'])['month'];
                $month_name = $mons[$month];
                $day = date_parse_from_format('Y-m-d', $row['date_limit'])['day'];
                if ($row['match_fee'] > 0 ){
                    $match_fee = '<p><b>Custo por partida:</b>  R$'.$row['match_fee'].'</p> ';
                } 
                
                echo '
                    <!-- Project One -->
                    <div class="row">
                        <div class="col-md-7">
                                <img class="img-responsive" src="./img/competicoes/'.$row['id'].'.jpg" alt="">
                        </div>
                        <div class="col-md-5">
                            <h3>'.$row['name'].'</h3>
                            <h4>'.$row['location'].'</h4>
                            <p><b>Categorias: </b>'.$row['cathegory'].'</p>
                            <p><b>Jogos: </b>'.$row['matches_timeofweek'].'</p>
                            <p><b>Custo de inscrição:</b>  R$'.$row['entry_fee'].'</p> 
                            '.$match_fee.'
                            <p><b>Inscrições encerram em: </b>'.$day.' de '. $month_name .'</p>
                            <p><b>Contato:</b> '.$row['contact'].'</p> 
                            
                        </div>
                    </div>
                    <hr>';
                    }
                }
        ?>  

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
