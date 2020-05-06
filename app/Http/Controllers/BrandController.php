<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    
    public function store(Request $request)
    {
       $brand=new Brand;
       $brand->name=$request->name;
       $brand->save();
    }

    public function get(){
        return Brand::all();
    }

    
}
