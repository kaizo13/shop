<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    
    public function store(Request $request)
    {
        $cart=new Cart;
        $cart->name=$request->name;
        $cart->idCustomer=$request->idCustomer;
        $cart->save();
    }

    
}
