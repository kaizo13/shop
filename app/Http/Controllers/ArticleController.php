<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    
    public function store(Request $request)
    {
        $article=new Article;
        $article->name=$request->name;
        $article->save();
    }

    public function get(){
        return Article::all();
    }


}
