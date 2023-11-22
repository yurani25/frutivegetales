<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\producto;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Http;


class productosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $url = env('URL_SERVER_API', 'http://127.0.0.1:8000/api/');

        $response =  Http::get($url.'productos');

        $data = $response->json();

        return view('productos.index', compact('data'));

    }

 public function catalogo()
{
    return view('index');
}

    public function create()
    {
        $url = env('URL_SERVER_API', 'http://127.0.0.1:8000/api/');
        
        // Obtener productos desde la API
        $responseProductos = Http::get($url . 'productos');
        $productos = $responseProductos->json();
        
        // Obtener temporadas desde la API
        $responseusers = Http::get($url . 'users');
        
        // Verificar si la respuesta es exitosa y obtener los datos
        $users = $responseusers->successful() ? $responseusers->json() : null;
        
        return view('productos.create', ['productos' => $productos, 'users' => $users]);
    }
    
    


    public function store(Request $request)
    {
        try {
            $url = env('URL_SERVER_API', 'http://127.0.0.1:8000/api/');
    
            $response = Http::post($url.'productos/store', [
                'nombres' => $request->nombres,
                'tiempo_reclamo' => $request->tiempo_reclamo,
                'precio' => $request->precio,
                'descripcion' => $request->descripcion,
                'user_id' => $request->user_id, 
            ]);

          
    
            // Verificar si la solicitud fue exitosa
            if ($response->successful()) {
                // La solicitud fue exitosa
                return redirect()->route('productos.index');
            } else {
                // La solicitud no fue exitosa, manejar el error
                return view('error')->with('error', 'Error al almacenar el producto en la API.');
            }
        } catch (\Exception $e) {
            // Capturar cualquier excepción
            return view('error')->with('error', 'Error al realizar la solicitud a la API.');
        }
    }
    

    public function update(Request $request)
    {
     
        $url = env('URL_SERVER_API', 'http://127.0.0.1:8000/api/');

        $response = Http::put($url . 'productos/update/' . $request->id, [
         
            'nombres' => $request->nombres,
            'tiempo_reclamo' => $request->tiempo_reclamo,
            'precio' => $request->precio,
            'descripcion' => $request->descripcion,
            'user_id' => $request->user_id,

        
        ]);
      
        return redirect()->route('productos.index');
    }


    public function edit($id)
    {

        $url = env('URL_SERVER_API', 'http://127.0.0.1:8000/api/');

        $response = Http::get($url . 'productos/edit/' . $id);

        if ($response->successful()) {
            $producto = $response->json();

            // Obtener todos los season disponibles
            $userResponse = Http::get($url . 'users');
            $users = $userResponse->json();

            $user_id = $producto['user_id']; // Establecer el season actual del usuario

            return view('productos.edit', compact('producto', 'users', 'user_id'));
        } else {
            // Manejo de error si la solicitud a la API no tiene éxito
            return redirect()->back()->with('error', 'No se pudo obtener los datos del usuario');
        } 
    }

    public function destroy($producto)
    {

        $url = env('URL_SERVER_API', 'http://127.0.0.1:8000/api/');
        $response = Http::delete($url . 'productos/destroy/' . $producto);

        return redirect()->route('productos.index');
    }



}

