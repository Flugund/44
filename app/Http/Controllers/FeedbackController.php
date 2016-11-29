<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Feedback;
use DB;

class FeedbackController extends Controller
{
    public function index(Request $request, Feedback $feedback) 
    {
        $userLongitudeMin = $request->get('longitude_min');
        $userLatitudeMin = $request->get('latitude_min');

        $userLongitudeMax = $request->get('longitude_max');
        $userLatitudeMax = $request->get('latitude_max');

        $feedbacks = DB::select('call return_feedbacks(?,?,?,?)', [$userLongitudeMin, $userLatitudeMin, $userLongitudeMax, $userLatitudeMax]); // TODO: Find out the procuedure name!

        return response()->json($feedbacks);
    }

    public function store(Request $request, Feedback $feedback)
    {
        return $feedback->create($request->all());
    }

    public function update($id, Feedback $feedback)
    {
        return $feedback->find($id)->update($request->all());
    }
}
