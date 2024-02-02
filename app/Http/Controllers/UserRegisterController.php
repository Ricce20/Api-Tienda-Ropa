<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

//models
use App\Models\User;
use App\Models\Customer;
use App\Models\Employee;

class UserRegisterController extends Controller
{
    //Register to the Employees- tables users end employees

    public function RegisterEmployee(Request $request){
        try {
            // Validation
            Validator::make($request->all(), [
                'name' => 'required|string|max:100',
                'lastname' => 'required|string|max:100',
                'address' => 'nullable|string',
                'phone' => 'required|string|max:10|unique:customers,phone',
                'puesto' => 'required|string'
            ])->validate();

            $employee = new Employee();
            $employee->name = $request->name;
            $employee->lastname = $request->lastname;
            $employee->address = $request->address;
            $employee->phone = $request->phone;
            $employee->puesto = $request->puesto;
            $employee->save();

            //cargamos las imagenes 
            if($request->hasfile('photo')){
                $photo = $request->file('photo');
                //$path = image->path();
                $extension =  $photo->extension();
                $new_name = $employee->id."-1.".$extension;
                $path = $photo->storeAs('images/employees', $new_name ,'public');
                //$product->image->$new_name;
                $employee->photo = $path;
                $employee->save();
            }

            return response()->json([
               'message' => 'Empleado registrado'
            ], 200);

        }
        catch (\Illuminate\Validation\ValidationException $e) {
            // Obtener el primer error de validación para un campo específico
            $fieldError = $e->errors()[array_key_first($e->errors())][0];
    
            return response()->json([
                'errorValidacion' => $fieldError
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function UserEndEmployeeRegister(Request $request){
        try {        
            // Validation
            Validator::make($request->all(), [
                'name' => 'required|string|max:100',
                'lastname' => 'required|string|max:100',
                'address' => 'nullable|string',
                'phone' => 'required|string|max:10|unique:employees,phone',
                'puesto' => 'required|string',
                'email' => 'required|string|unique:users,email',
                'password' => 'required|string|min:8',
                

            ])->validate();
            $password = Hash::make($request->password);
            $user = new User();
            $user->email = $request->email;
            $user->password = $password;
            $user->rol_id = 1;
            $user->save();


            $employee = new Employee();
            $employee->user_id = $user->id;
            $employee->name = $request->name;
            $employee->lastname = $request->lastname;
            $employee->address = $request->address;
            $employee->phone = $request->phone;
            $employee->puesto = $request->puesto;
            $employee->save();

            //cargamos las imagenes 
            if($request->hasfile('photo')){
                $photo = $request->file('photo');
                //$path = image->path();
                $extension =  $photo->extension();
                $new_name = $employee->id."-1.".$extension;
                $path = $photo->storeAs('images/employees', $new_name ,'public');
                //$product->image->$new_name;
                $employee->photo = $path;
                $employee->save();
            }

            return response()->json([
                'message' => 'registro guardado'
            ], 200);
        } 
        catch (\Illuminate\Validation\ValidationException $e) {
            // Obtener el primer error de validación para un campo específico
            $fieldError = $e->errors()[array_key_first($e->errors())][0];
    
            return response()->json([
                'errorValidacion' => $fieldError
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
        
    }

    public function editEmpleyee(Request $request,$id){
        try {
            // Validation
            Validator::make($request->all(), [
                'name' => 'nullable|string|max:100',
                'lastname' => 'nullable|string|max:100',
                'address' => 'nullable|string',
                'phone' => 'nullable|string|max:10|unique:employees,phone,'.$id,
                'puesto' => 'nullable|string',
                
            ])->validate();

            $employee = Employee::where('id',$id)->first();
            $employee->name = $request->name;
            $employee->lastname = $request->lastname;
            $employee->address = $request->address;
            $employee->phone = $request->phone;
            $employee->puesto = $request->puesto;
            $employee->save();

            //cargamos las imagenes 
            if($request->hasfile('photo')){
                $photo = $request->file('photo');
                //$path = image->path();
                $extension =  $photo->extension();
                $new_name = $employee->id."-1.".$extension;
                $path = $photo->storeAs('images/employees', $new_name ,'public');
                //$product->image->$new_name;
                $employee->photo = $path;
                $employee->save();
            }
            return response()->json(['message'=>'empleado actualizado correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }


    public function deleteEmployee($id){
        try {
            $employee = Employee::where('id',$id)->first();
            if(!$employee){
                return response()->json(['message' =>'Empleado ya ha sido eliminado'], 404);

            }
            $employee->delete();

            return response()->json(['message' =>'Empleado eliminado correctamente'], 200);
        }catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function enableUser($id){
        try {
            $user = User::where('id', $id)->first();
            if (!$user) {
                return response()->json(['message' => 'Usuario no encontrado'], 404);
            }
            $user->state_id = '2';
            $user->save();
    
            return response()->json(['message' => 'Usuario Eliminado correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
    

    //Register to the Customers- tables users end customers
    public function UserEndCustomerRegister(Request $request){
        try {
            // Validation
            Validator::make($request->all(), [
                'name' => 'required|string|max:100',
                'lastname' => 'required|string|max:100',
                'shippingAddress' => 'nullable|string',
                'phone' => 'required|string|max:10',
                'email' => 'required|string|unique:users,email',
                'password' => 'required|string|min:8'               
            ])->validate();

            $password = Hash::make($request->password);

            $user = new User();
            $user->email = $request->email;
            $user->password = $password;
            // 2 = cliente
            $user->rol_id = 2;
            $user->save();

            $customer = new Customer();
            $customer->user_id = $user->id;
            $customer->name = $request->name;
            $customer->lastname = $request->lastname;
            $customer->shippingAddress = $request->shippingAddress;
            $customer->phone = $request->phone;
            $customer->save();

           //cargamos las imagenes 
            if($request->hasfile('photo')){
                $photo = $request->file('photo');
                //$path = image->path();
                $extension =  $photo->extension();
                $new_name = $customer->id."-1.".$extension;
                $path = $photo->storeAs('images/employees', $new_name ,'public');
                //$product->image->$new_name;
                $customer->photo = $path;
                $customer->save();
            }
            $token = $user->createToken('apiToken')->plainTextToken;

            return response()->json([
                'token' => $token,
                'customer'=>$customer
            ], 200);

        }
        catch (\Illuminate\Validation\ValidationException $e) {
            // Obtener el primer error de validación para un campo específico
            $fieldError = $e->errors()[array_key_first($e->errors())][0];
    
            return response()->json([
                'errorValidacion' => $fieldError
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    

}
