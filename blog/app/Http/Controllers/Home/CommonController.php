<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Navs;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class CommonController extends Controller
{
    public function __construct()
    {
        $navs = Navs::all();

        //点击量最高的6篇文章
        $hot2 = Article::orderBy('art_view','desc')->take(5)->get();

        //最新发布的8篇文章
        $new = Article::orderBy('art_time','desc')->take(8)->get();

        View::share('navs',$navs);
        View::share('hot2',$hot2);
        View::share('new',$new);


    }
}
