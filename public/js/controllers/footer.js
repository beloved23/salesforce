app.controller("Footer",function($scope,$http){
    //undefined validation
	if(!app_name){
		var  app_name = "SalesForce";
	}
    $scope.abc = app_name;
}); 
