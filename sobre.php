<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();

    ob_start();
    include('../admin/dbcon/dbcon.php');

	if ( !empty($_POST)) {
        
        include ('./admin/PHPMailer_config.php');
        
        $message = $_POST['message'];
        $email = $_POST['email'];
        $name = $_POST['name'];
            
        $mail->setFrom($email, $name);
        $mail->Subject = 'Contato pelo site';
        $mail->Body = $message;
        $mail->AddAddress('contato@esportes.co', 'Esportes.Co');
        if(!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
           $success = true;
        }
	}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Esportes.Co</title>
        <?php 
        include_once("./head.html");
        ?>
        
        <!-- Sweet Alert -->
        <script src="../js/sweetalert.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/sweetalert.css">
        
        <style>
        .image-cropper {
            width: 32px;
            height: 32px;
            position: relative;
            overflow: hidden;
            -webkit-border-radius: 50%;
            -moz-border-radius: 50%;
            -ms-border-radius: 50%;
            -o-border-radius: 50%;
            border-radius: 50%;
            margin-top:-5px;
        }
        .img_perfil {
            display: inline;
            margin: 0 auto;
            height: 100%;
            width: auto;
            border-radius: 32px;
            border: 2px solid #FFFFFF;
            width: 32px;
            height: 32px; 
        }
        </style>
    </head>
    <body class="pace-on pace-dot">
        <?php 
        include_once("./admin/analyticstracking.php");
        include_once("./navbar.php");
        ?>
       
        <div id="content" role="main">
            <section class="section swatch-red-white">
                <div class="container">
                    <div class="row"  style="margin-top:-80px;">
                        <div class="col-md-6  text-default">
                            <h1 class="text-right super hairline bordered-header">
                                   <br>Valorizar pessoas por meio do esporte.
                                </h1>
                            <p class="lead text-right">   <br>Esse é o propósito da Esportes.Co. 
                                <br>
                            </p>
                            <p class="lead text-right">Nossa plataforma de campeonatos de futebol coleta e divulga dados e vídeos das disputas, seus times e jogadores.<br />
                            </p>
                            <p class="lead text-right">Conheça mais sobre como temos impactado pessoas e de que formas você pode fazer parte disto.<br />
                            </p>
                            <!--<div class="text-center">
                                <a href="./cadastro/campeonato.php" class="btn btn-primary btn-lg  btn-icon-right" target="_self">Criar Campeonato
                                    <span class="hex-alt">
                                        <i class="fa fa-trophy" data-animation="swing"></i>
                                    </span>
                                </a>
                            </div>-->
                        </div>
                        <div class="col-md-6  text-default">
                            <p>
                                <img class="aligncenter size-full wp-image-2322" alt="app" src="../img/tela2.jpg" width="500" height="800">
                            </p>
                        </div>
                    </div>
                </div>
            </section>
            <section class="section swatch-white-red has-top">
                <div class="decor-top">
                    <svg class="decor hidden-xs hidden-sm" height="100%" preserveaspectratio="none" version="1.1" viewbox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 100 L2 60 L4 100 L6 60 L8 100 L10 60 L12 100 L14 60 L16 100 L18 60 L20 100 L22 60 L24 100 L26 60 L28 100 L30 60 L32 100 L34 60 L36 100 L38 60 L40 100 L42 60 L44 100 L46 60 L48 100 L50 60 L52 100 L54 60 L56 100 L58 60 L60 100 L62 60 L64 100 L66 60 L68 100 L70 60 L72 100 L74 60 L76 100 L78 60 L80 100 L82 60 L84 100 L86 60 L88 100 L90 60 L92 100 L94 60 L96 100 L98 60 L100 100 Z"
                        stroke-width="0"></path>
                    </svg>
                    <svg class="decor visible-xs visible-sm" height="100%" preserveaspectratio="none" version="1.1" viewbox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 100 L5 60 L10 100 L5 60 L10 100 L15 60 L20 100 L25 60 L30 100 L35 60 L40 100 L45 60 L50 100 L55 60 L60 100 L65 60 L70 100 L75 60 L80 100 L85 60 L90 100 L95 60 L100 100" stroke-width="0"></path>
                    </svg>
                </div>
               <div class="container">
                    <header class="section-header text-center underline">
                        <h1 class="headline super hairline">Depoimentos</h1>
                    </header>
                    <div class="row">
                        <div class="col-md-12 os-animation" data-os-animation="fadeInUp" data-os-animation-delay=".1s">
                            <div id="slider-flex1" class="flexslider" data-flex-speed="7000" data-flex-animation="slide" data-flex-directions="hide" data-flex-controls="show" data-flex-controlsalign="center">
                                <ul class="slides">
                                    <li>
                                        <blockquote class="fancy-blockquote">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="box-round box-huge">
                                                        <div class="box-dummy"></div>
                                                        <div class="box-inner">
                                                            <img width="300" height="300" src="img/bruno12345.jpeg" class="attachment-square-image-small wp-post-image" alt="some alt" draggable="false">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-10">
                                                    <p><i>A EsportesCo ajudou a otimizar a gestão das nossas competições, tanto para os participantes quanto para os professores, pela praticidade dos jogos online.</i></p>
                                                    <small>Bruno Fernandes - Escola de Futebol Projeto Bugrinho Campinas</small>
                                                </div>
                                            </div>
                                        </blockquote>
                                    </li>
                                    <li>
                                        <blockquote class="fancy-blockquote">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="box-round box-huge">
                                                        <div class="box-dummy"></div>
                                                        <div class="box-inner">
                                                            <img width="300" height="300" src="img/raquel.jpeg" class="attachment-square-image-small wp-post-image" alt="some alt" draggable="false">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-10">
                                                    <p><i>Como equipe de arbitragem, tivemos a oportunidade de trabalhar em parceria com a EsportesCo.
                                                    Foi uma experiência singular. Praticidade e rapidez. A informação chegando à todos de maneira rápida, objetiva e completa.</i></p>
                                                    <small> Raquel - GESTEC Arbitragem
                                    
                                                    </small>
                                                </div>
                                            </div>
                                        </blockquote>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div> 
            </section>
            <section class="section swatch-red-white has-top">
                <div class="decor-top">
                    <svg class="decor hidden-xs hidden-sm" height="100%" preserveaspectratio="none" version="1.1" viewbox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 100 L2 60 L4 100 L6 60 L8 100 L10 60 L12 100 L14 60 L16 100 L18 60 L20 100 L22 60 L24 100 L26 60 L28 100 L30 60 L32 100 L34 60 L36 100 L38 60 L40 100 L42 60 L44 100 L46 60 L48 100 L50 60 L52 100 L54 60 L56 100 L58 60 L60 100 L62 60 L64 100 L66 60 L68 100 L70 60 L72 100 L74 60 L76 100 L78 60 L80 100 L82 60 L84 100 L86 60 L88 100 L90 60 L92 100 L94 60 L96 100 L98 60 L100 100 Z"
                        stroke-width="0"></path>
                    </svg>
                    <svg class="decor visible-xs visible-sm" height="100%" preserveaspectratio="none" version="1.1" viewbox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 100 L5 60 L10 100 L5 60 L10 100 L15 60 L20 100 L25 60 L30 100 L35 60 L40 100 L45 60 L50 100 L55 60 L60 100 L65 60 L70 100 L75 60 L80 100 L85 60 L90 100 L95 60 L100 100" stroke-width="0"></path>
                    </svg>
                </div>
                <div class="container">
                    <header class="section-header ">
                        <h1 class="headline super hairline">Campeonatos com a Esportes.Co</h1>
                        <p class="">Nossa plataforma, associada à súmula online, possibilita aos organizadores:</p>
                    </header>
                    <div class="row">
                        <ul class="list-unstyled row box-list horizontal-icon-border">
                            <li class="col-md-3 text-center" data-os-animation="" data-os-animation-delay="">
                                <div class="box-round box-medium">
                                    <div class="box-dummy"></div>
                                    <a class="box-inner " href="single-service.html">
                                        <i class="fa fa-pencil" data-animation="swing"></i>
                                    </a>
                                </div>
                                <h3 class="text-center ">
                                <a href="">Automatizar inscrições</a></h3>
                                <p class="text-center">Receber os dados de times e jogadores dentro do prazo era uma tarefa trabalhosa? Agora não mais.</p>
                            </li>
                            <li class="col-md-3 text-center" data-os-animation="" data-os-animation-delay="">
                                <div class="box-round box-medium">
                                    <div class="box-dummy"></div>
                                    <a class="box-inner " href="single-service.html">
                                        <i class="fa fa-share-alt" data-animation="shake"></i>
                                    </a>
                                </div>
                                <h3 class="text-center ">
                                    <a href="">Atualizar e divulgar tabelas</a>
                                </h3>
                                <p class="text-center">Dados do campeonato são atualizados automaticamente com as informações dos jogos, reduzindo trabalho e erros.</p>
                            </li>
                            <li class="col-md-3 text-center" data-os-animation="" data-os-animation-delay="">
                                <div class="box-round box-medium">
                                    <div class="box-dummy"></div>
                                    <a class="box-inner " href="single-service.html">
                                        <i class="fa fa-heart" data-animation="bounce"></i>
                                    </a>
                                </div>
                                <h3 class="text-center ">
                                    <a href="">Engajar comunidades</a>
                                </h3>
                                <p class="text-center">Para manter jogadores e comunidades engajados, todas as informações são abertas ao público em tempo-real.</p>
                            </li>
                            <li class="col-md-3 text-center" data-os-animation="" data-os-animation-delay="">
                                <div class="box-round box-medium">
                                    <div class="box-dummy"></div>
                                    <a class="box-inner " href="single-service.html">
                                        <i class="fa fa-bullseye" data-animation="tada"></i>
                                    </a>
                                </div>
                                <h3 class="text-center ">
                                    <a href="">
                                        Encontrar patrocinadores
                                    </a>
                                </h3>
                                <p class="text-center">A internet é a nova TV. O alto interesse e volume de acessos auxilia na criação de melhores parcerias.</p>
                                <div class="text-center">
                                    <a href="./anuncie.php" class="btn btn-primary btn-lg  btn-icon-right" target="_self">Sou Patrocinador
                                        <span class="hex-alt">
                                            <i class="fa fa-bullseye" data-animation="swing"></i>
                                        </span>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                
                
            </section>
            <section class="section swatch-white-red has-top">
                <div class="decor-top">
                    <svg class="decor" height="100%" preserveAspectRatio="none" version="1.1" viewBox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg">
                        <path d="M-5 100 Q 0 20 5 100 Z M0 100 Q 5 0 10 100 M5 100 Q 10 30 15 100 M10 100 Q 15 10 20 100 M15 100 Q 20 30 25 100 M20 100 Q 25 -10 30 100 M25 100 Q 30 10 35 100 M30 100 Q 35 30 40 100 M35 100 Q 40 10 45 100 M40 100 Q 45 50 50 100 M45 100 Q 50 20 55 100 M50 100 Q 55 40 60 100 M55 100 Q 60 60 65 100 M60 100 Q 65 50 70 100 M65 100 Q 70 20 75 100 M70 100 Q 75 45 80 100 M75 100 Q 80 30 85 100 M80 100 Q 85 20 90 100 M85 100 Q 90 50 95 100 M90 100 Q 95 25 100 100 M95 100 Q 100 15 105 100 Z" stroke-width="0"></path>
                    </svg>
                </div>
                <div class="container">
                    <header class="section-header underline">
                        <h1 class="headline super hairline">Faça Parte</h1>
                        <p class="">Somos uma startup do interior do estado de São Paulo para o mundo.<br />Se você também quer fazer parte dessa história, tamo junto.</p>
                    </header>
                    <div class="col-md-6 col-md-offset-3">
                        <div class="text-center">
                            <a href="./vagas.php" class="btn btn-primary btn-lg btn-icon-right" target="_self">Vagas Abertas
                                <span class="hex-alt">
                                    <i class="fa fa-heartbeat" data-animation="swing"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
            <section class="section swatch-red-white">
                <div class="decor-top">
                    <svg class="decor" height="100%" preserveaspectratio="none" version="1.1" viewbox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 0 L50 100 L100 0 L100 100 L0 100" stroke-width="0"></path>
                    </svg>
                </div>
                <div class="container">
                    <header class="section-header underline">
                        <h1 class="headline hyper hairline">Contato</h1>
                        <p class="big">Envie um email agora, usando os campos abaixo.
                        </p>
                    </header>
                    <div class="row">
                        <div class="col-md-6">
                            <form id="contactForm" class="contact-form" method="post" role="form"  action="">
                                <div class="form-group form-icon-group">
                                    <input class="form-control" id="name" name="name" placeholder="Seu Nome *" type="text" required/>
                                    <i class="fa fa-user"></i>
                                </div>
                                <div class="form-group form-icon-group">
                                    <input class="form-control" id="email" name="email" placeholder="Seu Email *" type="email" required>
                                    <i class="fa fa-envelope"></i>
                                </div>
                                <div class="form-group form-icon-group">
                                    <textarea class="form-control" id="message" name="message" placeholder="Sua Mensagem *" rows="10" required></textarea>
                                    <i class="fa fa-pencil"></i>
                                </div>
                                <div class="form-group text-center">
                                    <button class="btn btn-primary btn-icon btn-icon-right" type="submit">
                                        Enviar email
                                        <div class="hex-alt">
                                            <i class="fa fa-envelope"></i>
                                        </div>
                                    </button>
                                </div>
                            </form>
                            <div id="messages"></div>
                        </div>
                        <div class="col-md-6">
                            <div class="google-map" id="map" style="height:354px;">
                                    <div id="overlay" class="map">
                                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3677.0107931860216!2d-47.05439298529107!3d-22.839090185046295!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94c8c425932bf631%3A0xaba13da26ab9c038!2sBaita+Aceleradora!5e0!3m2!1sen!2sbr!4v1493836083127" width="100%" height="354px" frameborder="0" style="border:0" allowfullscreen></iframe>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        
    <?php if ($success == true) {
        echo '
            <script type="text/javascript">
                swal({
                    title: "Email Enviado!",
                    text: "Agradecemos o contato. Responderemos em breve.",
                    type: "success",
                    showCancelButton: false,
                    closeOnConfirm: true
                    },
                    function(){
                    });
            </script>';
    }?>
        
    <a class="go-top hex-alt" href="javascript:void(0)">
        <i class="fa fa-angle-up"></i>
    </a>
    <script src="novo/assets/js/packages.min.js"></script>
    <script src="novo/assets/js/theme.min.js"></script>
    </body>
</html>
