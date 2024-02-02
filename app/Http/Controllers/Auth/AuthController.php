<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth; // Importación necesaria

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

        $user = User::where('email', $request->email)->where('state_id','1')->first();
        if(!$user){
            return response()->json(['message'=> 'No se encontro una cuenta'], 404 );
        }
        
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => 'Usuario o contraseña incorrectos'
            ], 401);
        }

        if ($user->rol_id == 2) {
            $customer = Customer::where('user_id', $user->id)->with('user')->first();
            $token = $user->createToken('apiToken')->plainTextToken;

            return response()->json([
                'customer' => $customer,
                'token' => $token
            ], 200);
        } elseif ($user->rol_id == 1) {
            $employee = Employee::where('user_id', $user->id)->with('user')->first();
            $token = $user->createToken('apiToken')->plainTextToken;

            return response()->json([
                'employee' => $employee,
                'token' => $token
            ], 200);
        }
    }

    public function logout(Request $request)
    {
        try {
            Auth::user()->tokens()->delete(); // Utilizando Auth::user()
            return response()->json(['message' => 'Usuario cerró sesión con éxito']);
        } catch (\Exception $e) {
            session()->flash('error', 'Error encontrado: ' . $e->getMessage());
        }
    }
}
