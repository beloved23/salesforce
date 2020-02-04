app.controller('ShowCountryController', function($scope, $http) {
    $scope.showCountryItem = false;
    $scope.countryList = countryList;
    $scope.showCountryDetails = function(index) {
        var currentCountry = $scope.countryList[index];
        $scope.countryName = currentCountry.name;
        $scope.countryCode = currentCountry.country_code;
        $scope.countryId = currentCountry.id;
        $scope.regions = currentCountry.regions_count;
        $scope.zones = currentCountry.zones_count;
        $scope.states = currentCountry.states_count;
        $scope.areas = currentCountry.areas_count;
        $('#modify-form').attr('action', 'modify/' + currentCountry.id);
        $scope.showCountryItem = true;
    };

    $scope.deleteCountry = function(index) {
        var currentCountry = $scope.countryList[index];
        var successCallback = function() {
            ShowGlobalLoader();
            $http.delete(app_url + "country/destroy/" + currentCountry.id).success(function(data) {
                HideGlobalLoader();
                if (data.validations && data.action) {
                    GlobalSuccessNotification(data.message + ". Prepping for a reload. Hang on!");
                    setTimeout(function() {
                        location.reload();
                    }, 3000);
                } else {
                    GlobalWarningNotification('An error occured while processing this request with message: ' + data.message);
                }
            }).error(function(error) {
                HideGlobalLoader();
                GlobalErrorNotification('An error occured while processing this request ');
            });
        };
        GlobalConfirmationDialog('Are you sure ?', 'This action will delete the country with code "' + currentCountry.country_code + '" on this application', 'Yes, continue', 'No, cancel', successCallback, null);
    };
});