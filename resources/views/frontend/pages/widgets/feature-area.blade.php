<!-- featured-area start -->
<div class="featured-area featured-area2">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Categories</h2>
                    {{-- <img src="{{asset('assets/frontend')}}/images/section-title.png" alt=""> --}}
                </div>
                <div class="featured-active2 owl-carousel next-prev-style">
                    @foreach ($categories as $category )

                        <div class="featured-wrap">
                            <div class="featured-img">
                                <img src="{{asset('storage/category')}}/{{$category->category_image}}" alt="">
                                <div class="featured-content">
                                    <a href="shop.html">{{$category->title}}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!-- featured-area end -->
