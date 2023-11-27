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
        // Si la solicitud fue exitosa, redirige a la página de inicio
        session(['userData' => $data['user'], 'auth_token' => $data['accessToken']]);
        
        // Verificar el indicador de inicio de sesión
        if (isset($data['isLoggedIn']) && $data['isLoggedIn']) {
            session(['isLoggedIn' => true]);
        }

        return redirect()->route('index');
    } else {
        // Manejo de errores más detallado
        if ($response->status() === 401) {
            // Credenciales incorrectas
            return redirect()->route('login')->withErrors(['email' => 'Credenciales incorrectas']);
        } else {
            // Otro tipo de error
            return redirect()->route('login')->withErrors(['general' => 'Error en el inicio de sesión']);
        }
        }
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
        try {
 // Obtener el id del usuario de la sesión
 $userId = session('userData')['id'] ?? null;

 if (!$userId) {
     // Manejar el caso en que no se pueda obtener el id del usuario
     return view('error')->with('error', 'No se puede obtener el ID del usuario desde la sesión.');
 }

            // Realizar solicitud GET a la API para obtener los datos del usuario
            $response = Http::get(env('URL_SERVER_API') . 'users/edit/' . $id);
    
            if ($response->successful()) {
                // Extraer datos de la respuesta
                $data = $response->json();
                $user = $data['user'];
    
                // Renderizar la vista con los datos obtenidos
                return view('users.edit', compact('user'));
            } else {
                // Manejar el error si la solicitud a la API no es exitosa
                return view('error')->with('error', 'Error al obtener el usuario de la API.');
            }
        } catch (\Exception $e) {
            // Manejo de errores generales
            return view('error')->with('error', 'Error al obtener el usuario: ' . $e->getMessage());
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
     

    public function update(Request $request, $id)
    {
        try {
            $url = env('URL_SERVER_API', 'http://127.0.0.1:8000/api/');
    
            // Construir datos para la solicitud
            $requestData = [
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'edad' => $request->edad,
                'telefono' => $request->telefono,
                'email' => $request->email,
             /*    'password' => $request->password, */
            ];
    
            // Verificar si se proporciona una nueva imagen de perfil
            if ($request->hasFile('profile_picture')) {
                // Leer el contenido de la imagen y codificarlo en base64
                $imageContent = base64_encode(file_get_contents($request->file('profile_picture')->path()));
                $requestData['profile_picture'] = $imageContent;
            }
    
            // Enviar la solicitud a la API
            $response = Http::put($url . 'users/update/' . $id, $requestData);
    
            // Verificar la respuesta de la API
            if ($response->successful()) {
                // Redirigir a la ruta de usuarios (o donde sea apropiado)
                return redirect()->route('users.edit');
            } else {
                // Manejar el error si la solicitud no fue exitosa
                return back()->withErrors(['error' => 'Error al actualizar el usuario en la API']);
            }
        } catch (\Exception $e) {
            // Manejar cualquier excepción que ocurra
            return back()->withErrors(['error' => 'Error en el servidor: ' . $e->getMessage()]);
        }
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
