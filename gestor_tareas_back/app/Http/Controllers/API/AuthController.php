<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RolUsuario;

class AuthController extends Controller {

    public function register(Request $request) {

        if (User::where('email', '=', $request->input('email'))->count() == 1) {
            return response()->json(['message' => ['correcto' => false, 'message' => 'Registro incorrecto. Revise las credenciales'], 'code' => 400], 400);
        }

        $validatedData = $request->validate([
            'nombre' => 'required',
            'apellidos' => 'required',
            'email' => 'email|required|unique:users',
            'password' => 'required',
            'estado' => 'required'
        ]);

        $validatedData['password'] = \Hash::make($request->input("password"));

        $user = User::create($validatedData);
        $accessToken = $user->createToken('authToken')->accessToken;
        RolUsuario::create([
            'role_id' => 1,
            'id' => $request->input("id")
        ]);
        

        return response()->json(['message' => ['correcto' => true, 'user' => $user, 'access_token' => $accessToken], 'code' => 201], 201);
    }

    /**
     * Update profesor
     * @param Request $request
     * @return json
     */
    public function mod_user(Request $request) {
        if (User::where('id', $request->input('id'))->count() != 1) {
            return response()->json(['message' => 'datos no encontrados', 'code' => 201], 201);
        }
        $user = User::where('id', $request->input('id'))->first();
        $user->nombre = $request->input("nombre");
        $user->apellidos = $request->input("apellidos");
        $user->email = $request->input("email");
        $user->save();
        
        return response()->json(['message' => ['user' => $user], 'code' => 201], 201);
    }
    /**
     * Función para cambiar contraseña
     * @param Request $request
     * @return type
     */
    public function mod_user_pass(Request $request) {
        $user = User::where('id', $request->input('id'))->get();

        return response()->json(['message' => ['user' =>  $user->password], 'code' => 400], 400);
        if (\Hash::check($request->input("password"), $user->password)) {
            return response()->json(['message' => 'Contraseña incorrecta. Revise las credenciales.', 'code' => 400], 400);
        }

        $user->password = \Hash::make($request->input("newpassword"));
        $user->save();

        return response()->json(['message' => ['user' => $user], 'code' => 201], 201);
    }

    public function login(Request $request) {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);
        
        if (!auth()->attempt($loginData,true)) {
            //return response(['message' => 'Login incorrecto. Revise las credenciales.'], 400);
            return response()->json(['message' => 'Login incorrecto. Revise las credenciales.', 'code' => 400], 400);
        }

        //Comprobar que la cuenta este activada
        $usu = User::where('email', '=', $request->input('email'))
                ->where('estado', '=', 0)
                ->get();
        if (count($usu) == 0) {
            return response()->json(['message' => 'Cuenta desactivada, contacte con el director.', 'code' => 400], 400);
        }
        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        //Obtener el rol del usuario
        /*
        $rol = RolUsuario::where("id", "=", $user->id)->get();
    
        if ($rol[0]->role_id == 1) {
            $rolDescripcion = "Director";
        } else if ($rol[1]->role_id == 2) {
            $rolDescripcion = "Jefe de estudios";
        } else if ($rol[1]->role_id == 3) {
            $rolDescripcion = "Tutor";
        }*/
        return response()->json(['message' => ['user' => auth()->user(), 'access_token' => $accessToken], 'code' => 200], 200);
    }
}
