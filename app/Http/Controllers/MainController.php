<?php

namespace App\Http\Controllers;

use App\Place;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function map(Place $place)
    {
        [$coordinates,$cities,$meters, $totalmeters,$total_etp] = $place->withPopup()->all();
        return view('home', compact('coordinates', 'cities','meters','totalmeters','total_etp'));
    }

    public function places(Place $place)
    {
        [$coordinates] = $place->all();
        $place->sortPlacesBy('name');
        $places = $place->getPlaces();
        return view('places', compact('coordinates', 'places'));
    }
}
