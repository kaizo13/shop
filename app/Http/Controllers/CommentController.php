<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Customer;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function get($id){
       $comments=$this->recursive(Comment::where('idProduct',$id)->where('idComment',null)->select('id','idCustomer','text','idComment')->get(),$id);
        return $comments;
    }
    
    public function store(Request $request)
    {
        $comment=new Comment;
        $comment->idCustomer=$request->idCustomer;
        $comment->idProduct=$request->idProduct;
        $comment->text=$request->text;
        if($request->idComment){
            $comment->idComment=$request->idComment;
        }
        $comment->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment=Comment::find($id);
        $comment->delete();
    }

    private function recursive(Object $comments,$id){
        foreach($comments as $comment){
            if($answers=Comment::where('idProduct',$id)->where('idComment',$comment->id)->select('id','idCustomer','text','idComment')->get()){
                $customer=Customer::find($comment->idCustomer);
                $comment['customer']=$customer->name;
                $comment['answers']=$answers;
                $this->recursive($answers,$id);
            }else{
                $comment['answers']=$comment;
            }
        }
        return $comments;
    }
}
