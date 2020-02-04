<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//custom route for my operations
Route::get('/patch/dummy', 'ProtectedApiController@dummy');

//Export Entire Salesforce
Route::get('/export/salesforce', 'ExportController@salesforce')->name('export.salesforce');
Route::get('/export/geography', 'ExportController@geography')->name('export.geography');

// get request for domain
Route::get("/", "Auth\LoginController@index");

//route to display login page
Route::get("/login", "Auth\LoginController@index")->name('login');

//route to authenticate user
Route::post("/login", "Auth\LoginController@login")->name('login');

//logout user
Route::get("/user/logout", "Auth\LoginController@logout")->name('user/logout');

//route to display registration page
Route::get('/register', "Auth\RegisterController@index")->name('register');

// Only authenticated users may enter dashboard
Route::resource('/dashboard', 'DashboardController');
Route::get('/home', 'DashboardController@index')->name('home');
// Resource controller
Route::resource('/users', 'UserController');


//RolePermission controller
Route::resource('/rolepermission', 'RolePermission');

Route::get('/userpermissions/get/{id}', 'RolePermission@userpermissions');

Route::get('/rolepermissions/get/{id}', 'RolePermission@rolepermissions');

Route::delete('/role/destroy/{id}', 'RolePermission@roledestroy');
Route::delete('/permission/destroy/{id}', 'RolePermission@permissiondestroy');

Route::put('/userpermissions/revoke', 'RolePermission@revokeUserPermission');

Route::put('/rolepermissions/revoke', 'RolePermission@revokeRolePermission');

Route::put('/userroles/remove', 'RolePermission@removeUserRole');


Route::post('/create/role', 'RolePermission@store');

Route::post('/create/permission', 'RolePermission@save');

Route::get('/destroy/role/{id}', 'RolePermission@destroy');

//End RolePermission

//Begin Hierachy Controller
Route::resource('/hierachy', 'HierachyController');

//End Hierachy Controller

//Location Controller
Route::resource('/location', 'LocationController');
Route::post('/location/save', 'LocationController@store');


//country controller
Route::get('/country/show', 'CountryController@index')->name('country.show');
Route::get('/country/show/{id}', 'CountryController@filter');
Route::post('/country/modify/{id}', 'CountryController@modify');
Route::delete('/country/destroy/{id}', 'CountryController@destroy');

Route::get('/region/show', 'RegionController@index')->name('region.show');
Route::get('/region/show/{id}', 'RegionController@filter');
Route::post('/region/modify/{id}', 'RegionController@modify');
Route::delete('/region/destroy/{id}', 'RegionController@destroy');

Route::get('/zone/show', 'ZoneController@index')->name('zone.show');
Route::get('/zone/show/{id}', 'ZoneController@filter');
Route::post('/zone/modify/{id}', 'ZoneController@modify');
Route::delete('/zone/destroy/{id}', 'ZoneController@destroy');

Route::get('/state/show', 'StateController@index')->name('state.show');

Route::resource('/territory', 'TerritoryController');

Route::get('/area/show', 'AreaController@index')->name('area.show');

Route::get('/lga/show', 'LgaController@index')->name('lga.show');

//Site Controller
Route::resource('/site', 'SiteController');
Route::post('/site/modify/{id}', 'SiteController@modify');
Route::delete('/site/destroy/{id}', 'SiteController@destroy');



//ProtectedApiController
Route::get('/retrieve/rods', 'ProtectedApiController@getRods');
Route::get('/retrieve/zbms', 'ProtectedApiController@getZbms');
Route::get('/retrieve/asms', 'ProtectedApiController@getAsms');
Route::get('/retrieve/mds','ProtectedApiController@getMds');
Route::get('/retrieve/user/{id}', 'ProtectedApiController@user');
//Postman test api route
Route::get('/retrieve/custom', 'ProtectedApiController@custom');
//Ajax Upload
Route::post('/picture/upload', 'ProtectedApiController@upload')->name('picture.upload');

//Retrieve downlines for Targets assignment
Route::get('/retrieve/downlines', 'ProtectedApiController@getDownlines');

//Retrieve auth user zbms
Route::get('/retrieve/myZbms', 'ProtectedApiController@getMyZbms');
Route::get('/retrieve/myAsms', 'ProtectedApiController@getMyAsms');
Route::get('/retrieve/myMds', 'ProtectedApiController@getMyMds');

