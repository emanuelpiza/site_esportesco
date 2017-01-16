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
        <div id="content" role="main">
            <section class="section swatch-white-red has-top">
                <div class="decor-top">
                    <svg class="decor" height="100%" preserveaspectratio="none" version="1.1" viewbox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 0 L50 100 L100 0 L100 100 L0 100" stroke-width="0"></path>
                    </svg>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <article class="post post-showinfo">
                                <div class="post-head small-screen-center">
                                    <h2 class="post-title" style="color:#e74c3c;">
                                       Resultado da Pesquisa
                                    </h2>
                                    <small class="post-author">
                                        <a href="https://br.linkedin.com/in/emanuelpiza" target="_blank">Emanuel Piza,</a>
                                    </small>
                                    <small class="post-date">16 de Dezembro de 2016
                                    </small>
                                    <div class="post-icon flat-shadow flat-hex">
                                        <div class="hex hex-big">
                                            <i class="fa fa-file-text"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="post-body">
                                  <div class="canva-embed" data-height-ratio="1" data-design-id="DACHhG3SPK8" style="padding:100% 5px 5px 5px;background:rgba(0,0,0,0.03);border-radius:8px;"></div><script async src="https://sdk.canva.com/v1/embed.js"></script>
                                </div>
                                <div class="bordered post-extras text-center">
                                    <div class="text-center">
                                    </div>
                                </div>
                                <nav class="post-navigation padded" id="nav-below">
                                    <ul class="pager">
                                        <li class="previous">
                                            <a class="btn btn-primary btn-icon btn-icon-left" href="./post.php" rel="prev">
                                                <div class="hex-alt">
                                                    <i class="fa fa-angle-left"></i>
                                                </div>
                                                Anterior
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </article>
                        </div>
                        <div class="col-md-4 col-md-offset-2">
                            <div class="sidebar-widget widget_text">
                                <h3 class="sidebar-header">Sobre Nós</h3>
                                <p>
                                    A Esportes Company busca oferecer a atletas amadores tudo o que profissionais tem acesso nos esportes. Reconhecemos o grande trabalho que pessoas fazem em todo o país para organizar e divulgar ações esportivas e acreditamos que podemos ajudá-las. Esse é nosso foco.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php 
            include_once("./foot.html");
            ?>
        </div>
        <script>
            var radarChartData = {
                labels: ["Nenhuma", "Comp. de Fut.", "Academia", "Corrida", "Comp. Multiesp.", "Gin. Laboral"],
                datasets: [
                {
                        label: "My Second dataset",
                        fillColor: "rgba(151,187,205,0.2)",
                        strokeColor: "rgba(151,187,205,1)",
                        pointColor: "rgba(151,187,205,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(151,187,205,1)",
                        data: [33,29,25,22,21,7]
                    }
                ]
            };
            var radarChartData2 = {
                labels: ["Intranet", "Excel", "Nenhuma", "Súmula elet."],
                datasets: [
                {
                        label: "My Second dataset",
                        fillColor: "rgba(151,187,205,0.2)",
                        strokeColor: "rgba(151,187,205,1)",
                        pointColor: "rgba(151,187,205,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(151,187,205,1)",
                        data: [40,  26,  13,  8]
                    }
                ]
            };
            var pieData = [
                {
                    label: "Não",
                    value: 39,
                    color:"#878BB6"
                },
                {
                    label: "Sim",
                    value : 61,
                    color : "#4ACAB4"
                }
            ];
            var pieOptions = {
                segmentShowStroke : true,
                animateScale : false
            }

            window.onload = function(){
                window.myRadar2 = new     Chart(document.getElementById("canvas2").getContext("2d")).Bar(radarChartData2, {
                    responsive: true
                });
                window.myRadar = new Chart(document.getElementById("canvas").getContext("2d")).Bar(radarChartData, {
                responsive: true
                });
                var retorno= document.getElementById("retorno").getContext("2d");
                new Chart(retorno).Pie(pieData, pieOptions);
	}

	</script> 
    </body>
</html>
