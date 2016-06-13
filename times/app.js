var app = angular.module("app", []);

app.factory('services', ['$http', function($http) {
    var obj={};
    obj.getPessoas = function() { return $http.get('plays.php'); }
    return obj;
}]);

app.controller("pessoasCtrl", function($scope, services) {
    services.getPessoas().then( function(data) {
        $scope.pessoas = data.data;
    } );
});

app.filter("trustUrl", ['$sce', function ($sce) {
        return function (recordingUrl) {
            return $sce.trustAsResourceUrl(recordingUrl);
        };
    }]);

app.run();