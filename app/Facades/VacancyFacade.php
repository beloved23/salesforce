<?php
namespace App\Facades;

use App\Models\LocationRegion;
use App\Models\LocationZone;
use App\Models\LocationArea;
use App\Models\LocationTerritory;
use App\Models\Vacancy;
use App\Models\User;
use App\Models\RodProfile;
use App\Models\ZbmProfile;
use App\Models\AsmProfile;
use App\Models\MdProfile;

class VacancyFacade
{
    public function sync()
    {
        //truncate table before synchronization
        Vacancy::truncate();
        //check all regions
        $regions = LocationRegion::all();
        foreach ($regions as $region) {
            if (is_null($region->rodByLocation)) {
                // Retrieve vacancy by model and id , or create it with the id,model,name and code attributes...
                $vacancy = Vacancy::firstOrCreate(
            ['location_model' => 'App\Models\LocationRegion',
            'location_id'=>$region->id,
            ],
            ['location_id' => $region->id,
            'location_model' => 'App\Models\LocationRegion',
            'location_name'=>$region->name,
            'location_code'=>$region->region_code,
            'required_profile'=>'ROD'
            ]
            );
            }
        }
        //check all zones
        $zones = LocationZone::all();
        foreach ($zones as $zone) {
            if (is_null($zone->zbmByLocation)) {
                // Retrieve vacancy by model and id , or create it with the id,model,name and code attributes...
                $vacancy = Vacancy::firstOrCreate(
                    ['location_model' => 'App\Models\LocationZone',
                    'location_id'=>$zone->id,
                    ],
                    ['location_id' => $zone->id,
                    'location_model' => 'App\Models\LocationZone',
                    'location_name'=>$zone->name,
                    'location_code'=>$zone->zone_code,
                    'required_profile'=>'ZBM'
                    ]
                    );
            }
        }
        //check all areas
        $areas = LocationArea::all();
        foreach ($areas as $area) {
            if (is_null($area->asmByLocation)) {
                // Retrieve vacancy by model and id , or create it with the id,model,name and code attributes...
                $vacancy = Vacancy::firstOrCreate(
    ['location_model' => 'App\Models\LocationArea',
    'location_id'=>$area->id,
    ],
    ['location_id' => $area->id,
    'location_model' => 'App\Models\LocationArea',
    'location_name'=>$area->name,
    'location_code'=>$area->area_code,
    'required_profile'=>'ASM'
    ]
    );
            }
        }
        // check all territories
        $territories = LocationTerritory::all();
        $territoriesCount  =0;
        foreach ($territories as $territory) {
            if (is_null($territory->mdByLocation)) {
                // Retrieve vacancy by model and id , or create it with the id,model,name and code attributes...
                $vacancy = Vacancy::firstOrCreate(
    ['location_model' => 'App\Models\LocationTerritory',
    'location_id'=>$territory->id,
    ],
    ['location_id' => $territory->id,
    'location_model' => 'App\Models\LocationTerritory',
    'location_name'=>$territory->name,
    'location_code'=>$territory->territory_code,
    'required_profile'=>'MD'
    ]
    );
            }
        }
    }
    public function report($userId)
    {
        $user = User::find($userId);
        $vacancies = collect();
        if ($user->hasRole('ROD')) {
            //retrieve rod profile
            $rod = RodProfile::where('user_id', $userId)->get();
            if ($rod->count() > 0) {
                //retrieve zones of rod
                $zones = $rod[0]->zones;
            }
        } elseif ($user->hasRole('ZBM')) {
            $zbm  = ZbmProfile::where('user_id', $userId)->get();
            $zones = LocationZone::where('id', $zbm[0]->zone_id)->get();
        }
        if ($user->hasRole('ROD') || $user->hasRole('ZBM')) {
            foreach ($zones as $zone) {
                //check vacant zone
                if (is_null($zone->zbmByLocation)) {
                    $vacant_zone =  array('location_id' => $zone->id,
                        'location_model' => 'App\Models\LocationZone',
                        'location_name'=>$zone->name,
                        'location_code'=>$zone->zone_code,
                        'required_profile'=>'ZBM'
                        );
                    $vacancies = $vacancies->concat([$vacant_zone]);
                }
                //retrieve all area under zone
                $areas = $zone->areas;
                foreach ($areas as $area) {
                    //check vacant area
                    if (is_null($area->asmByLocation)) {
                        // Retrieve vacancy by model and id , or create it with the id,model,name and code attributes...
                        $vacant_area =
                ['location_id' => $area->id,
                'location_model' => 'App\Models\LocationArea',
                'location_name'=>$area->name,
                'location_code'=>$area->area_code,
                'required_profile'=>'ASM'
            ];
                        $vacancies = $vacancies->concat([$vacant_area]);
                    }
                    //retrieve all territories under area
                    $territories = $area->territories;
                    foreach ($territories as $territory) {
                        if (is_null($territory->mdByLocation)) {
                            // Retrieve vacancy by model and id , or create it with the id,model,name and code attributes...
                            $vacanct_territory =
                ['location_id' => $territory->id,
                'location_model' => 'App\Models\LocationTerritory',
                'location_name'=>$territory->name,
                'location_code'=>$territory->territory_code,
                'required_profile'=>'MD'
                        ];
                            $vacancies = $vacancies->concat([$vacanct_territory]);
                        }
                    }
                }
            }
        }
        //else for other roles
        elseif ($user->hasRole('ASM')) {
            $asmProfile = AsmProfile::where('user_id', $userId)->get();
            $territories = $asmProfile[0]->area->territories;
            foreach ($territories as $territory) {
                if (is_null($territory->mdByLocation)) {
                    // Retrieve vacancy by model and id , or create it with the id,model,name and code attributes...
                    $vacanct_territory =
        ['location_id' => $territory->id,
        'location_model' => 'App\Models\LocationTerritory',
        'location_name'=>$territory->name,
        'location_code'=>$territory->territory_code,
        'required_profile'=>'MD'
                ];
                    $vacancies = $vacancies->concat([$vacanct_territory]);
                }
            }
        }
        $vacancies_str = json_encode($vacancies);
        $vacancies = json_decode($vacancies_str);
        return $vacancies;
    }
}
