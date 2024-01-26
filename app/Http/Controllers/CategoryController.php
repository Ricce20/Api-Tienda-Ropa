<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
//models
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            //get to the categories
            $categories = Category::select('id','category','description')->where('state_id','1')->get();

            return response()->json([
                'categories'=> $categories
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 200);
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
            // Validación
            $data = Validator::make($request->all(), [
                'category' => 'required|unique:categories|max:70',
                'description' => 'required|max:250',
            ])->validate();
    
            // Guardar la categoría
            $category = Category::create($data);
    
            return response()->json([
                'category' => $category
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
            $category = Category::where('id', $id)->where('state_id', '1')->first();

            return $category
            ?  response()->json(['category' => $category], 200) 
            : response()->json(['message' => 'no se encontro categoria'], 404);
    
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
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
            // Validación
            $data = Validator::make($request->all(), [
                'category' => 'string|max:70|unique:categories,category,'.$id,
                'description' => 'required|string|max:250',
            ])->validate();
    
            // Actualizar la categoría
            $category = Category::findOrFail($id);
            $category->update($data);
    
            return response()->json([
                'message' => 'Categoria Actualizada Correctamente'
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
            ],500);
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

            $category = Category::findOrFail($id);
            $category->update($data);

            return response()->json([
                'message' => 'Categoria Eliminada Correctamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ],500);
        }
    }
}
