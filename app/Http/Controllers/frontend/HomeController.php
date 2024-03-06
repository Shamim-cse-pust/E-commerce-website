<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;
use App\Models\Testimonial;
use App\Models\OrderDetails;
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

            $TSProducts = OrderDetails::select('product_id', DB::raw('SUM(product_qty) as total_quantity_sold'))
            ->groupBy('product_id')
            ->orderByDesc('total_quantity_sold')
            ->take(5)
            ->get();

        // dd($TSProducts);

        return view('frontend.pages.home',compact(['testimonials','categories','products','TSProducts']));
    }

    function shopPage()
    {
        $allproducts = Product::where('is_active', 1)
        ->latest('id')
        ->select('id','name','slug','product_price', 'product_stock', 'product_rating', 'product_image')
        ->paginate(12);

        $categories = Category::where('is_active', 1)
        ->with('product')
        ->latest('id')
        ->limit(5)
        ->select(['id', 'title', 'slug'])
        ->get();

        return view('frontend.pages.shop', compact(
            'allproducts',
            'categories'

        ));
    }

    function ProductDetail($product_slug)
    {
        $product = Product::whereSlug($product_slug)->with('category','productImages')->first();
        $related = Product::whereNot('slug',$product_slug)->limit(4)->get();
        // dd($product->productImages);
        return view('frontend.pages.single-product', compact(
            'product',
            'related'

        ));
    }
}
