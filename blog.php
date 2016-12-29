<!DOCTYPE html>
<html lang="en">
   <head>
        <title>Blog Esportes.Co</title>
        <?php 
        include_once("./head.html");
        ?>
    </head>
    <body class="pace-on pace-dot">
        <?php 
        include_once("./admin/analyticstracking.php");
        include_once("./navbar.php");
        ?>
        <div class="pace-overlay"></div>
        <div id="content" role="main">
            <section class="section swatch-red-white">
                <div class="container">
                    <header class="section-header no-underline">
                        <h1 class="headline hyper hairline">Nosso Blog</h1>
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
                    <ul class="isotope-filters small-screen-center">
                        <li>
                            <a class="pseudo-border active" data-filter="*" href="#">todas</a>
                        </li>
                        <li>
                            <a class="pseudo-border" data-filter=".filter-text" href="#">textos</a>
                        </li>
                        <li>
                            <a class="pseudo-border" data-filter=".filter-images" href="#">imagens</a>
                        </li>
                        <li>
                            <a class="pseudo-border" data-filter=".filter-quotes" href="#">citações</a>
                        </li>
                        <li>
                            <a class="pseudo-border" data-filter=".filter-media" href="#">áudios & vídeos</a>
                        </li>
                    </ul>
                    <div class="row">
                        <ul class="list-unstyled isotope no-transition">
                            <li class="col-md-4 post-item filter-text isotope-item">
                                <div class="grid-post swatch-red-white">
                                    <article class="post post-showinfo">
                                        <div class="post-media overlay">
                                            <a class="feature-image magnific" ></a>
                                            <a href="post2.php">
                                                <img alt="some image" src="../img/sweat3.jpg">
                                            </a>
                                        </div>
                                        <div class="post-head small-screen-center">
                                            <h2 class="post-title">
                                                <a href="post2.php">
                                                    Resultado da Pesquisa Sobre Esportes e o Ambiente Corporativo
                                                </a>
                                            </h2>
                                            <small class="post-author">
                                                16 de Dezembro de 2016    </small>
                                            <div class="post-icon flat-shadow flat-hex">
                                                <div class="hex hex-big">
                                                    <i class="fa fa-file-text"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="post-body">
                                            <p>
                                                Um mês e mais de cem participações depois, reunimos as principais respostas em um infográfico para ter uma visão mais clara sobre como as empresas estão utilizando esportes para atingir seus objetivos.
                                            </p>
                                        </div>
                                        <div class="bordered post-extras text-center"> 
                                        </div>
                                    </article>
                                </div>
                            </li>
                            <li class="col-md-4 post-item filter-images isotope-item">
                                <div class="grid-post swatch-red-white">
                                    <article class="post post-showinfo">
                                        <div class="post-media overlay">
                                            <a class="feature-image magnific hover-animate" href="../img/lcf.jpg" title="Premiação">
                                                <img alt="some image" src="../img/lcf.jpg">
                                                <i class="fa fa-search-plus"></i>
                                            </a>
                                        </div>
                                        <div class="post-head small-screen-center">
                                            <h2 class="post-title">
                                                 <a class="feature-image magnific hover-animate" href="../img/lcf.jpg" title="Premiação">
                                                    Ligas Municipais
                                                </a>
                                            </h2>
                                            <small class="post-author">
                                                8 de Dezembro de 2016
                                            </small>
                                            <div class="post-icon flat-shadow flat-hex">
                                                <div class="hex hex-big">
                                                    <i class="fa fa-camera"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="post-body">
                                            <p>
                                                Ontem fomos convidados pelo Irdival para participar de um evento de premiação da LMC. Além das premiações, aproveitamos para conhecer um pouco mais sobre quem mantém essa galera unida.
                                            </p>
                                            <p>
                                                Falamos tanto com presidentes de times quanto o pessoal da própria Liga. Em ambos os casos, vimos pessoas que fazem seu papel por que gostam, pelos outros, pra manter a coisa viva, apesar de todas as adversidades.
                                            </p>
                                            <p>
                                               Saímos com o sentimento de que nossa parceria é muito bem-vinda, pois vai facilitar muito, principalmente o trabalho recorrente de atualizar informações dos campeonatos e divulgar para os jogadores... Enfim, tamo junto!
                                            </p>
                                        </div>
                                        <div class="bordered post-extras text-center"> 
                                        </div>
                                    </article>
                                </div>
                            </li>
                             <li class="col-md-4 post-item filter-quotes isotope-item">
                                <div class="grid-post swatch-red-white">
                                    <article class="post post-showinfo">
                                        <div class="post-media"></div>
                                        <div class="post-head small-screen-center">
                                            <h2 class="post-title">
                                                Missão Cumprida
                                            </h2>
                                            <small class="post-author">
                                                19 de Novembro de 2016
                                            </small>
                                            <div class="post-icon flat-shadow flat-hex">
                                                <div class="hex hex-big">
                                                    <i class="fa fa-quote-left"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="post-body">
                                            <blockquote>
                                                <p>Graças a vocês, voltei a poder pescar de segunda-feira.</p>
                                                <small>
                                                    Bruno
                                                    <cite title="Any Given Sunday"> Gestor, Projeto Bugrinho</cite>
                                                </small>
                                            </blockquote>
                                        </div>
                                        <div class="bordered post-extras text-center">
                                        </div>
                                    </article>
                                </div>
                            </li>
                            <li class="col-md-4 post-item filter-text isotope-item">
                                <div class="grid-post swatch-red-white">
                                    <article class="post post-showinfo">
                                        <div class="post-media overlay">
                                            <a class="feature-image magnific" ></a>
                                            <a href="post.php">
                                                <img alt="some image" src="../img/sweat3.jpg">
                                            </a>
                                        </div>
                                        <div class="post-head small-screen-center">
                                            <h2 class="post-title">
                                                <a href="post.php">
                                                    Esportes e o Ambiente Corporativo
                                                </a>
                                            </h2>
                                            <small class="post-author">
                                                17 de Novembro de 2016    </small>
                                            <div class="post-icon flat-shadow flat-hex">
                                                <div class="hex hex-big">
                                                    <i class="fa fa-file-text"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="post-body">
                                            <p>
                                                Preparar... Apontar... Vai!
                                            </p>
                                            <p>
                                                O ambiente corporativo possui uma relação próxima com os esportes. Aspectos como liderança, trabalho em equipe e superação são constantes em ambos. Porém, nem sempre essas semelhanças são aproveitadas como poderiam.
                                            </p>
                                            <p>
                                                Uma das principais característica dos esportes é o conceito de "jogo". Nele, existem duas figuras essenciais...<a href="post.php"> continuar lendo </a>
                                            </p>
                                            
                                        </div>
                                        <div class="bordered post-extras text-center"> 
                                        </div>
                                    </article>
                                </div>
                            </li>
                            <li class="col-md-4 post-item filter-images isotope-item">
                                <div class="grid-post swatch-red-white">
                                    <article class="post post-showinfo">
                                        <div class="post-media overlay">
                                            <a class="feature-image magnific hover-animate" href="../img/mulecada.jpeg" title="Professor falando com os meninos e a Sophia">
                                                <img alt="some image" src="../img/molecada2.jpg">
                                                <i class="fa fa-search-plus"></i>
                                            </a>
                                        </div>
                                        <div class="post-head small-screen-center">
                                            <h2 class="post-title">
                                                 <a class="feature-image magnific hover-animate" href="../img/mulecada.jpeg" title="Professor falando com os meninos e a Sophia">
                                                    Campeonato Interno - Projeto Bugrinho
                                                </a>
                                            </h2>
                                            <small class="post-author">
                                                22 de Outubro de 2016
                                            </small>
                                            <div class="post-icon flat-shadow flat-hex">
                                                <div class="hex hex-big">
                                                    <i class="fa fa-camera"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="post-body">
                                            <p>
                                                Hoje estive em dois campos acompanhando os professores de futebol do Projeto Bugrinho. A ideia era ensiná-los a usar o sistema da súmula e pegar alguns feedbacks. O bate-papo com eles e os pais foi bem legal e, de quebra, aprendi algo novo. Vi o professor mostrando aos alunos o sistema no intervalo de jogo: "Alá, vamos ver o resultado do jogo. 3 a 0, só saiu uma falta. Vocês tão no Cartola!".
                                            </p>
                                            <p>Será que no futuro os técnicos vão conseguir utilizar nosso sistema pra passar informações pros jogadores? Ta aí uma nova possibilidade. De qualquer forma, o encontro com a molecada é sempre positivo. Vamos em frente!</p>
                                     
                                        </div>
                                        <div class="bordered post-extras text-center"> 
                                        </div>
                                    </article>
                                </div>
                            </li>
                            <li class="col-md-4 post-item filter-media isotope-item">
                                <div class="grid-post swatch-red-white">
                                    <article class="post post-showinfo">
                                        <div class="post-media overlay">
                                            <a class="feature-image magnific-youtube hover-animate" href="https://www.youtube.com/watch?v=gav6WqCola4" title="">
                                                <img alt="" src="img/poka.jpg">
                                            </a>
                                        </div>
                                        <div class="post-head small-screen-center">
                                            <h2 class="post-title">
                                                <a href="post.html">
                                                    Gravação de partidas com baixo custo
                                                </a>
                                            </h2>
                                            <small class="post-author">14 de Agosto 2016
                                            </small>
                                            <div class="post-icon flat-shadow flat-hex">
                                                <div class="hex hex-big">
                                                    <i class="fa fa-film"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="post-body">
                                            <p>
                                               Ao longo de seus dois anos de existência, a Esportes.Co testou diferentes formas de captura de jogos amadores, passando por câmeras IP, câmeras analógicas, celulares  e câmeras 360°.
                                            </p>
                                            <p>
                                                Uma das lições aprendidas é que o vídeo traz uma dimensão nova para os jogos. O orgulho de poder reproduzir um belo lance traz uma preocupação maior 
                                            </p>
                                            <p>
                                                Saber que a imagem estará disponível é o sonho de muita gente e, quando isso é feito, gera um interesse genuíno e recorrente no material produzido. Observamos que 80% do tempo de acesso é direcionado para vídeos.
                                            </p>
                                            <p>
                                                Para entregar isso, identificamos que a forma atual mais escalável é a utilização dos equipamentos eletrônicos que já estão disponíveis nos campos, como os celulares dos jogadores e torcedores. Uma vez capturada uma partida inteira, esse vídeo pode ser subido por meio da nossa plataforma, que disponibiliza um meio para que jogadores recortem e atribuam lances uns aos outros, montando um histórico de muito valor para o craque/autor.
                                            </p>
                                        </div>
                                        <div class="bordered post-extras text-center">
                                        </div>
                                    </article>
                                </div>
                            </li>
                            <!--
                            <li class="col-md-4 post-item filter-images isotope-item">
                                <div class="grid-post swatch-red-white">
                                    <article class="post post-showinfo">
                                        <div class="post-media overlay">
                                            <div id="slider-flex7" class="flexslider text-left feature-slider" data-flex-speed="7000" data-flex-animation="slide" data-flex-controls="hide" data-flex-directions="show" data-flex-controlsalign="center" data-flex-captionhorizontal="alternate" data-flex-captionvertical="bottom"
                                            data-flex-controlsposition="" data-flex-directions-type="">
                                                <ul class="slides">
                                                    <li>
                                                        <img src="novo/assets/images/design/vector/img-5-800x600.png" alt="some image">
                                                    </li>
                                                    <li>
                                                        <img src="novo/assets/images/design/vector/img-3-800x600.png" alt="some image">
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="post-head small-screen-center">
                                            <h2 class="post-title">
      <a href="post.html">
        Awesome design
      </a>
    </h2>
                                            <small class="post-author">
      <a href="blog.html">John Langan,</a>
    </small>
                                            <small class="post-date">
      <a href="post.html">9 June 2014</a>
    </small>
                                            <div class="post-icon flat-shadow flat-hex">
                                                <div class="hex hex-big">
                                                    <i class="fa fa-picture-o"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="post-body">
                                            <p>
                                                Donec luctus, dolor ut scelerisque luctus, erat elit consectetur arcu, eu pellentesque felis nulla sed massa. Nunc enim sem, ullamcorper ac tincidunt eget, euismod nec leo. Nunc imperdiet fringilla erat, sit amet iaculis ipsum congue et. Vestibulum sapien
                                                metus, fermentum et accumsan nec, imperdiet sed ligula. Praesent semper vitae nisi quis egestas.
                                            </p>
                                            <a class="more-link" href="post.html">
      read more
    </a>
                                        </div>
                                        <div class="bordered post-extras text-center">
                                            <div class="text-center">
                                                <span class="post-category">
      <a href="post.html">
        <i class="fa fa-folder-open"></i>
        News
      </a>
    </span>
                                                <span class="post-tags">
      <i class="fa fa-tags"></i>
      
        <a href="post.html">
          Design
        </a>
      
      
        <a href="post.html">
          Flat
        </a>
      
      
      
    </span>
                                                <span class="post-link">
      <a href="post.html">
        <i class="fa fa-comments"></i>
        2 comments
      </a>
    </span>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            </li>
                            <li class="col-md-4 post-item filter-images isotope-item">
                                <div class="grid-post swatch-red-white">
                                    <article class="post post-showinfo">
                                        <div class="post-media overlay">
                                            <a class="feature-image magnific hover-animate" href="novo/assets/images/design/vector/img-3-800x600.png" title="Thats a nice image">
                                                <img alt="some image" src="novo/assets/images/design/vector/img-3-800x600.png">
                                                <i class="fa fa-search-plus"></i>
                                            </a>
                                        </div>
                                        <div class="post-head small-screen-center">
                                            <h2 class="post-title">
      <a href="post.html">
        Clean &amp; Flat Design
      </a>
    </h2>
                                            <small class="post-author">
      <a href="blog.html">Manos Doe,</a>
    </small>
                                            <small class="post-date">
      <a href="post.html">30 April 2014</a>
    </small>
                                            <div class="post-icon flat-shadow flat-hex">
                                                <div class="hex hex-big">
                                                    <i class="fa fa-camera"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="post-body">
                                            <p>
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facilis, quo, veniam culpa maiores iure distinctio atque similique veritatis rem et adipisci eveniet aspernatur aut sapiente amet doloremque eos quasi numquam.
                                            </p>
                                            <a class="more-link" href="post.html">
      read more
    </a>
                                        </div>
                                        <div class="bordered post-extras text-center">
                                            <div class="text-center">
                                                <span class="post-category">
      <a href="post.html">
        <i class="fa fa-folder-open"></i>
        News
      </a>
    </span>
                                                <span class="post-tags">
      <i class="fa fa-tags"></i>
      
        <a href="post.html">
          Design,
        </a>
      
      
        <a href="post.html">
          Flat
        </a>
      
      
      
    </span>
                                                <span class="post-link">
      <a href="post.html">
        <i class="fa fa-comments"></i>
        4 comments
      </a>
    </span>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            </li>
                            <li class="col-md-4 post-item filter-text isotope-item">
                                <div class="grid-post swatch-red-white">
                                    <article class="post post-showinfo">
                                        <div class="post-media"></div>
                                        <div class="post-head small-screen-center">
                                            <h2 class="post-title">
      <a href="post.html">
        Bootstrap is Really Important
      </a>
    </h2>
                                            <small class="post-author">
      <a href="blog.html">Manos Proistak,</a>
    </small>
                                            <small class="post-date">
      <a href="post.html">25 July 2014</a>
    </small>
                                            <div class="post-icon flat-shadow flat-hex">
                                                <div class="hex hex-big">
                                                    <i class="fa fa-file-text"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="post-body">
                                            <p>
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facilis, quo, veniam culpa maiores iure distinctio atque similique veritatis rem et adipisci eveniet aspernatur aut sapiente amet doloremque eos quasi numquam.In lobortis eget ipsum vestibulum
                                                tristique. Donec luctus, dolor ut scelerisque luctus, erat elit consectetur arcu, eu pellentesque felis nulla sed massa. Nunc enim sem, ullamcorper ac tincidunt eget, euismod nec leo. Nunc imperdiet fringilla
                                                erat, sit amet iaculis ipsum congue et. Vestibulum sapien metus, fermentum et accumsan nec, imperdiet sed ligula. Praesent semper vitae nisi quis egestas.
                                            </p>
                                            <a class="more-link" href="post.html">
      read more
    </a>
                                        </div>
                                        <div class="bordered post-extras text-center">
                                            <div class="text-center">
                                                <span class="post-category">
      <a href="post.html">
        <i class="fa fa-folder-open"></i>
        News
      </a>
    </span>
                                                <span class="post-tags">
      <i class="fa fa-tags"></i>
      
        <a href="post.html">
          Design,
        </a>
      
      
        <a href="post.html">
          Flat
        </a>
      
      
      
    </span>
                                                <span class="post-link">
      <a href="post.html">
        <i class="fa fa-comments"></i>
        4 comments
      </a>
    </span>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            </li>
                            
                            <li class="col-md-4 post-item filter-media isotope-item">
                                <div class="grid-post swatch-red-white">
                                    <article class="post post-showinfo">
                                        <div class="post-media overlay">
                                            <a class="feature-image magnific-youtube hover-animate" href="http://vimeo.com/20061744" title="">
                                                <img alt="" src="novo/assets/images/design/vector/img-7-800x600.png">
                                                <i class="fa fa-play"></i>
                                            </a>
                                        </div>
                                        <div class="post-head small-screen-center">
                                            <h2 class="post-title">
      <a href="post.html">
        Let&#x27;s talk about it
      </a>
    </h2>
                                            <small class="post-author">
      <a href="blog.html">Chris Pantazis,</a>
    </small>
                                            <small class="post-date">
      <a href="post.html">5 August 2014</a>
    </small>
                                            <div class="post-icon flat-shadow flat-hex">
                                                <div class="hex hex-big">
                                                    <i class="fa fa-film"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="post-body">
                                            <p>
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facilis, quo, veniam culpa maiores iure distinctio atque similique veritatis rem et adipisci eveniet aspernatur aut sapiente amet doloremque eos quasi numquam.In lobortis eget ipsum vestibulum
                                                tristique. Donec luctus, dolor ut scelerisque luctus, erat elit consectetur arcu, eu pellentesque felis nulla sed massa.
                                            </p>
                                            <a class="more-link" href="post.html">
      read more
    </a>
                                        </div>
                                        <div class="bordered post-extras text-center">
                                            <div class="text-center">
                                                <span class="post-category">
      <a href="post.html">
        <i class="fa fa-folder-open"></i>
        Blog
      </a>
    </span>
                                                <span class="post-tags">
      <i class="fa fa-tags"></i>
      
        <a href="post.html">
          Design,
        </a>
      
      
        <a href="post.html">
          Flat
        </a>
      
      
      
    </span>
                                                <span class="post-link">
      <a href="post.html">
        <i class="fa fa-comments"></i>
        2 comments
      </a>
    </span>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            </li>
                            <li class="col-md-4 post-item filter-media isotope-item">
                                <div class="grid-post swatch-red-white">
                                    <article class="post post-showinfo">
                                        <div class="post-media swatch-white-red">
                                            <audio controls="" preload="auto" style="width:100%;">
                                                <source src="http://theme-background-videos.s3.amazonaws.com/audio/audio.wav">
                                                    <source src="http://theme-background-videos.s3.amazonaws.com/audio/audio.mp3">
                                                        <source src="http://theme-background-videos.s3.amazonaws.com/audio/audio.ogg">
                                            </audio>
                                        </div>
                                        <div class="post-head text-center">
                                            <h2 class="post-title">
      <a href="post.html">
        Sounds even better!
      </a>
    </h2>
                                            <small class="post-author">
      <a href="blog.html">Harry Doe,</a>
    </small>
                                            <small class="post-date">
      <a href="post.html">5 August 2014</a>
    </small>
                                            <div class="post-icon flat-shadow flat-hex">
                                                <div class="hex hex-big">
                                                    <i class="fa fa-volume-up"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="post-body">
                                            <p>
                                                Cras aliquet felis in magna accumsan, sit amet mattis arcu auctor. Nunc sollicitudin auctor adipiscing. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Etiam lacus ante, egestas id pellentesque vel, tempus at justo.
                                                Donec luctus, dolor ut scelerisque luctus, erat elit consectetur arcu, eu pellentesque felis nulla sed massa. Nunc enim sem, ullamcorper ac tincidunt eget, euismod nec leo. Nunc imperdiet fringilla erat,
                                                sit amet iaculis ipsum congue et. Vestibulum sapien metus.
                                            </p>
                                        </div>
                                        <div class="bordered post-extras text-center">
                                            <div class="text-center">
                                                <span class="post-category">
      <a href="post.html">
        <i class="fa fa-folder-open"></i>
        News
      </a>
    </span>
                                                <span class="post-tags">
      <i class="fa fa-tags"></i>
      
        <a href="post.html">
          Design,
        </a>
      
      
        <a href="post.html">
          Flat
        </a>
      
      
      
    </span>
                                                <span class="post-link">
      <a href="post.html">
        <i class="fa fa-comments"></i>
        4 comments
      </a>
    </span>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            </li>-->
                        </ul>
                    </div>
                </div>
            </section>
            <?php 
            include_once("./foot.html");
            ?>
        </div>
    </body>
</html>
