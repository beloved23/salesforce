app.controller('LocationMovementController', function ($scope, $http) {
    $scope.showResourceList = false;
    //preview variables
    $scope.uplineFullName = 'Unknown';
    $scope.resourcePicture = app_url + 'storage/avatar.jpg';
    $scope.attester = 'Not Required';
    //location data from backend
    $scope.locationCollection = locationCollection;
    //location model
    $scope.locationModel = '';
    $scope.showLocationList = false;
    $scope.locationList = [];

    $("#create-request").submit(function (event) {
        return $scope.performValidation();
    });

    $scope.getMyZbms = function() {
        ShowGlobalLoader();
        $http.get(app_url + 'retrieve/myZbms').success(function(data) {
            $scope.resourceList = data.data;
            $scope.showResourceListBanner = "Select ZBM Resource";
            HideGlobalLoader();
            $scope.showResourceList = true;
        }).error(function(error) {
            HideGlobalLoader();
            GlobalErrorNotification('An error occured while processing this request. Please try again');
        });
    }; 
    $scope.getMyAsms = function() {
        ShowGlobalLoader();
        $http.get(app_url + 'retrieve/myAsms').success(function(data) {
            $scope.resourceList = data.data;
            $scope.showResourceListBanner = "Select ASM Resource";
            HideGlobalLoader();
            $scope.showResourceList = true;
        }).error(function(error) {
            HideGlobalLoader();
            GlobalErrorNotification('An error occured while processing this request. Please try again');
        });
    };
    $scope.getMyMds = function() {
        ShowGlobalLoader();
        $http.get(app_url + 'retrieve/myMds').success(function(data) {
            $scope.resourceList = data.data;
            $scope.showResourceListBanner = "Select MD Resource";
            HideGlobalLoader();
            $scope.showResourceList = true;
        }).error(function(error) {
            HideGlobalLoader();
            GlobalErrorNotification('An error occured while processing this request. Please try again');
        });
    };
    //Define retieve all zones
    $scope.retrieveVacantLocations = function() {
        ShowGlobalLoader();
        $http.get(app_url + "vacancies/location?role="+$scope.selectedResourceRole).success(function(data) {
           $scope.locationList = data;
           if(data.length<=0){
            GlobalWarningNotification('No vacant location for selected resource role. Please change role and try again');
            $scope.showLocationList = false;
            $scope.showResourceList = false;
           }
           else{
            $scope.showLocationList = true;
            $scope.showResourceList = true;
           }
            HideGlobalLoader();
        }).error(function(error) {
            HideGlobalLoader();
            GlobalErrorNotification('An error occured while retrieving location list. Please try again');
        });
    };

    $scope.performValidation = function () {
            if (!angular.isDefined($scope.selectedResource)) {
                GlobalValidationAlert("Location Movement","Please choose a resource to move");
                return false;
            }
        return true;
    }
    $scope.changeRegion = function () {
        $scope.desiredLocation = $scope.locationCollection[$scope.selectedLocation];
        $scope.locationName = $scope.desiredLocation.name;
        $scope.selectedLocationId = $scope.desiredLocation.id;
        $scope.retrieveCountryByRegion();
        $scope.showResourceList = true;
        if ($scope.selectedLocationId == initialLocationId) {
            if (currentRoleFromMaster == "ROD") {
                GlobalWarningNotification("Please select a region that differs from your current region");
            }
        }
    }
    $scope.changeDesiredLocation = function () {
        $scope.desiredLocation = $scope.locationCollection[$scope.selectedLocation];
        $scope.locationName = $scope.desiredLocation.name;
        $scope.selectedLocationId = $scope.desiredLocation.id;
        $scope.retrieveUplineLocation();
        $scope.showResourceList = true;
        if ($scope.selectedLocationId == initialLocationId) {
            if (currentRoleFromMaster == "ZBM") {
                GlobalWarningNotification("Please select a zone that differs from your current zone");
            }
            else if (currentRoleFromMaster == "ASM") {
                GlobalWarningNotification("Please select an area that differs from your current area");
            }
            else if (currentRoleFromMaster == "MD") {
                GlobalWarningNotification("Please select a territory that differs from your current territory");
            }
        }
    }
    //retrieve country by region id
    $scope.retrieveCountryByRegion = function () {
        $http.get(app_url + '/location/movement/get/country/by/region/' + $scope.desiredLocation.id).success(function (data) {
            $scope.uplineFullName = data.name
        }).error(function (error) {
            GlobalErrorNotification('An error occured while retrieving country. Please try again');
        });
    }
    //retrieve upline location for preview
    $scope.retrieveUplineLocation = function () {
        $http.get(app_url + '/location/movement/get/upline/for/profile/' + $scope.desiredLocation.id).success(function (data) {
            $scope.uplineFullName = data.first_name + ' ' + data.last_name;
            $scope.resourcePicture = app_url + "storage/" + data.profile_picture;
        }).error(function (error) {
            alert(JSON.stringify(error));
            GlobalErrorNotification('An error occured while retrieving information. Please try again');
        });
        if (currentRoleFromMaster == "ASM" || currentRoleFromMaster == "MD") {
            $http.get(app_url + '/location/movement/get/upline/for/profile/' + initialLocationId).success(function (data) {
                $scope.attester = data.first_name + ' ' + data.last_name;
            }).error(function (error) {
                GlobalErrorNotification('An error occured while retrieving attestation information. Please try again');
            });
        }
    }
    //retrieve all downlines associated with currentUserRole
    $scope.changeResourceRole = function() {
        //Check Role of Requester
        if ($scope.currentUserRole == "HR" || $scope.currentUserRole == "HQ") {
            //  if ($scope.selectedResourceRole == "ZBM") {
            //     $scope.retrieveAllZbm();
            //     $scope.destinationRoleList = $scope.destinationListIfResourceIsZbm;
            // }
            // else if ($scope.selectedResourceRole == "ASM") {
            //     $scope.retrieveAllAsm();
            //     $scope.destinationRoleList = $scope.destinationListIfResourceIsAsm;
            // }
            // else if ($scope.selectedResourceRole == "MD") {
            //     $scope.retrieveAllMd();
            //     $scope.destinationRoleList = $scope.destinationListIfResourceIsMd;
            // }
            // write requests for other roles ROD,ZBM,ASM,MD
        } else { //Requester is ROD,ZBM or ASM
            if ($scope.selectedResourceRole == "ZBM") {
                $scope.locationModel = "Zone";
                $scope.getMyZbms();
                // $scope.destinationRoleList = $scope.destinationListIfResourceIsZbm;
            }
            else if ($scope.selectedResourceRole == "ASM") {
                $scope.getMyAsms();
                $scope.locationModel = "Area";
            }
            else if ($scope.selectedResourceRole == "MD") {
                $scope.getMyMds();
                $scope.locationModel = "Territory";
            }
            $scope.retrieveVacantLocations();
        }
       

    };

});