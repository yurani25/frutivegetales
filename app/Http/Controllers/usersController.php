<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\abastecimiento;
use Illuminate\Support\Facades\Http;
use App\Models\rol;
use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\User as AuthUser;

class usersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $url = env('URL_SERVER_API', 'http://127.0.0.1:8000/api/');

        $response =  Http::get($url.'users');

        $data = $response->json();

        return view('users.index', compact('data'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create()
    {

        return view('users.create');
       /*  $url = env('URL_SERVER_API', 'http://127.0.0.1:8000/api/');
    
        $response = Http::get($url . 'users/create');
    
        // Verificar si la solicitud fue exitosa (código de respuesta 2xx)
        if ($response->successful()) {
            $data = $response->json(); // Obtener los datos en formato JSON
    
            // Aquí puedes trabajar con los datos como desees
            // Por ejemplo, podrías pasar los datos a una vista o realizar otras operaciones.
    
            return view('users.create', compact('data'));
        } else {
            // Manejar el caso en que la solicitud no fue exitosa
            return response('Error al obtener datos de la API', 500);
        } */
    } 
    public function registro(Request $request )
    {

        $url = env('URL_SERVER_API', 'http://127.0.0.1:8000/api/');

        $response = Http::post($url . 'register', [
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'edad' => $request->edad,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        // Verificar la respuesta de la API
        if ($response->successful()) {
            $data = $response->json();

            // Almacena el token en la sesión
            session(['auth_token' => $data['access_token']]);

            // Manejar la respuesta como desees, por ejemplo, redirigir al usuario
            return redirect()->route('login');
        } else {
            // Si la solicitud no fue exitosa, manejar el error
            return response()->json(['error' => 'Error al registrar el usuario'], $response->status());
        }
    }
    
    
    public function logins(Request $request)
    {
        // Obtén las credenciales del formulario de inicio de sesión
        $credentials = $request->only('email', 'password');

        // URL de la API
        $apiUrl = env('URL_SERVER_API', 'http://127.0.0.1:8000/api/');

        // Enviar solicitud POST a la API logins
        $response = Http::post($apiUrl . 'logins', $credentials);
        $data = $response->json();

        // Verificar la respuesta de la API
        if ($response->successful() && isset($data['accessToken'])) {
            // Si la solicitud fue exitosa y hay un accessToken en la respuesta, pasa el nombre del usuario y el token a la sesión
            session(['isLoggedIn' => true, 'userData' => $data['user'], 'auth_token' => $data['accessToken']]);
        } else {
            // Si la solicitud no fue exitosa o no hay accessToken en la respuesta, establece la sesión sin datos de usuario
            session(['isLoggedIn' => false, 'userData' => null, 'auth_token' => null]);
        }

        // Redirige a la vista de inicio
        return redirect()->route('index');
    }





    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   /*  public function store(Request $request)
    {
        try {
            $url = env('URL_SERVER_API', 'http://127.0.0.1:8000/api/');
    
            // Asigna una foto predeterminada
            $defaultProfilePicture = 'img/default_profile_picture.png';
    
            $response = Http::post($url . 'users/store', [
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'edad' => $request->edad,
                'telefono' => $request->telefono,
                'email' => $request->email,
                'password' => $request->password,
                'profile_picture' => $request->hasFile('profile_picture')
                    ? $request->file('profile_picture')->store('profile_pictures', 'public')
                    : $defaultProfilePicture,
                // Asegúrate de ajustar los demás campos según tu lógica
            ]);
    
            // Verificar si la solicitud fue exitosa
            if ($response->successful()) {
                // La solicitud fue exitosa
                return redirect()->route('users.index'); // Ajusta 'tu_vista' según tus necesidades
            } else {
                // La solicitud no fue exitosa, manejar el error
                return view('error')->with('error', 'Error al crear el usuario en la API.');
            }
        } catch (\Exception $e) {
            // Capturar cualquier excepción
            return view('error')->with('error', 'Error al realizar la solicitud a la API.');
        }
    } */
    
 

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
        $url = env('URL_SERVER_API', 'http://127.0.0.1:8000/api/');
    
        $response = Http::get($url . 'users/' . $id);
    
        if ($response->successful()) {
            $usuario = $response->json();
    
            return view('usuarios.edit', compact('users'));
        } else {
            // Manejo de error si la solicitud a la API no tiene éxito
            return redirect()->back()->with('error', 'No se pudo obtener los datos del usuario');
        }
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
/*     public function update(Request $request)
    {
        $url = env('URL_SERVER_API', 'http://127.0.0.1:8000/api/');
    
        $data = [
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'edad' => $request->edad,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'password' => $request->password,
        ];
    
        // Si se proporciona una nueva foto de perfil
        if ($request->hasFile('profile_picture')) {
            // Eliminar la foto de perfil anterior si no es la predeterminada
            $data['remove_profile_picture'] = 1;
    
            // Agregar la nueva foto de perfil al formulario
            $data['profile_picture'] = $request->file('profile_picture');
        }
    
        $response = Http::put($url . 'usuarios/update/' . $request->id, $data);
    
        // Verifica si la solicitud a la API fue exitosa antes de redirigir
        if ($response->successful()) {
            return redirect()->route('users.index'); // Reemplaza 'usuarios.index' con la ruta correcta
        } else {
            // Manejo de error si la solicitud a la API no tiene éxito
            return redirect()->back()->with('error', 'Error al actualizar el usuario en la API');
        }
    } */
     

    public function update(Request $request)
    {
     
        $url = env('URL_SERVER_API', 'http://127.0.0.1:8000/api/');

        $response = Http::put($url . 'users/update/' . $request->id, [
         
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'edad' => $request->edad,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'password' => $request->password,

        ]);
      
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user)
    {
        $url = env('URL_SERVER_API', 'http://127.0.0.1:8000/api/');
        $response = Http::delete($url . 'users/destroy/' . $user);
        return redirect()->route('users.index');
    }

}
