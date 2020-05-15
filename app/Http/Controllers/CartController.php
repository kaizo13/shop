<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Size;
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

    public function addProduct(Request $request){
       
        $cart=Cart::where('idCustomer',$request->idCustomer)->first();
        if($cp=CartProduct::where('idCart',$cart->id)->where('idProduct',$request->idProduct)->where('idSize',$request->idSize)->first()){
            $quantity=$cp->quantity;
            $cp->delete();
            $cp=new CartProduct;
            $cp->idCart=$cart->id;
            $cp->idProduct=$request->idProduct;
            if($request->idSize!=null){
                $cp->idSize=$request->idSize;
            }
            $cp->quantity=$quantity+$request->quantity;
            $cp->save();
        }else{
            $cp=new CartProduct;
            $cp->idCart=$cart->id;
            $cp->idProduct=$request->idProduct;
            $cp->quantity=$request->quantity;
            if($request->idSize!=null){
                $cp->idSize=$request->idSize;
            }
            $cp->save();
        }
        
    }

    public function getCart($id){
        $cart=Cart::where('idCustomer',$id)->first();
        
            $cp=CartProduct::where('idCart',$cart->id)->orderBy('id','desc')->get();
            $array=array();
            $price=0;

            foreach($cp as $c){
                $product=Product::where('id',$c->idProduct)->first();
                $img=ProductImage::where('idProduct',$product->id)->orderBy('id','asc')->select('img')->first();
                $product['img']=$img->img;
                $product['quantity']=$c->quantity;
                if($c->idSize!=null){
                    $size=Size::find($c->idSize);
                    $product['size']=$size->size;
                }
                array_push($array,$product);
                $price=$price + $c->quantity * $product->price;
            }
            $cart['price']=$price;
            $cart['products']=$array;
            
        
        
        return $cart;
    }

    public function deleteProductCart($idCart,Request $request){
      
            if($request->size){
                $size=Size::where('size',$request->size)->first();
                CartProduct::where('idCart',$idCart)->where('idProduct',$request->id)->where('idSize',$size->id)->delete();
            }else{
                CartProduct::where('idCart',$idCart)->where('idProduct',$request->id)->delete();
            }
        
    }

    public function emptyCart($id){
        CartProduct::where('idCart',$id)->delete();
    }

    
}
