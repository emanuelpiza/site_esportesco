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
        include_once("./navbar.html");
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
                        <div class="col-md-9">
                            <article class="post post-showinfo">
                       <script src='https://maps.googleapis.com/maps/api/js?key=&sensor=false&extension=.js'></script> 
 
<script> 
    google.maps.event.addDomListener(window, 'load', init);
    var map;
    function init() {
        var mapOptions = {
            center: new google.maps.LatLng(-22.935551,-47.049395),
            zoom: 15,
            zoomControl: true,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.SMALL,
            },
            disableDoubleClickZoom: true,
            mapTypeControl: true,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
            },
            scaleControl: true,
            scrollwheel: true,
            panControl: true,
            streetViewControl: true,
            draggable : true,
            overviewMapControl: true,
            overviewMapControlOptions: {
                opened: false,
            },
            mapTypeId: google.maps.MapTypeId.ROADMAP,
        }
        var mapElement = document.getElementById('EsportesCoTeste');
        var map = new google.maps.Map(mapElement, mapOptions);
        var locations = [
['Liga Campineira', 'undefined', 'undefined', 'undefined', 'undefined', -22.9375794, -47.050516200000004, 'http://www.esportes.co/img/logo.png']
        ];
        for (i = 0; i < locations.length; i++) {
			if (locations[i][1] =='undefined'){ description ='';} else { description = locations[i][1];}
			if (locations[i][2] =='undefined'){ telephone ='';} else { telephone = locations[i][2];}
			if (locations[i][3] =='undefined'){ email ='';} else { email = locations[i][3];}
           if (locations[i][4] =='undefined'){ web ='';} else { web = locations[i][4];}
           if (locations[i][7] =='undefined'){ markericon ='';} else { markericon = locations[i][7];}
            marker = new google.maps.Marker({
                icon: markericon,
                position: new google.maps.LatLng(locations[i][5], locations[i][6]),
                map: map,
                title: locations[i][0],
                desc: description,
                tel: telephone,
                email: email,
                web: web
            });
link = '';     }

}
</script>
<style>
    #EsportesCoTeste {
        height:400px;
        width:550px;
    }
    .gm-style-iw * {
        display: block;
        width: 100%;
    }
    .gm-style-iw h4, .gm-style-iw p {
        margin: 0;
        padding: 0;
    }
    .gm-style-iw a {
        color: #4272db;
    }
</style>

<div id='EsportesCoTeste'></div>
                            </article>
                        </div>
                        <div class="col-md-3">
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
