<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index(Request $request, Feedback $feedback) 
    {
        $userLongitude = $request->get('longitue');
        $userLatitude = $request->get('latitude');
        $userMaxRadius = $request->get('radius');

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;

        $feedbacks = $feedback->where('longitude', '>', $userLongitude - $userMaxRadiusDegree)
                ->where('longitude', '<', $userLongitude + $userMaxRadius)
                ->where('latitude', '>', $userLatitude - $userMaxRadius)
                ->where('latitude', '<', $userLatitude + $userMaxRadius)
                ->get();

        return response()->json($feedbacks);
    }

    public function store(Request $request)
    {

    }

    public function update()
    {

    }
}
