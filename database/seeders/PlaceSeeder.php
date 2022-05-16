<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Place;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Place::truncate();
        $places = Place::factory()->count(5)->create();

        $impact = $places->map(function ($place) {
            $item = clone $place;
            $item->type_donnees = 'impact';
            $item->data = '{}';

            return $item;
        });

        Place::insert($impact->toArray());
    }
}
