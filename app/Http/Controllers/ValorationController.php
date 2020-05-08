<?php

namespace App\Http\Controllers;

use App\Models\Valoration;
use Illuminate\Http\Request;

class ValorationController extends Controller
{
    
    public function store($idCustomer,$idProduct,Request $request)
    {
        $valoration=new Valoration;
        $valoration->idCustomer=$idCustomer;
        $valoration->idProduct=$idProduct;
        $valoration->valoration=$request->valoration;
        $valoration->save();
    }

    public function update($id,Request $request)
    {
        $valoration=Valoration::find($id);
        $valoration->valoration=$request->valoration;
        $valoration->save();
    }

    public function get($idCustomer,$idProduct){
        return Valoration::where('idCustomer',$idCustomer)->where('idProduct',$idProduct)->first();
    }

    public function destroy(Valoration $valoration)
    {
        //
    }
}
