<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Feedback;
use DB;

class FeedbackController extends Controller
{
    public function score(Request $request)
    {
        $long = $request->get('longitude');
        $lat = $request->get('latitude');

        $feedbacks = DB::select('call get_location_score(?, ?)', [$long, $lat]);

        return response()->json($feedbacks);
    }

    public function index(Request $request, Feedback $feedback)
    {
        $userLongitudeMin = $request->get('longitude_min');
        $userLatitudeMin = $request->get('latitude_min');

        $userLongitudeMax = $request->get('longitude_max');
        $userLatitudeMax = $request->get('latitude_max');

        $status = $request->has('status') ? $request->get('status') : 2;

        $feedbacks = DB::select('call get_status_feedbacks(?,?,?,?,?)', [$userLongitudeMin, $userLatitudeMin, $userLongitudeMax, $userLatitudeMax, $status]);

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
