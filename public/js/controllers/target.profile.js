app.controller('TargetProfileController', function ($scope, $http) {
    $scope.markAsCompleted = function (id) {
        var successCallback = function () {
            ShowGlobalLoader();
            $http.get(app_url + "targetsprofile/" + id+"/edit").success(function (data) {
                HideGlobalLoader();
                if (data.action) {
                    GlobalSuccessNotification(data.message);
                    setTimeout(function(){
                        window.location.href = window.location.href;
                    },2000);
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
});