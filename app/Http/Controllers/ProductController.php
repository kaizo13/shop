<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    
    public function store(Request $request)
    {
        $product=new Product;
        $product->idArticle=$request->idArticle;
        $product->idBrand=$request->idBrand;
        $product->description=$request->description;
        $product->price=$request->price;
        $product->save();
    }

   
}
