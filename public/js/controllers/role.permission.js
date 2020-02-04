
$('#slimtest2').slimScroll({
    height: '200px'
});
$('#profileRolesScroll').slimScroll({
    height: '200px'
});
$('#profilePermissionsScroll').slimScroll({
    height: '200px'
});
$('#availablePermissionsScroll').slimScroll({
    height: '200px'
});
app.controller('RolePermissionController',function($scope,$http){

    //assign controller variables
    $scope.roles = roles;
    $scope.usersPerRole = usersPerRole;
    $scope.permissions = appPermissions;
    $scope.profileRoles = [];
    $scope.profilePermissions = [];


    $scope.deleteRoleForUser = function(action,userId,roleId,roleName){
        //define callback for user-permission-revoke
    var successCallback = function(){
        ShowGlobalLoader();    
        var config = {headers: {'Content-Type': 'application/x-www-form-urlencoded'}};
    var data = "userId="+encodeURIComponent(userId)+"&roleId="+encodeURIComponent(roleId);
    $http.put(app_url+"userroles/remove",data,config).success(function(data){
        HideGlobalLoader();
        if(data.action){
            GlobalSuccessNotification(data.message);                                                            
            $scope.profileRoles = data.roles;        
        }
        else{
            GlobalErrorNotification('An error occured while processing this request with message '+data.message);                                            
        }
    }).error(function(error){
    HideGlobalLoader();
    GlobalErrorNotification('An error occured while processing this request . Please try again');                                    
    });
    };
    
    if(action=="USER"){
    GlobalConfirmationDialog('Are you sure ?','Please note that role: "'+roleName+'" will be detached from user: '+userId,'Yes, continue','No, cancel',successCallback,null);                        
    }
    };



// Define Revoke Permissions from Profiling
$scope.deletePermissionForUserOrRole = function(action,userId,permissionId,permissionName){
    //define callback for user-permission-revoke
var successCallback = function(){
    ShowGlobalLoader();    
    var config = {headers: {'Content-Type': 'application/x-www-form-urlencoded'}};
var data = "userId="+encodeURIComponent(userId)+"&permissionId="+encodeURIComponent(permissionId);
$http.put(app_url+"userpermissions/revoke",data,config).success(function(data){
    HideGlobalLoader();
    if(data.action){
        GlobalSuccessNotification(data.message);                                                            
        $scope.profilePermissions = data.permissions;        
    }
    else{
        GlobalErrorNotification('An error occured while processing this request with message '+data.message);                                            
    }
}).error(function(error){
HideGlobalLoader();
GlobalErrorNotification('An error occured while processing this request . Please try again');                                    
});
};
//define callback for role-permission-revoke
var successCallbackTwo = function(){
    ShowGlobalLoader();    
    var config = {headers: {'Content-Type': 'application/x-www-form-urlencoded'}};
var data = "roleId="+encodeURIComponent($scope.profileRoles[0].id)+"&permissionId="+encodeURIComponent(permissionId);
$http.put(app_url+"rolepermissions/revoke",data,config).success(function(data){
    HideGlobalLoader();
    if(data.action){
        GlobalSuccessNotification(data.message);                                                            
        $scope.profilePermissions = data.permissions;        
    }
    else{
        GlobalErrorNotification('An error occured while processing this request with message '+data.message);                                            
    }
}).error(function(error){
HideGlobalLoader();
GlobalErrorNotification('An error occured while processing this request . Please try again');                                    
});
};

if(action=="USER"){
GlobalConfirmationDialog('Are you sure ?','Please note that permission "'+permissionName+'" will be detached from user: '+userId,'Yes, continue','No, cancel',successCallback,null);                        
}
else if(action=="ROLE"){
    GlobalConfirmationDialog('Are you sure ?','Please note that permission "'+permissionName+'" will be detached from the role "'+$scope.profileRoles[0].name+'"','Yes, continue','No, cancel',successCallbackTwo,null);                            
}
};

    //Define Profile Filtering
    $scope.initiateFiltering = function (){
        if(angular.isDefined($scope.filterAction)){
            if(angular.isDefined($scope.selectedProfileElement)){
            if($scope.filterAction=="USER"){
                $http.get(app_url+"userpermissions/get/"+$scope.selectedProfileElement).success(function(data){
                    if(data.action){
                    $scope.profileRoles = data.roles;
                    $scope.profilePermissions = data.permissions;
                    GlobalSuccessNotification("Please click the drop down to display role(s) and permission(s) for the profile");                                                    
                    }else{
                        GlobalErrorNotification('An error occured while processing this request with message: '+data.message);                                    
                    }
                }).error(function(error){
                    GlobalErrorNotification('An error occured while processing this request. Please try again');            
                });
            }
            else if($scope.filterAction=="ROLE"){
                $http.get(app_url+"rolepermissions/get/"+$scope.selectedProfileElement).success(function(data){
                    if(data.action){
                    $scope.profileRoles = [{"id":$scope.selectedProfileElement,"name":data.rolename}];
                    $scope.profilePermissions = data.permissions;
                    GlobalSuccessNotification("Please click the drop down to display role(s) and permission(s) for the profile");                                                                        
                    }
                    else{
                        GlobalErrorNotification('An error occured while processing this request with message: '+data.message);                                                            
                    }
                }).error(function(error){
                    GlobalErrorNotification('An error occured while processing this request. Please try again');                                
                });
            }
        }
        else{
            GlobalValidationAlert("Input Validation","Please select either a user or role to profile");          
        }
        }
        else{
            GlobalValidationAlert("Filter Validation","Please select a filter");                                                             
        }
    };


    //AssignUserWithoutPermissions
    $scope.assignUserWithoutPermissions = function (){
        ShowGlobalLoader();
        var config = {headers: {'Content-Type': 'application/x-www-form-urlencoded'}};
        var data = "users="+JSON.stringify($scope.selectedUsers)+"&roles="+JSON.stringify($scope.selectedRoles);
        $http.put(app_url+"users/update",data,config).success(function(data){
            HideGlobalLoader();
            if(data.validations&&data.action){
                GlobalSuccessNotification("Action Response: "+data.message);                                
            }
            else{
                GlobalErrorNotification('An error occured while processing this request. Please try again');                
            }
        }).error(function(error){
            HideGlobalLoader();
            GlobalErrorNotification('An error occured while processing this request. Please try again');            
        });
    };
    //AssignUserWithPermissions
    $scope.assignUserWithPermissions = function (){
        ShowGlobalLoader();
        var config = {headers: {'Content-Type': 'application/x-www-form-urlencoded'}};
        var data = "users="+JSON.stringify($scope.selectedUsers)+"&roles="+JSON.stringify($scope.selectedRoles)+"&permissions="+JSON.stringify($scope.selectedPermissions);
        $http.put(app_url+"users/update",data,config).success(function(data){
            HideGlobalLoader();
            if(data.validations&&data.action){
                GlobalSuccessNotification("Action Response: "+data.message);                           
            }
            else{
                GlobalErrorNotification('An error occured while processing this request. Please try again');                
            }
        }).error(function(error){
            HideGlobalLoader();
           GlobalErrorNotification('An error occured while processing this request. Please try again');                        
        });
    };

     //AssignRoleWithPermissions
     $scope.assignRoleWithPermissions = function (){
        ShowGlobalLoader();
        var config = {headers: {'Content-Type': 'application/x-www-form-urlencoded'}};
        var data = "roles="+JSON.stringify($scope.selectedRoles)+"&permissions="+JSON.stringify($scope.selectedPermissions);
        $http.put(app_url+"rolepermission/update",data,config).success(function(data){
            HideGlobalLoader();
            if(data.validations&&data.action){
                GlobalSuccessNotification("Action Response: "+data.message);                           
            }
            else{
                GlobalErrorNotification('An error occured while processing this request. Please try again');                
            }
        }).error(function(error){
            HideGlobalLoader();
           GlobalErrorNotification('An error occured while processing this request. Please try again');                        
        });
    };

    //Begin assign to roles function
 $scope.assignToRoles = function (){
        if(angular.isDefined($scope.selectedRoles)){
        if($scope.selectedRoles.length > 0){
            
            //check if permissions were assigned
            if(angular.isDefined($scope.selectedPermissions)){
                if($scope.selectedPermissions.length>0){
                    GlobalConfirmationDialog('Are you sure ?','Please note that previous permissions associated with the selected roles will be detached','Yes, continue','No, cancel',$scope.assignRoleWithPermissions,null);                        
                }
                else{
          //Insert confirmation dialog
          GlobalValidationAlert("Assignment Validation","Please select atleast one permission to assign");                                                 
        }
            }
            // no permission was assigned
            else{
                 //Insert confirmation dialog
                 GlobalValidationAlert("Assignment Validation","Please select atleast one permission to assign");                                                 
            }
                
        }
        else{
            GlobalValidationAlert("Assignment Validation","Please select atleast one role to assign");                                
        }
    }
    else{
        GlobalValidationAlert("Assignment Validation","Please select atleast one role");   
    }
};
//End assign to roles function

    //Begin assign to users function
    $scope.assignToUsers = function (){
        if(angular.isDefined($scope.selectedUsers)){
            if(angular.isDefined($scope.selectedRoles)){
            if($scope.selectedUsers.length > 0 && $scope.selectedRoles.length > 0){
                
                //check if permissions were assigned
                if(angular.isDefined($scope.selectedPermissions)){
                    if($scope.selectedPermissions.length>0){
                        GlobalConfirmationDialog('Are you sure ?','Please note that previous roles and permissions associated with the selected users will be detached','Yes, continue','No, cancel',$scope.assignUserWithPermissions,null);                        
                    }
                    else{
              //Insert confirmation dialog
              GlobalConfirmationDialog('Are you sure ?','Please note that previous roles associated with the selected users will be detached','Yes, continue','No, cancel',$scope.assignUserWithoutPermissions,null);
            }
                }
                // no permission was assigned
                else{
                     //Insert confirmation dialog
        GlobalConfirmationDialog('Are you sure ?','Please note that previous roles associated with the selected users will be detached','Yes, continue','No, cancel',$scope.assignUserWithoutPermissions,null);
                }
                    
            }
            else{
                GlobalValidationAlert("Assignment Validation","Please select atleast one role and user to assign");                                
            }
        }
        else{
            GlobalValidationAlert("Assignment Validation","Please select atleast one role");   
        }
        }
        else{
            GlobalValidationAlert("Assignment Validation","Please select atleast one user");                
           }
    };
    //End assign to users function


    //Begin create Permission function
    $scope.createPermission = function (){
        if(angular.isDefined($scope.permissionName)){
            //validate role name length
            if($scope.permissionName.length > 4){
                //create Ajax request callback
                var successCallback = function(){
                var config = {headers: {'Content-Type': 'application/x-www-form-urlencoded'}};
                var data = "name="+encodeURIComponent($scope.permissionName);
                ShowGlobalLoader();
                $http.post(app_url+"create/permission",data,config).success(function(data){
                    HideGlobalLoader();
                    if(data.action&&data.validations){
                       $scope.permissions = data.permissions;
                        GlobalSuccessNotification("Permission: "+$scope.permissionName+" successfully created.");                
                        $scope.permissionName = "";
                    }
                    else if(!data.action){
                        GlobalValidationAlert("Permission Creation","A permission with this name already exist");                
                    }
                }).error(function(error){
                    HideGlobalLoader();
                    GlobalErrorNotification('An error occured while processing this request. Please try again');
                });
                };

         //Insert confirmation dialog
        GlobalConfirmationDialog('Are you sure ?','This request will create permission, "'+$scope.permissionName+'" on this application','Yes, create permission','No, cancel',successCallback,null);
    }
    else{
        GlobalValidationAlert("Permission Name Validation","permission name must be greater than five characters in length")
    }
    }
    else{
        GlobalValidationAlert("Permission Name Validation","Please provide permission name")        
    }
    };
    //End create Permission function

    //Show delete tooltip on MouseHove
    $scope.showTip = function(data){
      $('#'+data).protipShow();
    };
    
    //Begin delete role function
    $scope.destroyRole = function (roleId,roleName){
       var successCallback  = function(){ 
        ShowGlobalLoader();        
        $http.delete(app_url+"role/destroy/"+roleId).success(function(data){
        HideGlobalLoader();
           if(data.action){
                $scope.roles = data.roles;
                GlobalSuccessNotification(data.message);                                
           }
           else{
            GlobalErrorNotification('An error occured while processing this request with message: '+data.message);            
           }
        }).error(function(error){
            HideGlobalLoader();
        });
    };
    GlobalConfirmationDialog('Are you sure ?','This request will delete "'+roleName+'" role on this application','Yes, delete role','No, cancel',successCallback,null);    
    };
    //End delete role function

    //Begin delete permission function
    $scope.destroyPermission = function (permissionId,permissionName){
        var successCallback  = function(){ 
         ShowGlobalLoader();        
         $http.delete(app_url+"permission/destroy/"+permissionId).success(function(data){
         HideGlobalLoader();
            if(data.action){
                 $scope.permissions = data.permissions;
                 GlobalSuccessNotification(data.message);                                
            }
            else{
             GlobalErrorNotification('An error occured while processing this request with message: '+data.message);            
            }
         }).error(function(error){
            GlobalErrorNotification('An error occured while processing this request. Please try again');                        
             HideGlobalLoader();
         });
     };
     GlobalConfirmationDialog('Are you sure ?','This request will delete "'+permissionName+'" permit on this application','Yes, delete role','No, cancel',successCallback,null);    
     };
     //End delete role function

    //Begin create role Function
    $scope.createRole = function(){
        if(angular.isDefined($scope.roleName)){
            //validate role name length
            if($scope.roleName.length > 2){
                //create Ajax request callback
                var successCallback = function(){
                var config = {headers: {'Content-Type': 'application/x-www-form-urlencoded'}};
                var data = "name="+encodeURIComponent($scope.roleName);
                ShowGlobalLoader();
                $http.post(app_url+"create/role",data,config).success(function(data){
                    HideGlobalLoader();
                    if(data.action&&data.validations){
                        $scope.roles = data.data;
                        $scope.usersPerRole = data.usersPerRole;
                        GlobalSuccessNotification("Role: "+$scope.roleName+" successfully created.");                
                        $scope.roleName = "";
                    }
                    else if(!data.action){
                        GlobalValidationAlert("Role Creation","A role with this name already exist");                
                    }
                }).error(function(error){
                    HideGlobalLoader();
                    GlobalErrorNotification('An error occured while processing this request. Please try again');
                });
                }

         //Insert confirmation dialog
        GlobalConfirmationDialog('Are you sure ?','This request will create a role, "'+$scope.roleName+'" on this application','Yes, create role','No, cancel',successCallback,null);
    }
    else{
        GlobalValidationAlert("Role Name Validation","Role name must be greater than two characters in length")
    }
    }
    else{
        GlobalValidationAlert("Role Name Validation","Please provide role name")        
    }
    };
// End create role function

});