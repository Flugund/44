<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class AreaController extends Controller
{
    public function index(Request $request) 
    {
        $userLongitudeMin = $request->get('longitude_min');
        $userLatitudeMin = $request->get('latitude_min');

        $userLongitudeMax = $request->get('longitude_max');
        $userLatitudeMax = $request->get('latitude_max');

        $areas = DB::select('exec return_area_score(?,?,?,?)', [$userLongitudeMin, $userLatitudeMin, $userLongitudeMax, $userLatitudeMax]); 

        return response()->json($areas);
    }
}
