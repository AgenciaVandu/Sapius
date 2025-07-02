<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Landing\Pride;
use App\Models\Landing\Slide;
use App\Models\Landing\Teacher;

class SortController extends Controller
{
    public function teachers(Request $request){
        $position = 1;

        $sorts = $request->get('teachers');
        foreach ($sorts as $sort) {
            $teacher = Teacher::find($sort);
            $teacher->position = $position;
            $teacher->save();
            $position++;
        }
    }

    public function prides(Request $request){
        $position = 1;

        $sorts = $request->get('prides');
        foreach ($sorts as $sort) {
            $pride = Pride::find($sort);
            $pride->position = $position;
            $pride->save();
            $position++;
        }
    }

    public function slides(Request $request){
        $position = 1;

        $sorts = $request->get('slides');
        foreach ($sorts as $sort) {
            $slide = Slide::find($sort);
            $slide->position = $position;
            $slide->save();
            $position++;
        }
    }
}
