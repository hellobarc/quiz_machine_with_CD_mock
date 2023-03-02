<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\Category;

class LevelTestController extends Controller
{
    public function levelTest()
    {
        $category = Category::where('name', '=', 'Level Testing')->first();
        $exams = Exam::where('category_id', $category->id)->get();
        return view('frontend.level_test.level_test_info', compact('exams'));
    }
    public function levelTestAdult()
    {

    }
}
