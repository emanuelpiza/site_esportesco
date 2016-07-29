<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();

    ob_start();
    include('../admin/dbcon/dbcon.php');

    if (isset($_SESSION["logname"])) {
        $_SESSION["error1"] = "Please Sign in";
        header("Location: index.php");
    }
    $id = $_GET['id'];
    $sqlgeral = mysqli_query($mysqli,"SELECT * FROM teams where id_teams='$id'");
    $dados = mysqli_fetch_assoc($sqlgeral);
    $sqlcount_players = mysqli_query($mysqli,"SELECT count(*) as total FROM players  where players_team_id > 9 and players_team_id < 24");
    $count_players = mysqli_fetch_assoc($sqlcount_players);
    $sqlcount_videos = mysqli_query($mysqli,"SELECT count(*) as total FROM videos where team_id > 9 and team_id < 24 and type='v'");
    $count_videos = mysqli_fetch_assoc($sqlcount_videos);
    $sqlcount_plays = mysqli_query($mysqli,"SELECT count(*) as total FROM plays p join teams t on t.`teams_name` = p.`teams_name` where available in (1,2) and id_teams between 9 and 24;");
    $count_plays = mysqli_fetch_assoc($sqlcount_plays);
    $sql_anos = mysqli_query($mysqli,"SELECT YEAR(teams_schedule_date) as year FROM teams WHERE id_teams='$id'");
    $anos = mysqli_fetch_assoc($sql_anos);
    $sql_jogadores = mysqli_query($mysqli,"SELECT * FROM players where players_team_id = '$id' order by players_name");
    $sql_jogadores2 = mysqli_query($mysqli,"SELECT * FROM players where players_team_id = '$id' order by players_name");
    while ($data4 = mysqli_fetch_assoc($sql_jogadores2)) {
        $selecoes .= "<option value=".$data4['id_players'].">".$data4['players_name']."</option>" ;
    }
    $today = date('d/m/Y', time());
    // PAGINATION
    $total = 21;
    $limit = 3;
    $pages = ceil($total / $limit);
    $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
        'options' => array(
            'default'   => 2,
            'min_range' => 1,
        ),
    )));
    // Calculate the offset for the query
    $offset = ($page - 1)  * $limit;
    // Some information to display to the user
    $start = $offset + 1;
    $end = min(($offset + $limit), $total);
         
    $dbh = new PDO('mysql:host=localhost;dbname=Esportes', $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
                            
?>


<!DOCTYPE html>
<html lang="en" content="text/html; charset=utf-8">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Emanuel Piza" >

    <!-- Javascript - Nosso 
    <script src="marcador.js" type="text/javascript"></script>-->
    
    <!-- Sweet Alert -->
    <script src="../../js/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../css/sweetalert.css">
    
    <title>Arbitragem - EsportesCo</title>

   <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../../css/_all-skins.min.css">
    <!-- Ícones -->
    <link rel="icon" type="image/png" href="../img/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="../img/favicon-16x16.png" sizes="16x16" />
    <link href='https://fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lalezar" rel="stylesheet">
     <!-- jQuery -->
    <script src="./js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/app.js"></script>
    <script src="../js/Chart.js"></script>
		<meta name = "viewport" content = "initial-scale = 1, user-scalable = no">
		<style>
			canvas{
			}
		</style>
    
    <!-- Include Mask plugin -->
    <script src="http://oss.maxcdn.com/jquery.mask/1.11.4/jquery.mask.min.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="skin-blue" style="padding:10px; background-color:#F0F8FF; padding-top: 70px;">
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.6&appId=1510121465959695";
        fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    <?php 
        include_once("../admin/analyticstracking.php");
        include('../navbar.php');
    ?>
   <section class="content-header">
    </section>
    
        <div class="row" style="background-color:#003366; text-align:center; margin:-25px -10px 25px -10px;">
        <h1 style="color:white; margin-top:5px; font-size: 40px;"><b>15ª COPA</b> <img src="./img/benteler.png" style="width:200px; margin-top:-7px;"></h1><h1 style=" color:white; margin-top:-10px;">de Futebol Society</h1>
        </div>
            <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
            <div class="box" id="class_grupoA">
                <div class="box-header" style="text-align:center;">
                  <h1 class="box-title" style="float:middle;">Jogos <?php echo $today ?></h1>
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                    <div class="col-md-10 col-md-offset-1">
                          <?php
                            try {
                            $campo1 = mysqli_query($mysqli,"SELECT m.id, m.`team1`, left(t1.`teams_name`,3) as 'team1_name', m.`team2`, m.`score1`, m.`score2`, left(t2.`teams_name`,3) as 'team2_name', t1.`teamd_fields_id` as 'teams_field', date_format(m.datetime, '%hh%i') as hour, date_format(m.datetime,'%d/%m') as date FROM matches as m left join teams t1 on m.team1 = t1.`id_teams` left join teams as t2 on m.team2 = t2.id_teams where date_format(m.datetime,'%Y-%d-%m') = '2016-24-07' order by m.datetime");
                            while ($data5 = mysqli_fetch_assoc($campo1)) {
                                echo '<hr style="margin-top:-2px;"></hr>
                        <div class="row">
                            <div class="col-xl-offset-5 col-xl-2 center-block" style="text-align:center; margin-bottom:0px;margin-top:-15px;">
                                <span style="font-family: Roboto, Arial, serif; font-size:12px;">'.$data5['hour'].'</span>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:10px;">
                            <a href="../marcador/mark5/?id='.$data5['id'].'">
                                    <div class="col-xs-4" style="text-align:right; padding:0;">
                                        <span style="font-family: \'Poiret One\', Arial, serif; font-size:25px; margin-right:10px; color:black;">'.$data5['team1_name'].'</span>
                                        
                                        <img src="./img/equipes/'.$data5['team1'].'.png" style="width:30px; margin-top: -10px; margin-right:5px;">
                                    </div>
                                
                                    <div  class="col-xs-1" style="text-align:center; font-size:15px;padding:0;">
                                        <span style="font-family: Arial, serif; font-size:25px;text-align:left; margin-right:-25px; color:black;font-weight:bolder;">'.$data5['score1'].'</span>
                                    </div>
                                
                              <div  class="col-xs-2 center-block" style="text-align:center; font-size:15px; margin-top:10px;"><i class="fa fa-times" aria-hidden="true"></i></div>
                              
                              
                          
                                    <div  class="col-xs-1" style="text-align:center; font-size:15px; padding:0;">
                                        <span style="font-family: Arial, serif; font-size:25px;text-align:left; margin-left:-25px; color:black;font-weight:bolder;">'.$data5['score2'].'</span>
                                    </div>
                                    
                                    <div  class="col-xs-4" style="padding:0;">
                                        <img src="./img/equipes/'.$data5['team2'].'.png" style="width:30px; margin-top: -10px; margin-left:5px">
                                        
                                        <span style="font-family: \'Poiret One\', Arial, serif; font-size:25px ;text-align:left; margin-left:10px; color:black;">'.$data5['team2_name'].'</span>
                                  </div>
                                  </a>
                            </div>';   
                                }
                            }
                        catch (Exception $e) {
                            echo '<p>', $e->getMessage(), '</p>';
                        }?> 
                    </div><!-- /.box-body -->
                </div>
              </div><!-- /.box -->
            </div>
    </div><!-- /.row -->
</body>

</html>
