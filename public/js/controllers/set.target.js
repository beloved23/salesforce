app.controller('SetTargetController', function ($scope, $http) {
    $scope.targets = targets;
    $scope.downlineList = [];
    $scope.showAssignTarget = false;
    $scope.showAssignTargetButton = false;
    $scope.currentTargetTag = "Tag: ";
    var el = document.querySelector('#js-switch');
    var abc = document.querySelector('#assignToAll');
    var options = {
        size: 'default',
        checked: false,
        onText: 'Y',
        offText: 'N',
        onSwitchColor: '#64BD63',
        offSwitchColor: '#fff',
        onJackColor: '#fff',
        offJackColor: '#fff',
        showText: false,
        disabled: false,
        onInit: function () { },
        beforeChange: function () { },
        onChange: function () {

        },
        beforeRemove: function () { },
        onRemove: function () { },
        beforeDestroy: function () { },
        onDestroy: function () { }
    };
    $scope.assignToMeSwitch = new Switch(el, options);
    $scope.assignToAllDownlines = new Switch(abc, options);

    $scope.currentTargetToModify = function (index) {
        var target = $scope.targets[index];
        $scope.modifiedIndex = index;
        $scope.modifiedTargetId = target.id;
        $scope.modifyTag = target.tag;
        $scope.modifyDecrement = target.decrement;
        $scope.modifyGrossAds = target.gross_ads
        $scope.modifyKit = target.kit;
    }
    $scope.modifyTarget = function () {
        if ($scope.modifyTag.trim().length > 0 && $scope.modifyDecrement.trim().length > 0 &&
            $scope.modifyGrossAds.trim().length > 0 && $scope.modifyKit.trim().length > 0) {
            if ($scope.isNumber($scope.modifyDecrement) && $scope.isNumber($scope.modifyGrossAds) && $scope.isNumber($scope.modifyKit)) {
                var successCallback = function () {
                    ShowGlobalLoader();
                    var config = { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } };
                    var data = "id=" + $scope.modifiedTargetId + "&tag=" + encodeURIComponent($scope.modifyTag) + "&decrement=" + encodeURIComponent($scope.modifyDecrement) +
                        "&grossAds=" + encodeURIComponent($scope.modifyGrossAds) + "&kit=" + encodeURIComponent($scope.modifyKit);
                    $http.put(app_url + "targets/update", data, config).success(function (data) {
                        HideGlobalLoader();
                        if (data.action) {
                            GlobalSuccessNotification(data.message);
                            $scope.targets[$scope.modifiedIndex] = data.target;
                        } else {
                            GlobalErrorNotification('An error occured while processing this request with message ' + data.message);
                        }
                    }).error(function (error) {
                        HideGlobalLoader();
                        GlobalErrorNotification('An error occured while processing this request . Please try again');
                    });
                };
                GlobalConfirmationDialog('Are you sure ?', 'The target details will be updated with the provided information', 'Yes, continue', 'No, cancel', successCallback, null);
            } else {
                GlobalValidationAlert("Input Validation", "Decrement, Gross ads and Kit fields require only numbers");
            }
        } else {
            GlobalValidationAlert("Input Validation", "Please provide a tag, decrement, gross ads and kit");
        }
    };

    $scope.retrieveDownlines = function (index) {
        ShowGlobalLoader();
        $http.get(app_url + 'retrieve/downlines').success(function (data) {
            HideGlobalLoader();
                $scope.downlineList = data.downlines; 
                $scope.role = data.role;
                $scope.indexToAssign = index;
                $scope.currentTargetTag = $scope.targets[index].tag;
                $scope.showAssignTarget = true;
                $scope.showAssignTargetButton = true;
        }).error(function (error) {
            HideGlobalLoader();
            GlobalErrorNotification('An error occured while processing this request . Please try again');
        });
    };


    $scope.isNumber = function (value) {
        return /^\d+$/.test(value);
    };

    $scope.assignTarget = function () {
        if (angular.isDefined($scope.indexToAssign)) {
            var successCallback = function () {
                ShowGlobalLoader();
                var config = { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } };
                var data = "id=" + $scope.targets[$scope.indexToAssign].id + "&assignToMe=" + ((currentRoleFromMaster!="HQ") ? encodeURIComponent($scope.assignToMeSwitch.getChecked()) : JSON.stringify(false) ) + "&role=" + $scope.role +
                    "&assignToAllDownlines=" +( (currentRoleFromMaster!="MD"&& currentRoleFromMaster!="HQ") ? encodeURIComponent($scope.assignToAllDownlines.getChecked()) : JSON.stringify(false)) + "&selectedDownlines=" + encodeURIComponent((angular.isDefined($scope.selectedDownlines) ? JSON.stringify($scope.selectedDownlines) : JSON.stringify([])));
                $http.put(app_url + "targetsprofile/store", data, config).success(function (data) {
                    HideGlobalLoader();
                    if (data.action) {
                        GlobalSuccessNotification(data.message);
                        //update number of assigned to property
                        $scope.targets[$scope.indexToAssign].profile_count = data.assigned_to_count;
                        setTimeout(function () {
                            window.location.href = window.location.href;
                        }, 1000);
                    } else {
                        GlobalErrorNotification('An error occured while processing this request with message ' + data.message);
                    }
                }).error(function (error) {
                    HideGlobalLoader();
                    GlobalErrorNotification('An error occured while processing this request . Please try again');
                });
            };
            if(currentRoleFromMaster!="MD" && currentRoleFromMaster!="HQ"){
            //check if all downlines is checked
            if ($scope.assignToAllDownlines.getChecked()) {
                var users_count = $scope.downlineList.length;
                if ($scope.assignToMeSwitch.getChecked()) {
                    users_count += 1;
                }
                if (users_count > 0) {
                    GlobalConfirmationDialog('Assign "' + $scope.targets[$scope.indexToAssign].tag + '" to ' + users_count + ' users?', '', 'Yes, continue', 'No, cancel', successCallback, null);
                } else {
                    GlobalValidationAlert("Input Validation", "Please select atleast a user");
                }
            }
            else{
                if (angular.isDefined($scope.selectedDownlines)) {
                    var users_count = $scope.selectedDownlines.length;
                } else {
                    var users_count = 0;
                }
                if ($scope.assignToMeSwitch.getChecked()) {
                    users_count += 1;
                }
                if (users_count > 0) {
                    GlobalConfirmationDialog('Assign "' + $scope.targets[$scope.indexToAssign].tag + '" to ' + users_count + ' users?', '', 'Yes, continue', 'No, cancel', successCallback, null);
                } else {
                    GlobalValidationAlert("Input Validation", "Please select a atleast a user");
                }
            } 
        }
        else{
            if(angular.isDefined($scope.indexToAssign)){
            var users_count = 0;
            if(currentRoleFromMaster!="HQ"){
                if ($scope.assignToMeSwitch.getChecked()) {
                    users_count += 1;
                }
            }
            else{
                users_count = $scope.selectedDownlines.length;
            }
          
            if (users_count > 0) {
                GlobalConfirmationDialog('Assign "' + $scope.targets[$scope.indexToAssign].tag + '" to ' + users_count + ' users?', '', 'Yes, continue', 'No, cancel', successCallback, null);
            } else {
                GlobalValidationAlert("Input Validation", "Please select a atleast a user");
            }
        }
        else{
            GlobalValidationAlert("Input Validation", "Please select a atleast a user");            
        }
        }
               
            
        }
         else {
            GlobalValidationAlert("Input Validation", "Please select a target to assign");
        }
    };
    $scope.destroyTarget = function (index) {
        var successCallback = function () {
            ShowGlobalLoader();
            $http.delete(app_url + "target/delete/" + $scope.targets[index].id).success(function (data) {
                HideGlobalLoader();
                if (data.action) {
                    $scope.targets.splice(index, 1);
                    GlobalSuccessNotification(data.message);
                } else {
                    GlobalErrorNotification('An error occured while processing this request with message ' + data.message);
                }
            }).error(function (error) {
                HideGlobalLoader();
                GlobalErrorNotification('An error occured while processing this request . Please try again');
            });
        };
        GlobalConfirmationDialog('Delete Target Profile ', 'Do you wish to delete the target with tag: ' + $scope.targets[index].tag, 'Yes, continue', 'No, cancel', successCallback, null);
    };
    $scope.markAsCompleted = function (id) {
        var successCallback = function () {
            ShowGlobalLoader();
            $http.get(app_url + "targetsprofile/" + id + "/edit").success(function (data) {
                HideGlobalLoader();
                if (data.action) {
                    GlobalSuccessNotification(data.message);
                    setTimeout(function () {
                        window.location.href = window.location.href;
                    }, 2000);
                } else {
                    GlobalErrorNotification('An error occured while processing this request with message ' + data.message);
                }
            }).error(function (error) {
                HideGlobalLoader();
                GlobalErrorNotification('An error occured while processing this request . Please try again');
            });
        };
        GlobalConfirmationDialog('Target Completion', 'Do you wish to mark the target as completed by this user? ', 'Yes, continue', 'No, cancel', successCallback, null);
    }
    $scope.loadMoreTargets = function () {
        var length = $scope.targets.length;
        var lastTarget = $scope.targets[length - 1];
        var successCallback = function () {
            ShowGlobalLoader();
            $http.get(app_url + "retrieve/targets/more/" + lastTarget.id).success(function (data) {
                HideGlobalLoader();
                if (data.length > 0) {
                    $scope.targets = $scope.targets.concat(data);
                }

            }).error(function (error) {
                HideGlobalLoader();
                GlobalErrorNotification('An error occured while processing this request . Please try again');
            });
        };
        successCallback();
    }
});