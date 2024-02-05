<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;

class CustomerController extends Controller
{
    public function getCustomers()
    {
        try {
            $customers = Customer::select('id','user_id','name','lastname','shippingAddress','phone')->get();

            return response()->json(['customers' => $customers], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



}
