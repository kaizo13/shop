<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Valoration;
use Illuminate\Http\Request;
use DB;

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

    public function get($id){
        $product= Product::find($id);
        $article=Article::find($product->idArticle);
        $brand=Brand::find($product->idBrand);
        $valorations=Valoration::where('idProduct',$id)->get();
        $result=0;
        if(count($valorations)){
            foreach($valorations as $valoration){
                if($valoration!=null){
                    $result=$result+$valoration->valoration;
                }
            }
    
            $product['valoration']=$result/count($valorations);
        }else{
            $product['valorations']=0;
        }
        
        $product['article']=$article->name;
        $product['brand']=$brand->name;
        
        return $product;
    }

    public function getProducts(Request $request){
        $products=DB::table('products')
            ->join('articles','products.idArticle','articles.id')
            ->join('brands','products.idBrand','brands.id')
             ->orderBy('products.id','desc')
            ->select('products.id','description','price','articles.name as article','brands.name as brand');
        

        if($request->idArticle){
            $products->where('articles.id','=',$request->idArticle);
        }

        if($request->idBrand){
            $products->where('brands.id','=',$request->idBrand);
        }

        if($request->minPrice){
            $products->where('price','>=',$request->minPrice);
        }

        if($request->maxPrice){
            $products->where('price','<=',$request->maxPrice);
        }

        if($request->description){
            $products->where('description','like', '%' . $request->description . '%');
        }

        $products=$products->get();


        foreach($products as $product){
           
            $valorations=Valoration::where('idProduct',$product->id)->get();
            $result=0;
            if(count($valorations)){
                foreach($valorations as $valoration){
                    if($valoration!=null){
                        $result=$result+$valoration->valoration;
                    }
                }
                $product->valoration=$result/count($valorations);
            }else{
                $product->valoration=0;
            }
        }

        return $products;
    }

   
}
