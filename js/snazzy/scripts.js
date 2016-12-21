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
        { type: '<a href="http://www.esportes.co/ligas/campinas.php" style="text-decoration: none; color:black;"><h2 style="text-align: center; color:#e74c3c;">Liga<br>Campineira</h2></a>', LatLng: offsetCenter(-0.078, -0.0165) },
        { type: '<a href="http://www.esportes.co/ligas/piracicaba.php" style="text-decoration: none; color:black; margin-bottom:-30px"><h2 style="text-align: center; color:#e74c3c;">Liga<br>Piracicabana</h2></a>', LatLng: offsetCenter(0.12, -0.6) }
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
