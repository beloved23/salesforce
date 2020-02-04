app.controller('ShowRegionController', function($scope, $http) {
    $scope.showRegionItem = false;
    $scope.regionList = regionList;
    $scope.countryList = countryList;
    $scope.showRegionDetails = function(index) {
        var currentRegion = $scope.regionList[index];
        $scope.regionName = currentRegion.name;
        $scope.regionCode = currentRegion.region_code;
        $scope.selectedCountry = currentRegion.country.id;
        $scope.zones = currentRegion.zones_count;
        $scope.states = currentRegion.states_count;
        if (angular.isDefined(currentRegion.states[0])) {
            $scope.areas = currentRegion.states[0].areas_count;
            $scope.lgas = currentRegion.states[0].lgas_count;
        } else {
            $scope.areas = 0;
            $scope.lgas = 0;
        }
        $('#modify-form').attr('action', 'modify/' + currentRegion.id);
        $scope.showRegionItem = true;
    };
    $scope.deleteRegion = function(index) {
        var currentRegion = $scope.regionList[index];
        var successCallback = function() {
            ShowGlobalLoader();
            $http.delete(app_url + "region/destroy/" + currentRegion.id).success(function(data) {
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
        GlobalConfirmationDialog('Are you sure ?', 'This action will delete the region with code "' + currentRegion.region_code + '" on this application', 'Yes, continue', 'No, cancel', successCallback, null);

    };
});