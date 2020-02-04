$('.location-highlight').addClass('active');
app.controller('LocationController', function($scope, $http) {
    $scope.countryCount = countryCount;
    $scope.regionCount = regionCount;
    $scope.zoneCount = zoneCount;
    $scope.stateCount = stateCount;
    $scope.areaCount = areaCount;
    $scope.lgaCount = lgaCount;
    $scope.territoryCount = territoryCount;

    $scope.countryTimestamp = countryTimestamp;
    $scope.regionTimestamp = regionTimestamp;
    $scope.zoneTimestamp = zoneTimestamp;
    $scope.stateTimestamp = stateTimestamp;
    $scope.areaTimestamp = areaTimestamp;
    $scope.lgaTimestamp = lgaTimestamp;
    $scope.territoryTimestamp = territoryTimestamp;

    $scope.selectedGeographyName = "Country";

    //declare variables to hold data for list
    $scope.countryList = [];
    $scope.regionList = [];
    $scope.zoneList = [];
    $scope.stateList = [];
    $scope.areaList = [];
    $scope.lgaList = [];
    $scope.lgaList = [];
    $scope.territoryList = [];




    //reset all lists to hide
    $scope.hideAllList = function() {
        $scope.showCountryList = false;
        $scope.showRegionList = false;
        $scope.showZoneList = false;
        $scope.showStateList = false;
        $scope.showAreaList = false;
        $scope.showLgaList = false;
        $scope.showTerritoryList = false;
    };

    //hide all list
    $scope.hideAllList();

    //Define retieve all countries
    $scope.retrieveAllCountries = function() {
        ShowGlobalLoader();
        $http.get(app_url + "api/retrieve/countries").success(function(data) {
            $scope.countryList = data.data;
            $scope.showCountryList = true;
            HideGlobalLoader();
        }).error(function(error) {
            HideGlobalLoader();
            GlobalErrorNotification('An error occured while retrieving Country list. Please try again');
        });
    };
    //Define retieve all regions
    $scope.retrieveAllRegions = function() {
        ShowGlobalLoader();
        $http.get(app_url + "api/retrieve/regions").success(function(data) {
            $scope.regionList = data.data;
            $scope.showRegionList = true;
            HideGlobalLoader();
        }).error(function(error) {
            HideGlobalLoader();
            GlobalErrorNotification('An error occured while retrieving Region list. Please try again');
        });
    };
    //Define retieve all zones
    $scope.retrieveAllZones = function() {
        ShowGlobalLoader();
        $http.get(app_url + "api/retrieve/zones").success(function(data) {
            $scope.zoneList = data.data;
            $scope.showZoneList = true;
            HideGlobalLoader();
        }).error(function(error) {
            HideGlobalLoader();
            GlobalErrorNotification('An error occured while retrieving Zone list. Please try again');
        });
    };
    //Define retieve all states
    $scope.retrieveAllStates = function() {
        ShowGlobalLoader();
        $http.get(app_url + "api/retrieve/states").success(function(data) {
            $scope.stateList = data.data;
            $scope.showStateList = true;
            HideGlobalLoader();
        }).error(function(error) {
            HideGlobalLoader();
            GlobalErrorNotification('An error occured while retrieving State list. Please try again');
        });
    };
    //Define retieve all areas
    $scope.retrieveAllAreas = function() {
        ShowGlobalLoader();
        $http.get(app_url + "api/retrieve/areas").success(function(data) {
            $scope.areaList = data.data;
            $scope.showAreaList = true;
            HideGlobalLoader();
        }).error(function(error) {
            HideGlobalLoader();
            GlobalErrorNotification('An error occured while retrieving Area list. Please try again');
        });
    };
    //Define retieve all lga
    $scope.retrieveAllLga = function() {
        ShowGlobalLoader();
        $http.get(app_url + "api/retrieve/lgas").success(function(data) {
            $scope.lgaList = data.data;
            $scope.showLgaList = true;
            HideGlobalLoader();
        }).error(function(error) {
            HideGlobalLoader();
            GlobalErrorNotification('An error occured while retrieving Lga list. Please try again');
        });
    };

    //Define retieve all territories
    $scope.retrieveAllTerritories = function() {
        ShowGlobalLoader();
        $http.get(app_url + "api/retrieve/territories").success(function(data) {
            $scope.territoryList = data.data;
            $scope.showTerritoryList = true;
            HideGlobalLoader();
        }).error(function(error) {
            HideGlobalLoader();
            GlobalErrorNotification('An error occured while retrieving Country list. Please try again');
        });
    };


    //Define on Geography changed function 
    $scope.selectGeography = function() {
        if (angular.isDefined($scope.selectedGeography)) {
            //hide all list for country selection
            if ($scope.selectedGeography == "CO") {
                $scope.hideAllList();
                $scope.selectedGeographyName = "Country";
            } else if ($scope.selectedGeography == "RE") {
                $scope.hideAllList();
                $scope.retrieveAllCountries();
                $scope.selectedGeographyName = "Region";
            } else if ($scope.selectedGeography == "ZO") {
                $scope.hideAllList();
                $scope.retrieveAllRegions();
                $scope.selectedGeographyName = "Zone";
            } else if ($scope.selectedGeography == "ST") {
                $scope.hideAllList();
                $scope.retrieveAllZones();
                $scope.selectedGeographyName = "State";
            } else if ($scope.selectedGeography == "AR") {
                $scope.hideAllList();
                $scope.retrieveAllStates();
                $scope.selectedGeographyName = "Area";
            } else if ($scope.selectedGeography == "LG") {
                $scope.hideAllList();
                $scope.retrieveAllAreas();
                $scope.selectedGeographyName = "LGA";
            } else if ($scope.selectedGeography == "TE") {
                $scope.hideAllList();
                $scope.retrieveAllLga();
                $scope.selectedGeographyName = "Territory";
            } else if ($scope.selectedGeography == "SI") {
                $scope.hideAllList();
                $scope.retrieveAllTerritories();
                $scope.selectedGeographyName = "Site";
            }
        }
    };

    //Define LocationItem Submit
    $scope.saveLocationItem = function() {
        if (angular.isDefined($scope.selectedGeography)) {
            if ($scope.selectedGeography == "CO") {
                // validations for country
                if (angular.isDefined($scope.locationName) && angular.isDefined($scope.locationCode)) {
                    if ($scope.locationName.trim().length > 0 && $scope.locationCode.trim().length > 0) {
                        ShowGlobalLoader();
                        //save country to db
                        var data = "action=" + encodeURIComponent($scope.selectedGeography) + "&name=" + encodeURIComponent($scope.locationName) + "&code=" + $scope.locationCode;
                        var config = { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } };
                        $http.post(app_url + "location/save", data, config).success(function(data) {
                            HideGlobalLoader();
                            if (data.action && data.validations) {
                                GlobalSuccessNotification(data.message);
                                $scope.countryCount = data.count;
                                $scope.locationCode = "";
                                $scope.locationName = "";
                            } else {
                                GlobalErrorNotification('An error occured while processing this request with message: ' + data.message);
                            }
                        }).error(function(error) {
                            HideGlobalLoader();
                            alert(JSON.stringify(error));
                            GlobalErrorNotification('An error occured while processing this request. Please try again');
                        });
                    } else {
                        GlobalValidationAlert("Input Validation", "Please provide country name and country code");
                    }
                } else {
                    GlobalValidationAlert("Input Validation", "Please provide country name and country code");
                }
            } else if ($scope.selectedGeography == "RE") {
                //save to region db
                $scope.saveLocationToDb($scope.selectedCountry, "country", "countryId", "region");
            } else if ($scope.selectedGeography == "ZO") {
                //save to zone db
                $scope.saveLocationToDb($scope.selectedRegion, "region", "regionId", "zone");
            } else if ($scope.selectedGeography == "ST") {
                //save to state db
                $scope.saveLocationToDb($scope.selectedZone, "zone", "zoneId", "state");
            } else if ($scope.selectedGeography == "AR") {
                //save to area db
                $scope.saveLocationToDb($scope.selectedState, "state", "stateId", "area");
            } else if ($scope.selectedGeography == "LG") {
                //save to lga db
                $scope.saveLocationToDb($scope.selectedArea, "area", "areaId", "lga");
            } else if ($scope.selectedGeography == "TE") {
                //save to territory db
                $scope.saveLocationToDb($scope.selectedLga, "lga", "lgaId", "territory");
            }
        } else {
            GlobalValidationAlert("Input Validation", "Please select a location type");
        }
    };
    //End Location submit function

    //Begin SaveLocation Helper Function
    $scope.saveLocationToDb = function(parentId, parentName, queryName, currentLocationName) {
        if (angular.isDefined($scope.locationName) && angular.isDefined($scope.locationCode) && angular.isDefined(parentId)) {
            if ($scope.locationName.trim().length > 0 && $scope.locationCode.trim().length > 0 && parentId.trim().length > 0) {
                ShowGlobalLoader();
                //save zone to db
                var data = "action=" + encodeURIComponent($scope.selectedGeography) + "&name=" + encodeURIComponent($scope.locationCode) +
                    "&code=" + encodeURIComponent($scope.locationName) + "&" + queryName + "=" + parentId;
                var config = { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } };
                $http.post(app_url + "location/save", data, config).success(function(data) {
                    HideGlobalLoader();
                    if (data.action && data.validations) {
                        GlobalSuccessNotification(data.message);
                        $scope.locationCode = "";
                        $scope.locationName = "";
                        if (currentLocationName == "region") {
                            $scope.regionCount = data.count;
                        } else if (currentLocationName == "zone") {
                            $scope.zoneCount = data.count;
                        } else if (currentLocationName == "state") {
                            $scope.stateCount = data.count;
                        } else if (currentLocationName == "lga") {
                            $scope.lgaCount = data.count;
                        } else {
                            $scope.territoryCount = data.count;
                        }
                    } else {
                        GlobalErrorNotification('An error occured while processing this request with message: ' + data.message);
                    }
                }).error(function(error) {
                    HideGlobalLoader();
                    GlobalErrorNotification('An error occured while processing this request. Please try again');
                });
            } else {
                GlobalValidationAlert("Input Validation", "Please provide " + currentLocationName + " name, " + currentLocationName + " code and a " + parentName + " id");
            }
        } else {
            GlobalValidationAlert("Input Validation", "Please provide " + currentLocationName + " name, " + currentLocationName + " code and a " + parentName + " id");
        }
    };
    //End SaveLocatio Helper function

    // Save Site to Db
    $scope.saveSite = function() {
        if (angular.isDefined($scope.siteId) && angular.isDefined($scope.siteAddress) &&
            angular.isDefined($scope.townName) && angular.isDefined($scope.siteCode) &&
            angular.isDefined($scope.selectedTerritory) && angular.isDefined($scope.siteClassCode) &&
            angular.isDefined($scope.siteLongitude) && angular.isDefined($scope.siteLatitude)) {
            if ($scope.siteId.trim().length > 0 && $scope.siteAddress.trim().length > 0 && $scope.townName.trim().length > 0 && $scope.siteClassCode.trim().length > 0 && $scope.siteCode.length > 0) {
                ShowGlobalLoader();
                //Save site to Db
                var data = "action=SI&siteId=" + encodeURIComponent($scope.siteId) +
                    "&siteAddress=" + encodeURIComponent($scope.siteAddress) + "&townName=" + encodeURIComponent($scope.townName) + "&siteCode=" + encodeURIComponent($scope.siteCode) +
                    "&siteTerritory=" + $scope.selectedTerritory + "&siteClassCode=" + encodeURIComponent($scope.siteClassCode) + "&siteLongitude=" + $scope.siteLongitude +
                    "&siteLatitude=" + $scope.siteLatitude;
                var config = { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } };
                $http.post(app_url + "location/save", data, config).success(function(data) {
                    HideGlobalLoader();
                    if (data.action && data.validations) {
                        GlobalSuccessNotification(data.message);
                        $scope.locationCode = "";
                        $scope.locationName = "";
                        $scope.siteCount = data.count;
                    } else {
                        GlobalWarningNotification('An error occured while processing this request with message: ' + data.message);
                    }
                }).error(function(error) {
                    HideGlobalLoader();
                    GlobalErrorNotification('An error occured while processing this request. Please try again');
                });
            } else {
                GlobalValidationAlert("Input Validation", "Please provide Territory, Site Id, Site code, Town name, Site class code , Latitude, Longitude and Site address");
            }
        } else {
            GlobalValidationAlert("Input Validation", "Please provide Territory, Site Id, Site code, Town name, Site class code , Latitude, Longitude and Site address");
        }
    };

    $scope.editRegionItem = function(index) {
        $('#edit-region').click();
    };
});