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
    $sponsor = $dados['sponsor'];    
    $sponsor_url = $dados['sponsor_url'];

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

    $sql_fase = mysqli_query($mysqli,"select name from cup_phases where cup_id = '$copa' and start_date <= '$data' order by start_date DESC limit 1");
    $fase = mysqli_fetch_assoc($sql_fase)['name'];

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
    
    <title><?php echo $dados['name']; ?> - EsportesCo</title>

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
    <link href="https://fonts.googleapis.com/css?family=Oleo+Script:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Teko:400,700" rel="stylesheet">
    <link rel="stylesheet" href="http://www.esportes.co/novo/assets/css/swatch-red-white.min.css">
     <!-- jQuery -->
    <script src="http://www.esportes.co/js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="http://www.esportes.co/js/bootstrap.min.js"></script>
    <script src="http://www.esportes.co/js/app.js"></script>
    <script src="http://www.esportes.co/js/Chart.js"></script>
    <meta name = "viewport" content = "initial-scale = 1, user-scalable = no">
    <script src="http://oss.maxcdn.com/jquery.mask/1.11.4/jquery.mask.min.js"></script>
    <style>
        /*Contact sectiom*/
        .titulo{
            font-family: 'Oleo Script', cursive;
            color:#73bfc1;
            font-size: 45px;
            text-align:center;
            margin: 10px;
        }
        
/* --------- */
/* MEGA MENU */
/* --------- */
.menu-item-object-oxy_mega_menu {
  position: static !important;
}
.menu-item-object-oxy_mega_menu .dropdown-menu {
  left: 0px !important;
  right: 0px !important;
  overflow: hidden;
  background-position: center;
  background-size: cover;
}
.menu-item-object-oxy_mega_menu .dropdown-menu > li {
  position: relative;
  padding-left: 0;
  padding-right: 0;
}
.menu-item-object-oxy_mega_menu .dropdown-menu > li:before {
  content: "";
  position: absolute;
  height: 1000px;
  width: 1px;
  left: 0;
  top: 3px;
}
.menu-item-object-oxy_mega_menu .dropdown-menu > li:first-child:before {
  display: none;
}
.menu-item-object-oxy_mega_menu .dropdown-menu > li > ul {
  list-style-type: none;
  padding: 0px;
  overflow: hidden;
}
.menu-item-object-oxy_mega_menu .dropdown-menu > li > ul > li {
  padding-bottom: 0px;
  margin-left: 30px;
}
.menu-item-object-oxy_mega_menu .dropdown-menu > li > ul > li > a {
  padding: 8px 20px;
  display: block;
  font-size: 14px;
  -moz-transition: color 0.1s;
  -o-transition: color 0.1s;
  -webkit-transition: color 0.1s;
  transition: color 0.1s;
  position: relative;
}
.menu-item-object-oxy_mega_menu .dropdown-menu > li > strong {
  text-indent: 20px;
  line-height: 37px;
  display: block;
}
.menu-item-object-oxy_mega_menu .dropdown-menu > li > strong a {
  padding: 0;
  line-height: 37px;
  display: block;
}
.menu-item-object-oxy_mega_menu .dropdown-menu > li .fa {
  text-indent: 0;
}
.menu-item-object-oxy_mega_menu .dropdown-menu > li .menu-widget {
  padding: 8px 20px;
}
.menu-item-object-oxy_mega_menu .dropdown-menu > li > p {
  font-size: 14px;
  font-style: italic;
  padding-bottom: 12px;
  margin-bottom: 0px;
  border-bottom: 1px solid;
}

.container-fullwidth .menu-item-object-oxy_mega_menu .dropdown-menu {
  margin-left: 15px !important;
  margin-right: 15px !important;
}

.oxy_mega_menu-no-dividers > ul > li:before {
  display: none;
}

.oxy_mega_menu-no-dividers > ul > li > p {
  border: 0 !important;
}

@media (max-width: 992px) {
  .menu-item-object-oxy_mega_menu {
    position: relative !important;
  }

  .menu-item-object-oxy_mega_menu .dropdown-menu {
    background-image: none !important;
  }

  .menu-item-object-oxy_mega_menu .dropdown-menu > li > ul > li > a {
    padding-left: 0px;
    padding-right: 0px;
  }
}
	</style>
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

