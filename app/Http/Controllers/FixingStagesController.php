<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FixingStages;

class FixingStagesController extends Controller
{
    public function index(FixingStages $fixingStages)
    {
        $fixingStages = $fixingStages->all();
        
        return response()->json($fixingStages);
    }
}
