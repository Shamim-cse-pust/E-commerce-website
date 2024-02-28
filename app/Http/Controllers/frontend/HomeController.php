<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    function home()
    {
        $testimonials= Testimonial::where('is_active',1)->latest('id')->select(['id','client_name','client_designation','client_message','client_image'])->limit(3)->get();
        $categories= Category::where('is_active',1)->latest('id')->select(['id','title','slug','category_image'])->limit(5)->get();
        // dd($testimonial);
        return view('frontend.pages.home',compact(['testimonials','categories']));
    }
}
