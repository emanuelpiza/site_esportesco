<!DOCTYPE html>
<html>
    <head>
        <title>Mapa EsportesCo</title>
        <link rel="stylesheet" href="js/snazzy/snazzy-info-window.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyClckjszY9yT3lWsGx-9lsK9nU0UmTc5JQ"></script>
        <script src="js/snazzy/snazzy-info-window.min.js"></script>
        <script>
        $(function() {
            var center = { lat: -22.5, lng: -46.9 };
            var map = new google.maps.Map($('.map-canvas')[0], {
                zoom: 8,
                center: center
            });

            var offsetCenter = function(dx, dy) {
                return { lat: center.lat + dx, lng: center.lng + dy };
            };
            var dx = 0.3;
            var positions = [
                //{ type: '<a href="http://www.esportes.co/times/liga.php?id=2" style="text-decoration: none; color:black;"><img src="http://www.esportes.co/cadastro/uploads/0.png" style="width:80px;"></a>', LatLng: offsetCenter(-0.078, -0.0165) },
                { type: '<a href="http://www.esportes.co/times/copa.php?id=1" style="text-decoration: none; color:black;"><img src="http://www.esportes.co/cadastro/uploads/benteler.jpeg" style="width:80px;"></a>', LatLng: { lat: -23.004614, lng: -47.116369} },//Benteler
                { type: '<a href="http://www.esportes.co/times/copa.php?id=17" style="text-decoration: none; color:black;"><img src="http://www.esportes.co/cadastro/uploads/LBF 150X150.png" style="width:80px;"></a>', LatLng: { lat:-22.959844, lng:-46.544389} },
                { type: '<img src="http://www.esportes.co/cadastro/uploads/LMRFS.jpeg" style="width:80px;"><br><a href="http://www.esportes.co/times/copa.php?id=24" style="text-decoration: none; color:black;">Feminino<br></a><a href="http://www.esportes.co/times/copa.php?id=23" style="text-decoration: none; color:black;">Masculino</a>', LatLng: { lat:-22.4179005, lng:-47.5660947} }

                //,{ type: '<a href="http://www.esportes.co/times/copa.php?id=16" style="text-decoration: none; color:black;"><img src="http://www.esportes.co/cadastro/uploads/liredep.png" style="width:80px;"></a>', LatLng: {lat:-22.9174848, lng:-47.0667094} }
            ];

            $.each(positions, function(i, e) {
                var marker = new google.maps.Marker({
                    map: map,
                    draggable: true,
                    position: e.LatLng
                });
                var info = new SnazzyInfoWindow($.extend({}, {
                    marker: marker,
                    position: e.type,
                    content: e.type,
                    panOnOpen: false
                }));
                info.open();
            });
        });
        </script>
        <style>
            /* Styles that make the map full-screen */
            html, body {
                height: 100%;
                margin: 0;
            }

            .map-canvas {
                height: 100%;
            }
        </style>
         <?php 
        include_once("./head.html");
        ?>
    </head>
    <body>
        <?php 
        include_once("./admin/analyticstracking.php");
        ?>
        <div class="map-canvas">
        </div>
    </body>
</html>
