app.controller('SentController', function($scope, $http) {

    $scope.starMessage = function(id) {
        $('#starred' + id).removeClass('fa-star-o').addClass('fa-star').addClass('text-warning');
    }

});