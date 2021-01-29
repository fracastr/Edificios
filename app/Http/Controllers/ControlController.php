<?php

namespace App\Http\Controllers;

use App\Models\Control;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ControlController extends Controller
{
    public function in(Request $request){
        //guarda una entrada
        $validator = Validator::make($request->all(), [
            'block_list' => 'required|string',
            'type' => 'required|string|in:in',
            'user_id' => 'required|exists:users,id,deleted_at,NULL',
            'building_id' => 'required|exists:buildings,id,deleted_at,NULL'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0,'message' => 'Error en la validación', 'errors' => $validator->errors()], 422);
        }

        $control = Control::create($request->all());

        return response()->json([
            'message' => 'Ingreso Creado exitosamente', 'ingreso' => $control
        ], 201);
    }

    public function out(Request $request){
        //guarda una entrada
        $validator = Validator::make($request->all(), [
            'block_list' => 'required|string',
            'type' => 'required|string|in:out',
            'user_id' => 'required|exists:users,id,deleted_at,NULL',
            'building_id' => 'required|exists:buildings,id,deleted_at,NULL'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0,'message' => 'Error en la validación', 'errors' => $validator->errors()], 422);
        }

        $control = Control::create($request->all());

        return response()->json([
            'message' => 'Salida Creada exitosamente', 'salida' => $control
        ], 201);
    }

    public function controls(){
        $controls = Control::with('building')->with('user')->get();

        return response()->json($controls);
    }
}
