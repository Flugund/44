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

        $feedbacks = $feedback->where('longitude', '>', $userLongitude - $userMaxRadius)
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
