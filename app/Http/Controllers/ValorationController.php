<?php

namespace App\Http\Controllers;

use App\Models\Valoration;
use Illuminate\Http\Request;

class ValorationController extends Controller
{
    
    public function store(Request $request)
    {
        $valoration=new Valoration;
        $valoration->idCustomer=$request->idCustomer;
        $valoration->idProduct=$request->idProduct;
        $valoration->valoration=$request->valoration;
    }

    public function update(Request $request)
    {

    }

    public function destroy(Valoration $valoration)
    {
        //
    }
}
