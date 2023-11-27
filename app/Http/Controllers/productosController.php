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

    public function Catalogo()
    {
        $url = env('URL_SERVER_API', 'http://127.0.0.1:8000/api/');
        
        // Hacer la solicitud GET a la API
        $response = Http::get($url . 'productos');
    
        // Verificar si la solicitud fue exitosa
        if ($response->successful()) {
            // Obtener los productos desde la respuesta JSON
            $productos = $response->json(); // Elimina ['productos']
    
            // Puedes pasar los productos a la vista o realizar cualquier otra lógica aquí
            return view('index', compact('productos'));
        } else {
            // Si la solicitud no fue exitosa, manejar el error
            return view('index')->with('error', 'Error al obtener el catálogo desde la API.');
        }
    }
    
    public function inorganico()
    {
        $url = env('URL_SERVER_API', 'http://127.0.0.1:8000/api/');
        
        // Hacer la solicitud GET a la API
        $response = Http::get($url . 'productos');
    
        // Verificar si la solicitud fue exitosa
        if ($response->successful()) {
            // Obtener los productos desde la respuesta JSON
            $productos = $response->json(); // Elimina ['productos']
    
            // Puedes pasar los productos a la vista o realizar cualquier otra lógica aquí
            return view('inorganico', compact('productos'));
        } else {
            // Si la solicitud no fue exitosa, manejar el error
            return view('inorganico')->with('error', 'Error al obtener el catálogo desde la API.');
        }
    }





/*     public function create()
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
    } */
    public function create()
{
    $url = env('URL_SERVER_API', 'http://127.0.0.1:8000/api/');

    // Obtener productos desde la API
    $responseProductos = Http::get($url . 'productos');
    
    // Obtener usuarios desde la API
    $responseUsers = Http::get($url . 'users');
    
    // Verificar si las respuestas son exitosas y obtener los datos
    $productos = $responseProductos->successful() ? $responseProductos->json() : [];
    $users = $responseUsers->successful() ? $responseUsers->json() : [];

    return view('productos.create', compact('productos', 'users'));
}
    
public function store(Request $request)
{
    try {
        $url = env('URL_SERVER_API', 'http://127.0.0.1:8000/api/');

        $request->validate([
            'nombres' => 'required|max:255',
            'tiempo_reclamo' => 'required|max:255',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Ajusta las extensiones y el tamaño según tus necesidades
            'precio' => 'required|integer',
            'descripcion' => 'required|max:255',
            'user_id' => 'required|integer',
        ]);

        // Subir y almacenar la imagen en la API
        $response = Http::attach(
            'imagen',
            file_get_contents($request->file('imagen')->getRealPath()),
            $request->file('imagen')->getClientOriginalName()
        )->post($url . 'productos/store', [
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

public function show($id)
{
    $url = 'http://127.0.0.1:8000/api/productos/' . $id; // Ajusta la URL de acuerdo a tu configuración

    // Hacer la solicitud GET a la API
    $response = Http::get($url);

    // Verificar si la solicitud fue exitosa
    if ($response->successful()) {
     
        $productos = $response->json();

        // Puedes hacer lo que quieras con los datos, por ejemplo, pasarlos a una vista
        return view('productos.detalle', compact('producto'));
    } else {
        // Si la solicitud no fue exitosa, manejar el error
        return view('productos.detalle')->with('error', 'Error al obtener los detalles del producto desde la API.');
    }
}



public function update(Request $request)
{
    // Validación de campos
    $request->validate([
        'nombres' => 'required|max:255',
        'tiempo_reclamo' => 'required|max:255',
        'precio' => 'required|integer',
        'descripcion' => 'required|max:255',
        'user_id' => 'required|integer',
        'nueva_imagen' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Ajusta según tus necesidades
    ]);

    $url = env('URL_SERVER_API', 'http://127.0.0.1:8000/api/');

    // Configura los datos para la solicitud PUT
    $formData = [
        'nombres' => $request->nombres,
        'tiempo_reclamo' => $request->tiempo_reclamo,
        'precio' => $request->precio,
        'descripcion' => $request->descripcion,
        'user_id' => $request->user_id,
    ];

    // Agrega la imagen si está presente en la solicitud
    if ($request->hasFile('nueva_imagen')) {
        $formData['nueva_imagen'] = $request->file('nueva_imagen');
    }

    // Realiza la solicitud PUT a la API Laravel
    $response = Http::attach('nueva_imagen', file_get_contents($formData['nueva_imagen']->path()), $formData['nueva_imagen']->getClientOriginalName())
        ->put($url . 'productos/update/' . $request->id, $formData);

    // Maneja la respuesta según tus necesidades
    if ($response->successful()) {
        // Puedes redirigir o hacer cualquier otra cosa en función de la respuesta
        return redirect()->route('productos.index');
    } else {
        // Maneja el caso en el que la solicitud no fue exitosa
        return redirect()->route('productos.index')->with('error', 'Error al actualizar el producto.');
    }
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

