<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FeedbackCategory;

class FeedbackCategoryController extends Controller
{
    public function index(FeedbackCategory $feedbackCategory)
    {
        $feedbackCategories = $feedbackCategory->all();

        return response()->json($feedbackCategories);
    }
}
