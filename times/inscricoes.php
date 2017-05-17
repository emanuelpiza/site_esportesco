<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();

    ob_start();
    include('../admin/dbcon/dbcon.php');

    if (isset($_SESSION["logname"])) {
        $_SESSION["error1"] = "Please Sign in";
        header("Location: index.php");
    }
    $copa = $_GET['id'];

    $sqlgeral = mysqli_query($mysqli,"SELECT * FROM cups where id='$copa'");
    $dados = mysqli_fetch_assoc($sqlgeral);
    
    $sql_max = mysqli_query($mysqli,"select MAX(DATE_FORMAT(m.datetime,'%Y-%m-%d')) as data from matches m where cup_id = '$copa';");
    $max = mysqli_fetch_assoc($sql_max)['data'];

    $sql_min = mysqli_query($mysqli,"select MIN(DATE_FORMAT(m.datetime,'%Y-%m-%d')) as data from matches m where cup_id = '$copa';");
    $min = mysqli_fetch_assoc($sql_min)['data'];

    $data = $_GET['data'];
    //Data da última partida
    if ($data == null){
        $sql_data = mysqli_query($mysqli,"select DATE_FORMAT(m.datetime,'%Y-%m-%d') as data from matches m where cup_id = '$copa' and datetime <= now() order by datetime DESC LIMIT 1;");
        $data = mysqli_fetch_assoc($sql_data)['data'];
        if($data == null){
            $data = $min;
        }
    }
    $mons = array(1 => "Janeiro", 2 => "Fevereiro", 3 => "Março", 4 => "Abril", 5 => "Maio", 6 => "Junho", 7 => "Julho", 8 => "Agosto", 9 => "Setembro", 10 => "Outubro", 11 => "Novembro", 12 => "Dezembro");
    $month = date_parse_from_format('Y-m-d', $data)['month'];
    $month_name = $mons[$month];
    $day = date_parse_from_format('Y-m-d', $data)['day'];

    $sql_last = mysqli_query($mysqli,"select DATE_FORMAT(m.datetime,'%Y-%m-%d') as data from matches m where cup_id = '$copa' and datetime <= '$data' and cup_id = '$copa' order by datetime DESC LIMIT 1;");
    $last = mysqli_fetch_assoc($sql_last)['data'];

    $sql_next = mysqli_query($mysqli,"select DATE_FORMAT(m.datetime,'%Y-%m-%d') as data from matches m where cup_id = '$copa' and DATE_FORMAT(m.datetime,'%Y-%m-%d') > '$data' and cup_id = '$copa' order by datetime LIMIT 1;");
    $next = mysqli_fetch_assoc($sql_next)['data'];

    // Total de jogadores
    $sqlcount_players = mysqli_query($mysqli,"SELECT count(*) as total FROM players  where players_team_id in (select id_teams from teams where cup_id = '$copa')");
    $count_players = mysqli_fetch_assoc($sqlcount_players);

    // Total de partidas gravadas
    $sqlcount_videos = mysqli_query($mysqli,"SELECT count(*) as total FROM matches where match_video_id is not null and cup_id = '$copa'");
    $count_videos = mysqli_fetch_assoc($sqlcount_videos);
    // Total de marcações
    $sqlcount_plays = mysqli_query($mysqli,"SELECT count(*) as total FROM plays p join teams t on t.`teams_name` = p.`teams_name` where available in (1,2) and id_teams in (select id_teams from teams where cup_id = '$copa');");
    $count_plays = mysqli_fetch_assoc($sqlcount_plays);
    
    // PAGINATION
    $total = 21;
    $limit = 3;
    $pages = ceil($total / $limit);

    $sqlcount_inicio = mysqli_query($mysqli,"select round(count(1) / 6) as inicio from matches where cup_id = '$copa' and datetime < now()");
    $count_inicio = mysqli_fetch_assoc($sqlcount_inicio);
    $inicio = $count_inicio['inicio'];
    $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
        'options' => array(
            'default'   => $inicio,
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
    <script src="http://www.esportes.co/js/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="http://www.esportes.co/css/sweetalert.css">
    
    <title>Inscrições <?php echo $dados['name']; ?></title>

   <link rel="stylesheet" href="http://www.esportes.co/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="http://www.esportes.co/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="http://www.esportes.co/css/_all-skins.min.css">
    <!-- Ícones -->
    <link rel="icon" type="image/png" href="http://www.esportes.co/img/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="http://www.esportes.co/img/favicon-16x16.png" sizes="16x16" />
    <link href='https://fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lalezar" rel="stylesheet">
     <!-- jQuery -->
    <script src="http://www.esportes.co/js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="http://www.esportes.co/js/bootstrap.min.js"></script>
    <script src="http://www.esportes.co/js/app.js"></script>
    <script src="http://www.esportes.co/js/Chart.js"></script>
		<meta name = "viewport" content = "initial-scale = 1, user-scalable = no">
		<style>
             #estrela_content{
                display:-moz-box;
                -moz-box-pack:center;
                -moz-box-align:center;
                display:-webkit-box;
                -webkit-box-pack:center;
                -webkit-box-align:center;
                display:box;
                box-pack:center;
                box-align:center;
            }   
            .estrela {
                width:50%;
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
    
    <!-- Hotjar Tracking Code for http://www.esportes.co -->
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:280196,hjsv:5};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'//static.hotjar.com/c/hotjar-','.js?sv=');
</script>
</head>

