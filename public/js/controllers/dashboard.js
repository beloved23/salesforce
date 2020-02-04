app.controller('DashboardController', function ($scope, $http) {
        $scope.rodCount = totalRod;
        $scope.zbmCount = totalZbm;
        $scope.asmCount = totalAsm;
        $scope.mdCount = totalMd;

    //If Profile is ROD
    if (profile == "ROD") {
        $scope.myZbms = myZbm;
        $scope.myAsms = myAsm;
        $scope.myMds = myMd;
    }
    //If profile is ZBM
    else if (profile == "ZBM") {
        $scope.myAsms = myAsm;
        $scope.myMds = myMd;
    }
    //If profile is ASM
    else if (profile == "ASM") {
        $scope.myMds = myMd;
    }
    if(profile=="GeoMarketing"){
        $scope.regionCount = regionCount;
        $scope.zoneCount = zoneCount;
        $scope.areaCount = areaCount;
        $scope.territoryCount = territoryCount;
    }
});