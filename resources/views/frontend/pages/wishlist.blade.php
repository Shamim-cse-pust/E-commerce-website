@extends('frontend.layouts.master')

@section('frontendtitle') Wishlist Page @endsection

@section('frontend-content')
   @include('frontend.pages.widgets.breadcumb-area', ['pagename' => 'Wishlist'])



<!-- cart-area start -->
<div class="cart-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                {{-- <form action="http://themepresss.com/tf/html/tohoney/cart"> --}}
                    <table class="table-responsive cart-wrap">
                        <thead>
                            <tr>
                                <th class="images">Image</th>
                                <th class="product">Product</th>
                                <th class="ptice">Price</th>
                                <th class="stock">Stock Stutus </th>
                                <th class="addcart">Add to Cart</th>
                                <th class="remove">Remove</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($wishlists as $wishlist)
                                <tr>
                                    @php
                                        $product = App\Models\Product::find($wishlist->id);
                                    @endphp
                                    <td class="images"><img src="{{asset('storage/product')}}/{{ $wishlist->options->product_image }}" alt=""></td>
                                    <td class="product"><a href="#">{{$wishlist->name}}</a></td>
                                    <td class="ptice">{{$wishlist->price}}</td>
                                    <td class="stock">{{$wishlist->qty}}</td>
                                    {{-- <td class="stock">{{$product->slug}}</td> --}}
                                    <td class="addcart">

                                        <form action="{{ route('add-to.cart') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="product_slug" value="{{ $product->slug }}">
                                            <li class="quantity cart-plus-minus">
                                                <input type="text" value="1" name="order_qty" />
                                            </li>
                                            <li>
                                                <button type="submit" class="btn btn-danger">Add to Cart</button>
                                            </li>
                                        </form>

                                    </td>
                                    <td class="remove">
                                        <a href="{{ route('removefrom.wishlist',['wishlist_id' => $wishlist->rowId]) }}">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </td>
                                </tr>



                            @endforeach
                        </tbody>
                    </table>
                {{-- </form> --}}
            </div>
        </div>
    </div>
</div>
<!-- cart-area end -->


@endsection