//Target Pagination(Ajax) retrieve more targets
Route::get('/retrieve/targets/more/{id}', 'ProtectedApiController@moreTargets');
//Pusher Authentication
Route::post('/pusher/auth', 'ProtectedApiController@pusherAuth')->name('pusher.auth');

//Organogram Controller
Route::get('/organogram/rod', 'OrganogramController@rod')->name('organogram.rod');
Route::get('/organogram/zbm', 'OrganogramController@zbm')->name('organogram.zbm');
Route::get('/organogram/asm', 'OrganogramController@asm')->name('organogram.asm');
Route::get('/organogram/md', 'OrganogramController@md')->name('organogram.md');
Route::get('/organogram/api', 'OrganogramController@api')->name('organogram.api');


//Profile Controller
Route::resource('/profile', 'ProfileController');

//Targets Controller
Route::delete('/target/delete/{id}', 'TargetController@destroy');
Route::resource('/targets', 'TargetController');

Route::get('/targetsprofile/filter/completed', 'TargetProfileController@completed')->name('targetsprofile.filter.completed');
Route::get('/targetsprofile/filter/uncompleted', 'TargetProfileController@uncompleted')->name('targetsprofile.filter.uncompleted');
Route::get('/targetsprofile/filter/thisMonth', 'TargetProfileController@thisMonth')->name('targetsprofile.filter.thisMonth');
Route::get('/targetsprofile/filter/lastMonth', 'TargetProfileController@lastMonth')->name('targetsprofile.filter.lastMonth');
Route::get('/targetsprofile/filter/thisYear', 'TargetProfileController@thisYear')->name('targetsprofile.filter.thisYear');

Route::resource('/targetsprofile', 'TargetProfileController');

//Group Messages Controller
Route::get('/messages', 'MessageController@index')->name('messages.index');
Route::get('/messages/peers', 'MessageController@peers')->name('messages.peers');
Route::get('/messages/downlines', 'MessageController@downlines')->name('messages.downlines');

//Personal Inbox Controller
Route::get('/inbox/sent', 'InboxController@sent')->name('inbox.sent');

Route::get('/inbox/category/{filter}', 'InboxController@category')->name('inbox.category');
Route::post('/inbox/reply/{id}', 'InboxController@update')->name('inbox.reply');
Route::resource('/inbox', 'InboxController');


//Email Controller
Route::get('/mail', 'MailController@index')->name('mail.index');

//RoleMovement Controller
Route::get('/role/movement/create', 'RoleMovementController@index')->name('role.movement.create');
Route::get('/role/movement/history', 'RoleMovementController@history')->name('role.movement.history');
Route::get('/role/movement/profile/{id}', 'RoleMovementController@profile')->name('role.movement.profile');
Route::post('/role/movement/store', 'RoleMovementController@store');
Route::get('/role/movement/profile/action/unclaim/{id}', 'RoleMovementController@unclaim')->name('role.movement.profile.action.unclaim');
Route::get('/role/movement/profile/action/claim/{id}', 'RoleMovementController@claim')->name('role.movement.profile.action.claim');
Route::post('/role/movement/profile/action/approve/{id}', 'RoleMovementController@approve')->name('role.movement.profile.action.approve');
Route::post('/role/movement/profile/action/deny/{id}', 'RoleMovementController@deny')->name('role.movement.profile.action.deny');
Route::post('/role/movement/attest/{id}', 'RoleMovementController@attest')->name('role.movement.attest');
Route::get('/role/movement/get/attester/{id}', 'RoleMovementController@getAttester');
Route::delete('/role/movement/{id}/destroy', 'RoleMovementController@destroy')->name('role.movement.destroy');

//LocationMovement Controller
Route::get('/location/movement/create', 'LocationMovementController@create')->name('location.movement.create');
Route::get('/location/movement/history', 'LocationMovementController@history')->name('location.movement.history');
Route::delete('/location/movement/{id}/destroy', 'LocationMovementController@destroy')->name('location.movement.destroy');
Route::get('/location/movement/cancel/{id}', 'LocationMovementController@cancel')->name('location.movement.cancel');
Route::get('/location/movement/profile/{id}', 'LocationMovementController@profile')->name('location.movement.profile');
Route::get('/location/movement/get/country/by/region/{id}', 'LocationMovementController@getCountryByRegion');
Route::get('/location/movement/get/upline/for/profile/{id}', 'LocationMovementController@getUpline');
Route::post('/location/movement/store', 'LocationMovementController@store')->name('location.movement.store');
Route::post('/location/movement/attest/{id}', 'LocationMovementController@attest')->name('location.movement.attest');
Route::get('/location/movement/profile/action/unclaim/{id}', 'LocationMovementController@unclaim')->name('location.movement.profile.action.unclaim');
Route::get('/location/movement/profile/action/claim/{id}', 'LocationMovementController@claim')->name('location.movement.profile.action.claim');
Route::post('/location/movement/profile/action/approve/{id}', 'LocationMovementController@approve')->name('location.movement.profile.action.approve');
Route::post('/location/movement/profile/action/deny/{id}', 'LocationMovementController@deny')->name('location.movement.profile.action.deny');

