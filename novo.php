<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Esportes.Co</title>
        <?php 
        include_once("./head.html");
        ?>
        
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
        include_once("./navbar2.html");
        ?>
       
        <div id="content" role="main">
            <section class="section swatch-red-white">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6  text-default">
                            <p>
                                <img class="aligncenter size-full wp-image-2322" alt="app" src="../img/tela2.jpg" width="500" height="800">
                            </p>
                        </div>
                        <div class="col-md-6  text-default">
                            <h1 class="text-left super hairline bordered-header">
                                Seus campeonatos, mais profissionais.
                                </h1>
                            <p class="lead text-left">A Esportes.Co oferece a atletas não-profissionais tudo o que profissionais tem acesso nos esportes. 
                                <br>
                            </p>
                            <p class="lead text-left">Nossa plataforma de campeonatos de futebol atende a organizadores e atletas, levantando informações como tabelas, artilharias e vídeos.
                            </p>
                            <p class="lead text-left">
                                Entregamos mais reconhecimento pra quem merece, e isso é só o começo. 
                                <br>
                            </p>
                            <div class="text-center">
                                <a href="./cadastro/campeonato.php" class="btn btn-primary btn-lg  btn-icon-right" target="_self">Criar Campeonato
                                    <span class="hex-alt">
                                        <i class="fa fa-trophy" data-animation="swing"></i>
                                    </span>
                                </a>
                            </div>
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
                    <header class="section-header ">
                        <h1 class="headline super hairline">Campeonatos com a Esportes.Co</h1>
                        <p class="">Substituímos a boa e velha súmula de papel por uma súmula pelo celular, o que possibilita:</p>
                    </header>
                    <div class="row">
                        <ul class="list-unstyled row box-list horizontal-icon-border">
                            <li class="col-md-3 text-center" data-os-animation="" data-os-animation-delay="">
                                <div class="box-round box-medium">
                                    <div class="box-dummy"></div>
                                    <a class="box-inner " href="single-service.html">
                                        <i class="fa fa-heart" data-animation="bounce"></i>
                                    </a>
                                </div>
                                <h3 class="text-center ">
                                    <a href="single-service.html">Engajar mais os jogadores</a>
                                </h3>
                                <p class="text-center">Para manter os jogadores envolvidos, disponibilizamos todas as informações para acompanhamento dos interessados, em tempo-real.</p>
                            </li>
                            <li class="col-md-3 text-center" data-os-animation="" data-os-animation-delay="">
                                <div class="box-round box-medium">
                                    <div class="box-dummy"></div>
                                    <a class="box-inner " href="single-service.html">
                                        <i class="fa fa-pencil" data-animation="swing"></i>
                                    </a>
                                </div>
                                <h3 class="text-center ">
                                <a href="single-service.html">Automatizar as inscrições</a></h3>
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
                                    <a href="single-service.html">Atualizar e divulgar tabelas</a>
                                </h3>
                                <p class="text-center">Todos os dados do campeonato são atualizados automaticamente com as informações coletadas no momento do jogo, reduzindo trabalho e erros.</p>
                            </li>
                            <li class="col-md-3 text-center" data-os-animation="" data-os-animation-delay="">
                                <div class="box-round box-medium">
                                    <div class="box-dummy"></div>
                                    <a class="box-inner " href="single-service.html">
                                        <i class="fa fa-dollar" data-animation="tada"></i>
                                    </a>
                                </div>
                                <h3 class="text-center ">
                                    <a href="single-service.html">
                                        Atrair patrocinadores
                                    </a>
                                </h3>
                                <p class="text-center">A internet é a nova TV. O interesse e número de acessos auxilia a obtenção de patrocínios maiores.</p>
                            </li>
                        </ul>
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
                                                    <p><i>A EsportesCo ajudou a otimizar a gestão das competições, tanto para os participantes quanto para os professores, pela praticidade dos jogos online.</i></p>
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
                                                    <p><i>Tivemos a oportunidade de trabalhar em parceria com a EsportesCo fazendo a súmula online no Campeonato de Society da empresa Benteler.
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
            <section class="section swatch-white-red has-top">
                <div class="decor-top">
                    <svg class="decor" height="100%" preserveaspectratio="none" version="1.1" viewbox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 100 L50 0 L100 100" stroke-width="0"></path>
                    </svg>
                </div>
                <div class="container">
                    <header class="section-header underline">
                        <h1 class="headline super hairline">Perguntas Frequentes</h1>
                    </header>
                    <div class="col-md-6 col-md-offset-3">
                        <div class="panel-group" id="accordion">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <a class="accordion-toggle collapsed" data-parent="#accordion"  data-toggle="collapse" href="#collapseOne">
                                        1. A plataforma é pra mim?
                                    </a>
                                </div>
                                <div class="panel-collapse collapse" id="collapseOne">
                                    <div class="panel-body">
                                        <p>
                                            Se você é um organizador de campeonatos de futebol amadores (de campo, society ou salão), a resposta é sim.<br><br>
                                            
                                            Nossa plataforma substitui sistemas antigos e o famoso excel com uma interface mais automática e navegável.<br><br>
                                            
                                            Outros esportes por enquanto não são atendidos.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <a class="accordion-toggle collapsed" data-parent="#accordion" data-toggle="collapse" href="#collapseTwo">
                                        2. O que preciso para começar a usar?
                                    </a>
                                </div>
                                <div class="panel-collapse collapse" id="collapseTwo">
                                    <div class="panel-body">
                                        <p>
                                           São necessários 3 passos:<br><br>
                                            1 - Preencher dados iniciais, como nome do camponato, modalidade, dados de contato e termo de aceite.<br><br>
                                            2 - Você receberá um link para divulgar, para que os times possam fazer a inscrição dos jogadores.<br><br>
                                            3 - Após a inscrição das equipes, será preciso definir os grupos e criar as partidas.<br><br>
                                            E pronto! Bola em jogo.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <a class="accordion-toggle collapsed" data-parent="#accordion" data-toggle="collapse" href="#collapseThree">
                                        3. Como administro o sistema?
                                    </a>
                                </div>
                                <div class="panel-collapse collapse" id="collapseThree">
                                    <div class="panel-body">
                                        <p>
                                            Você receberá um endereço único, com uma chave que só você tem acesso. A partir desse endereço é possível acessar o portal do administrador, que possibilida a inclusão, edição e exclusão de times, jogadores e partidas.<br><br>
                                            
                                            Esse mesmo portal dá acesso à súmula eletrônica para as partidas criadas.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <a class="accordion-toggle collapsed" data-parent="#accordion" data-toggle="collapse" href="#collapseFour">
                                       5. Como funciona a súmula eletrônica?
                                    </a>
                                </div>
                                <div class="panel-collapse collapse" id="collapseFour">
                                    <div class="panel-body">
                                        <p>
                                            Nossa súmula é um site preparado para celulares que funciona em qualquer dispositivo Android/iOS sem a necessidade de instalação prévia. Ela pode ser usada de duas maneiras:<br><br>
                                            
                                            1 - Pela arbitragem, durante as partidas.<br>
                                            Este caso minimiza o trabalho do organizador e os jogadores conseguem acessar as informações marcadas em <b>tempo real</b> pelos seus próprios celulares.<br><br>
                                            
                                            2- Pelo organizador, após as partidas.<br>
                                            Caso a equipe de arbitragem não esteja preparada para utilizar a súmula no celular, eles podem utilizar o papel normalmente, que nosso sistema gera para impressão, e entregar as anotações para o organizador. A partir dessas anotações, o organizador passa tudo para o sistema e encerra a partida, o que atualizará todas as informações (como a tabela, artilharia e cartões).
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php 
            include_once("./foot.html");
            ?>
        </div>
    </body>
</html>
