<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

//models
use App\Models\User;
use App\Models\Customer;
use App\Models\Employee;
class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validation
        Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string|min:8',
        ])->validate();

        $user = User::where('email', $request->email)->first();
        

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => 'Usuario o contrasena incorrectos'
            ], 401);
        }
        if($user->rol_id == 2){
            $customer = Customer::where('user_id',$user->id)->with('user')->first();
            $token = $user->createToken('apiToken')->plainTextToken;

            return response()->json([
                'customer' => $customer,
                'token' => $token
            ], 200);
            
        }


        $token = $user->createToken('apiToken')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 200);
    }

    public function logout(Request $request)
    {
        try {
            if(auth()->check()) { // Verifica si el usuario está autenticado
                $user = auth()->user();
                $user->tokens->each(function ($token, $key) {
                    $token->delete();
                });
            }
            return response()->json(['message' => 'Usuario cerró sesión con éxito']);

           

            
        } catch (\Exception $e) {
            session()->flash('error', 'Error encontrado: ' . $e->getMessage());
        }
    }
}
