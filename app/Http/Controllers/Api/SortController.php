<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ManageableGuiaMedicine;
use App\ManageableGuiaNutrition;
use App\ManageableSimulatorMedicine;
use App\ManageableSimulatorNutrition;
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

    public function manageableSimulatorMedicine(Request $request){
        $position = 1;

        $sorts = $request->get('simulatormedicines');
        foreach ($sorts as $sort) {
            $medicine = ManageableSimulatorMedicine::find($sort);
            $medicine->position = $position;
            $medicine->save();
            $position++;
        }
    }


    public function manageableSimulatorNutrition(Request $request){
        $position = 1;

        $sorts = $request->get('simulatornutritions');
        foreach ($sorts as $sort) {
            $nutrition = ManageableSimulatorNutrition::find($sort);
            $nutrition->position = $position;
            $nutrition->save();
            $position++;
        }
    }

    public function manageableGuiasMedicine(Request $request){
        $position = 1;

        $sorts = $request->get('guiamedicines');
        foreach ($sorts as $sort) {
            $guiamedicines = ManageableGuiaMedicine::find($sort);
            $guiamedicines->position = $position;
            $guiamedicines->save();
            $position++;
        }
    }

    public function manageableGuiasNutrition(Request $request){
        $position = 1;

        $sorts = $request->get('guianutritions');
        foreach ($sorts as $sort) {
            $nutrition = ManageableGuiaNutrition::find($sort);
            $nutrition->position = $position;
            $nutrition->save();
            $position++;
        }
    }
}