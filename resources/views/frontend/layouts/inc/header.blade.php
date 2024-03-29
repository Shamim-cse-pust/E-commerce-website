<!-- header-area start -->
<header class="header-area">
    <div class="header-top bg-2">
        <div class="fluid-container">
            <div class="row">
                <div class="col-md-6 col-12">
                    <ul class="d-flex header-contact">
                        <li><i class="fa fa-phone"></i> +88 01784766676</li>
                        <li><i class="fa fa-envelope"></i> shamim.pust.cse@gmail.com</li>
                    </ul>
                </div>
                <div class="col-md-6 col-12">
                    <ul class="d-flex account_login-area">
                        @auth
                        <li>
                            <a href="javascript:void(0);"><i class="fa fa-user"></i> My Account <i
                                    class="fa fa-angle-down"></i></a>
                            <ul class="dropdown_style">
                                <li><a href="{{ route('cart.page') }}">Cart</a></li>
                                <li><a href="checkout.html">Checkout</a></li>
                                <li><a href="{{route('wishlist.page')}}">wishlist</a></li>
                                <li><a href="{{ route('customer.logout') }}">Logout</a></li>
                            </ul>
                        </li>
                        @endauth
                        @guest
                        <li><a href="{{ route('login.page') }}"> Login </a></li>
                        <li><a href="{{ route('register.page') }}"> Register </a></li>
                        @endguest
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom">
        <div class="fluid-container">
            <div class="row">
                <div class="col-lg-3 col-md-7 col-sm-6 col-6">
                    <div class="logo">
                        <a href="index.html">
                    <img src="{{asset('assets/frontend')}}/images/logo.png" alt="">
                    </a>
                    </div>
                </div>
                <div class="col-lg-7 d-none d-lg-block">
                    <nav class="mainmenu">
                        <ul class="d-flex">
                            <li class="active"><a href="{{route('home')}}">Home</a></li>
                            <li><a href="about.html">About</a></li>
                            <li>
                                <a href="javascript:void(0);">Shop <i class="fa fa-angle-down"></i></a>
                                <ul class="dropdown_style">
                                    <li><a href="{{route('shop.page')}}">Shop Page</a></li>
                                    <li><a href="{{ route('cart.page') }}">Shopping cart</a></li>
                                    <li><a href="{{route('customer.checkoutpage')}}">Checkout</a></li>
                                    <li><a href="{{route('wishlist.page')}}">Wishlist</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0);">Pages <i class="fa fa-angle-down"></i></a>
                                <ul class="dropdown_style">
                                    <li><a href="about.html">About Page</a></li>
                                    <li><a href="{{ route('cart.page') }}">Shopping cart</a></li>
                                    <li><a href="{{route('customer.checkoutpage')}}">Checkout</a></li>
                                    <li><a href="{{route('wishlist.page')}}">Wishlist</a></li>
                                    <li><a href="faq.html">FAQ</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0);">Blog <i class="fa fa-angle-down"></i></a>
                                <ul class="dropdown_style">
                                    <li><a href="blog.html">blog Page</a></li>
                                    <li><a href="blog-details.html">blog Details</a></li>
                                </ul>
                            </li>
                            <li><a href="contact.html">Contact</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-md-4 col-lg-2 col-sm-5 col-4">
                    <ul class="search-cart-wrapper d-flex">
                        <li class="search-tigger"><a href="javascript:void(0);"><i class="flaticon-search"></i></a></li>
                        <li>
                            {{-- @php
                                        $wishlist = \Gloudemans\Shoppingcart\Facades\Cart::instance('wishlist')->content();
                                        $Wtotal_price = \Gloudemans\Shoppingcart\Facades\Cart::instance('wishlist')->subtotal();
                            @endphp --}}


                            <a href="javascript:void(0);"><i class="flaticon-like"></i> <span></span></a>
                            <ul class="cart-wrap dropdown_style">
                                {{-- @foreach ($wishlist as $items )
                                <li class="cart-items">
                                    <div class="cart-img">
                                        <img src="{{asset('assets/storage/product')}}/{{$items->options->product_image}}" alt="" class="img-fluid rounded" style="width: 60px;">
                                    </div>
                                    <div class="cart-content">
                                        <a href="{{ route('wishlist.page') }}">{{$items->name}}</a>
                                        <span>{{$items->qty}}</span>
                                        <p>{{$items->price}}</p>
                                        <i class="fa fa-times"></i>
                                    </div>
                                </li>

                                @endforeach
                                <li>Subtotol: <span class="pull-right">${{$Wtotal_price}}</span></li> --}}
                                <li>
                                    <a href="{{route('wishlist.page')}}" class="btn btn-danger">Wishlist</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                                @php
                                        $carts = \Gloudemans\Shoppingcart\Facades\Cart::content();
                                        $cartCount= \Gloudemans\Shoppingcart\Facades\Cart::count();
                                        $total_price = \Gloudemans\Shoppingcart\Facades\Cart::subtotal();
                                @endphp
                            <a href="javascript:void(0);"><i class="flaticon-shop"></i> <span>{{$cartCount}}</span></a>
                            <ul class="cart-wrap dropdown_style">

                                @foreach ($carts as $item)
                                <li class="cart-items">
                                    <div class="cart-img">
                                        <img src="{{asset('assets/storage/product')}}//{{ $item->options->product_image }}" alt="" class="img-fluid rounded" style="width: 60px;">
                                    </div>
                                    <div class="cart-content text-white">
                                        <a href="{{ route('cart.page') }}">{{ $item->name }}</a>
                                        <span>QTY : {{ $item->qty }}</span>
                                        <p>${{ $item->qty*$item->price }}</p>
                                        <a href="{{ route('removefrom.cart',['cart_id' => $item->rowId]) }}">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </div>
                                    @endforeach

                                    <li>Subtotol: <span class="pull-right">${{ $total_price }}</span></li>
                                <li>
                                    <a href="{{route('customer.checkoutpage')}}" class="btn btn-danger">Check Out</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="col-md-1 col-sm-1 col-2 d-block d-lg-none">
                    <div class="responsive-menu-tigger">
                        <a href="javascript:void(0);">
                    <span class="first"></span>
                    <span class="second"></span>
                    <span class="third"></span>
                    </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- responsive-menu area start -->
        <div class="responsive-menu-area">
            <div class="container">
                <div class="row">
                    <div class="col-12 d-block d-lg-none">
                        <ul class="metismenu">
                            <li><a href="index.html">Home</a></li>
                            <li><a href="about.html">About</a></li>
                            <li class="sidemenu-items">
                                <a class="has-arrow" aria-expanded="false" href="javascript:void(0);">Shop </a>
                                <ul aria-expanded="false">
                                    <li><a href="shop.html">Shop Page</a></li>
                                    <li><a href="single-product.html">Product Details</a></li>
                                    <li><a href="{{ route('cart.page') }}">Shopping cart</a></li>
                                    <li><a href="checkout.html">Checkout</a></li>
                                    <li><a href="{{route('wishlist.page')}}">Wishlist</a></li>
                                </ul>
                            </li>
                            <li class="sidemenu-items">
                                <a class="has-arrow" aria-expanded="false" href="javascript:void(0);">Pages </a>
                                <ul aria-expanded="false">
                                  <li><a href="about.html">About Page</a></li>
                                  <li><a href="single-product.html">Product Details</a></li>
                                  <li><a href="{{ route('cart.page') }}">Shopping cart</a></li>
                                  <li><a href="checkout.html">Checkout</a></li>
                                  <li><a href="{{route('wishlist.page')}}">Wishlist</a></li>
                                  <li><a href="faq.html">FAQ</a></li>
                                </ul>
                            </li>
                            <li class="sidemenu-items">
                                <a class="has-arrow" aria-expanded="false" href="javascript:void(0);">Blog</a>
                                <ul aria-expanded="false">
                                    <li><a href="blog.html">Blog</a></li>
                                    <li><a href="blog-details.html">Blog Details</a></li>
                                </ul>
                            </li>
                            <li><a href="contact.html">Contact</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- responsive-menu area start -->
    </div>
</header>
<!-- header-area end -->
