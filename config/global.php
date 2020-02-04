<?php


return [

    /**Define App name below **/
'app_name'=>'SalesForce',

/**Define default profile pictur below **/
'avatar'=> 'avatar.jpg',
'mail_address'=>'support@salesforce.com.ng',

/**secret for location movement claim route **/
'location_movement_secret'=>'moTvtZS8BcsUe0bwZS783B01yWErNyDa',
'ad_api'=>'http://localhost/salesforce/api/simulate/auth?auuid=%s&password=%s',
'validate_api'=>'http://localhost/salesforce/api/application/user/',
'valid_file_extensions'=>['jpeg', 'png', 'PNG', 'JPG', 'jpg', 'gif', 'doc',
 'docx', 'pdf', 'xlsx', 'rtf', 'mp3', 'mp4', 'avi'],
'models'=>['ROD'=>'App\Models\RodProfile',
'ZBM'=>'App\Models\ZbmProfile','ASM'=>'App\Models\AsmProfile',
'MD'=>'App\Models\MdProfile'],
'location_column'=>['ROD'=>'region_id',
'ZBM'=>'zone_id','ASM'=>'area_id','MD'=>'territory_id'],
'location_models'=>['ROD'=>'App\Models\LocationRegion',
'ZBM'=>'App\Models\LocationZone','ASM'=>'App\Models\LocationArea',
'MD'=>'App\Models\LocationTerritory'],
'locationmodel_to_name'=>['App\Models\LocationRegion'=>'Region',
'App\Models\LocationZone'=>'Zone','App\Models\LocationArea'=>'Area',
'App\Models\LocationTerritory'=>'Territory']
];
// {"IsSuccess":true,"MessageList":[],"ObjectList":[{"FullName":"SalesForce","Email":"support@salesforce.com.ng","PhoneNumber":"080300000000","Department":"IT"}]}


// {"IsSuccess":true,"MessageList":[],"ObjectList":[{"FullName":"Ayanfe Adegoke","Email":"Adegoke.Ayanfe@ng.airtel.com","PhoneNumber":"08022221569","Department":"IT"}]}

// 'http://172.24.91.109:7777/Auth/Validate?username=2330854&password=Oluwasemilore12%21'
