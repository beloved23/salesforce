$('#slimtest1').slimScroll({
    height: '200px'
});

app.controller("CreateUserController", function ($scope, $http) {
    $scope.contr = "Test User Controller";
    $scope.showRegionList = false;
    $scope.showZoneList = false;

    $scope.successNotify = function () {
        GlobalInfoNotification();
    };

    $("#create-form").submit(function (event) {
        return $scope.performValidation();
    });
    //reset all lists to hide
    $scope.hideAllList = function () {
        $scope.showRegionList = false;
        $scope.showZoneList = false;
        $scope.showRodList = false;
        $scope.showStateList = false;
        $scope.showAreaList = false;
        $scope.showZbmList = false;
        $scope.showTerritoryList = false;
    };
    $scope.performValidation = function () {

        //assign elements for easier access

        //auuid elements
        var auuidErrorElement = $('#auuid-error');
        var auuidErrorGroup = $('#auuid-input-group');

        //password elements
        var passwordErrorElement = $('#password-error');
        var passwordErrorGroup = $('#password-input-group');

        //validate auuid contains only numbers
        var isnum = /^\d+$/.test($scope.auuid);
        if (!isnum) {
            auuidErrorGroup.addClass('has-error');
            auuidErrorElement.removeClass('hidden');
            auuidErrorElement.html("Auuid must contain only numbers");
            return false;
        }

        //validate password matches
        if (angular.isDefined($scope.cpassword) && angular.isDefined($scope.password)) {
            if (!angular.equals($scope.cpassword, $scope.password)) {
                passwordErrorGroup.addClass('has-error');
                passwordErrorElement.removeClass('hidden');
                passwordErrorElement.html("Password do not match");
                return false;
            }
        }
        //validates a profile is selected
        if (!angular.isDefined($scope.selectedProfile)) {
            GlobalValidationAlert('Accout Profile Validation', 'Please a role');
            return false;
        }
        //perform validations based on selected profile e.g ROD, ZBM, ASM, MD
        if (angular.isDefined($scope.selectedProfile)) {
            //validate ROD profile
            if ($scope.selectedProfile == "ROD") {
                if (!angular.isDefined($scope.selectedRegion)) {
                    GlobalValidationAlert('Account Profile Validation', 'Please select a region.');
                    return false;
                }
            }
            //validate ZBM profile
            else if ($scope.selectedProfile == "ZBM") {
                if (!angular.isDefined($scope.selectedZone)) {
                    GlobalValidationAlert('Account Profile Validation', 'Please select a zone.');
                    return false;
                }
            }
            //validate ASM profile
            else if ($scope.selectedProfile == "ASM") {
                if (!angular.isDefined($scope.selectedArea)) {
                    GlobalValidationAlert('Account Profile Validation', 'Please select aan area.');
                    return false;
                }
            }
            //validate MD profile
            else if ($scope.selectedProfile == "MD") {
                if (!angular.isDefined($scope.selectedTerritory)) {
                    GlobalValidationAlert('Account Profile Validation', 'Please select a territory.');
                    return false;
                }
            }
        }
        return true;
    };

    $scope.auuidKeyUp = function (event) {
        //assign elements for easier access
        var auuidErrorElement = $('#auuid-error');
        var auuidErrorGroup = $('#auuid-input-group');
        //validate auuid contains only numbers
        var isnum = /^\d+$/.test($scope.auuid);
        if (!isnum) {
            auuidErrorGroup.addClass('has-error');
            auuidErrorElement.removeClass('hidden');
            auuidErrorElement.html("Auuid must contain only numbers");
        } else {
            auuidErrorGroup.removeClass('has-error');
            auuidErrorElement.addClass('hidden');
        }
    };

    $scope.passwordKeyUp = function (event) {
        //assign elements for easier access
        var passwordErrorElement = $('#password-error');
        var passwordErrorGroup = $('#password-input-group');
        if (angular.isDefined($scope.cpassword) && angular.isDefined($scope.password)) {
            if (!angular.equals($scope.cpassword, $scope.password)) {
                passwordErrorGroup.addClass('has-error');
                passwordErrorElement.removeClass('hidden');
                passwordErrorElement.html("Password do not match");
            } else {
                passwordErrorGroup.removeClass('has-error');
                passwordErrorElement.addClass('hidden');
            }
        }
    };
    //Define retieve vancant locations
    $scope.retrieveVacantLocations = function () {
        ShowGlobalLoader();
        $http.get(app_url + "vacancies/location?role=" + $scope.selectedProfile).success(function (data) {
            if (data.length > 0) {
                if ($scope.selectedProfile == "ROD") {
                    $scope.regionList = data;
                    $scope.showRegionList = true;
                } else if ($scope.selectedProfile == "ZBM") {
                    $scope.zoneList = data;
                    $scope.showZoneList = true;
                } else if ($scope.selectedProfile == "ASM") {
                    $scope.areaList = data;
                    $scope.showAreaList = true;
                } else {
                    $scope.territoryList = data;
                    $scope.showTerritoryList = true;
                }

            } else {
                GlobalWarningNotification('No vacant location for selected role. Please select another role');
            }
            HideGlobalLoader();
        }).error(function (error) {
            HideGlobalLoader();
            GlobalErrorNotification('An error occured while retrieving Region list. Please try again');
        });
    };
    $scope.changeProfile = function () {
        if (angular.isDefined($scope.selectedProfile)) {
            $scope.hideAllList();
            if ($scope.selectedProfile != 'HR' && $scope.selectedProfile != "HQ" &&
                $scope.selectedProfile != "GeoMarketing" && $scope.selectedProfile != "InformationTechnology") {
                $scope.retrieveVacantLocations();
            }
        }
    };
});