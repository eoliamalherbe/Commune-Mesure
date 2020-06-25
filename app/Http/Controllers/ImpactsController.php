<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\PopulationChart;
use App\Charts\ActivitiesChart;
use App\Charts\ActivitiesOverlayChart;
use App\Charts\LogementChart;
use App\Place;

class ImpactsController extends Controller
{
    public function show(Place $place)
    {
        [$coordinates,$cities, $places] = $place->all();
        return view('impacts.show', compact('coordinates', 'cities', 'places'));
    }

    public function statistics(Place $place)
    {
        [$coordinates,$cities, $places] = $place->all();
        $plots[] = (new ActivitiesOverlayChart('chart-overlay', 'bar'))->build(
            (array) [$cities['Paris'][0]['data_chart']->population, $cities['Paris'][1]['data_chart']->population]
        );
        return view('impacts.statistics', compact('coordinates', 'cities', 'plots', 'places'));
    }

    public function datas(Place $place)
    {
        [$coordinates,$cities, $places] = $place->all();
        return view('impacts.datas', compact('coordinates', 'cities', 'places'));
    }
}
