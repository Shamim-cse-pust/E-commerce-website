<?php

namespace App\Http\Controllers\frontend;

use App\Models\Product;
use App\Models\Category;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    function home()
    {
        $testimonials= Testimonial::where('is_active',1)->latest('id')->select(['id','client_name','client_designation','client_message','client_image'])->limit(3)->get();
        $categories= Category::where('is_active',1)->latest('id')->select(['id','title','slug','category_image'])->limit(5)->get();
        $products = Product::where('is_active',1)
            ->latest('id')
            ->select('id','name','slug','product_price', 'product_stock', 'product_rating', 'product_image')
            ->paginate(12);

        return view('frontend.pages.home',compact(['testimonials','categories','products']));
    }
}
