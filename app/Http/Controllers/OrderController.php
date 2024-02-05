<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
class OrderController extends Controller
{
    public function getOrders(){
        try {
            $orders = Order::where('state_id','3')->with('customer','state')->get();
            return response()->json([
                'orders'=>$orders
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error'=> $e->getMessage()
            ]);
        }
    }

    public function createOrder(Request $request){
        try {
            //validate
            $data = Validator::make($request->all(), [
                'customer_id' => 'required|numeric|',
                'orderDate' => 'required|date',
                'total' => 'required|numeric'
                //numero de pago 
                //paquteria
                //guia

            ])->validate();

            $order = Order::create($data);

            return response()->json([
                'orderCreated'=>$order
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error'=> 'error encontrado'.$e->getMessage()
            ]);
        }
    }

    public function completeOrder($id){
        try {
            $data = [
                'state_id'=> 4
            ];
            $order = Order::findOrFail($id);
            $order = Order->update($data);

            return response()->json([
                'orderComplete'=>$order
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'error encontrado: '.$e->getMessage()
            ]);
        }
    }

    
}
