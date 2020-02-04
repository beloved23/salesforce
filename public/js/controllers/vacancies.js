
app.controller('VacancyController',function($scope,$http){
    $scope.recruitSelected = function(){
        var data = table.rows({
            selected: true
        }).data();
        if (data.length > 0) {
            //extract user ids from datatable
            var users  = [];
            for(var x = 0; x < data.length; x++){
                users.push(data[x][5]);
            }
            var successCallback = function () {
                ShowGlobalLoader();
                var postData = "vacancies=" + JSON.stringify(users);
                var config = {
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                };
                $http.post(app_url + "vacancies/recruit", postData, config).success(function (data) {
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
            GlobalConfirmationDialog('Recruitment Notification', 'Do you wish to notify recruitment agencies for ' + data.length + ' users ?', 'Yes, verify', 'Cancel', successCallback, null);
        } else {
            GlobalWarningNotification('Please select atleast a user to recruit');
        }
    }
});