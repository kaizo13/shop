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
        $valoration->save();
    }

    public function update($id,Request $request)
    {
        $valoration=Valoration::find($id);
        $valoration->valoration=$request->valoration;
        $valoration->save();
    }

    public function destroy(Valoration $valoration)
    {
        //
    }
}
