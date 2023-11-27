<?php

namespace App\Http\Controllers;

use App\Models\pqr;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class pqrsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $url = env('URL_SERVER_API', 'http://127.0.0.1:8000/api/');

        $response =  Http::get($url.'pqrs');

        $data = $response->json();

        return view('pqrs.index', compact('data'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usuarios = User::all(); // Obtén la lista de usuarios registrados
    
        return view('pqrs.create', compact('usuarios'));
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        try {
            $url = env('API_URL', 'http://127.0.0.1:8000/api/'); // Ajusta la URL según tu configuración
    
            $response = Http::post($url . 'pqrs/store', [
                'user_id' => $request->user_id,
                'motivo' => $request->motivo,
                'tipo' => $request->tipo,
            ]);
    
            // Verificar si la solicitud fue exitosa
            if ($response->successful()) {
                // La solicitud fue exitosa
                return redirect()->route('pqrs.index');
            } else {
                // La solicitud no fue exitosa, manejar el error
                return view('error')->with('error', 'Error al enviar la PQRS a la API.');
            }
        } catch (\Exception $e) {
            // Capturar cualquier excepción
            return view('error')->with('error', 'Error al realizar la solicitud a la API.');
        }
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  // Obtener datos para editar
  public function edit($id)
  {

      $url = env('URL_SERVER_API', 'http://127.0.0.1:8000/api/');

      $response = Http::get($url . 'pqrs/edit/' . $id);

      if ($response->successful()) {
          $pqr = $response->json();

          // Obtener todos los season disponibles
          $userResponse = Http::get($url . 'users');
          $users = $userResponse->json();

          $user_id = $pqr['user_id']; // Establecer el season actual del usuario

          return view('pqrs.edit', compact('pqr', 'users', 'user_id'));
      } else {
          // Manejo de error si la solicitud a la API no tiene éxito
          return redirect()->back()->with('error', 'No se pudo obtener los datos del usuario');
      } 
  }

// Actualizar datos
public function update(Request $request, $id)
{
    try {
        // Realizar solicitud PUT a la API para actualizar el PQRS
        $response = Http::put(env('URL_SERVER_API') . 'pqrs/update/' . $id, [
            'user_id' => $request->user_id,
            'motivo' => $request->motivo,
            'tipo' => $request->tipo,
            // ... otros campos
        ]);

        if ($response->successful()) {
            // Redirigir a la página principal o a la que consideres
            return redirect()->route('pqrs.index')->with('success', 'Registro actualizado correctamente');
        } else {
            // Manejar el error si la solicitud a la API no es exitosa
            return view('error')->with('error', 'Error al actualizar el PQRS en la API.');
        }
    } catch (\Exception $e) {
        // Capturar cualquier excepción
        return view('error')->with('error', 'Error al realizar la solicitud a la API: ' . $e->getMessage());
    }
}

    
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
 
     public function destroy($pqr)
     {
         $url = env('URL_SERVER_API', 'http://127.0.0.1:8000/api/');
         
         // Envia el parámetro $pqr como parte de la URL
         $response = Http::delete($url . 'pqrs/destroy/' . $pqr);
     
         return redirect()->route('pqrs.index');
     }
}
