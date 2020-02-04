app.controller('HierachyRelationshipController', function($scope, $http) {
    $scope.selectRod = false;
    $scope.selectZbm = false;
    $scope.selectAsm = false;
    $scope.showRegionList = false;
    $scope.showZoneList = false;
    $scope.showRodList = false;
    $scope.showStateList = false;
    $scope.showAreaList = false;
    $scope.showZbmList = false;
    $scope.areaList = [];
    $scope.regionList = [];
    $scope.zbmList = [];
    $scope.rodList = [];
    $scope.asmList = [];
    $scope.territoryList = [];
    $scope.rodCount = rodCount;
    $scope.zbmCount = zbmCount;
    $scope.asmCount = asmCount;
    $scope.mdCount = mdCount;

    //reset all lists to hide
    $scope.hideAllList = function() {
        $scope.showRegionList = false;
        $scope.showZoneList = false;
        $scope.showRodList = false;
        $scope.showStateList = false;
        $scope.showAreaList = false;
        $scope.showZbmList = false;
    };
    $scope.hideAllList();

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
    //Define retieve all Rods
    $scope.retrieveAllRods = function() {
        ShowGlobalLoader();
        $http.get(app_url + "retrieve/rods").success(function(data) {
            $scope.rodList = data.data;
            $scope.showRodList = true;
            HideGlobalLoader();
        }).error(function(error) {
            HideGlobalLoader();
            GlobalErrorNotification('An error occured while retrieving ROD list. Please try again');
        });
    };

    //Define retieve all Zbms
    $scope.retrieveAllZbms = function() {
        ShowGlobalLoader();
        $http.get(app_url + "retrieve/zbms").success(function(data) {
            $scope.zbmList = data.data;
            $scope.showZbmList = true;
            HideGlobalLoader();
        }).error(function(error) {
            HideGlobalLoader();
            GlobalErrorNotification('An error occured while retrieving ZBM list. Please try again');
        });
    };

    //Define retieve all Asms
    $scope.retrieveAllAsms = function() {
        ShowGlobalLoader();
        $http.get(app_url + "retrieve/asms").success(function(data) {
            $scope.asmList = data.data;
            $scope.showAsmList = true;
            HideGlobalLoader();
        }).error(function(error) {
            HideGlobalLoader();
            GlobalErrorNotification('An error occured while retrieving ASM list. Please try again');
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
    $scope.changeProfile = function() {
        if (angular.isDefined($scope.selectedProfile)) {
            if ($scope.selectedProfile == "ROD") {
                $scope.hideAllList();
                $scope.retrieveAllRegions();
            } else if ($scope.selectedProfile == "ZBM") {
                $scope.hideAllList();
                $scope.retrieveAllZones();
                $scope.retrieveAllRods();
            } else if ($scope.selectedProfile == "ASM") {
                $scope.hideAllList();
                $scope.retrieveAllZbms();
                $scope.retrieveAllStates();
                $scope.retrieveAllAreas();
            } else if ($scope.selectedProfile == "MD") {
                $scope.hideAllList();
                $scope.retrieveAllAsms();
                $scope.retrieveAllTerritories();
            }
        }
    };
    $scope.createRelationship = function() {
        if (angular.isDefined($scope.selectedProfile)) {
            //Create ROD Relationship
            if ($scope.selectedProfile == "ROD") {
                //perform validation
                if (angular.isDefined($scope.selectedUsers) && angular.isDefined($scope.selectedRegion)) {
                    //create Ajax request callback
                    var successCallback = function() {
                        var config = { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } };
                        var data = "action=" + encodeURIComponent($scope.selectedProfile) + "&users=" + JSON.stringify($scope.selectedUsers) + "&regionId=" + encodeURIComponent($scope.selectedRegion);
                        ShowGlobalLoader();
                        $http.put(app_url + "hierachy/update", data, config).success(function(data) {
                            HideGlobalLoader();
                            if (data.action && data.validations) {
                                GlobalSuccessNotification(data.message);
                                $scope.rodCount = data.count;
                            } else if (!data.action) {
                                GlobalWarningNotification("An error occured with message " + data.message);
                            }
                        }).error(function(error) {
                            HideGlobalLoader();
                            GlobalErrorNotification('An error occured while processing this request. Please try again');
                        });
                    };
                    GlobalConfirmationDialog('Are you sure ?', 'Please note that existing relationship will be overwritten', 'Yes, continue', 'No, cancel', successCallback, null);
                } else {
                    GlobalValidationAlert("Input Validation", "Please select atleast a user and a region");
                }
            }
            //Create ASM Relationship
            else if ($scope.selectedProfile == "ZBM") {
                //perform validation
                if (angular.isDefined($scope.selectedUsers) && angular.isDefined($scope.selectedZone)) {
                    //create Ajax request callback
                    var successCallback = function() {
                        var config = { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } };
                        var data = "action=" + encodeURIComponent($scope.selectedProfile) + "&users=" + JSON.stringify($scope.selectedUsers) +
                            "&zoneId=" + encodeURIComponent($scope.selectedZone) + "&selectedRod=" +
                            encodeURIComponent($scope.selectedRod);
                        ShowGlobalLoader();
                        $http.put(app_url + "hierachy/update", data, config).success(function(data) {
                            HideGlobalLoader();
                            if (data.action && data.validations) {
                                GlobalSuccessNotification(data.message);
                                $scope.zbmCount = data.count;
                            } else if (!data.action) {
                                GlobalWarningNotification("An error occured with message " + data.message);
                            }
                        }).error(function(error) {
                            HideGlobalLoader();
                            GlobalErrorNotification('An error occured while processing this request. Please try again');
                        });
                    };
                    GlobalConfirmationDialog('Are you sure ?', 'Please note that existing relationship will be overwritten', 'Yes, continue', 'No, cancel', successCallback, null);
                } else {
                    GlobalValidationAlert("Input Validation", "Please select atleast a user, a zone and a rod");
                }
            }
            //Create ASM Relationship
            else if ($scope.selectedProfile == "ASM") {
                //perform validation
                if (angular.isDefined($scope.selectedUsers) && angular.isDefined($scope.selectedState) && angular.isDefined($scope.selectedArea) && angular.isDefined($scope.selectedZbm)) {
                    //create Ajax request callback
                    var successCallback = function() {
                        var config = { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } };
                        var data = "action=" + encodeURIComponent($scope.selectedProfile) + "&users=" + JSON.stringify($scope.selectedUsers) +
                            "&stateId=" + encodeURIComponent($scope.selectedState) + "&selectedZbm=" + encodeURIComponent($scope.selectedZbm) + "&areaId=" + encodeURIComponent($scope.selectedArea);
                        ShowGlobalLoader();
                        $http.put(app_url + "hierachy/update", data, config).success(function(data) {
                            HideGlobalLoader();
                            if (data.action && data.validations) {
                                GlobalSuccessNotification(data.message);
                                $scope.asmCount = data.count;
                            } else if (!data.action) {
                                GlobalWarningNotification("An error occured with message " + data.message);
                            }
                        }).error(function(error) {
                            HideGlobalLoader();
                            GlobalErrorNotification('An error occured while processing this request. Please try again');
                        });
                    };
                    GlobalConfirmationDialog('Are you sure ?', 'Please note that existing relationship will be overwritten', 'Yes, continue', 'No, cancel', successCallback, null);
                } else {
                    GlobalValidationAlert("Input Validation", "Please select atleast a user, a state, an area and a Zbm ");
                }
            }
            //Create MD Relationship
            else if ($scope.selectedProfile == "MD") {
                //perform validation
                if (angular.isDefined($scope.selectedUsers) && angular.isDefined($scope.selectedTerritory) && angular.isDefined($scope.selectedAsm)) {
                    //create Ajax request callback
                    var successCallback = function() {
                        var config = { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } };
                        var data = "action=" + encodeURIComponent($scope.selectedProfile) + "&users=" + JSON.stringify($scope.selectedUsers) +
                            "&selectedAsm=" + encodeURIComponent($scope.selectedAsm) + "&selectedTerritory=" + encodeURIComponent($scope.selectedTerritory);
                        ShowGlobalLoader();
                        $http.put(app_url + "hierachy/update", data, config).success(function(data) {
                            HideGlobalLoader();
                            if (data.action && data.validations) {
                                GlobalSuccessNotification(data.message);
                                $scope.mdCount = data.count;
                            } else if (!data.action) {
                                GlobalWarningNotification("An error occured with message " + data.message);
                            }
                        }).error(function(error) {
                            HideGlobalLoader();
                            GlobalErrorNotification('An error occured while processing this request. Please try again');
                        });
                    };
                    GlobalConfirmationDialog('Are you sure ?', 'Please note that existing relationship will be overwritten', 'Yes, continue', 'No, cancel', successCallback, null);
                } else {
                    GlobalValidationAlert("Input Validation", "Please select atleast a user, a territory, and an Asm ");
                }
            }
            //handle other relationship
            else {

            }
        } else {
            GlobalValidationAlert("Input Validation", "Please select a profile");
        }
    };
});