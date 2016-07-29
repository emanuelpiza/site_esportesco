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
    $sqlcount_plays = mysqli_query($mysqli,"SELECT count(*) as total FROM plays where available in (1,2) and teams_name LIKE '%".$nome."%' ");
    $count_plays = mysqli_fetch_assoc($sqlcount_plays);
    $sql_anos = mysqli_query($mysqli,"SELECT YEAR(teams_schedule_date) as year FROM teams WHERE id_teams='$id'");
    $anos = mysqli_fetch_assoc($sql_anos);
    $sql_jogadores = mysqli_query($mysqli,"SELECT * FROM players where players_team_id = '$id' order by players_name");
    $sql_jogadores2 = mysqli_query($mysqli,"SELECT * FROM players where players_team_id = '$id' order by players_name");
    while ($data4 = mysqli_fetch_assoc($sql_jogadores2)) {
        $selecoes .= "<option value=".$data4['id_players'].">".$data4['players_name']."</option>" ;
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
    
    <title><?php echo $dados['teams_name']; ?> - EsportesCo</title>

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
    <div class="row">
   <div class="col-xl-offset-5 col-xl-2 center-block">
        <img src="./img/equipes/<?php echo $id; ?>.png" style="width:100px; display: block; margin-left: auto; margin-right: auto;">
    </div>
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
              <h3 class="box-title">Equipe</h3>
            </div><!-- /.box-header -->
            <div class="box-body no-padding">
              <ul class="users-list clearfix">
                <?php while ($data2 = mysqli_fetch_assoc($sql_jogadores)) {
                    echo '
                    <li>
                        <a class="users-list-name" href="./jogador.php?id=' . $data2['id_players'] . '">
                      <img class="img-circle" src="img/jogadores/' . $data2['player_picture'] . '" alt="User Image" style="height:80px; width:80px;"></a>
                      <a class="users-list-name" href="./jogador.php?id=' . $data2['id_players'] . '">' . $data2['players_name'] . '</a>
                      <span class="users-list-date">' . $data2['player_position'] . '</span>
                    </li>';}
                ?>
              </ul><!-- /.users-list -->
            </div><!-- /.box-body -->
          </div><!--/.box -->
             
               
            <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Artilharia Interna</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered">
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Nome</th>
                      <th style="width: 40px">Gols</th>
                    </tr>
                    <tr>
                     <?php $sqlartilharia = mysqli_query($mysqli,"SELECT p.goals, p.players_name, id_players, t.teams_name, t.id_teams FROM players p left join teams t on p.`players_team_id` = t.id_teams where goals > 0 and t.id_teams = ".$id." order by goals DESC LIMIT 5");
                        $posicao = 1;
                    while ($data8 = mysqli_fetch_assoc($sqlartilharia)) {
                    echo '
                    <tr>
                      <td>'.$posicao.'</td>
                      <td><a href="./jogador.php?id='.$data8['id_players'].'"><span style="color:black;">'.$data8['players_name'].'<span></a></td>
                      <td><span>'.$data8['goals'].'</span></td>
                    </tr>';
                    $posicao = $posicao+1;}?>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
        </div><!-- /.col -->

        <div class="col-md-6">
          <!-- USERS LIST -->
            
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Partidas</h3>
            </div><!-- /.box-header -->
            <div class="box-body no-padding">
                <?php $sqlpartida = mysqli_query($mysqli,"SELECT * FROM videos where team_id = '$id' and type = 'v' order by date DESC LIMIT 1");
                    while ($data3 = mysqli_fetch_assoc($sqlpartida)) {
                        if ($data3['available'] != 1) {
                            $marcador = ""; // Vídeo não está disponível
                        } else{
                            $marcador = '
                            <div class="row">
                                <div class="col-xs-6 col-md-6" style="margin-top:20px;">
                                    <button class="btn btn-sm btn-success"  style="margin: 10 auto; float:right; width:140px;" onclick=\'marcacao("'.$data3['webaddress'].'", "0"," '.$data3['field_id'].'")\'>Marcar Lado Esquerdo</button>
                                </div>
                                <div class="col-xs-6 col-md-6" style="margin-top:20px;float:right;">
                                    <button class="btn btn-sm btn-success"  style="margin: 10 auto; width:140px;" onclick=\'marcacao("'.$data3['webaddress'].'", "1"," '.$data3['field_id'].'")\'>Marcar Lado Direito</button>
                                </div>
                            </div>';};
                    echo '
                    <form name="f" id="f" onSubmit="return false">
                    <input type="hidden" name="video" value="' . $data3['webaddress'] . '">
                    <input type="hidden" id="'.$data3['webaddress'].'_equip" name="equipe" value="' . $id . '">
                    
                        <div style="width: 95%; margin:10px auto; 10px; auto;" ><iframe type="text/html" id="video_iframe" width="100%" src="https://www.youtube.com/embed/' . $data3['webaddress'] . '?enablejsapi=1&version=3" frameborder="0" allowfullscreen></iframe>
                    
                        '.$marcador.'
                        </div>
                    </form>';}?>
            </div><!-- /.box-body -->
          </div><!--/.box -->
            
            <?php $sqlfoto = mysqli_query($mysqli,"SELECT * FROM videos where team_id = '$id' and type = 'p' order by date DESC LIMIT 1");
                while ($datafoto = mysqli_fetch_assoc($sqlfoto)) {
                    echo'
                <!-- Fotos LIST -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Álbum</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                        <div style="width: 95%; height:95%; margin:10px auto; 10px; auto;" >
                            <img src="./img/' . $datafoto['webaddress'] . '" style="width:100%;">
                            <div class="fb-share-button" style="position:absolute;bottom:14px;right:3%;" data-href="http://www.esportes.co/times/img/' . $datafoto['webaddress'] . '" data-layout="button" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fwww.esportes.co%2Ftimes%2Fimg%2' . $datafoto['webaddress'] . '&amp;src=sdkpreparse"> </a></div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!--/.box -->    ';
            }?>
            
            
              <?php $sqlmelhores = mysqli_query($mysqli,"SELECT * FROM videos where team_id = '$id' and type = 'm' order by date DESC LIMIT 1");
                while ($datamelhores = mysqli_fetch_assoc($sqlmelhores)) {
                    echo'
                <!-- Fotos LIST -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Melhores Momentos</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                         <div style="width: 95%; height:95%; margin:10px auto; 10px; auto;" ><iframe type="text/html" id="video_iframe" width="100%" src="https://www.youtube.com/embed/' . $datamelhores['webaddress'] . '?enablejsapi=1&version=3" frameborder="0" allowfullscreen></iframe>
                    </div><!-- /.box-body -->
                </div><!--/.box -->    ';
            }?>
          
        </div><!-- /.col --> 
    </div>
    
    <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <!-- Box Comment -->
        
        <?php 

        $query_plays = mysqli_query($mysqli, "SELECT * FROM plays where available = 1 and teams_name = '".$dados['teams_name']."' order by id_plays DESC LIMIT 25") or die(mysqli_error($mysqli)); 
        
        while ($plays = mysqli_fetch_assoc($query_plays)) {
            echo '
                <div class="box box-widget" id="'. $plays['video_id'] .'">
                    <div class="box-header with-border" style="height:78px;">
                    
                    <button type="button" class="btn btn-box-tool" style="float:right; margin-top:-5px;" 
                    onclick=\'deletar("' . $plays['video_id'] . '")\' title="Remover"><i class="fa fa-times"></i></button>
                    
                    <a href="lances/' . $plays['video_id'] . '.mp4" download="Lance ' . $plays['players_name'] .'.mp4"> <button class="btn btn-box-tool" style="float:right; margin-top:-5px;"  title="Download"><i class="fa fa-download"></i></button></a>
                    
                   <button class="btn btn-box-tool" style="float:right; margin-top:-5px;"  title="Categorizar" onclick=\'toggleDiv("' . $plays['video_id'] . '_categ")\'><span class="label label-danger"><i class="fa fa-bar-chart"></i> Estatística Pendente</span></button>
                     
                    <div class="form-group col-xs-6 col-md-6" style="float:right; margin-top:-5px; margin-bottom:-20px; display: none;" id="' . $plays['video_id'] . '_categ">
                        <div class="form-group col-xs-6 col-md-6">
                            <select id="' . $plays['video_id'] . '_craq" class="form-control">
                                <option value="45">Autor</option>
                                '. $selecoes .'
                            </select>
                            <select id="' . $plays['video_id'] . '_tipo" class="form-control">
                                <option value="0">Tipo</option>
                                <option value="1">Gol</option>
                                <option value="4">Defesa</option>
                                <option value="2">Caneta</option>
                                <option value="3">Chapéu</option>
                                <option value="5">Bola Mucha</option>
                            </select>
                        </div>
                        <div class="form-group col-xs-6 col-md-6">
                            <select id="' . $plays['video_id'] . '_assist" class="form-control">
                                <option value="45">Participação</option>
                                '. $selecoes .'
                            </select>
                            <button class="btn btn-sm btn-success" style="float:right; margin-top:2px; width:100%;" onclick=\'estatisticas("' . $plays['video_id'] . '")\'>Categorizar</button>
                        </div>
                    </div>
                    <div class="user-block">
                        <img class="img-circle" src="img/jogadores/0.png" alt="user image">
                        <span class="username"><a href="jogador.php?id=' . $plays['plays_players_id'] . '">' . $plays['players_name'] . '</a></span>
                        <span class="description"><i class="fa fa-clock-o" aria-hidden="true"></i> ' . $plays['initial_time'] . '</span>
                    </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <video width="100%" loop onclick="this.paused?this.play():this.pause();">
                          <source src="lances/' . $plays['video_id'] . '.mp4" type="video/mp4" />
                            Seu navegador não suporta este formato de vídeos. Atualize seu navegador.
                        </video>
                    </div><!-- /.box-body -->
                  </div><!-- /.box -->';}
        ?>
    </div><!-- /.col -->
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
    </script>
</body>

</html>
