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
    $sqlgeral = mysqli_query($mysqli,"SELECT * FROM leagues where id='$id'");
    $dados = mysqli_fetch_assoc($sqlgeral);

    $sqlcups = mysqli_query($mysqli,"SELECT * FROM cups where league='$id' order by date_limit DESC");
    $sqlcount_players = mysqli_query($mysqli,"SELECT points FROM teams where id_teams='$id'");
    $count_players = mysqli_fetch_assoc($sqlcount_players);
    $sqlcount_videos = mysqli_query($mysqli,"SELECT goals_balance FROM teams where id_teams='$id'");
    $count_videos = mysqli_fetch_assoc($sqlcount_videos);
    $nome = $dados['teams_name'];
    $sqlcount_plays = mysqli_query($mysqli,"SELECT count(*) as total FROM plays where available in (1,2) and teams_name LIKE '%".$nome."%' ");
    $count_plays = mysqli_fetch_assoc($sqlcount_plays);
    $sql_anos = mysqli_query($mysqli,"SELECT YEAR(teams_schedule_date) as year FROM teams WHERE id_teams='$id'");
    $anos = mysqli_fetch_assoc($sql_anos);
    $sql_jogadores = mysqli_query($mysqli,"SELECT * FROM players where players_team_id = '$id' order by players_name");
    $sql_jogadores2 = mysqli_query($mysqli,"SELECT * FROM players where players_team_id = '$id' order by players_name");
    while ($data4 = mysqli_fetch_assoc($sql_jogadores2)) {
        $selecoes .= "<option value=".$data4['id_players'].">".$data4['players_name']."</option>" ;
    }
    $sqlnav = mysqli_query($mysqli,"select max(id_teams) as maximo, min(id_teams) as minimo from teams where cup_id =".$dados['cup_id']);
    $fetch_nav = mysqli_fetch_assoc($sqlnav);
    $max_teamid = $fetch_nav['maximo'];  
    $min_teamid = $fetch_nav['minimo'];
    if ($id == $max_teamid){
        $nextteam = $min_teamid;
    } else {    
        $nextteam = ($id+1);
    }
    if ($id == $min_teamid){
        $prevteam = $max_teamid;
    } else {
        $prevteam = ($id-1);
    }
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
    
    <title><?php echo $dados['name']; ?> - EsportesCo</title>

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
    <link rel="icon" type="image/png" href="../img/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="../img/favicon-16x16.png" sizes="16x16" />
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
            }   
            .estrela {
                width:50%;
            }
            .timeline_ano{
                margin-left: 8px;
                width: 50px;
                height: 50px;
                background: #DDDDDD; 
                -moz-border-radius: 25px; 
                -webkit-border-radius: 25px; 
                border-radius: 25px;  
                padding-top: 14px;
                text-align: center;
            }
                
            .timeline_ano span{
                font-size: 15px;
                color: black;
                font-weight: 700;
            }
            .timeline_mes{
                margin-left: 8px;
                width: 50px;
                height: 50px;
                background: #BBBBBB; 
                -moz-border-radius: 25px; 
                -webkit-border-radius: 25px; 
                border-radius: 25px;  
                padding-top: 14px;
                text-align: center;
            }
                
            .timeline_mes span{
                font-size: 15px;
                color: black;
                font-weight: 700;
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
              font-size: 9px;
              line-height: 15px;
              text-transform: uppercase;
              font-weight: bold;
              color: black;
              border: 5px solid black;
              padding: 10px 7px;
              border-radius: 10px;

              opacity: 0.8;
              -webkit-transform: rotate(-10deg);
              -o-transform: rotate(-10deg);
              -moz-transform: rotate(-10deg);
              -ms-transform: rotate(-10deg);
              position:absolute;
              margin-top:-140px; 
              margin-left: auto; 
              margin-right: auto;
              margin-left:25px;
              text-align:center;
              filter:alpha(opacity=80);
              opacity:0.8;
              box-shadow: 0 0 2px black;
            }
            .rubber_stamp::after {
              position: absolute;
              content: " ";
              width: 100%;
              height: auto;
              min-height: 100%;
              padding: 10px;
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
</head>

<body class="skin-blue" style="padding:10px; background-color:#F0F8FF;">
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.6&appId=1510121465959695";
        fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    
      <div class="row" style="background-color:#333333; text-align:center; margin:-10px -10px 10px -10px;">
        <h1 style="color:white; margin-top:5px; font-size: 40px;"><b><?php echo $dados['name']; ?></b></h1>
    </div>

    <div class="row">
        <?php 
                echo '
                <div id="estrela_content">
                    <img src="../cadastro/uploads/'.$dados['image'].'" class="estrela" style="width:100px;margin-left:30px; margin-right:30px;">
                </div>';
        ?>
   
    </div>
    <div class="row" style="margin-top:15px;">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box" style="background-color:#333333; color:white; margin-right:15px; margin-left:15px; height:110px;">
                <div class="inner">
                    <h3><?php echo $dados['competitions']; ?></h3>
                    <p>Competições</p>
                </div>
                <div class="icon">
                    <i class="ion ion-trophy" style="color:#AAAAAA"></i>
                </div>
            </div>
        </div><!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box" style="background-color:#333333; color:white; margin-right:15px; margin-left:15px; height:110px;">
                <div class="inner">
                    <h3><?php echo $dados['clubs']; ?></h3>
                    <p>Clubes</p>
                </div>
                <div class="icon">
                    <i class="ion ion-ios-people" style="color:#AAAAAA"></i>
                </div>
            </div>
            </div><!-- ./col --> 
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box" style="background-color:#333333; color:white; margin-right:15px; margin-left:15px; height:110px;">
                <div class="inner">
                    <h3><?php echo $dados['plays']; ?></h3>
                    <p>Lances</p>
                </div>
                <div class="icon">
                    <i class="ion ion-film-marker" style="color:#AAAAAA"></i>
                </div>
            </div>
        </div><!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box" style="background-color:#333333; color:white; margin-right:15px; margin-left:15px; height:110px;">
                <div class="inner">
                    <h3><?php echo $dados['foundation_year']; ?></h3>
                    <p>Fundação</p>
                </div>
                <div class="icon">
                    <i class="ion ion-ios-flame" style="color:#AAAAAA"></i>
                </div>
            </div>
        </div><!-- ./col -->
    </div><!-- /.row -->

    <div class="row" style="margin-top:50px;">
        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
          
            <!-- The time line -->
              <?php
                      
                    if ($dados['competitions'] == 0){
                        echo '
                        <div class="col-xl-offset-5 col-xl-2 center-block">
                            <span id="estrela_content">
                            <i class="fa fa-star" aria-hidden="true" class="estrela"></i>
                            <i class="fa fa-star" aria-hidden="true" class="estrela"></i>
                            <i class="fa fa-star" aria-hidden="true" class="estrela"></i>
                            <i class="fa fa-star" aria-hidden="true" class="estrela"></i>
                            <i class="fa fa-star-half-o" aria-hidden="true" class="estrela"></i>
                            </span>
                            <h4 style="color:#CCC; opacity: 0.8; filter: alpha(opacity=80); width:90%;" align="center">
                                Não existem competições cadastradas até o momento.
                            </h4>
                        </div>';
                    }else {
                        echo ' <section class="content-header" style="margin-bottom:10px; margin-top:-10px;">
                          <h1>
                            Competições
                          </h1>
                        </section>
                         <ul class="timeline">';
                        while ($data2 = mysqli_fetch_assoc($sqlcups)) {
                            if  ($data2['status'] == 1){
                                $enfeite = '
                                <div style="width:100%; heigth:400px;">
                                    <i class="ion ion-trophy">
                                    <div class="rubber_stamp">Inscrições<br>Abertas</div></i>
                                </div>';
                                 $path = '../cadastro/clube.php';
                            }else if ($data2['status'] == 2){
                                 $enfeite ='';
                            }else{
                                 $enfeite = '  
                                 <img src="./img/equipes/'.$data2['winner'].'.png" class="estrela" style="width:60px;position: absolute; margin-top:48px; margin-left: auto; margin-right: auto; left: 0; right: 0;">
                                 <div style="width:100%; heigth:400px;">
                                    <i class="ion ion-trophy"></i>
                                 </div> 
                                 ';
                                 $path = 'copa.php';
                            };
                            echo '
                             <li><a href="' . $path . '?id=' . $data2['id'] . '">
                                 <div style="text-align:center; font-size:150px; height:300px;">
                                         '.$enfeite.'
                                     <button type="button" class="btn base-trofeu" style="margin-top:-303px;">' . $data2['name'] . '</button>
                                 </div></a>
                            </li>';
                        }
                        echo '
                    <li>
                      <i class="ion ion-ios-flame bg-gray"></i>
                    </li>
                  </ul>        
                </div>';
                    }?>
              
              
              
              
              
              
              
              
              
              
              
              
              
              
           <!-- <li>
                
                <div style="text-align:center; font-size:150px; margin-top:-85px; height:200px;">
                    <div style="width:100%; heigth:400px;">
                        <i class="ion ion-trophy">
                        <div class="rubber_stamp">Inscrições<br>Abertas</div></i>
                    </div>
                     <a href="../cadastro/clube.php?id=16"><button type="button" class="btn base-trofeu" style="margin-top:-303px;">18º Copa Metropolitana</button></a>
                </div>
            </li>
              
              
              
              
            <li class="timeline_ano">
                  <span>
                    2017
                  </span>
            </li>
              
            <li>
                
                <div style="text-align:center; font-size:150px; margin-top:-85px; height:200px;">
                    
                    <img src="./img/equipes/13.png" class="estrela" style="width:60px;position: absolute; margin-top:48px; margin-left: auto; margin-right: auto; left: 0; right: 0;">
                    <div style="width:100%; heigth:400px;">
                        <i class="ion ion-trophy"></i>
                    </div>
                    <a href="copa.php?id=1"><button type="button" class="btn base-trofeu" >XV Copa Benteler de Futebol Society</button></a>
                </div>
            </li>
              
            <li class="timeline_ano">
                  <span>
                    2016
                  </span>
            </li>
              
            <li>
              <i class="ion ion-ios-flame bg-gray"></i>
            </li>
          </ul>-->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    
    <div class="row">
        <div class="col-xl-offset-5 col-xl-2 center-block" style="text-align:center;">
            <h4 style="color:#555;">Patrocinadores:</h4>
            <div class="col-md-4" style="margin-top:30px;">
              
            </div>
            <div class="col-md-4" style="margin-top:30px;">
                <a href="http://www.gestecarbitragem.com.br/site" target="_blank">
                    <img src="../img/gestec.png" style="display: block; margin-left: auto; margin-right: auto;">
                </a>
            </div>
            <div class="col-md-4" style="margin-top:30px;">
             
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
