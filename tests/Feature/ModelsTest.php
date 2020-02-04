<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\AsmProfile;
use App\Models\User;
use App\Models\UserProfile;
use Faker\Factory as Faker;
use App\Models\LocationCountry;
use Spatie\Permission\Models\Role;
use App\Models\LocationRegion;
use App\Models\LocationZone;
use App\Models\LocationState;
use App\Models\LocationArea;
use App\Models\LocationLga;
use App\Models\LocationTerritory;
use App\Models\LocationSite;
use App\Models\Target;

class ModelsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    // public static function setUpBeforeClass()
    // {
    //     fwrite(STDOUT, 'Refreshing Database');
    //     parent::setUpBeforeClass();
    //     shell_exec('php artisan migrate:refresh --env=testing');
    // }

    public function testUser()
    {
        $faker = Faker::create('en_NG');
        $auuid = $faker->randomNumber($nbDigits = 7);
        $user = factory(User::class)->create(
            [
            'auuid'=>$auuid,
            ]
        );
        $this->assertDatabaseHas(
            'users',
            [
            'auuid' => $auuid
            ]
        );
    }
    public function testUserProfile()
    {
        $faker = Faker::create('en_NG');
        $auuid = $faker->randomNumber($nbDigits = 7);
        $user = factory(User::class)->create(
            [
            'auuid'=>$auuid,
            ]
        );
        $user->profile()->save(factory(UserProfile::class)->make([
            'auuid'=>$user->auuid,
        ]));
        $this->assertDatabaseHas(
            'users_profile',
            [
            'user_id' => $user->id
            ]
        );
    }
    public function testUserProfileBelongsToUser()
    {
        $faker = Faker::create('en_NG');
        $auuid = $faker->randomNumber($nbDigits = 7);
        $user = factory(User::class)->create(
            [
            'auuid'=>$auuid,
            ]
        );
        $user->profile()->save(factory(UserProfile::class)->make([
            'auuid'=>$user->auuid,
        ]));
        $profile = UserProfile::where('user_id', $user->id)->get()[0];
        $this->assertEquals($auuid, $profile->user->auuid);
    }
    public function testRoles()
    {
        $roles = ['HR','HQ','ROD','ZBM','ASM','MD','GeoMarketing','Information Technology'];
        foreach ($roles as $role) {
            factory(Role::class)->create(['name'=>$role]);
        }
        $this->assertDatabaseHas(
            'roles',
            [
            'name' => 'HR'
            ]
        );
    }
    public function testCountry()
    {
        factory(LocationCountry::class, 5)->create();
        $this->assertCount(5, LocationCountry::all());
    }
    /**
     * Create a country with the provided name
     *
     * @param string $name name
     *
     * @return collection model instance
     */
    public function createCountry($name='Nigeria')
    {
        $country = factory(LocationCountry::class)->create([
            'name'=>$name
        ]);
        return $country;
    }
    /**
     * Create a region with the provided name
     *
     * @param string $name name
     *
     * @return collection model instance
     */
    public function createRegion($name='LAGOS')
    {
        $country = $this->createCountry();
        $country->regions()->save(factory(LocationRegion::class)->make(['name'=>'LAGOS']));
    }
    public function testRegion()
    {
        $this->createRegion();
        $this->assertDatabaseHas(
            'location_regions',
            [
            'name' => 'LAGOS'
            ]
        );
    }
    /**
     * Create a zone with the provided name
     *
     * @param string $name name
     *
     * @return collection model instance
     */
    public function createZone($name='LAGOS COASTLINE')
    {
        $this->createRegion();
        $region = LocationRegion::where('name', 'LAGOS')->get()[0];
        $zone01 = factory(LocationZone::class)->make([
            'name'=>$name,
            'region_id'=>$region->id,
        ]);
        $region->zones()->save($zone01);
    }
    public function testZone()
    {
        $this->createZone();
        $this->assertCount(1, LocationZone::all());
    }
    /**
     * Create a state with the provided name
     *
     * @param string $name name
     *
     * @return collection model instance
     */
    public function createState($name='LAGOS')
    {
        $this->createZone();
        $zone = LocationZone::where('name', 'LAGOS COASTLINE')->get()[0];
        $state01 = factory(LocationState::class)->make([
            'name'=>'LAGOS'
        ]);
        $state02 = factory(LocationState::class)->make(
            [
            'name'=>'KOGI'
            ]
        );
        $state03 = factory(LocationState::class)->make([
            'name'=>'NASSARAWA'
        ]);
        $zone->states()->save($state01);
        $zone->states()->save($state02);
        $zone->states()->save($state03);
    }
    public function testState()
    {
        $this->createState();
        $this->assertCount(3, LocationState::all());
    }
    /**
     * Create an area with the provided name
     *
     * @param string $name name
     *
     * @return collection model instance
     */
    public function createArea($name='Lagos_Amuwo_Odofin')
    {
        $this->createState();
        $state = LocationState::where('name', 'LAGOS')->get()[0];
        $area01 = factory(LocationArea::class)->make([
            'name'=>'Lagos_Amuwo_Odofin'
        ]);
        $area02 = factory(LocationArea::class)->make([
            'name'=>'Lagos_Apapa'
        ]);
        $area03 = factory(LocationArea::class)->make([
            'name'=>'Lagos_Badagry'
        ]);
        $state->areas()->save($area01);
        $state->areas()->save($area02);
        $state->areas()->save($area03);
    }
    public function testArea()
    {
        $this->createArea();
        $this->assertCount(3, LocationArea::all());
    }
    public function createLga()
    {
        $this->createArea();
        $area = LocationArea::where('name', 'Lagos_Amuwo_Odofin')->get()[0];
        $lga01 = factory(LocationLga::class)->make(
            [
            'name'=>'AMUWOODOFIN',
            'lga_code'=>'LGA002'
            ]
        );
        $lga02 = factory(LocationLga::class)->make(
            [
                'name'=>'APAPA',
                'lga_code'=>'LGA003'
            ]
            );
        $area->lgas()->save($lga01);
        $area->lgas()->save($lga02);
    }
    public function testLga()
    {
        $this->createLga();
        $this->assertCount(2, LocationLga::all());
    }
    /**
     * Create a territory
     *
     * @return collection model instance
     */
    public function createTerritory()
    {
        $this->createLga();
        $lga = LocationLga::where('name', 'AMUWOODOFIN')->get()[0];
        $territory01 = factory(LocationTerritory::class)->make(
            [
                'name'=>'Md_Lagos_Abule_Odo',
                'territory_code'=>'NG.LA.AE.01',
            ]
        );
        $territory02 = factory(LocationTerritory::class)->make(
            [
                'name'=>'Md_Lagos_Festac',
                'territory_code'=>'NG.LA.FS.01',
            ]
        );
        $lga->territories()->save($territory01);
        $lga->territories()->save($territory02);
    }
    public function testTerritory()
    {
        $this->createTerritory();
        $this->assertCount(2, LocationTerritory::all());
    }
    public function createSite()
    {
        $this->createTerritory();
        $territory = LocationTerritory::where('name', 'Md_Lagos_Abule_Odo')->get()[0];
        $site01 = factory(LocationSite::class)->make(
            [
            'site_code'=>'site code two'
            ]
        );
        $site02 = factory(LocationSite::class)->make(
            [
            'site_code'=>'TES CODE'
            ]
        );
        $territory->sites()->save($site01);
        $territory->sites()->save($site02);
    }
    public function testSite()
    {
        $this->createSite();
        $this->assertCount(2, LocationSite::all());
    }
    public function testSiteHasTerritory()
    {
        $this->createSite();
        $site = LocationSite::where('site_code', 'TES CODE')->get()[0];
        $this->assertTrue($site->territory()->exists());
    }
    public function testCountryHasZones()
    {
        $this->createSite();
        $country = LocationCountry::where('name', 'Nigeria')->get()[0];
        $this->assertCount(1, $country->zones);
    }
    public function testRegionHasCountry()
    {
        $this->createRegion();
        $region = LocationRegion::where('name', 'LAGOS')->get()[0];
        $country = $region->country()->get()[0];
        $this->assertEquals($country->name, 'Nigeria');
    }
    public function testRegionHasZones()
    {
        $this->createZone();
        $region = LocationRegion::where('name', 'LAGOS')->get()[0];
        $region->zones()->save(factory(LocationZone::class)->make());
        $this->assertCount(2, $region->zones);
    }
    public function testRegionHasStates()
    {
        $this->createZone();
        $region = LocationRegion::where('name', 'LAGOS')->get()[0];
        $zones = $region->zones;
        $zones[0]->states()->save(factory(LocationState::class)->make());
        $zones[0]->states()->save(factory(LocationState::class)->make());
        $this->assertCount(2, $region->states);
    }
    public function testTargets()
    {
        $faker = Faker::create('en_NG');
        $auuid = $faker->randomNumber($nbDigits = 7);
        $user = factory(User::class)->create(
            [
            'auuid'=>$auuid,
            ]
        );
        factory(Target::class)->create(
            [
                'tag'=>'Test Target One',
                'user_id'=>$user->id,
                'owner'=>$user->auuid
            ]
        );
        $this->assertDatabaseHas(
            'targets',
            [
            'tag' => 'Test Target One'
            ]
        );
    }
}
