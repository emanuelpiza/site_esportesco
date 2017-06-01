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
    $sqlcount_players = mysqli_query($mysqli,"SELECT points FROM teams where id_teams='$id'");
    $count_players = mysqli_fetch_assoc($sqlcount_players);
    $sqlcount_videos = mysqli_query($mysqli,"SELECT goals_balance FROM teams where id_teams='$id'");
    $count_videos = mysqli_fetch_assoc($sqlcount_videos);
    $nome = $dados['teams_name'];
    $short_name = $dados['short_name'];
    $copa = $dados['cup_id'];

    $sqlcup = mysqli_query($mysqli,"SELECT name from cups where id = '$copa'");
    $nome_copa = mysqli_fetch_assoc($sqlcup)['name'];

    $sqlcampanha = mysqli_query($mysqli,"select count(*) as total from matches where (team1 = '$id' or team2 = '$id') and score2 is not null;");
    $campanha = mysqli_fetch_assoc($sqlcampanha)['total'];

    $sqlcount_plays = mysqli_query($mysqli,"SELECT count(*) as total FROM plays where available in (1,2) and teams_name LIKE '%".$nome."%' ");
    $count_plays = mysqli_fetch_assoc($sqlcount_plays);
    $sql_anos = mysqli_query($mysqli,"SELECT YEAR(teams_schedule_date) as year FROM teams WHERE id_teams='$id'");
    $anos = mysqli_fetch_assoc($sql_anos);
    $sql_jogadores = mysqli_query($mysqli,"SELECT * FROM players where players_team_id = '$id' order by players_name");
    $sql_jogadores2 = mysqli_query($mysqli,"SELECT * FROM players where players_team_id = '$id' order by players_name");
    while ($data4 = mysqli_fetch_assoc($sql_jogadores2)) {
        $selecoes .= "<option value=".$data4['id_players'].">".$data4['players_name']."</option>" ;
    }

    // Navegação entre os times do campeonato
    $sqlnav = mysqli_query($mysqli,"select max(id_teams) as maximo, min(id_teams) as minimo from teams where cup_id =".$dados['cup_id']);
    $fetch_nav = mysqli_fetch_assoc($sqlnav);
    $max_teamid = $fetch_nav['maximo'];  
    $min_teamid = $fetch_nav['minimo'];

    $sql_team_prev = mysqli_query($mysqli,"select max(id_teams) as prev_team from teams where id_teams < '$id' and cup_id =".$dados['cup_id']);
    $team_prev = mysqli_fetch_assoc($sql_team_prev)['prev_team'];
    $sql_team_foll = mysqli_query($mysqli,"select min(id_teams) as foll_team from teams where id_teams > '$id' and cup_id =".$dados['cup_id']);
    $team_foll = mysqli_fetch_assoc($sql_team_foll)['foll_team'];

    if ($id == $max_teamid){
        $nextteam = $min_teamid;
    } else {    
        $nextteam = $team_foll;
    }
    if ($id == $min_teamid){
        $prevteam = $max_teamid;
    } else {
        $prevteam = $team_prev;
    }
?>


<!DOCTYPE html>
<html lang="en" content="text/html; charset=utf-8" xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://ogp.me/ns/fb#">

