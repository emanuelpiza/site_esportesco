<!DOCTYPE html>
<html>
    <?php
 
    header('Content-Type: text/html; charset=utf-8');
    session_start();

    ob_start();
    include('./admin/dbcon/dbcon.php');

    $match = $_GET['match'];
    ?>
    
    <head>
        
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Emanuel Piza" >

    <title>Subir Vídeo - EsportesCo</title>

   <link rel="stylesheet" href="./css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="./css/AdminLTE.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="./css/_all-skins.min.css">
    
  <link type='text/css' href='css/style.css' rel='stylesheet'>
    
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
        <link rel="stylesheet" href="/fancybox/jquery.fancybox.css" type="text/css" media="screen" />
    <script type="text/javascript" src="/fancybox/jquery.fancybox.pack.js"></script>
    
    <!-- Ícones -->
    <link rel="icon" type="image/png" href="img/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="img/favicon-16x16.png" sizes="16x16" />

    <script src="./times/js/Chart.js"></script>
        <style>
            .calendar-text { margin-top: .3em; }
            .file-text { margin-top: .5em; }
            .fileUpload {
                position: relative;
                overflow: hidden;
                margin: 10px;
            }
        .fileUpload input.upload {
            position: absolute;
            top: 0;
            right: 0;
            margin: 0;
            padding: 0;
            font-size: 20px;
            cursor: pointer;
            opacity: 0;
            filter: alpha(opacity=0);
        }
        </style>
   
    </head>
<body>
    <div class="container" style="
  height: 500px;
  overflow: auto;">
        <div class="col-xs-12 col-sm-12 col-md-offset-3 col-md-6 cfeature infos col-lg-offset-3 col-lg-6">
            <div class="panel-heading" style="text-align:center;">
                <h3>Atualizar informações da partida. </h3> <small><?php echo $nome_copa;?></small>
            </div>
        </div>
        <div class="row">
            <form action="upload_video.php" method="post" enctype="multipart/form-data">
                <div class="form-inline" style="text-align:center;">
                    <div class="col-sm-6">
                        	<table class="table table-bordered table-responsive">
	
                                <tr>
                                    <td><label for="title">Título (Max 80 Caracteres)</label></td>
                                    <td><input type="text" maxlength="80" class="form-control" id="title" name="title" placeholder="Título dos acontecimentos da partida"></td>
                                </tr>
                                
                                <tr>
                                    <td><label for="subtitle">Subtítulo (Max 130 Caracteres)</label></td>
                                    <td><input type="text" maxlength="130" class="form-control" id="subtitle" name="subtitle" placeholder="Descrição mais aprofundada da partida."></td>
                                </tr>
                                
                                <tr>
                                    <td><label for="author_name">Nome do responsável</label></td>
                                    <td><input type="text" maxlength="80" class="form-control" id="author_name" name="author_name" placeholder="Ex: Bastidores do Esporte"></td>
                                </tr>
                                
                                <tr>
                                    <td> <label for="subtitle">Link do responsável</label></td>
                                    <td><input type="author_link" maxlength="130" class="form-control" id="author_link" name="author_link" placeholder="Ex: www.bastidores.com.br"></td>
                                </tr>
                        </table>
                    </div>
                    <div class="col-sm-6">
                        <?php 
                        for ($x = 1; $x <= 5; $x++) {
                            echo ' <div class="row">
                             <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"  style="text-align:right;">
                                 <span class="fa-stack fa-3x">
                                  <i class="fa fa-circle-thin fa-stack-2x"></i>
                                  <strong class="fa-stack-1x calendar-text" style="margin-top:0px;">'.$x.'</strong>
                                 </span>
                               </div>
                               <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"  style="margin-top:15px;">
                                   <span>Arquivo '.$x.'.<br></span>
                                   <div class="form-group fileUpload">
                                       <input id="files'.$x.'" type="file" accept="video/*" name="fileToUpload'.$x.'" id="fileToUpload'.$x.'"><br>
                                   </div>
                               </div>
                             </div>';
                        } 
                        ?>
                         <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"  style="text-align:right;">
                             <span class="fa-stack fa-3x" style="margin-top:10px;">
                                 <i class="fa fa-circle-thin fa-stack-2x"></i>
                                 <strong class="fa-stack-1x calendar-text" style="margin-top:0px;"><i class="fa fa-upload" aria-hidden="true"></i></strong>
                             </span>
                         </div>
                         <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="margin-top:25px;">

                             <span>Enviar os vídeos para processamento. (Não feche esta página).<br></span>
                             <input type="submit" class="btn btn-sm btn-primary" value="Atualizar" name="submit" style="margin-left:10px; margin-top:8px;">
                         </div>
                         <input type="hidden" name="match" value="<?php echo $match;?>"> 
                     </div>
                    <div style="height:300px;"></div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>