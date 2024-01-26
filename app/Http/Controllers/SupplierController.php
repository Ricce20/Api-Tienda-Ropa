<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
//models
use App\Models\Supplier;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            //get to th suppliers

            $suppliers = Supplier::select('id','companyName','contact','address','city','c_p','email','phone')->where('state_id', '1')->get();

            return response()->json([
                'suppliers' => $suppliers
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ],500);
        }
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
            //validation
            $data = Validator::make($request->all(),[
            'companyName' => 'required|string|max:50|unique:suppliers',
            'contact' => 'nullable|string|max:30',
            'address'=> 'nullable|string',
            'city'=> 'nullable|string|max:50',
            'c_p'=> 'nullable|string|max:5|',
            'email' => 'nullable|email|string|max:255',
            'phone'=> 'nullable|string|max:10',            
            ]
            )->validate();
            //save
            $supplier = Supplier::create($data);
            

            return response()->json([
                'supplierCreated' => $supplier
            ], 200);
        
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Obtener el primer error de validación para un campo específico
            $fieldError = $e->errors()[array_key_first($e->errors())][0];
    
            return response()->json([
                'errorValidate' => $fieldError
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
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
        try {
            $supplier = Supplier::where('id',$id)->where('state_id','1')->first();

            return $supplier
            ? response()->json(['supplier' =>$supplier], 200)
            : response()->json(['message'=>'Elemento no encontrado'],404);

        } catch (\Exception $e) {
            return response()->json(['error'=>$e->getMessage()]);
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
            //validation
            $data = Validator::make($request->all(),[
                'companyName' => 'string|max:50|unique:suppliers,companyName,'.$id,
                'contact' => 'nullable|string|max:30',
                'address'=> 'nullable|string',
                'city'=> 'nullable|string|max:50',
                'c_p'=> 'nullable|string|max:6|',
                'email' => 'nullable|email|string|max:255',
                'phone'=> 'nullable|string|max:10',            
                ]
                )->validate();
            //update
            $supplier = Supplier::findOrFail($id);
            $supplier->update($data);
            

            return response()->json([
                'message'=> 'Proveedor Actualizado Correctamente'
            ]);

        }  catch (\Illuminate\Validation\ValidationException $e) {
            // Obtener el primer error de validación para un campo específico
            $fieldError = $e->errors()[array_key_first($e->errors())][0];
    
            return response()->json([
                'errorValidate' => $fieldError
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
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
        try {
            $data = ['state_id'=>'2'];
            $supplier = Supplier::findOrFail($id);
            $supplier->update($data);

            return response()->json([
                'message'=> 'Proveedor Eliminado Correctamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error'=>$e->getMessage()
            ]);
        }
    }
}
