<!DOCTYPE html>
<html>
    <head>
        <title>Mapa EsportesCo</title>
        <link rel="stylesheet" href="js/snazzy/snazzy-info-window.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyClckjszY9yT3lWsGx-9lsK9nU0UmTc5JQ"></script>
        <script src="js/snazzy/snazzy-info-window.min.js"></script>
        <script src="js/snazzy/scripts.js"></script>
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
        include_once("./navbar.html");
        ?>
        <div class="map-canvas">
        </div>
    </body>
</html>
