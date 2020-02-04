app.controller('VerificationController', function ($scope, $http) {
    $scope.verifySelectedMds = function () {
        var data = table.rows({
            selected: true
        }).data();
        if (data.length > 0) {
            //extract user ids from datatable
            var mds  = [];
            for(var x = 0; x < data.length; x++){
                mds.push(data[x][6]);
            }
            var successCallback = function () {
                ShowGlobalLoader();
                var data = "mds=" + JSON.stringify(mds);
                var config = {
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                };
                $http.post(app_url + "md/verification/store", data, config).success(function (data) {
                    if(data.action){
                        GlobalSuccessNotification(data.message);
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    }
                    else{
                     GlobalErrorNotification('Error: '+data.message);            
                    }
                    HideGlobalLoader();
                }).error(function (error) {
                    HideGlobalLoader();
                    GlobalErrorNotification('An error occured. Please try again');
                });
            };
            GlobalConfirmationDialog('Monthly Verification', 'Do you wish to verify ' + data.length + '  selected MDs ?', 'Yes, verify', 'Cancel', successCallback, null);
        } else {
            GlobalWarningNotification('Please select atleast a MD to verify');
        }
    };
});