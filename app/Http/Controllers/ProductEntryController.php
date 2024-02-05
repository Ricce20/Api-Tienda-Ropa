<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductEntry;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Support\Facades\Validator;

class ProductEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $entries = ProductEntry::select('id','product_id','supplier_id','quantity','unit_price','total','entry_date')->with('product', 'supplier')->get();
            return response()->json(['entries' => $entries], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error encontrado: ' . $e->getMessage()], 500);
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
            //validate
            $data = Validator::make($request->all(), [
                'supplier_id' => 'required|numeric|',
                'product_id' => 'required|numeric',
                'quantity' => 'required|numeric',
                'total' => 'required|numeric',
                'unit_price'=> 'required|numeric',
              //  'entry_date'=>'require|'
                
            ])->validate();

            $entry = ProductEntry::create($data);

            return response()->json(['entry'=>$entry], 200);
        } catch (\Exception $e) {
            return response()->json(['error'=> 'error: '.$e->getMessage()]);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
