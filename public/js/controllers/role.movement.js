app.controller('RoleMovementController', function($scope, $http) {
    $scope.showResourceList = false;
    $scope.resourceList = [];
    $scope.showResourceListBanner = "";
    $scope.appUrl = app_url;
    $scope.destinationListIfResourceIsZbm = [{ "name": "ROD" }];
    $scope.destinationListIfResourceIsAsm = [{ "name": "ROD" }, { "name": "ZBM" }];
    $scope.destinationListIfResourceIsMd = [{ "name": "ROD" }, { "name": "ZBM" }, { "name": "ASM" }];
    $scope.currentUserRole = currentRoleFromMaster;

    //preview variables
    $scope.resourceFullName = 'Name: Unknown';
    $scope.resourcePicture = app_url + 'storage/avatar.jpg';
    $scope.attester = 'Not Required';

 //Define retrieve all Rods
 $scope.retrieveAllZbm = function() {
    ShowGlobalLoader();
    $http.get(app_url + "retrieve/zbms").success(function(data) {
        $scope.resourceList = data.data;
        $scope.showResourceList = true;
        $scope.showResourceListBanner = "Select ZBM Resource";        
        HideGlobalLoader();
    }).error(function(error) {
        HideGlobalLoader();
        GlobalErrorNotification('An error occured while retrieving ZBM list. Please try again');
    });
};
 //Define retrieve all Asm
 $scope.retrieveAllAsm = function() {
    ShowGlobalLoader();
    $http.get(app_url + "retrieve/asms").success(function(data) {
        $scope.resourceList = data.data;
        $scope.showResourceList = true;
        $scope.showResourceListBanner = "Select ASM Resource";        
        HideGlobalLoader();
    }).error(function(error) {
        HideGlobalLoader();
        GlobalErrorNotification('An error occured while retrieving ASM list. Please try again');
    });
};
 //Define retrieve all Md
 $scope.retrieveAllMd = function() {
    ShowGlobalLoader();
    $http.get(app_url + "retrieve/mds").success(function(data) {
        $scope.resourceList = data.data;
        $scope.showResourceList = true;
        $scope.showResourceListBanner = "Select MD Resource";        
        HideGlobalLoader();
    }).error(function(error) {
        HideGlobalLoader();
        GlobalErrorNotification('An error occured while retrieving MD list. Please try again');
    });
};
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
    $scope.getAttester = function(){
            $http.get(app_url + 'role/movement/get/attester/' + $scope.resourceList[$scope.selectedResourceIndex].user.id).success(function (data) {
              if(data.length>0){
                $scope.attester = data[0].userprofile.first_name + ' ' + data[0].userprofile.last_name;
              }
              else{
                  $scope.attester = 'N/A';
                  GlobalWarningNotification('Selected Resource does not have a ZBM');
              }
            }).error(function (error) {
                GlobalErrorNotification('An error occured while retrieving attestation information. Please try again');
            });
    };
    $scope.changeResourceRole = function() {
        //Check Role of Requester
        if ($scope.currentUserRole == "HR" || $scope.currentUserRole == "HQ") {
             if ($scope.selectedResourceRole == "ZBM") {
                $scope.retrieveAllZbm();
                $scope.destinationRoleList = $scope.destinationListIfResourceIsZbm;
            }
            else if ($scope.selectedResourceRole == "ASM") {
                $scope.retrieveAllAsm();
                $scope.destinationRoleList = $scope.destinationListIfResourceIsAsm;
            }
            else if ($scope.selectedResourceRole == "MD") {
                $scope.retrieveAllMd();
                $scope.destinationRoleList = $scope.destinationListIfResourceIsMd;
            }
            //write requests for other roles ROD,ZBM,ASM,MD
        } else { //Requester is ROD,ZBM or ASM
            if ($scope.selectedResourceRole == "ZBM") {
                $scope.getMyZbms();
                $scope.destinationRoleList = $scope.destinationListIfResourceIsZbm;
            }
            else if ($scope.selectedResourceRole == "ASM") {
                $scope.getMyAsms();
                $scope.destinationRoleList = $scope.destinationListIfResourceIsAsm;
            }
            else if ($scope.selectedResourceRole == "MD") {
                $scope.getMyMds();
                $scope.destinationRoleList = $scope.destinationListIfResourceIsMd;
            }
        }
       

    };
    $scope.onChangeDestinationRole = function(){
        ShowGlobalLoader();
        $http.get(app_url + 'vacancies/location?role='+$scope.destinationRole).success(function(data) {
            $scope.vacantLocationList = data;
            var location = "";
            if($scope.destinationRole=="ROD"){
                $scope.destinationLocationTitle = "Select desired Region";
                location = "Region";
            }
            else if($scope.destinationRole=="ZBM"){
                $scope.destinationLocationTitle = "Select desired  Zone";
                location = "Zone";
            }
            else if($scope.destinationRole=="ASM"){
                $scope.destinationLocationTitle = "Select desired Area";
                location = "Area";
            }
            else if($scope.destinationRole=="MD"){
                $scope.destinationLocationTitle = "Select desired Territory";
                location  = "Territory";
            }
            if(data.length<=0)
            {
                GlobalErrorNotification('No vacant '+location+'. Please try again');
                $scope.showResourceList = false;
                $scope.showDestinationLocationProfile = false;
            }
            else{
                $scope.showDestinationLocationProfile = true;
            }
            HideGlobalLoader();
           
          
        }).error(function(error) {
            HideGlobalLoader();
            GlobalErrorNotification('An error occured while processing this request. Please try again');
        });
    };
    $scope.onChangeResource = function() {
        var selectedResourceData = $scope.resourceList[$scope.selectedResourceIndex];
        if (selectedResourceData.userprofile != null) {
            $scope.resourceFullName = selectedResourceData.userprofile.first_name + ' ' + selectedResourceData.userprofile.last_name
            $scope.resourcePicture = app_url + 'storage/' + selectedResourceData.userprofile.profile_picture;
        }
        if($scope.selectedResourceRole=="ASM" || $scope.selectedResourceRole=="MD"){
            $scope.getAttester();
        }
    };

    $scope.sendRequestToServer = function() {
        //perform validation
        //validation all required values are defined
        if (angular.isDefined($scope.selectedResourceRole) && angular.isDefined($scope.selectedResourceIndex) && angular.isDefined($scope.destinationRole)) {
            //validate destination is selected
            if(angular.isDefined($scope.destinationLocation)){
                //assign data for resource to a varible
                var selectedResourceData = $scope.resourceList[$scope.selectedResourceIndex];
                var successCallback = function() {
                    ShowGlobalLoader();

                    var data = "resourceAuuid=" + encodeURIComponent(selectedResourceData.user.id) + "&resourceRoleName=" + encodeURIComponent($scope.selectedResourceRole) +
                        "&requestedRoleName=" + encodeURIComponent($scope.destinationRole) +"&destinationLocation="+encodeURIComponent($scope.destinationLocation);
                    var config = { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } };
                    $http.post(app_url + "role/movement/store", data, config).success(function(data) {
                        HideGlobalLoader();
                        if (data.validations && data.action) {
                            $scope.showResourceList = false;
                            $scope.showDestinationLocationProfile = false;
                            GlobalSuccessNotification(data.message);
                        } else {
                            GlobalWarningNotification('An error occured with message: ' + data.message);
                        }
                    }).error(function(error) {
                        HideGlobalLoader();
                       alert(JSON.stringify(error));
                        GlobalErrorNotification('An error occured while processing this request. Please try again');
                    });
                };
                //place confirmation dialog below
                GlobalConfirmationDialog('Are you sure ?', 'This is a role movement request for resource ' + selectedResourceData.auuid + ' from ' + $scope.selectedResourceRole + ' to ' +
                    $scope.destinationRole, 'Yes, continue', 'No, cancel', successCallback, null);
            }
            else{
                GlobalValidationAlert("Input Validation", "Please select a destination location for resource");
            }
        } else {
            GlobalValidationAlert("Input Validation", "Please provide resource, resource role, comment and destination role");
        }

    };
});