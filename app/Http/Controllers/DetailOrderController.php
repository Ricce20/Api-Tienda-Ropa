<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailOrder;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class DetailOrderController extends Controller
{
    public function getDetails($id){
        try {
            $detailOrder =  DetailOrder::where('order_id',$id)->with('product','order')->get();

            return $detailOrder 
            ? response()->json(['details'=>$detailOrder],200)
            : response()->json(['none'=>'no se encontraron detalles'],404);
            
        } catch (\Exception $e) {
            return response()->json([
                'error'=> $e->getMessage()
            ]);
        }
    }

    public function decrementQuantity(Request $request,$id){
        try {
            // Validación
            $validator = Validator::make($request->all(), [
                'decrement' => 'required|numeric',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
    
            // Buscar el producto
            $product = Product::findOrFail($id);
    
            // Decrementar la cantidad
            $product->decrement('quantity', $request->decrement);
    
            // Recargar el modelo para obtener la cantidad actualizada
            $product->refresh();
    
            return response()->json(['productUpdate' => $product], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error encontrado: ' . $e->getMessage()], 500);
        }
    }

    public function incrementQuantity(Request $request, $id)
{
    try {
        // Validación
        $data = Validator::make($request->all(), [
            'increment' => 'required|numeric',
        ])->validate();

        $product = Product::findOrFail($id);

        // Convertir $data['increment'] a un valor numérico antes de sumar
        $incrementValue = (float)$data['increment'];

        $product->increment('quantity', $incrementValue);
        
        return response()->json(['productUpdate' => $product], 200);

    } catch (\Exception $e) {
        return response()->json(['error' => 'Error encontrado: ' . $e->getMessage()]);
    }
}

}
