<?php

namespace App\Http\Controllers;

use App\Models\mensaje;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class mensajesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
*/

public function index()
{

    $url = env('URL_SERVER_API', 'http://127.0.0.1:8000/api/');

    $response =  Http::get($url.'mensajes');

    $data = $response->json();

    return view('mensajes.index', compact('data'));

}


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('mensajes.create', compact('users') );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
   /*      $mensajes = new mensaje();
        $mensajes->nombre_chat = $request->nombre_chat;
        $mensajes->user_id=$request->user_id;
        $mensajes->save();
        return Redirect()->route('mensajes.index',$mensajes); */
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
    public function edit( $mensaje)
    {
        $users = User::all(); 
        return view('mensajes.edit', compact('mensaje', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $mensaje)
    {
        $mensaje->nombre_chat = $request->nombre_chat;
        $mensaje->user_id=$request->user_id;
        $mensaje->save();
        return redirect()->route('mensajes.index')->with('success', 'Registro actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      /*   $mensaje = mensaje::find($id)->delete(); */

        return redirect()->route('mensajes.index')->with('success', 'Usuario eliminado exitosamente');
    }
}