//Claim route for location movement by HR
Route::get('/location/movement/claim/{id}', 'ClaimLocationMovement@claim');
Route::post('/location/movement/claim/verify', 'ClaimLocationMovement@verifyWithToken');
Route::get('/location/movement/claim/continue', 'ClaimLocationMovement@authenticateAndRedirectWithToken');

//Claim route for role movement by HR
Route::get('/role/movement/claim/{id}', 'ClaimRoleMovement@claim');
Route::post('/role/movement/claim/verify', 'ClaimRoleMovement@verifyWithToken');
Route::get('/role/movement/claim/continue', 'ClaimRoleMovement@authenticateAndRedirectWithToken');


//Route for downloads

Route::get('/download/inbox/attachment/{id}', 'DownloadController@downloadAttachment')->name('download.inbox.attachment');

//Route for displaying HierachyProfiles(downlines) for each roles
//display all hq
Route::get('/hierachy/downlines/hq', 'HierachyProfileController@hq')->name('hierachy.downlines.hq');

//for HR
Route::get('/hierachy/downlines/hr', 'HierachyProfileController@hr')->name('hierachy.downlines.hr');

//for ROD
Route::get('/hierachy/downlines/rod', 'HierachyProfileController@rod')->name('hierachy.downlines.rod');
//for ZBM
Route::get('/hierachy/downlines/zbm', 'HierachyProfileController@zbm')->name('hierachy.downlines.zbm');
//for ASM
Route::get('/hierachy/downlines/asm', 'HierachyProfileController@asm')->name('hierachy.downlines.asm');

//for MD
Route::get('/hierachy/downlines/md', 'HierachyProfileController@md')->name('hierachy.downlines.md');

//for Territories
Route::get('/hierachy/downlines/territories', 'HierachyProfileController@territories')->name('hierachy.downlines.territories');
Route::get('/hierachy/downlines/sites', 'HierachyProfileController@sites')->name('hierachy.downlines.sites');


//Route for displaying all hierachyprofiles/user to HR
Route::get('/application/users/hierachyprofile/{id}', 'ApplicationUsersController@hierachyprofile')->name('application.users.hierachyprofile');
//Route for displaying all locationprofiles/user to HR
Route::get('/application/users/locationprofile/{id}', 'ApplicationUsersController@locationprofile')->name('application.users.locationprofile');
Route::get('/application/users/manage', 'ApplicationUsersController@manage')->name('application.users.manage');
Route::get('/application/user/deactivate/{id}', 'ApplicationUsersController@deactivate');
Route::get('/application/user/activate/{id}', 'ApplicationUsersController@activate');
Route::post('/application/user/profile/update/{id}', 'ApplicationUsersController@updateProfile')->name('application.users.profile.update');

//Route to manage Vancancies
Route::get('/vacancies', 'VacancyController@index')->name('vacancies.index');
Route::get('/vacancies/sync', 'VacancyController@sync')->name('vacancies.sync');
Route::get('/vacancies/location', 'VacancyController@location');
Route::get('/vacancies/report/user/{id}', 'VacancyController@report')->name('vacancies.report.user');
Route::post('/vacancies/recruit', 'VacancyController@recruit');

//Route to manage monthly verification
Route::get('/md/verification', 'MonthlyVerification@index')->name('md.verification.index');
Route::post('/md/verification/store', 'MonthlyVerification@store');

Route::get('/history/attestation', 'AttestationController@index')->name('history.attestation');

//Route to manage work history
Route::resource('/workhistory', 'WorkHistoryController');

//Route to manage md agency
Route::get('/agency/remove/region/{id}', 'MdAgencyController@detach')->name('agency.remove.region');
Route::get('/agency/delete/{id}', 'MdAgencyController@destroy')->name('agency.delete');
Route::resource('/agency', 'MdAgencyController');