<body class="skin-blue" style="padding:10px; background-color:#F0F8FF;">
    <?php 
        include_once("../admin/analyticstracking.php");
        include("../navbar.php");
    ?>
   <section class="content-header">
    </section>
    
        <div class="row" style="background-color:black; text-align:center; margin:-25px -10px 25px -10px;">
        <h1 style="color:white; margin-top:5px; font-size: 40px;"><b><?php echo $dados['name']; ?></b></h1>
        </div>
    
    
    <div class="row" style="text-align:center;">
        <div>
            <img src="../cadastro/uploads/0.png" class="estrela" style="width:100px;margin-left:30px; margin-right:30px;">
        </div>
        <a href="../cadastro/time.php?id=<?php echo $copa;?>"><button type="button" class="btn btn-success btn-lg"  style="margin-top:10px; margin-bottom:30px;">Inscreva seu time</button></a>
    </div>
    
    <div class="row">
         <div class="col-md-6">
                       <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Compartilhe Este Campeonato</h3>
                </div><!-- /.box-header -->
                <div class="box-body" style="text-align:center; height:350px;">
                    <div class="addthis_inline_share_toolbox" style="margin-top:140px;"></div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
        </div><!-- /.col --> 
        
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Conheça a Plataforma</h3>
                </div>
                <div class="box-body" style="text-align:center; height:350px;">
                    <iframe width=100% height="100%" src="https://www.youtube.com/embed/KedOsEHQe-Q" frameborder="0" allowfullscreen></iframe>
                </div>
              </div>
        </div>
    </div>
    
    <div class="row" style="margin-top:15px;">
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-light-blue-active">
                <div class="inner">
                    <h3>2017</h3>
                    <p>Edição</p>
                </div>
                <div class="icon">  
                    <i class="ion ion-ios-calendar"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-light-blue-active">
                <div class="inner">
                    <h3><?php echo $count_players['total']; ?></h3>
                    <p>Jogadores Aprovados</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-light-blue-active">
            <div class="inner">
                <h3><?php echo $count_videos['total']; ?></h3>
                <p>Jogos Publicados</p>
            </div>
            <div class="icon">
                <i class="ion ion-videocamera"></i>
            </div>
        </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-light-blue-active">
                <div class="inner">
                    <h3><?php echo $count_plays['total']; ?></h3>
                    <p>Marcações</p>
                </div>
                <div class="icon">
                    <i class="ion ion-checkmark-round"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
    <div class="col-xl-offset-5 col-xl-2 center-block" style="text-align:center">
        <h4 style="color:#555;">Arbitragem:</h4>
        <a href="http://www.gestecarbitragem.com.br/site" target="_blank">
        <img src="../img/gestec.png" style="display: block; margin-left: auto; margin-right: auto;">
        </a>
    </div>
    </div>
    
    <script>
        // Javascript to enable link to tab
        var url = document.location.toString();
        if (url.match('#')) {
            $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
        } 

        // Change hash for page-reload
        $('.nav-tabs a').on('shown.bs.tab', function (e) {
            window.location.hash = e.target.hash;
        })
    </script>
   <!-- Go to www.addthis.com/dashboard to customize your tools --> <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5203771652a333c5"></script> 
</body>

</html>
