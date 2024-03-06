<?php

namespace App\Http\Controllers\frontend;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Gloudemans\Shoppingcart\Facades\Cart;

class WishlistController extends Controller
{
    public function wishlistPage()
    {
        $wishlists=Cart::instance('wishlist')->content();
        // dd($wishlist);
        return view('frontend.pages.wishlist', compact('wishlists'));
    }
    public function addToWishlist(Request $request)
    {
        $product_slug = $request->product_slug;
        $order_qty = $request->order_qty;

        $product = Product::whereSlug($product_slug)->first();

        Cart::instance('wishlist')->add([
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'price' => $product->product_price,
            'weight' => 0,
            'product_stock' => $product->product_stock,
            'qty' => $order_qty,
            'options' => [
                'product_image' => $product->product_image
            ]
        ]);

        Toastr::success('Product Added in to wishlist');
        return back();

    }
    public function removeFromWishlist($wishlist_id)
    {
        // dd($wishlist_id);
        Cart::instance('wishlist')->remove($wishlist_id);

        Toastr::info('Product Removed from wishlist!!');
        return back();
    }



}
