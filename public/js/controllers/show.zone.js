app.controller('ShowZoneController', function($scope, $http) {
    $scope.showZoneItem = false;
    $scope.zoneList = zoneList;
    $scope.countryList = countryList;
    $scope.regionList = regionList;
    $scope.showZoneDetails = function(index) {
        var currentZone = $scope.zoneList[index];
        $scope.zoneName = currentZone.name;
        $scope.zoneCode = currentZone.zone_code;
        $scope.selectedCountry = currentZone.region.country.id;
        $scope.selectedRegion = currentZone.region.id;
        $scope.states = currentZone.states_count;
        $scope.areas = currentZone.areas_count;
        if (angular.isDefined(currentZone.areas[0])) {
            $scope.lgas = currentZone.areas[0].lgas_count;
            $scope.territories = currentZone.areas[0].territories_count;
        } else {
            $scope.lgas = 0;
            $scope.territories = 0;
        }
        $('#modify-form').attr('action', 'modify/' + currentZone.id);
        $scope.showZoneItem = true;
    };
    $scope.deleteZone = function(index) {
        var currentZone = $scope.zoneList[index];
        var successCallback = function() {
            ShowGlobalLoader();
            $http.delete(app_url + "zone/destroy/" + currentZone.id).success(function(data) {
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
                alert(JSON.stringify(error));
            });
        };
        GlobalConfirmationDialog('Are you sure ?', 'This action will delete the zone with code "' + currentZone.zone_code + '" on this application', 'Yes, continue', 'No, cancel', successCallback, null);

    };
});