<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //obtiene la lista de edificios registrados en el sistema que no han sido borrados
        $buildings = Building::where('deleted_at', NULL)->get();
        if($buildings->isEmpty()){
            return ['No se encontraron edificios en el sistema'];
        }

        return response()->json($buildings);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:buildings,deleted_at,NULL'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0,'message' => 'Error en la validación', 'errors' => $validator->errors()], 422);
        }

        $building = Building::create([
            'name' => $request->name
        ]);

        return response()->json([
            'message' => 'Edificio Creado exitosamente', 'edificio' => $building
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:buildings,deleted_at,NULL'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0,'message' => 'Error en la validación', 'errors' => $validator->errors()], 422);
        }

        $building = Building::find($id);
        $building->update($request->all());

        return response()->json([
            'message' => 'Edificio Actualizado exitosamente', 'edificio' => $building
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = Building::destroy($id);
        if($response){
            return response()->json([
                'message' => 'Edificio Eliminado exitosamente'
            ], 200);
        }
        else{
            return ['No se encontró el edificio'];
        }
    }
}
