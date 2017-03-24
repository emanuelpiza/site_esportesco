<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();

    ob_start();
    include('../admin/dbcon/dbcon.php');

    if (isset($_SESSION["logname"])) {
        $_SESSION["error1"] = "Please Sign in";
        header("Location: index.php");
    }

    $key = $_GET['key'];
    $sqlgeral = mysqli_query($mysqli,"SELECT * FROM cups where admin_key='$key'");
    $dados = mysqli_fetch_assoc($sqlgeral);
    $id = $dados['id'];

    $sql_times = mysqli_query($mysqli,"SELECT * FROM teams where cup_id='$id'");
    
    $sql_max = mysqli_query($mysqli,"select MAX(DATE_FORMAT(m.datetime,'%Y-%m-%d')) as data from matches m where cup_id = '$id';");
    $max = mysqli_fetch_assoc($sql_max)['data'];

    $sql_min = mysqli_query($mysqli,"select MIN(DATE_FORMAT(m.datetime,'%Y-%m-%d')) as data from matches m where cup_id = '$id';");
    $min = mysqli_fetch_assoc($sql_min)['data'];

    $data = $_GET['data'];
    //Data da última partida
    if ($data == null){
        $sql_data = mysqli_query($mysqli,"select DATE_FORMAT(m.datetime,'%Y-%m-%d') as data from matches m where cup_id = '$id' and datetime <= now() + INTERVAL 1 DAY order by datetime DESC LIMIT 1;");
        $data = mysqli_fetch_assoc($sql_data)['data'];
        if($data == null){
            $data = $min;
        }
    }
    $mons = array(1 => "Janeiro", 2 => "Fevereiro", 3 => "Março", 4 => "Abril", 5 => "Maio", 6 => "Junho", 7 => "Julho", 8 => "Agosto", 9 => "Setembro", 10 => "Outubro", 11 => "Novembro", 12 => "Dezembro");
    $month = date_parse_from_format('Y-m-d', $data)['month'];
    $month_name = $mons[$month];
    $day = date_parse_from_format('Y-m-d', $data)['day'];

    $sql_fase = mysqli_query($mysqli,"select name from cup_phases where cup_id = '$id' and start_date <= '$data' order by start_date DESC limit 1");
    $fase = mysqli_fetch_assoc($sql_fase)['name'];

    $sql_last = mysqli_query($mysqli,"select DATE_FORMAT(m.datetime,'%Y-%m-%d') as data from matches m where cup_id = '$id' and datetime <= '$data' and cup_id = '$id' order by datetime DESC LIMIT 1;");
    $last = mysqli_fetch_assoc($sql_last)['data'];

    $sql_next = mysqli_query($mysqli,"select DATE_FORMAT(m.datetime,'%Y-%m-%d') as data from matches m where cup_id = '$id' and DATE_FORMAT(m.datetime,'%Y-%m-%d') > '$data' and cup_id = '$id' order by datetime LIMIT 1;");
    $next = mysqli_fetch_assoc($sql_next)['data'];

    // Total de jogadores
    $sqlcount_players = mysqli_query($mysqli,"SELECT count(*) as total FROM players  where players_team_id in (select id_teams from teams where cup_id = '$id')");
    $count_players = mysqli_fetch_assoc($sqlcount_players);

    // Total de partidas gravadas
    $sqlcount_videos = mysqli_query($mysqli,"SELECT count(*) as total FROM matches where match_video_id is not null and cup_id = '$id'");
    $count_videos = mysqli_fetch_assoc($sqlcount_videos);
    // Total de marcações
    $sqlcount_plays = mysqli_query($mysqli,"SELECT count(*) as total FROM plays p join teams t on t.`teams_name` = p.`teams_name` where available in (1,2) and id_teams in (select id_teams from teams where cup_id = '$id');");
    $count_plays = mysqli_fetch_assoc($sqlcount_plays);
    
        // PAGINATION
        $total = 21;
        $limit = 3;
        $pages = ceil($total / $limit);

        $sqlcount_inicio = mysqli_query($mysqli,"select round(count(1) / 6) as inicio from matches where cup_id = '$id' and datetime < now()");
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
    <script src="../../js/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../css/sweetalert.css">
    
    <title>Administração - <?php echo $dados['name']; ?> - EsportesCo</title>

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
        <h1 style="color:white; margin-top:5px; font-size: 40px;"><b>Administração - <?php echo $dados['name']; ?></b></h1>
        </div>
    
    
        <div class="row">
            <div class="col-md-6">
          <!-- USERS LIST -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Times</h3>
                <a href="../cadastro/time.php?id=<?php echo $id; ?>"><button class="btn btn-xs btn-success" style="float:right;">Adicionar Time</button></a>
            </div><!-- /.box-header -->
            <div class="box-body no-padding">
              <ul class="users-list">
                <?php while ($data2 = mysqli_fetch_assoc($sql_times)) {
                    echo '
                    <li>
                        <a href="admintime.php?key=' . $data2['admin_key'] . '">
                            <div class="figurinha">
                                <img style="height:150px;" src="../cadastro/uploads/' . $data2['teams_picture'] . '">
                                <span class="users-list-name">' . $data2['teams_name'] . '</span>
                            </div>
                        </a> 
                       <a href="../cadastro/jogador.php?key='.$data2['admin_key'].'"><button class="btn btn-xs btn-success">+1 Jogador</button></a>
                    </li>';}
                ?>
              </ul><!-- /.users-list -->
            </div><!-- /.box-body -->
          </div><!--/.box -->
        </div><!-- /.col -->
            
            <div class="col-md-6">
            <div class="box" id="class_partidas">
                <div class="box-header" style="text-align:center;">
                  <h1 class="box-title">Jogos / Arbitragem</h1>
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                    <div class="col-md-10 col-md-offset-1">
                          <?php
                            try {

 
                            // Prepare the paged query
                            $stmt = $dbh->prepare("
                                SELECT 
                                    m.id, 
                                    m.field_id, 
                                    f.fields_name,
                                    m.`team1`,
                                    t1.teams_picture as t1_picture, 
                                    t2.teams_picture as t2_picture, 
                                    t1.`short_name` as 'team1_name', 
                                    m.`team2`, 
                                    m.`score1`, 
                                    m.`score2`, 
                                    t2.`short_name` as 'team2_name', 
                                    t1.`teamd_fields_id` as 'teams_field', 
                                    date_format(m.datetime, '%hh%i') as hour, 
                                    date_format(m.datetime,'%d/%m') as date 
                                FROM matches as m 
                                left join teams t1 
                                    on m.team1 = t1.`id_teams` 
                                left join teams as t2 
                                    on m.team2 = t2.id_teams
                                left join fields as f
                                    on f.id_fields = m.field_id
                                where
                                DATE_FORMAT(m.datetime,'%Y-%m-%d') = '$data' and m.cup_id = '$id'  order by m.datetime");

                            // Bind the query params
                            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
                            $stmt->execute();

                            // Do we have any results?
                            if ($stmt->rowCount() > 0) {
                                // Define how we want to fetch the results
                                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                $iterator = new IteratorIterator($stmt);

                                // Display the results
                                foreach ($iterator as $data5) {
                                     echo '<hr style="margin-top:-2px;"></hr>
                        <div class="row">
                            <div class="col-xl-offset-5 col-xl-2 center-block" style="text-align:center; margin-bottom:0px;margin-top:-15px;">
                                <span style="font-family: Roboto, Arial, serif; font-size:12px;">'.$data5['fields_name'].' às '.$data5['hour'].'</span>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:10px;">
                              <a href="../marcador/mark5/?id='.$data5['id'].'">
                              
                                    <div class="col-xs-4" style="text-align:right; padding:0;">
                                        <span style="font-family: \'Poiret One\', Arial, serif; font-size:25px; margin-right:10px; color:black;">'.$data5['team1_name'].'</span>
                                        
                                        <img src="../cadastro/uploads/'.$data5['t1_picture'].'" style="width:30px; margin-top: -10px; margin-right:5px;">
                                    </div>
                                
                                    <div  class="col-xs-1" style="text-align:center; font-size:15px;padding:0;">
                                        <span style="font-family: Arial, serif; font-size:25px;text-align:left; margin-right:-25px; color:black;font-weight:bolder;">'.$data5['score1'].'</span>
                                    </div>
                                
                              <div  class="col-xs-2 center-block" style="text-align:center; font-size:15px; margin-top:10px; color:black;"><i class="fa fa-times" aria-hidden="true"></i></div>
                              
                              
                                    <div  class="col-xs-1" style="text-align:center; font-size:15px; padding:0;">
                                        <span style="font-family: Arial, serif; font-size:25px;text-align:left; margin-left:-25px; color:black;font-weight:bolder;">'.$data5['score2'].'</span>
                                    </div>
                                    
                                    <div  class="col-xs-4" style="padding:0;">
                                        <img src="../cadastro/uploads/'.$data5['t2_picture'].'" style="width:30px; margin-top: -10px; margin-left:5px">
                                        
                                        <span style="font-family: \'Poiret One\', Arial, serif; font-size:25px ;text-align:left; margin-left:10px; color:black;">'.$data5['team2_name'].'</span>
                                  </div>
                              </a>
                              
                                <div class="col-xl-offset-5 col-xl-2 center-block" style="text-align:center; margin-bottom:0px;margin-top:-15px;">
                                    <br><span style="text-align:center;">
                                    <a href="../marcador/mark5/impressao.php?id='.$data5['id'].'"> <i class="fa fa-print fa-lg" aria-hidden="true" style="margin:10px;"> </i> </a>
                                    <a href="../painel_video.php?match='.$data5['id'].'"> <i class="fa fa-file-video-o fa-lg" aria-hidden="true" style="margin:10px;"></i></a></span>
                                </div>
                            </div>';   
                                }

                            } else {
                                echo '<p>Não foi possível exibir resultados.</p>';
                            }  
                                
                            // The "back" link
                            $prevlink = ($data > $min) ? '<a href="?key='.$key.'&data=' . $last . '#class_partidas" title="Previous page"><span style="color:black; margin-right:14px; margin-top:10px; font-size:17px; "><i class="fa fa-caret-left" aria-hidden="true"></i></span></a>' : '<span style="color:white; margin-right:14px; margin-top:10px; font-size:17px; "><i class="fa fa-caret-left" aria-hidden="true"></i></span>';

                            // The "forward" link
                            $nextlink = ($data < $max) ? '<a href="?key='.$key.'&data=' . $next . '#class_partidas" title="Next page"><span style="color:black; margin-left:15px; margin-top:10px; font-size:17px; "><i class="fa fa-caret-right" aria-hidden="true"></i></span></a>' : '<span style="color:white; margin-left:15px; margin-top:10px; font-size:17px; "><i class="fa fa-caret-right" aria-hidden="true"></i></span>';

                            // Display the paging information
                            echo '
                                 <hr style="margin-top:-5px;"></hr>
                                 <div id="paging" class="col-xl-offset-5 col-xl-2 center-block" style="text-align:center; margin-bottom:0px;margin-top:-17px;">
                                ', $prevlink, '<span style="font-family: \'Lalezar\', cursive; font-size:20px; font-wigth:bold; margin-top:-15px;">', $day," de ", $month_name,"</span>", $nextlink, '
                            </div>     ';
                                
                                
                        } catch (Exception $e) {
                            echo '<p>', $e->getMessage(), '</p>';
                        }?> 
                    </div><!-- /.box-body -->
                </div>
              </div><!-- /.box -->
                
          <!-- USERS LIST -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Portal público</h3>
            </div><!-- /.box-header -->
            <div class="box-body no-padding" style="text-align:center;">
                <a href="./copa.php?id=<?php echo $id; ?>" target="_blank"><i class="fa fa-trophy fa-5x" aria-hidden="true"></i><br>Abrir</a>
            </div><!-- /.box-body -->
          </div><!--/.box -->
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
</body>

</html>
