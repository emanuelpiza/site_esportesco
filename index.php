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
            var center = { lat: -22.83965, lng: -47.05147 };
            var map = new google.maps.Map($('.map-canvas')[0], {
                zoom: 9,
                center: center
            });

            var offsetCenter = function(dx, dy) {
                return { lat: center.lat + dx, lng: center.lng + dy };
            };
            var dx = 0.3;
            var positions = [
                { type: '<a href="http://www.esportes.co/times/liga.php?id=2" style="text-decoration: none; color:black;"><img src="http://www.esportes.co/cadastro/uploads/0.png" style="width:80px;"></a>', LatLng: offsetCenter(-0.078, -0.0165) }
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