<body class="skin-blue" style="padding-left:10px; padding-right:10px; background-color:#F0F8FF;">
    <?php 
        include_once("../admin/analyticstracking.php");
    ?>
    
    <header id="masthead" class="navbar navbar-sticky navbar-stuck swatch-red-white" role="banner" style="margin-left:-13px;margin-right:-13px;">
    <div class="container">
        <div class="navbar-header">
            <a href="">       
                <span style="font-size:35px; margin-left:10px; position:absolute;"><i class="fa fa-trophy" aria-hidden="true"></i></span> 
            </a>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".main-navbar"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
            </button>
        </div>
        <nav class="navbar-collapse main-navbar collapse" role="navigation" aria-expanded="false" style="height: 1px;">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="http://www.esportes.co/index.php" class="dropdown-toggle"><i class="fa fa-newspaper-o" aria-hidden="true"></i> Notícias
                    </a>
                </li>
                <li class="dropdown menu-item-object-oxy_mega_menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                         <i class="fa fa-trophy" aria-hidden="true"></i> Campeonatos
                    </a>
                    <ul class="dropdown-menu row">
                        <li class="dropdown col-md-4 menu-item-object-oxy_mega_columns">
                            <strong>Futebol de Campo</strong>
                            <ul role="menu">
                                <li>
                                    <a href="./times/copa.php?id=17">Série - A</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown col-md-4 menu-item-object-oxy_mega_columns"><strong>Futebol Society</strong>
                            <ul role="menu">
                                <li>
                                    <a href="./times/copa.php?id=1">15º Copa Benteler</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown col-md-4 menu-item-object-oxy_mega_columns">
                            <strong>Futsal</strong>
                            <ul role="menu">
                                <li>
                                    <a href="./times/copa.php?id=23">Liga Futsal Rioclarense Masculino</a>
                                </li>
                                <li>
                                    <a href="./times/copa.php?id=24">Liga Futsal Rioclarense Feminino</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="http://www.esportes.co/novo.php" class="dropdown-toggle">
                        <i class="fa fa-plus" aria-hidden="true"></i> Criar Campeonato
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</header>
    
    <div class="row">
        <h1 class="titulo"><?php echo $dados['name']; ?></h1>
    </div>
    
     <?php 
        if ($sponsor <> ""){
            echo '
        <div class="row" style="margin-bottom:20px;">
        <div class="col-xl-offset-5 col-xl-2 center-block" style="text-align:center">
            <h4 style="color:#555;">Oferecimento:</h4>
            <a href="'.$sponsor_url.'" target="_blank">
            <img src="../img/'.$sponsor.'" style="display: block; margin-left: auto; margin-right: auto; width:150px;">
            </a>
        </div>
        </div>';
        }
    ?>
    
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
            <div class="box" id="class_partidas">
                <div class="box-header">
                  <h1 class="box-title" style="float:middle;"><?php echo $fase ?></h1>
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
                                    date_format(m.datetime, '%Hh%i') as hour, 
                                    date_format(m.datetime,'%d/%m') as date 
                                FROM matches as m 
                                left join teams t1 
                                    on m.team1 = t1.`id_teams` 
                                left join teams as t2 
                                    on m.team2 = t2.id_teams
                                left join fields as f
                                    on f.id_fields = m.field_id
                                where
                                DATE_FORMAT(m.datetime,'%Y-%m-%d') = '$data' and m.cup_id = '$copa'  order by m.datetime");

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
                              <a href="./partida.php?id='.$data5['id'].'">
                              
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
                            </div>';   
                                }

                            } else {
                                echo '<p>Nenhuma partida cadastrada. Favor enviar email para contato@esportes.co</p>';
                            }  
                                
                            // The "back" link
                            $prevlink = ($data > $min) ? '<a href="?id='.$copa.'&data=' . $last . '#class_partidas" title="Previous page"><span style="color:black; margin-right:14px; margin-top:10px; font-size:17px; "><i class="fa fa-caret-left" aria-hidden="true"></i></span></a>' : '<span style="color:white; margin-right:14px; margin-top:10px; font-size:17px; "><i class="fa fa-caret-left" aria-hidden="true"></i></span>';

                            // The "forward" link
                            $nextlink = ($data < $max) ? '<a href="?id='.$copa.'&data=' . $next . '#class_partidas" title="Next page"><span style="color:black; margin-left:15px; margin-top:10px; font-size:17px; "><i class="fa fa-caret-right" aria-hidden="true"></i></span></a>' : '<span style="color:white; margin-left:15px; margin-top:10px; font-size:17px; "><i class="fa fa-caret-right" aria-hidden="true"></i></span>';

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
            </div>
        </div>
    
        <div class="row">
            <?php 
            $sql_groups = mysqli_query($mysqli,"SELECT distinct(groups) as nome FROM teams where cup_id = $copa order by nome");
             while ($data_grupos = mysqli_fetch_assoc($sql_groups)) {
                 $nome_grupo = $data_grupos['nome'];
            echo '
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header">
                      <h3 class="box-title">Grupo ' .$nome_grupo. '</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                      <table class="table table-striped">
                        <tr>
                          <th style="width: 10px">#</th>
                          <th>Equipe</th>
                          <th style="width: 70px">P</th>
                          <th style="width: 70px">J</th>
                          <th style="width: 70px">V</th>
                          <th style="width: 70px">E</th>
                          <th style="width: 70px">D</th>
                          <th style="width: 70px">SG</th>
                        </tr>';
                        $sqltimes = mysqli_query($mysqli,"SELECT * FROM teams where cup_id = '$copa' and groups = '$nome_grupo' order by rank");
            
                        while ($data4 = mysqli_fetch_assoc($sqltimes)) {
                        echo '
                        <tr style="height:60px;">
                          <td>'.$data4['rank'].'</td>
                          <td><a href="./index.php?id=' . $data4['id_teams'] . '"><span style="font-family: \'Source Sans Pro\', Arial, serif; font-size:16px; color:black;">'.$data4['teams_name'].'</span></a></td>
                          <td><b>'.$data4['points'].'</b></td>
                          <td>'.$data4['matches'].'</td>
                          <td>'.$data4['victories'].'</td>
                          <td>'.$data4['draws'].'</td>
                          <td>'.$data4['losses'].'</td>
                          <td>'.$data4['goals_balance'].'</td>
                        </tr>';
                        }
                        echo '
                      </table>
                    </div>
                </div>
            </div>';}
                ?>
    </div>
    <div class="row">
         <div class="col-md-6">
                       <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Artilharia</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered">
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Nome</th>
                      <th>Equipe</th>
                      <th style="width: 50px; height:57px;">Gols</th>
                    </tr>
                    <?php $sqlartilharia = mysqli_query($mysqli,"SELECT p.goals, p.players_name, id_players, t.teams_name, t.id_teams FROM players p left join teams t on p.`players_team_id` = t.id_teams where players_team_id in (select id_teams from teams where cup_id = '$copa') order by p.goals DESC LIMIT 5");
                        $posicao = 1;
                    while ($data8 = mysqli_fetch_assoc($sqlartilharia)) {
                    echo '
                    <tr>
                      <td>'.$posicao.'</td>
                      <td><a href="./jogador.php?id='.$data8['id_players'].'"><span style="color:black;">'.$data8['players_name'].'<span></a></td>
                      <td><a href="./index.php?id='.$data8['id_teams'].'"><span style="color:black;">'.$data8['teams_name'].'<span></a></td>
                      <td><span>'.$data8['goals'].'</span></td>
                    </tr>';
                    $posicao = $posicao+1;}?>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
        </div><!-- /.col --> 
        
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Equipe Menos Vazada</h3>
                </div>
                <div class="box-body">
                  <table class="table table-bordered">
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Nome</th>
                      <th style="width: 50px">Jogos</th>
                      <th style="width: 50px">Gols Sof.</th>
                    </tr>
                    <?php $sqldefesa = mysqli_query($mysqli,"select id_teams, teams_name, goals_taken, matches from teams where cup_id = '$copa' order by matches DESC, goals_taken LIMIT 5");
                        $posicao = 1;
                    while ($data8 = mysqli_fetch_assoc($sqldefesa)) {
                    echo '
                    <tr>
                      <td>'.$posicao.'</td>
                      <td><a href="./index.php?id='.$data8['id_teams'].'"><span style="color:black;">'.$data8['teams_name'].'<span></a></td>
                      <td><span>'.$data8['matches'].'</span></td>
                      <td><span>'.$data8['goals_taken'].'</span></td>
                    </tr>';
                    $posicao = $posicao+1;}?>
                  </table>
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
                    <p>Jogadores</p>
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
