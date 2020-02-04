app.controller('ManageController',function($scope,$http){
    $scope.showProfile  = false;
   $scope.changeUser = function($id){
    //    if($scope.selectedUsers.length<=1){
    //        if($scope.currentProfiledUser != $scope.selectedUsers[0]){
        $scope.selectedUsers = [$id];
           $scope.retrieveProfile();
    //        }
    //    }
    //    else{
    //     GlobalValidationAlert('Manage Users Validation','Maximum user selection exceeded. Please remove all users and select only one')
    //    }
   }
   $scope.retrieveProfile = function(){
        if(angular.isDefined($scope.selectedUsers[0])){
            ShowGlobalLoader();
            $http.get(app_url+'retrieve/user/'+$scope.selectedUsers[0]).success(function(data){
                $scope.showProfile = true;
                $scope.currentProfiledUser = $scope.selectedUsers[0];
                $scope.bindDataForPreview(data);
                HideGlobalLoader();
            }).error(function(error){
                HideGlobalLoader();
                GlobalErrorNotification('An error occured. Please try again');
            });
        }
   }
   $scope.bindDataForPreview = function(data){
    $scope.userPicture = app_url+'storage/'+data.profile.profile_picture;
    $scope.userFirstName = data.profile.first_name;
    $scope.userLastName  = data.profile.last_name;
    $scope.userFullName = data.profile.last_name+' '+data.profile.first_name;
    $scope.userRole = data.role.name;
    $scope.userEmail = data.email;
    $scope.userPhone =data.profile.phone_number; 
    $scope.userData = data;
    $scope.showDeactivateUser = data.is_deactivated;
    //hierachy profiles
    $scope.zbmCount =data.zbmCount;
    $scope.asmCount = data.asmCount;
    $scope.mdCount = data.mdCount;
    //modify update profile form
   var url =  $('#update-profile').attr('action');
    url = url.replace('00',data.id);
    $('#update-profile').attr('action',url);
   }
   $scope.deactivateUser = function(){
       var successCallback = function(){
            ShowGlobalLoader();
            $http.get(app_url+'application/user/deactivate/'+$scope.userData.id).success(function(data){
                HideGlobalLoader();
                if(data.action){
                    $scope.showDeactivateUser = true;                                    
                    GlobalSuccessNotification(data.message);
                }
                else{
                    GlobalErrorNotification('Error: '+data.message);
                }
            }).error(function(error){
                HideGlobalLoader();
                alert(JSON.stringify(error));
            });
       };
       GlobalConfirmationDialog('Deactivate User','Do you wish to deactivate '+$scope.userFullName+' Note: This will remove user profile and prevent access to the application?','Yes, deactivate','Cancel',successCallback,null);
   }
   $scope.activateUser = function(){
    var successCallback = function(){
         ShowGlobalLoader();
         $http.get(app_url+'application/user/activate/'+$scope.userData.id).success(function(data){
             HideGlobalLoader();
             if(data.action){
                $scope.showDeactivateUser = false;                
                 GlobalSuccessNotification(data.message);
             }
             else{
                 GlobalErrorNotification('Error: '+data.message);
             }
         }).error(function(error){
             HideGlobalLoader();
             GlobalErrorNotification('An error occured. Please try again');             
         });
    };
    GlobalConfirmationDialog('Activate User','Do you wish to activate '+$scope.userFullName+' Note: This will give user access to the application?','Yes, activate','Cancel',successCallback,null);
}
    $scope.UpdateProfile = function(){
        var successCallback = function(){
           var data = "action=update" + "&first_name=" + encodeURIComponent($scope.userFirstName) +
           "&last_name=" + encodeURIComponent($scope.userLastName) + "&email=" + encodeURIComponent($scope.userEmail)+"&msisdn="+encodeURIComponent($scope.userPhone);
       var config = { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } };
       $http.post(app_url + "application/user/profile/update/"+$scope.userData.id, data, config).success(function(data) {
           if(data.action){
            $scope.bindDataForPreview(data);
           }
           else{
            GlobalErrorNotification('Error: '+data.message);            
           }
       }).error(function(error){
        GlobalErrorNotification('An error occured. Please try again');             
    });
    };
    if(angular.isDefined($scope.userFirstName) && angular.isDefined($scope.userLastName) && angular.isDefined($scope.userEmail) && angular.isDefined($scope.userPhone)){
            GlobalConfirmationDialog('Update User Profile','Do you wish to update '+$scope.userFullName+"'s Profile ? Note: This will overwrite user predefined information",'Yes, update','Cancel',successCallback,null);                              
    }
    else{
     GlobalValidationAlert('Update User Profile','Please fill the fields for first name, last name, email and phone number');   
    }
}

});