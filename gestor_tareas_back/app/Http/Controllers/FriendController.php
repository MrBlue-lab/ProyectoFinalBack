<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserUser;

class FriendController extends Controller {

    public function getAllUsers(Request $request) {
        $us = \DB::select('SELECT users.email,users.id from users where id != :id', ['id' => $request->input('id')]);
        $users=null;
        foreach ($us as $user) {
            if ($user->email != null) {
               $users[]=$user->email;
            }
        }
        return response()->json(['message' => ['correcto' => true, 'users' => $users], 'code' => 201], 201);
    }
    public function getUsersNotFriends(Request $request) {
        $us = \DB::select('SELECT users.email,users.id from users where id != :id', ['id' => $request->input('id')]);
        foreach ($us as $user) {
            if ((UserUser::where('id_user_a', '=', $request->input('id'))->where('id_user_b', '=', $user->id)->first() == null &&
                    UserUser::where('id_user_b', '=', $request->input('id'))->where('id_user_a', '=', $user->id)->first() == null) && $user->email != null) {
                    $users[]=$user->email;
            }
        }
        return response()->json(['message' => ['correcto' => true, 'users' => $users], 'code' => 201], 201);
    }
    public function getUsersAlmostFriends(Request $request) {
        $us = \DB::select('SELECT users.email,users.id from users');
        $users=null;
        foreach ($us as $user) {
            if ((UserUser::where('id_user_a', '=', $request->input('id'))->where('id_user_b', '=', $user->id)->where('aceptado','=',0)->first() != null ||
                    UserUser::where('id_user_b', '=', $request->input('id'))->where('id_user_a', '=', $user->id)->where('aceptado','=',0)->first() != null) && $user->email != null) {
                    $users[]=$user->email;
            }
        }
        return response()->json(['message' => ['correcto' => true, 'users' => $users], 'code' => 201], 201);
    }
    public function getUsersFriends(Request $request) {
        $us = \DB::select('SELECT users.email,users.id from users');
        $users=null;
        foreach ($us as $user) {
            if ((UserUser::where('id_user_b', '=', $user->id)->where('aceptado','=',1)->first() != null ||
                    UserUser::where('id_user_a', '=', $user->id)->where('aceptado','=',1)->first() != null) && $user->email != null) {
                    $users[]=$user->email;
            }
        }
        return response()->json(['message' => ['correcto' => true, 'users' => $users], 'code' => 201], 201);
    }

    public function putUserAmigo(Request $request) {
        if (User::where('email', '=', $request->input("email"))->first() == null) {
            return response()->json(['message' => 'error al añadir amigo', 'code' => 400], 400);
        }
        $idb = User::where('email', '=', $request->input("email"))->first('id');
        if ($idb['id'] == $request->input('id') ||
                UserUser::where('id_user_a', '=', $request->input('id'))->where('id_user_b', '=', $idb['id'])->first() != null ||
                UserUser::where('id_user_b', '=', $request->input('id'))->where('id_user_a', '=', $idb['id'])->first() != null) {
            return response()->json(['message' => 'error al añadir amigo', 'code' => 400], 400);
        }
        UserUser::create([
            'id_user_a' => $request->input('id'),
            'id_user_b' => $idb['id'],
            'aceptado' => 0
        ]);
        return response()->json(['message' => 'peticion enviada', 'code' => 201], 201);
    }

}