<head>
    <meta property="og:image" content="../cadastro/uploads/<?php echo $dados['teams_picture']?>">
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
    
    <title><?php echo $dados['teams_name']; ?> - EsportesCo</title>

   <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../css/AdminLTE.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../../css/_all-skins.min.css">
    <!-- Ícones -->
    <link rel="shortcut icon" href="../img/favicon-trophy.ico" />
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
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="../js/raphael-min.js"></script>
    <script src="../js/morris.min.js"></script>
    <link rel="stylesheet" href="../css/morris.css">
    
    <link href='https://fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lalezar" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oleo+Script:400,700" rel="stylesheet">
    		<style>
			canvas{
			}
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
                text-align: center;
                }   
            .estrela {
                width:50%;
            }  
            .ion-trophy{
                color:#c5b358;
            }
            .base-trofeu{
                margin-top:-303px;
                background-color:#855E42;
                color: white;
                font-weight:600;
            }
            .rubber_stamp {
              font-family: 'Vollkorn', serif;
              font-size: 12px;
              line-height: 12px;
              text-transform: uppercase;
              font-weight: bolder;
              color: white;
              border: 2px solid white;
              padding: 10px 7px;
              border-radius: 10px;

              opacity: 0.8;
              -webkit-transform: rotate(-10deg);
              -o-transform: rotate(-10deg);
              -moz-transform: rotate(-10deg);
              -ms-transform: rotate(-10deg);
              position:absolute;
              margin-top:130px;
              margin-left: auto; 
              margin-right: auto;
              margin-left:30px;
              text-align:center;
              filter:alpha(opacity=80);
              opacity:0.8;
              box-shadow: 0 0 2px white;
                background-color: black;
            }
            .rubber_stamp::after {
              position: absolute;
              content: " ";
              width: 100%;
              height: auto;
              min-height: 100%;
              padding: 10px;
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
        .wrapper {
            position: relative;
            padding-bottom: 56.25%; /* 16:9 */
            padding-top: 25px;
            height: 0;
        }
        .wrapper iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
		</style>
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
    <link rel="stylesheet" href="http://www.esportes.co/novo/assets/css/swatch-red-white.min.css">
</head>

<body class="skin-blue" style="padding-left:10px; padding-right:10px; background-color:#F0F8FF;">
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
        include("../navbar.php");
    ?>
    
    <div class="row">
        <h1 class="titulo"><?php echo $dados['name']; ?></h1>
    </div>

    <div class="row">
        <?php 
                echo '
                <div id="estrela_content">
                    <a href="index.php?id='.$prevteam.'" style="color:black"><i class="fa fa-angle-double-left" aria-hidden="true" class="estrela"></i></a>
                    <img src="../cadastro/uploads/'.$dados['teams_picture'].'" class="estrela" style="width:100px;margin-left:30px; margin-right:30px; margin-bottom:10px;">
                    <a href="index.php?id='.$nextteam.'" style="color:black"><i class="fa fa-angle-double-right" aria-hidden="true" class="estrela"></i></a>
                    <span style="font-family: \'Poiret One\', Arial, serif; font-size:25px; color:black;"><br>'.$short_name.'</span>
                </div>';
        ?>
   
    </div>
    <div class="row" style="margin-top:15px;">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-light-blue-active">
                <div class="inner">
                    <h3><?php echo $dados['rank']; ?></h3>
                    <p>Posição</p>
                </div>
                <div class="icon">
                    <i class="ion ion-ribbon-a"></i>
                </div>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-light-blue-active">
                <div class="inner">
                    <h3><?php echo $count_players['points']; ?></h3>
                    <p>Pontos</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
            </div>
        </div><!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-light-blue-active">
                <div class="inner">
                    <h3><?php echo $count_videos['goals_balance']; ?></h3>
                    <p>Saldo de Gols</p>
                </div>
                <div class="icon">
                    <i class="ion ion-ios-football"></i>
                </div>
            </div>
            </div><!-- ./col --> 
                <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-light-blue-active">
                <div class="inner">
                    <h3><?php echo $count_plays['total']; ?></h3>
                    <p>Marcações</p>
                </div>
                <div class="icon">
                    <i class="ion ion-checkmark-round"></i>
                </div>
            </div>
        </div><!-- ./col -->
    </div><!-- /.row -->
    
    <div class="row">

        <div class="col-md-6">
          <!-- USERS LIST -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Jogadores</h3>
            </div><!-- /.box-header -->
            <div class="box-body no-padding">
              <ul class="users-list">
                <?php while ($data2 = mysqli_fetch_assoc($sql_jogadores)) {
                    if  ($data2['situation'] != "Apto"){
                                $enfeite = '
                                    <div class="rubber_stamp">Suspenso</div></i>';
                    }
                    else {
                         $enfeite = '';
                    }
                    echo '
                    <li>
                        <a href="./jogador.php?id=' . $data2['id_players'] . '">
                        <div class="figurinha">
                        <img class="figurinha_img" src="img/jogadores/' . $data2['player_picture'] . '" alt="User Image" style="width:120px; height:160px;">
                        <span class="users-list-name">' . $data2['players_name'] . '</span>
                      </div>
                      </a>
                      '.$enfeite.' 
                      
                    </li>';}
                ?>
              </ul><!-- /.users-list -->
            </div><!-- /.box-body -->
          </div>
        </div><!-- /.col -->
        
        
        
        
        
        <div class="col-md-6">
            
            
               <div class="box" id="class_grupoA">
                <div class="box-header">
                  <h3 class="box-title" style="float:middle;">Eventos</h3>
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                    <div class="col-md-10 col-md-offset-1">
                          <?php
                            // Prepare the paged query
                            $sqlpartidas = mysqli_query($mysqli,"SELECT m.id,t1.teams_picture as t1_picture, t2.teams_picture as t2_picture, m.`team1`, t1.`short_name` as 'team1_name', m.`team2`, m.`score1`, m.`score2`, t2.`short_name` as 'team2_name', t1.`teamd_fields_id` as 'teams_field', date_format(m.datetime, '%Hh%i') as hour, date_format(m.datetime,'%d/%m') as date FROM matches as m left join teams t1 on m.team1 = t1.`id_teams` left join teams as t2 on m.team2 = t2.id_teams where (m.team1 = '$id' or m.team2 = '$id') order by m.datetime");

                            while ($data5 = mysqli_fetch_assoc($sqlpartidas)) {
                                echo '
                                <hr style="margin-top:-2px;"></hr>
                                 <a href="./partida.php?id='.$data5['id'].'">
                                <div class="row">';
                              if ($data5['team2'] <> null) {
                                  echo '
                                    <div class="col-xl-offset-5 col-xl-2 center-block" style="text-align:center; margin-bottom:0px;margin-top:-15px;  color:black;">
                                        <span style="font-family: Roboto, Arial, serif; font-size:12px;">'.$data5['date'].' às '.$data5['hour'].'</span>
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom:10px;">
                                    <div class="col-xs-4" style="text-align:right; padding:0;">
                                        <span style="font-family: \'Poiret One\', Arial, serif; font-size:25px; margin-right:10px; color:black;">'.$data5['team1_name'].'</span>
                                        
                                        <img src="../cadastro/uploads/'.$data5['t1_picture'].'" style="width:30px; margin-top: -10px; margin-right:5px;">
                                    </div>
                                
                                    <div  class="col-xs-1" style="text-align:center; font-size:15px;padding:0;">
                                        <span style="font-family: Arial, serif; font-size:25px;text-align:left; margin-right:-25px; color:black;font-weight:bolder;">'.$data5['score1'].'</span>
                                    </div>
                                
                              <div  class="col-xs-2 center-block" style="text-align:center; font-size:15px; margin-top:10px;  color:black;"><i class="fa fa-times" aria-hidden="true"></i></div>
                              
                              
                                    <div  class="col-xs-1" style="text-align:center; font-size:15px; padding:0;">
                                        <span style="font-family: Arial, serif; font-size:25px;text-align:left; margin-left:-25px; color:black;font-weight:bolder;">'.$data5['score2'].'</span>
                                    </div>
                                    
                                    <div  class="col-xs-4" style="padding:0;">
                                        <img src="../cadastro/uploads/'.$data5['t2_picture'].'" style="width:30px; margin-top: -10px; margin-left:5px">
                                        
                                        <span style="font-family: \'Poiret One\', Arial, serif; font-size:25px ;text-align:left; margin-left:10px; color:black;">'.$data5['team2_name'].'</span>
                                  </div>';}
                                else {
                                 echo '
                                    <div class="col-xl-6 col-xl-offset-3" style="text-align:center; height: 20px; line-height: 20px; margin-top:-10px; margin-bottom:10px;">
                                        <span style="font-family: Roboto, Arial, serif; font-size:18px; color:black;">'.$data5['date'].'</span>
                                        <span style="font-family: \'Poiret One\', Arial, serif; font-size:15px; color:black;"> - Amistoso interno</span> 
                                    </div>
                                ';}
                                echo '</div></a>';
                        }?> 
                    </div>
                </div>
              </div>
            
                <?php if ($campanha > 0){
                    echo '
                    <div class="box box-solid bg-light-blue-gradient">
                        <div class="box-header">
                          <i class="fa fa-th"></i>
                          <h3 class="box-title">Gols por Partida</h3>
                        </div>
                        <div class="box-body border-radius-none">
                            <div id="tabs-1" class="tab-pane fade in active">
                                <div class="chart" id="line-chart-gols-pro" style="height: 250px;"></div>
                            </div>
                        </div>
                    </div>';}
                ?>
          
             <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Top 3 Artilharia Interna</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered">
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Nome</th>
                      <th style="width: 90px; text-align:center;">Gols</th>
                    </tr>
                    <tr>
                     <?php $sqlartilharia = mysqli_query($mysqli,"SELECT p.goals, p.players_name, id_players, t.teams_name, t.id_teams FROM players p left join teams t on p.`players_team_id` = t.id_teams where t.id_teams = ".$id." order by p.goals DESC, p.players_name LIMIT 3");
                        $posicao = 1;
                    while ($data8 = mysqli_fetch_assoc($sqlartilharia)) {
                    echo '
                    <tr>
                      <td>'.$posicao.'</td>
                      <td><a href="./jogador.php?id='.$data8['id_players'].'"><span style="color:black;">'.$data8['players_name'].'<span></a></td>
                      <td style="text-align:center;"><span>'.$data8['goals'].'</span></td>
                    </tr>';
                    $posicao = $posicao+1;}?>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            
            <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Cartões</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered">
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Nome</th>
                      <th style="width: 90px; text-align:center;">Amarelos</th>
                      <th style="width: 90px; text-align:center;">Vermelhos</th>
                    </tr>
                    <tr>
                     <?php $sqlcartoes = mysqli_query($mysqli,"SELECT p.yellow_cards, p.red_cards, p.players_name, id_players, t.teams_name, t.id_teams FROM players p left join teams t on p.`players_team_id` = t.id_teams where t.id_teams = ".$id." and (p.yellow_cards > 0 or p.red_cards > 0) order by p.red_cards DESC, p.yellow_cards DESC, p.players_name");
                        $posicao = 1;
                    while ($data8 = mysqli_fetch_assoc($sqlcartoes)) {
                    echo '
                    <tr>
                      <td>'.$posicao.'</td>
                      <td><a href="./jogador.php?id='.$data8['id_players'].'"><span style="color:black;">'.$data8['players_name'].'<span></a></td>
                      <td style="text-align:center;"><span>'.$data8['yellow_cards'].'</span></td>
                      <td style="text-align:center;"><span>'.$data8['red_cards'].'</span></td>
                    </tr>';
                    $posicao = $posicao+1;}?>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            
            
            <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Aprimoramentos</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="col-xs-4" style="text-align:center;">
                        <a href="#" data-toggle="modal" data-target="#myModal_fotos" style="font-family: \'Poiret One\', Arial, serif; color:black;">
                            <div class="row">
                                 <div style="width:100px; height:135px; display:block; margin-right:auto; margin-left:auto; padding: 5px; background-color: #FEFEFE; box-shadow: 0px 1px 1px 0px grey;margin-bottom:5px;">
                                    <img src="../img/peoplebw.png" class="estrela img-responsive" style="width:90px; height:105px; display:block; margin:auto; margin-bottom:5px;">
                                    <span class="users-list-name" style="margin-top:5px;">Jogador</span>
                                </div>
                            </div>
                            <h5 class="box-title">Fotos / Vídeos</h5>
                        </a>
                    </div>
                     <div class="col-xs-4" style="text-align:center;">
                        <a href="#" data-toggle="modal" data-target="#myModal_brasao" style="font-family: \'Poiret One\', Arial, serif; color:black;">
                            <div class="row">
                                <img src="../cadastro/uploads/0.png" class="estrela img-responsive" style="height:130px; width:100px; display:block; margin:auto; margin-bottom:10px;">
                            </div>
                            <h5 class="box-title">Brasão</h5>
                         </a>
                    </div>
                    <div class="col-xs-4" style="text-align:center;">
                        <a href="#" data-toggle="modal" data-target="#myModal_uniforme" style="font-family: \'Poiret One\', Arial, serif; color:black;">
                            <div class="row">
                                <img src="../img/shirt.png" class="estrela img-responsive" style="height:140px; width:100px; display:block; margin:auto;">
                            </div>
                            <h5 class="box-title">Uniforme</h5>
                        </a>
                    </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
        </div><!-- /.col -->
    </div>
    
    <!-- Modal FOTOS -->
    <div class="modal fade" id="myModal_fotos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Todo mundo bem na foto.</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="wrapper">  
                <iframe type="text/html" id="video_iframe" width="100%" height="100%" src="https://www.youtube.com/embed/rkL2FqYbCwg?enablejsapi=1&version=3" frameborder="0" allowfullscreen></iframe>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Entendido</button>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Modal BRASÃO -->
    <div class="modal fade" id="myModal_brasao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">E a imagem do seu time?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="wrapper">  
                <iframe type="text/html" id="video_iframe" width="100%" height="100%" src="https://www.youtube.com/embed/0W7vE2aDfKc?enablejsapi=1&version=3" frameborder="0" allowfullscreen></iframe>
              </div>
              <h5 class="box-title" style="text-align:center; font-family: \'Poiret One\', Arial, serif; font-size:16px;"><i class="fa fa-envelope" aria-hidden="true"></i>: contato@esportes.co<br /><i class="fa fa-whatsapp" aria-hidden="true"></i>: (19) 99975-0044</h5>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Entendido</button>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Modal Uniforme -->
    <div class="modal fade" id="myModal_uniforme" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tá chegando a hora de renovar o armário?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="wrapper">  
                <iframe type="text/html" id="video_iframe" width="100%" height="100%" src="https://www.youtube.com/embed/dUpY94oN49Q?enablejsapi=1&version=3" frameborder="0" allowfullscreen></iframe>
              </div>
                <h5 class="box-title" style="text-align:center; font-family: \'Poiret One\', Arial, serif; font-size:16px;"><i class="fa fa-envelope" aria-hidden="true"></i>: contato@esportes.co<br /><i class="fa fa-whatsapp" aria-hidden="true"></i>: (19) 99975-0044</h5>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Entendido</button>
          </div>
        </div>
      </div>
    </div>
    
    <script>
        
        //import YouTube API script
        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
        
         //create the YouTube Player
          var player;

          function onYouTubeIframeAPIReady() {
            console.log("API  is Ready");
            player = new YT.Player("video_iframe", { 
            events : {
              'onReady': onPlayerReady(),
              'onStateChange': onStateChangeEvent()
              } 
            });
          }
          function onPlayerReady() {
            console.log("My plaer is onReady" );

          }
          function onStateChangeEvent(){
            setInterval(function(){
               var time = player.getCurrentTime();
              //var volume = player.getVolume();
              console.log("Get Current Time: " + time);
            },1000); 

          }
        
    function marcacao(strVideo, lado_esq, campo) {
        var time = player.getCurrentTime();
        if (time < 9){
            swal("Não foi possível identificar o momento.", "Pressione o botão apenas quando assistir algum lance no vídeo acima.", "warning");
        } else{
        var hours = parseInt( time / 3600 ) % 24;
        var minutes = parseInt( time / 60 ) % 60;
        var seconds = (time % 60).toFixed(0);
        var strMomento = hours+":"+minutes+":"+seconds;
        
        swal("Marcação Realizada em "+strMomento, "Vídeo em processamento. Isso pode levar alguns minutos.", "success");
        
        $.post("acoes.php",{acao: "marcar",video: strVideo, momento: strMomento, radio_lado: lado_esq, jogada: 0, equipe: document.getElementById(strVideo + "_equip").value, campo: campo},function(data){});    
        }
    }
        
    function estatisticas(strVideo) {
        swal("Categorização realizada!", "As estatísticas dos jogadores envolvidos estão sendo atualizadas.", "success");
        
        var craq = document.getElementById(strVideo + "_craq");
        var strCraq = craq.options[craq.selectedIndex].value;
        var assist = document.getElementById(strVideo + "_assist");
        var strAssist = assist.options[assist.selectedIndex].value;
        var tipo = document.getElementById(strVideo + "_tipo");
        var strTipo = tipo.options[tipo.selectedIndex].value;
        
        $.post("acoes.php",{acao: "estatisticas",video: strVideo, craque: strCraq, assistencia: strAssist, tipo: strTipo, time: <?php echo $id?>},function(data){});
        $(document.getElementById(strVideo)).hide(500);
    }
        
    function deletar(strVideo) {
       if (confirm('Tem certeza que deseja deletar esta marcação?')) {
            $(document.getElementById(strVideo)).hide(500);
            $.post("acoes.php",{acao: "deletar",video: strVideo},function(data){});
        }
    }
    function toggleDiv(divId) {
       $("#"+divId).toggle(500);
    }
    var strJson = "json_gols_pro.php?id=<?php echo $id; ?>";   
    $.get( strJson, function( json ) {
        var graph_pro = Morris.Line({
            element: 'line-chart-gols-pro',
            resize: 'true',
            data: json,
            xkey: 'day',
            ykeys: ['goals'],
            labels: ['Gols'],
            lineColors: ['#efefef'],
            lineWidth: 2,
            hideHover: 'auto',
            gridTextColor: "#fff",
            gridStrokeWidth: 0.4,
            pointSize: 4,
            pointStrokeColors: ["#efefef"],
            gridLineColor: "#efefef",
            gridTextFamily: "Open Sans",
            gridTextSize: 10,
            parseTime: false
        });
    });
        
    var strJson = "json_gols_contra.php?id=<?php echo $id; ?>";   
    $.get( strJson, function( json ) {
        var graph_contra = Morris.Line({
            element: 'line-chart-gols-contra',
            resize: 'true',
            data: json,
            xkey: 'day',
            ykeys: ['goals'],
            labels: ['Gols'],
            lineColors: ['#efefef'],
            lineWidth: 2,
            hideHover: 'auto',
            gridTextColor: "#fff",
            gridStrokeWidth: 0.4,
            pointSize: 4,
            pointStrokeColors: ["#efefef"],
            gridLineColor: "#efefef",
            gridTextFamily: "Open Sans",
            gridTextSize: 10,
            parseTime: false
        });
    });
        
    </script>
</body>

</html>
