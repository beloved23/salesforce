app.controller('ShowSiteController', function($scope, $http) {

    $scope.siteList = siteList;
    $scope.territoryList = territoryList;
    $scope.showEditForm = false;
    $scope.currentSiteIndex = 0;
    $scope.siteView = function(index) {
        $scope.showEditForm = true;
        var currentSite = $scope.siteList[index];
        $scope.currentSiteIndex = index;

        //update form action
        $('#create-form').attr('action', 'site/modify/' + currentSite.id);
        //bind all textboxes to data
        $scope.siteId = currentSite.site_id;
        $scope.siteAddress = currentSite.address;
        $scope.townName = currentSite.town_name;
        $scope.siteCode = currentSite.site_code;
        $scope.siteStatus = currentSite.is_active;
        $scope.selectedTerritory = currentSite.territory_id;
        $scope.siteClassCode = currentSite.class_code;
        $scope.siteLatitude = currentSite.latitude;
        $scope.siteLongitude = currentSite.longitude;
        $scope.siteClassification = currentSite.classification;
        $scope.siteCategory = currentSite.category;
        $scope.siteType = currentSite.type;
        $scope.siteCategoryCode = currentSite.category_code;
        $scope.siteHubCode = currentSite.hubcode;
        $scope.siteCommercialClassification = currentSite.commercial_classification;
        $scope.siteBscCode = currentSite.bsc_code;
        $scope.siteBscName = currentSite.bsc_name;
        $scope.siteBscRnc = currentSite.bsc_rnc;
        $scope.siteBtsType = currentSite.bts_type;
        $scope.siteCellCode = currentSite.cell_code;
        $scope.siteCellId = currentSite.cell_id;
        $scope.siteCgi = currentSite.cgi;
        $scope.siteCity = currentSite.city;
        $scope.siteCi = currentSite.ci;
        $scope.siteCityCode = currentSite.city_code;
        $scope.siteComment = currentSite.comment;
        $scope.siteCorrespondingNetwork = currentSite.corresponding_network;
        $scope.siteCoverageArea = currentSite.coverage_area;
        $scope.siteLac = currentSite.lac;
        $scope.siteMscName = currentSite.msc_name;
        $scope.siteMscCode = currentSite.msc_code;
        $scope.siteMss = currentSite.mss;
        $scope.siteNetworkCode = currentSite.network_code;
        $scope.siteNewMssPool = currentSite.new_mss_pool;
        $scope.siteOmClassification = currentSite.om_classification;
        $scope.siteVendor = currentSite.vendor;
        $scope.siteNewZone = currentSite.new_zone;
        $scope.siteNewRegion = currentSite.new_region;
        $scope.siteOperationalDate = currentSite.operational_date;
        $scope.siteLocationInfo = currentSite.location_information;
    };

    $scope.siteLayers = function(index) {
        var currentSite = $scope.siteList[index];
        $scope.currentSiteIndex = index;
        $('#showHierachyRelations').click();
        $scope.hierachyTerritoryName = currentSite.territory.name;
        $scope.hierachyTerritoryCode = currentSite.territory.territory_code;
        $scope.hierachyLgaName = currentSite.territory.lga.name;
        $scope.hierachyLgaCode = currentSite.territory.lga.lga_code;
        $scope.hierachyAreaName = currentSite.territory.lga.area.name;
        $scope.hierachyAreaCode = currentSite.territory.lga.area.area_code;
    };

    $scope.siteDelete = function(index) {
        var currentSite = $scope.siteList[index];
        $scope.currentSiteIndex = index;
        var successCallback = function() {
            ShowGlobalLoader();
            $http.delete(app_url + "site/destroy/" + currentSite.id).success(function(data) {
                HideGlobalLoader();
                if (data.validations && data.action) {
                    GlobalSuccessNotification(data.message + ". Prepping for a reload. Hang on!");
                    setTimeout(function() {
                        location.reload();
                    }, 3000);
                } else {
                    GlobalWarningNotification('An error occured while processing this request with message: ' + data.message);
                }
            }).error(function(error) {
                HideGlobalLoader();
                GlobalErrorNotification('An error occured while processing this request ');
            });
        };
        GlobalConfirmationDialog('Are you sure ?', 'This action will delete the site with code "' + currentSite.site_code + '" on this application', 'Yes, continue', 'No, cancel', successCallback, null);
    }
});