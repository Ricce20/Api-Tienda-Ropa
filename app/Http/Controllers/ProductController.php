<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use validation;

//models
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $products = Product::select('id','name','description','color','size','quantity','price','image1','image2','image3','supplier_id','category_id','updated_at')->with('supplier','category')->where('state_id','1')->get();
            //sobreescribimos laruta de las imagenes
            foreach ($products as $product) {
                $product->image1 = asset('/storage/' . $product->image1);
                $product->image2 = asset('/storage/' . $product->image2);
                $product->image3 = asset('/storage/' . $product->image3);
            }

            return response()->json(['products'=> $products], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error'=>$e->getMessage()
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
                'name' => 'required|string|max:100|unique:products',
                'description'=>'required|string',
                'color'=>'required|string',
                'size'=>'required|string',
                'quantity'=>'required|numeric',
                'price'=>'required|numeric',
                'supplier_id'=>'required|numeric',
                'category_id'=>'required|numeric'
                
            ])->validate();
            //save
            $product = new Product();
            $product->name = $request->name;
            $product->description = $request->description;
            $product->color = $request->color;
            $product->size = $request->size;
            $product->quantity = $request->quantity;
            $product->price = $request->price;
            $product->image1 = 'default.jpg';
            $product->image2 = 'default.jpg';
            $product->image3 = 'default.jpg';
            $product->supplier_id = $request->supplier_id;
            $product->category_id = $request->category_id;
            $product->state_id = 1;
            $product->save();

            //cargamos las imagenes 
            if($request->hasfile('image1')){
                $image1 = $request->file('image1');
                //$path = image->path();
                $extension =  $image1->extension();
                $new_name = $product->id."-1.".$extension;
                $path = $image1->storeAs('images/products', $new_name ,'public');
                //$product->image->$new_name;
                $product->image1 = $path;
                $product->save();
            }
            if($request->hasfile('image2'))
            {
                $image2 = $request->file('image2');
                //$path = image->path();
                $extension = $image2->extension();
                $new_name = $product->id."-2.".$extension;
                $path = $image2->storeAs('images/products', $new_name ,'public');
                //$product->image->$new_name;
                $product->image2 = $path;
                $product->save();
            }
            if($request->hasfile('image3'))
            {
                $image3 = $request->file('image3');
                //$path = image->path();
                $extension = $image3->extension();
                $new_name = $product->id."-3.".$extension;
                $path = $image3->storeAs('images/products', $new_name ,'public');
                //$product->image->$new_name;
                $product->image3 = $path;
                $product->save();
            }

            $product->save();

            return response()->json([
                'message' => 'Producto Guardado Correctamente'
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $product = Product::where('id', $id)->where('state_id', '1')->with('supplier', 'category')->first();

            if (!$product) {
                return response()->json(['message' => 'Elemento no encontrado'], 404);
            }

            $product->image1 = asset('/storage/' . $product->image1);
            $product->image2 = asset('/storage/' . $product->image2);
            $product->image3 = asset('/storage/' . $product->image3);

            return response()->json(['product' => $product], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
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
                'name' => 'required|string|max:100|unique:products,name,'.$id,
                'description'=>'required|string',
                'color'=>'required|string',
                'size'=>'required|string',
                'quantity'=>'required|numeric',
                'price'=>'required|numeric',
                'supplier_id'=>'required|numeric',
                'category_id'=>'required|numeric'
                // 'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                // 'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                // 'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ])->validate();
             //save
             $product = Product::find($id);
             $product->name = $request->name;
             $product->description = $request->description;
             $product->color = $request->color;
             $product->size = $request->size;
             $product->quantity = $request->quantity;
             $product->price = $request->price;
             $product->supplier_id = $request->supplier_id;
             $product->category_id = $request->category_id;
             $product->save();
 
             //cargamos las imagenes 
             if($request->hasfile('image1')){
                 $image1 = $request->file('image1');
                 //$path = image->path();
                 $extension =  $image1->extension();
                 $new_name = $product->id."-1.".$extension;
                 $path = $image1->storeAs('images/products', $new_name ,'public');
                 //$product->image->$new_name;
                 $product->image1 = $path;
                 $product->save();
             }
             if($request->hasfile('image2'))
             {
                 $image2 = $request->file('image2');
                 //$path = image->path();
                 $extension = $image2->extension();
                 $new_name = $product->id."-2.".$extension;
                 $path = $image2->storeAs('images/products', $new_name ,'public');
                 //$product->image->$new_name;
                 $product->image2 = $path;
                 $product->save();
             }
             if($request->hasfile('image3'))
             {
                 $image3 = $request->file('image3');
                 //$path = image->path();
                 $extension = $image3->extension();
                 $new_name = $product->id."-3.".$extension;
                 $path = $image3->storeAs('images/products', $new_name ,'public');
                 //$product->image->$new_name;
                 $product->image3 = $path;
                 $product->save();
             }

             return response()->json([
                'message'=>'Producto Actualizado Correctamente'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error'=>$e->getMessage()
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
            $product = Product::find($id);
            $product->state_id = 2;
            $product->save();
            return response()->json([
                'message'=>'Producto eliminado correctamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error'=>$e->getMessage()
            ],500);
        }
    }
}
