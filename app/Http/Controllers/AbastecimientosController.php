<?php

namespace App\Http\Controllers;

use App\Models\abastecimiento;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class AbastecimientosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
 */
public function index()
{
    $url = env('URL_SERVER_API', 'http://127.0.0.1:8000/api/');
    $response = Http::get($url . 'abastecimientos');

    if ($response->successful()) {
        $data = $response->json();
       // dd($data); // Puedes usar dd para imprimir y detener la ejecución para depurar
        return view('abastecimientos.index', compact('data'));
    } else {
        // Manejar el caso en que la solicitud no fue exitosa
        return response('Error al obtener datos de la API', 500);
    }
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function create()
     {
         return view('abastecimientos.create');
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
            $url = env('URL_SERVER_API', 'http://127.0.0.1:8000/api/');
    
            $response = Http::post($url.'abastecimientos', [
                'nombre' => $request->nombre,
                'ubicacion' => $request->ubicacion,
                'horario_atencion' => $request->horario_atencion,
            ]);
    
            // Verificar si la solicitud fue exitosa
            if ($response->successful()) {
                // La solicitud fue exitosa
                return redirect()->route('abastecimientos.index');
            } else {
                // La solicitud no fue exitosa, manejar el error
                return view('error')->with('error', 'Error al almacenar el abastecimiento en la API.');
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
        try {
            $url = env('URL_SERVER_API', 'http://127.0.0.1:8000/api/');
    
            $response = Http::get($url . "abastecimientos/edit/{$id}");
    
            // Verificar si la solicitud fue exitosa (código de respuesta 2xx)
            if ($response->successful()) {
                $abastecimiento = $response->json(); // Obtener los datos en formato JSON
    
                // Aquí puedes trabajar con los datos como desees
                // Por ejemplo, podrías pasar los datos a una vista o realizar otras operaciones.
    
                return view('abastecimientos.edit', compact('abastecimiento'));
            } else {
                // Manejar el caso en que la solicitud no fue exitosa
                return response('Error al obtener datos de la API', 500);
            }
        } catch (\Exception $e) {
            // Capturar cualquier excepción
            return response('Error al realizar la solicitud a la API.', 500);
        }
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
        try {
            $url = env('URL_SERVER_API', 'http://127.0.0.1:8000/api/');
        
            $response = Http::put($url . "abastecimientos/{$id}", [
                'nombre' => $request->nombre,
                'ubicacion' => $request->ubicacion,
                'horario_atencion' => $request->horario_atencion,
            ]);
    
            // Verificar si la solicitud fue exitosa
            if ($response->successful()) {
                // La solicitud fue exitosa
                return redirect()->route('abastecimientos.index')->with('success', 'Registro actualizado correctamente');
            } else {
                // La solicitud no fue exitosa, manejar el error
                return view('error')->with('error', 'Error al actualizar el registro en la API.');
            }
        } catch (\Exception $e) {
            // Capturar cualquier excepción
            return view('error')->with('error', 'Error al realizar la solicitud a la API.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $abastecimiento = abastecimiento::find($id)->delete();

        return redirect()->route('abastecimientos.index')->with('success', 'Usuario eliminado exitosamente');
    }
}
