<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Vagas Esportes.Co</title>
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
                    <header class="section-header no-underline">
                        <h1 class="headline hyper hairline">Vagas Abertas</h1>
                    </header>
                </div>
            </section>
            <section class="section swatch-white-red has-top">
                <div class="decor-top">
                    <svg class="decor" height="100%" preserveaspectratio="none" version="1.1" viewbox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 0 L50 100 L100 0 L100 100 L0 100" stroke-width="0"></path>
                    </svg>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <header class="section-header underline">
                                <p class="text-left">
                                    Estamos montando uma equipe que queira crescer com a gente. Participando dessa etapa você poderá acompanhar nossas decisões e nos ajudar a tomar o caminho certo para alcançarmos o maior número de pessoas possível. Todas as posições tem como benefícios:
                                    <br /><br />
                                    * Nenhuma formalidade de vestimenta, em ambiente descontraído.
                                    <br />
                                    * Flexibilidade de horário.
                                    <br />
                                    * Possibilidade de trabalho remoto em alguns momentos.
                                </p>
                                <p class="text-left">
                                    Quer crescer junto com a gente? Envie seu currículo para <b>contato@esportes.co</b> e indique o código da vaga para participar do processo.
                                </p>
                            </header>
                            <br>
                            <br>
                            <article class="post post-showinfo">
                                
                                <div class="post-head small-screen-center">
                                    <h2 class="post-title">
                                        <a href="post.html">
                                            Pesquisador de Machine Learning / Deep Learning
                                        </a>
                                    </h2>
                                    <small class="post-author">
                                        Código: DEEP_LEARNING
                                    </small>
                                    <div class="post-icon flat-shadow flat-hex"  style="margin-bottom:50px;">
                                        <div class="hex hex-big">
                                            <i class="fa fa-gears fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="post-body">
                                    <p>
                                       Atividades da vaga
                                    </p>
                                    <p>
                                        * Estudar redes neurais profundas, em especial redes neurais convolutivas.
                                    </p>
                                    <p>
                                        * Implementar arquiteturas propostas na literatura para a detecção automática de melhores momentos das partidas gravadas.
                                    </p>
                                    <p>
                                        * Realizar o treinamento da máquina, seus consecutivos testes e avaliar constantemente os resultados.
                                    </p>
                                    <p>
                                        Requisitos
                                    </p>
                                    <p>
                                        * Diploma no ensino superior e mais de 4 anos de experiência na área *após* a graduação // esse requisito é indispensável devido à agência de fomento que financiará a bolsa.
                                    </p>
                                    <p>
                                        * Possuir conhecimentos e experiência em processamento de imagem, aprendizado de máquina, programação paralela ou afins.
                                    </p>
                                    <p>
                                        * Interesse em aprender e se aperfeiçoar nas técnicas de redes neurais profundas e disposto a se dedicar integralmente no projeto de pesquisa.
                                    </p>
                                    <p>
                                        * Proatividade.
                                    </p>
                                    <p>
                                        Remuneração.
                                    </p>
                                    <p>
                                        * Pagamento mensal <b>líquido</b> na forma de bolsa de pesquisa, de acordo do nível de experiência, de R$ 4.705,20 a R$ 6.819,30. 
                                    </p>
                                </div>
                                <div class="bordered post-extras text-center">
                                </div>
                            </article>
                            
                            <article class="post post-showinfo">
                                
                                <div class="post-head small-screen-center">
                                    <h2 class="post-title">
                                        <a href="post.html">
                                            Web Developer
                                        </a>
                                    </h2>
                                    <small class="post-author">
                                        Código: WEB_DEV
                                    </small>
                                    <div class="post-icon flat-shadow flat-hex">
                                        <div class="hex hex-big">
                                            <i class="fa fa-tablet fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="post-body">
                                    <p>
                                       Atividades da vaga
                                    </p>
                                    <p>
                                        * Definir as tecnologias a serem utilizadas nos projetos da empresa.
                                    </p>
                                    <p>
                                        * Desenvolver produtos web, atuando tanto em back-end quanto em front-end.
                                    </p>
                                    <p>
                                        * Auxilinar na organização e preparação dos dados para o treinamento da inteligência de detecção de melhores momentos.
                                    </p>
                                    <p>
                                        Requisitos
                                    </p>
                                    <p>
                                        * Experiência em desenvolvimento web.
                                    </p>
                                    <p>
                                        * Flexibilidade para aprender novas tecnologias.
                                    </p>
                                    <p>
                                        * Proatividade.
                                    </p>
                                    <p>
                                        Diferenciais
                                    </p>
                                    <p>
                                        * Ter trabalhado em outras startups.
                                    </p>
                                    <p>
                                        * Experiência na área de educação.
                                    </p>
                                    <p>
                                        * Ter envolvimento com projetos de software livre.
                                    </p>
                                    <p>
                                        * Experiência com metodologias ágeis.
                                    </p>
                                    <p>
                                        * Ser full stack.
                                    </p>
                                    <p>
                                        * Toda informação sobre seu trabalho, como por exemplo sua conta do GitHub ou stackoverflow. 
                                    </p>
                                    <p>
                                        Remuneração.
                                    </p>
                                    <p>
                                        * A combinar, de acordo com o nível de experiência e desempenho.
                                    </p>
                                </div>
                                <div class="bordered post-extras text-center">
                                </div>
                            </article>
                            
                        </div>
                    </div>
                </div>
            </section>
            <footer id="footer" role="contentinfo">
                <section class="section swatch-red-white has-top">
                    <div class="decor-top">
                        <svg class="decor" height="100%" preserveaspectratio="none" version="1.1" viewbox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 0 L50 100 L100 0 L100 100 L0 100" stroke-width="0"></path>
                        </svg>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <div id="swatch_social-2" class="sidebar-widget  widget_swatch_social" style="margin-top:-20px;">
                                    <ul class="unstyled inline small-screen-center social-icons social-background social-big">
                                        <span>Saiba de novas vagas pela nossa página corporativa, no facebook<br><br></span>
                                        <li>
                                            <a target="_blank" href="https://www.facebook.com/esportes.company/">
                                                <i class="fa fa-facebook"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div id="text-4" class="sidebar-widget widget_text"  style="margin-bottom:-30px; margin-top:-20px;">
                                    <div class="textwidget">Esportes.Co 2017
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </footer>
        </div>
        <a class="go-top hex-alt" href="javascript:void(0)">
        <i class="fa fa-angle-up"></i>
    </a>
    <script src="novo/assets/js/packages.min.js"></script>
    <script src="novo/assets/js/theme.min.js"></script>
    </body>
</html>