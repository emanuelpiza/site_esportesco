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
    $sqlgeral = mysqli_query($mysqli,"SELECT * FROM teams where admin_key='$key'");
    $dados = mysqli_fetch_assoc($sqlgeral);
    $id = $dados['id_teams'];
    $cup_id = $dados['cup_id'];
    $nome = $dados['teams_name'];
    $team_picture = $dados['teams_picture'];
    $short_name = $dados['short_name'];
    $sql_jogadores = mysqli_query($mysqli,"SELECT * FROM players where players_team_id = '$id' order by players_name");
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
    
    <title><?php echo $nome ?> - EsportesCo</title>

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
                text-align: center;
                margin-bottom:10px;
                margin-top:10px;
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
        body{
            background: #e74c3c;
            padding-left:40px;
            padding-right:40px;
            padding-bottom:40px;
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
    <?php 
        include_once("../admin/analyticstracking.php");
    ?>
    <header class="main-header" style="margin-left:-10px; margin-right:-10px; margin-top:-10px;">
        <!-- Logo -->
        <a href="./copa.php?id=<?php echo $cup_id; ?>" class="logo" style="background-color:#e74c3c;">
          <!-- logo for regular state and mobile devices -->
            <span class="logo-lg" style="font-size:35px; margin-left:10px; position:absolute;"><i class="fa fa-trophy"></i> </span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation" style="background-color:#e74c3c;">
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li>
                <a href="./index.php?id=<?php echo $id; ?>" target="_blank"><i class="fa fa-globe"></i> Perfil Público</a>
              </li>
            </ul>
          </div>
        </nav>
      </header>
    
    <div class="row">
        <?php 
                echo '
                <div id="estrela_content">
                        <img src="../cadastro/uploads/'.$team_picture.'" class="estrela" style="width:100px;margin-left:30px; margin-right:30px;">
                         <span style="font-family: \'Poiret One\', Arial, serif; font-size:25px; color:black;"><br>'.$short_name.'</span>
                </div>';
        ?>
    </div>
    
    <div class="row">

        <div class="col-md-6">
          <!-- USERS LIST -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Jogadores - <?php echo $nome; ?></h3>
              <a href="../cadastro/jogador.php?key=<?php echo $key; ?>"><button class="btn btn-xs btn-success" style="float:right;">Adicionar</button></a>
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
                        <a href="../cadastro/edit_jogador.php?key=' . $data2['admin_key'] . '">
                        <div class="figurinha">
                        <img class="figurinha_img" src="img/jogadores/' . $data2['player_picture'] . '" alt="User Image" style="width:120px; height:160px;>
                        <span class="users-list-name">' . $data2['players_name'] . '</span>
                      </div>
                      </a>
                      '.$enfeite.'
                    </li>';}
                ?>
              </ul><!-- /.users-list -->
            </div><!-- /.box-body -->
              
             <div style="max-width: 650px; margin: 5px; color:black;">
                <span>Trocar imagem do Time</span>
                <p>Escolha uma imagem PNG ou JPEG image, de preferência com 150px X 150px.</p>
                <form action="novo_logo.php" method="post" enctype="multipart/form-data">
                    <div id="image-preview-div" style="display: none">
                        <label for="exampleInputFile">Selected image:</label>
                        <br>
                        <img id="preview-img" src="noimage">
                    </div>
                    <div class="form-group">
                        <input id="files" type="file" name="fileToUpload" id="fileToUpload" required>
                    </div>
                    <input type="hidden" name="key" value="<?php echo $key;?>"> 
                    <button class="btn btn-sm btn-primary" style="float:right; margin-top:-50px;" type="submit" >Subir Arquivo</button>
                </form>
                </div>
          </div><!--/.box -->  
            <button type="button" class="btn btn-danger" onclick='remover("teams", "<?php  echo $id ?>")'>Excluir Time</button>
        </div><!-- /.col -->
        
        <div class="col-md-6">
        <div class="box" id="class_grupoA">
                <div class="box-header">
                    <h3 class="box-title" style="float:middle;">Eventos</h3>
                    <a href="../cadastro/amistoso.php?key=<?php echo $key; ?>"><button class="btn btn-xs btn-success" style="float:right;">Adicionar</button></a>
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
       function remover(table, id) {   
       swal({

            title: "Excluir definitivamente?",
            text: "Atenção! Esta ação não pode ser desfeita.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Sim, excluir!",
            cancelButtonText: "Cancelar",
            closeOnConfirm: false,
            closeOnCancel: false
            },
            function(isConfirm){
                if (isConfirm) {
                    $.post("acoes.php",{acao: "remover", table: table, id: id},function(data){}); 
                    swal({
                        title: "Concluído!",
                        text: "Exclusão feita com sucesso. Você será redirecionado para a página de criação de times da competição.",
                        type: "success",
                        showCancelButton: false,
                        closeOnConfirm: false,
                    },
                    function(){
                        window.location.replace("../cadastro/time.php?id=<?php echo $cup_id; ?>");
                    });
              } else {
                swal("Cancelado", ":)", "error");
              }
            });
        };
    </script>
</body>

</html>
