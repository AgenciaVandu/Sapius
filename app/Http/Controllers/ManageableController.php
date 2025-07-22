<?php

namespace App\Http\Controllers;

use App\Manageable;
use App\ManageableGuiaMedicine;
use App\ManageableGuiaNutrition;
use App\ManageableSimulatorMedicine;
use App\ManageableSimulatorNutrition;
use Illuminate\Http\Request;

class ManageableController extends Controller
{
    public function index(){
        $manageable_simulator_medicine = ManageableSimulatorMedicine::orderBy('position','desc')->get();
        $manageable_simulator_nutrition = ManageableSimulatorNutrition::all();
        $manageable_guia_medicine = ManageableGuiaMedicine::all();
        $manageable_guia_nutrition = ManageableGuiaNutrition::all();
        return view('admin.manageable.index',compact('manageable_simulator_medicine','manageable_simulator_nutrition','manageable_guia_medicine','manageable_guia_nutrition'));
    }


    public function store(Request $request)
    {
        //Filtramos logica para cada uno de los formularios que mandamos desde admin.manageable.index
        if ($request->type == 'simuladores') {
            if ($request->category == 'medicina') {
                try {
                    //Obtenemos la url de la imagen
                /* $imageUrl = $request->file('image')->store('simuladores', 'public'); */
                //Realizamos la carga de la informacion en la base de datos en el modelo Manageable
                ManageableSimulatorMedicine::create([
                    'titulo' => $request->titulo,
                    'descripcion' => $request->descripcion,
                    /* 'image' => $imageUrl, */
                    'type' => $request->type,
                    'category' => $request->category,
                ]);
                } catch (\Throwable $th) {
                    throw $th;
                }
            }else{
                try {
                    //Obtenemos la url de la imagen
                /* $imageUrl = $request->file('image')->store('simuladores', 'public'); */
                //Realizamos la carga de la informacion en la base de datos en el modelo Manageable
                ManageableSimulatorNutrition::create([
                    'titulo' => $request->titulo,
                    'descripcion' => $request->descripcion,
                    /* 'image' => $imageUrl, */
                    'type' => $request->type,
                    'category' => $request->category,
                ]);
                } catch (\Throwable $th) {
                    throw $th;
                }
            }
        }else{
            if ($request->category == 'medicina') {
                try {
                    //Obtenemos la url de la imagen
               /*  $imageUrl = $request->file('image')->store('guias', 'public'); */
                //Realizamos la carga de la informacion en la base de datos en el modelo Manageable
                ManageableGuiaMedicine::create([
                    'titulo' => $request->titulo,
                    'descripcion' => $request->descripcion,
                    /* 'image' => $imageUrl, */
                    'type' => $request->type,
                    'category' => $request->category,
                ]);
                } catch (\Throwable $th) {
                    throw $th;
                }
            }else{
                try {
                    //Obtenemos la url de la imagen
                /* $imageUrl = $request->file('image')->store('guias', 'public'); */
                //Realizamos la carga de la informacion en la base de datos en el modelo Manageable
                ManageableGuiaNutrition::create([
                    'titulo' => $request->titulo,
                    'descripcion' => $request->descripcion,
                    /* 'image' => $imageUrl, */
                    'type' => $request->type,
                    'category' => $request->category,
                ]);
                } catch (\Throwable $th) {
                    throw $th;
                }
            }
        }
    return back();
    }

    public function update(Request $request)
    {

        //Filtramos logica para cada uno de los formularios que mandamos desde admin.manageable.index
        if ($request->type == 'simuladores') {
            if ($request->category == 'medicina') {
                try {
                    //Obtenemos la url de la imagen
                /* $imageUrl = $request->file('image')->store('simuladores', 'public'); */
                //Realizamos la carga de la informacion en la base de datos en el modelo Manageable
                $manageable_simulator_medicine = ManageableSimulatorMedicine::find($request->id);
                $manageable_simulator_medicine->update([
                    'titulo' => $request->titulo,
                    'descripcion' => $request->descripcion,
                    /* 'image' => $imageUrl, */
                ]);
                } catch (\Throwable $th) {
                    throw $th;
                }
            }else{
                try {
                    //Obtenemos la url de la imagen
                /* $imageUrl = $request->file('image')->store('simuladores', 'public'); */
                //Realizamos la carga de la informacion en la base de datos en el modelo Manageable
                $manageable_simulator_nutrition = ManageableSimulatorNutrition::find($request->id);
                $manageable_simulator_nutrition->update([
                    'titulo' => $request->titulo,
                    'descripcion' => $request->descripcion,
                    /* 'image' => $imageUrl, */
                ]);
                } catch (\Throwable $th) {
                    throw $th;
                }
            }
        }else{
            if ($request->category == 'medicina') {
                try {
                    //Obtenemos la url de la imagen
               /*  $imageUrl = $request->file('image')->store('guias', 'public'); */
                //Realizamos la carga de la informacion en la base de datos en el modelo Manageable
                $manageable_guia_medicine = ManageableGuiaMedicine::find($request->id);
                $manageable_guia_medicine->update([
                    'titulo' => $request->titulo,
                    'descripcion' => $request->descripcion,
                    /* 'image' => $imageUrl, */
                ]);
                } catch (\Throwable $th) {
                    throw $th;
                }
            }else{
                try {
                    //Obtenemos la url de la imagen
                /* $imageUrl = $request->file('image')->store('guias', 'public'); */
                //Realizamos la carga de la informacion en la base de datos en el modelo Manageable
                $manageable_guia_nutrition = ManageableGuiaNutrition::find($request->id);
                $manageable_guia_nutrition->update([
                    'titulo' => $request->titulo,
                    'descripcion' => $request->descripcion,
                    /* 'image' => $imageUrl, */
                ]);
                } catch (\Throwable $th) {
                    throw $th;
                }
            }
        }
    return back();
    }

    public function deleteManageablesimulatormedicine($id)
    {
        $manageable_simulator_medicine = ManageableSimulatorMedicine::find($id);
        $manageable_simulator_medicine->delete();

        return back();
    }
    public function deleteManageablesimulatornutrition($id)
    {
        $manageable_simulator_nutrition = ManageableSimulatorNutrition::find($id);
        $manageable_simulator_nutrition->delete();

        return back();
    }
    public function deleteManageableguiamedicine($id)
    {
        $manageable_guia_medicine = ManageableGuiaMedicine::find($id);
        $manageable_guia_medicine->delete();

        return back();
    }

    public function deleteManageableguianutrition($id)
    {
        $manageable_guia_nutrition = ManageableGuiaNutrition::find($id);
        $manageable_guia_nutrition->delete();

        return back();
    }

}