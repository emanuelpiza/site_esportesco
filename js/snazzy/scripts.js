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
        { type: '<a href="http://www.esportes.co/times/liga.php?id=1" style="text-decoration: none; color:black;"><h1 style="text-align: center; color:#e74c3c;">LCF</h1></a><a href="http://www.esportes.co/times/liga.php?id=3" style="text-decoration: none; color:black;"><h1 style="text-align: center; color:#e74c3c; margin-top:-20px; margin-bottom:0px;">LIREDEP</h1></a>', LatLng: offsetCenter(-0.078, -0.0165) },
        { type: '<a href="http://www.esportes.co/times/liga.php?id=2" style="text-decoration: none; color:black;"><h1 style="text-align: center; color:#e74c3c; margin-bottom:0px;">LPF</h1></a>', LatLng: offsetCenter(0.12, -0.6) }
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
