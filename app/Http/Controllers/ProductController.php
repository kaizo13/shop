<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSize;
use App\Models\Size;
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
        $sizes=ProductSize::where('idProduct',$id)->get();
        $product['images']=ProductImage::where('idProduct',$id)->select('img')->get();
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
        $data=array();
        $stock=0;
        foreach($sizes as $size){
            
            $array=array();
            $s=Size::find($size->idSize);
            $array['id']=$size->idSize;
            $array['size']=$s->size;
            $array['stock']=$size->stock;

            array_push($data,$array);

            $stock=$stock + $size->stock;

        }
        
        $product['article']=$article->name;
        $product['brand']=$brand->name;
        $product['sizes']=$data;
        $product['stock']=$stock;
        
        return $product;
    }

    public function getProducts(Request $request){
        
        $products=DB::table('products')
             ->join('articles','products.idArticle','articles.id')
             ->join('brands','products.idBrand','brands.id')
             ->orderBy('products.id','desc')
            // ->select('products.id','description','price','articles.name as article','brands.name as brand');
            ->select('products.id','description','price');
        
        

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

        if($request->description && strlen($request->description)>=3){
            $products->where('description','like', '%' . $request->description . '%');
        }

        $products=$products->get();


        foreach($products as $product){
            $product->images=ProductImage::where('idProduct',$product->id)->select('img')->get();
            $sizes=ProductSize::where('idProduct',$product->id)->get();
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

            $data=array();
            $stock=0;
            foreach($sizes as $size){
            
                $array=array();
                $s=Size::find($size->idSize);
                $array['size']=$s->size;
                $array['stock']=$size->stock;
    
                array_push($data,$array);
    
                $stock=$stock + $size->stock;
    
            }

            $product->sizes=$data;
            $product->stock=$stock;
        }

        return $products;
    }

   
}
