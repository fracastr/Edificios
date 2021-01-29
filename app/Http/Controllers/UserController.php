<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //obtiene la lista de usuarios registrados en el sistema que no han sido borrados
        $users = User::where('deleted_at', NULL)->get();
        if($users->isEmpty()){
            return ['No se encontraron usuarios en el sistema'];
        }

        return response()->json($users);
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
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,deleted_at,NULL',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0,'message' => 'Error en la validación', 'errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return response()->json([
            'message' => 'Usuario Creado exitosamente', 'user' => $user
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
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,deleted_at,NULL'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0,'message' => 'Error en la validación', 'errors' => $validator->errors()], 422);
        }

        $user = User::find($id);
        $user->update($request->all());

        return response()->json([
            'message' => 'Usuario Actualizado exitosamente', 'user' => $user
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
        $response = User::destroy($id);
        if($response){
            return response()->json([
                'message' => 'Usuario Eliminado exitosamente'
            ], 200);
        }
        else{
            return ['No se encontró el usuario'];
        }
    }
}
