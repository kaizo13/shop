<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
   
    public function store(Request $request)
    {
        $user=new User;
        $user->email=$request->email;
        $user->password=bcrypt($request->password);
        $user->role="CUSTOMER";
       

        $customer=new Customer;
        $customer->name=$request->name;
        $customer->dni=$request->dni;
        $customer->email=$request->email;
        $customer->phone=$request->phone;
        $customer->address=$request->address;
        $customer->postalCode=$request->postalCode;

        $user->save();
        $customer->idUser=$user->id;
        $customer->save();

        $cart=new Cart;
        $cart->name="Carro 1";
        $cart->idCustomer=$customer->id;
        $cart->save();
    }

    
}
