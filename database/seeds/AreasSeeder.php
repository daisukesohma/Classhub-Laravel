<?php

use Illuminate\Database\Seeder;

class AreasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $areas = [
            [
                'type' => 'location',
                'address' => 'All Dublin',
                'state' => 'Dublin',
                'country' => 'Ireland'
            ], [
                'type' => 'location',
                'address' => 'North Dublin',
                'state' => 'Dublin',
                'country' => 'Ireland'
            ], [
                'type' => 'location',
                'address' => 'South Dublin',
                'state' => 'Dublin',
                'country' => 'Ireland'
            ], [
                'type' => 'location',
                'address' => 'West Dublin',
                'state' => 'Dublin',
                'country' => 'Ireland'
            ],/* [
                'type' => 'location',
                'address' => 'Antrim',
                'state' => 'Antrim',
                'country' => 'Ireland'
            ],[
                'type' => 'location',
                'address' => 'Armagh',
                'state' => 'Armagh',
                'country' => 'Ireland'
            ],*/[
                'type' => 'location',
                'address' => 'Carlow',
                'state' => 'Carlow',
                'country' => 'Ireland'
            ],[
                'type' => 'location',
                'address' => 'Cavan',
                'state' => 'Cavan',
                'country' => 'Ireland'
            ],[
                'type' => 'location',
                'address' => 'Clare',
                'state' => 'Clare',
                'country' => 'Ireland'
            ],[
                'type' => 'location',
                'address' => 'Cork',
                'state' => 'Cork',
                'country' => 'Ireland'
            ],/*[
                'type' => 'location',
                'address' => 'Derry',
                'state' => 'Derry',
                'country' => 'Ireland'
            ],*/[
                'type' => 'location',
                'address' => 'Donegal',
                'state' => 'Donegal',
                'country' => 'Ireland'
            ],/*[
                'type' => 'location',
                'address' => 'Down',
                'state' => 'Down',
                'country' => 'Ireland'
            ],[
                'type' => 'location',
                'address' => 'Fermanagh',
                'state' => 'Fermanagh',
                'country' => 'Ireland'
            ],*/[
                'type' => 'location',
                'address' => 'Galway',
                'state' => 'Galway',
                'country' => 'Ireland'
            ],[
                'type' => 'location',
                'address' => 'Kerry',
                'state' => 'Kerry',
                'country' => 'Ireland'
            ],[
                'type' => 'location',
                'address' => 'Kildare',
                'state' => 'Kildare',
                'country' => 'Ireland'
            ],[
                'type' => 'location',
                'address' => 'Kilkenny',
                'state' => 'Kilkenny',
                'country' => 'Ireland'
            ],[
                'type' => 'location',
                'address' => 'Laois',
                'state' => 'Laois',
                'country' => 'Ireland'
            ],[
                'type' => 'location',
                'address' => 'Leitrim',
                'state' => 'Leitrim',
                'country' => 'Ireland'
            ],[
                'type' => 'location',
                'address' => 'Limerick',
                'state' => 'Limerick',
                'country' => 'Ireland'
            ],[
                'type' => 'location',
                'address' => 'Longford',
                'state' => 'Longford',
                'country' => 'Ireland'
            ],[
                'type' => 'location',
                'address' => 'Louth',
                'state' => 'Louth',
                'country' => 'Ireland'
            ],[
                'type' => 'location',
                'address' => 'Mayo',
                'state' => 'Mayo',
                'country' => 'Ireland'
            ],[
                'type' => 'location',
                'address' => 'Meath',
                'state' => 'Meath',
                'country' => 'Ireland'
            ],[
                'type' => 'location',
                'address' => 'Monaghan',
                'state' => 'Monaghan',
                'country' => 'Ireland'
            ],[
                'type' => 'location',
                'address' => 'Offaly',
                'state' => 'Offaly',
                'country' => 'Ireland'
            ],[
                'type' => 'location',
                'address' => 'Roscommon',
                'state' => 'Roscommon',
                'country' => 'Ireland'
            ],[
                'type' => 'location',
                'address' => 'Sligo',
                'state' => 'Sligo',
                'country' => 'Ireland'
            ],[
                'type' => 'location',
                'address' => 'Tipperary',
                'state' => 'Tipperary',
                'country' => 'Ireland'
            ],/*[
                'type' => 'location',
                'address' => 'Tyrone',
                'state' => 'Tyrone',
                'country' => 'Ireland'
            ],*/[
                'type' => 'location',
                'address' => 'Waterford',
                'state' => 'Waterford',
                'country' => 'Ireland'
            ],[
                'type' => 'location',
                'address' => 'Westmeath',
                'state' => 'Westmeath',
                'country' => 'Ireland'
            ],[
                'type' => 'location',
                'address' => 'Wexford',
                'state' => 'Wexford',
                'country' => 'Ireland'
            ],[
                'type' => 'location',
                'address' => 'Wicklow',
                'state' => 'Wicklow',
                'country' => 'Ireland'
            ],
        ];
        
        foreach ($areas as $area) {
            try {
                \App\Area::firstOrCreate(['address' => $area['address']], $area);
            } catch (\Exception $e) {
                dump($e->getMessage());
            }
        }
        
    }
}
