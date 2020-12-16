<?php

namespace App\Http\Controllers;

use App\Place;

class PlaceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function show($slug)
    {
        $place = (new Place())->getOne($slug);
        if ($place === false) {
            abort(404);
        }
        $place->slug = $slug;


        //Sort insee object data on each zone map
        $insee = $place->data->insee;
        foreach ($insee as $zone => $datas) {
          foreach ($datas as $key => $data) {
            $place->data->insee->{$zone}->{$key} = $this->sortDataInsee($data);
          }
        }

        if(property_exists($place->data, 'activites') === false) {
            throw new \LogicException("Pas de données sur les activitiés. Verifiez le json.", 1);
        }

        return view('place.show', compact('place'));
    }

    public function list(Place $place, $sortBy = null)
    {
        $places = $place->getList();

        $coordinates = $places->mapWithKeys(function ($item, $key) {
            return [$item->url => ['geo' => ['lat' => $item->lat, 'lon' => $item->lon]]];
        });

        if(isset($sortBy)){
          $place->sortNumericPlacesBy($sortBy);
          $selected = explode('-', $sortBy)[1];
        }else{
          $place->sortPlacesBy('name');
          $selected = "default_az";
        }

        return view('places', compact('places', 'coordinates', 'selected'));
    }

    protected function sortDataInsee($inseeData){
      $inseeDataArray = (array) $inseeData;
      $keys = array_keys($inseeDataArray);
      usort($inseeDataArray, function($a, $b)
      {
        return strcasecmp($a->title, $b->title);
      });
      return (object)$inseeDataArray;
    }

    protected function sortComposition($composition){
      $compositionArray = (array) $composition;
      $keys = array_keys($compositionArray);
      usort($compositionArray, function($a, $b)
      {
        if ($a->nombre == $b->nombre) {
            return 0;
        }
        return ($a->nombre > $b->nombre) ? -1 : 1;


      });
      return (object)$compositionArray;
    }
}
