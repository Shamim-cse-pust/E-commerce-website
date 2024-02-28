<?php

namespace App\Http\Controllers\backend;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::where('is_active', 1)->with('category')->latest('id')
            ->select('id', 'category_id', 'name', 'slug', 'product_price', 'product_stock', 'alert_quantity', 'product_image', 'product_rating','updated_at')
            ->paginate(20);

        //return $products;

            return view('backend.pages.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::select(['id','title'])->get();
        return view('backend.pages.product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        $product = Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'product_code' => $request->product_code,
            'product_price' => $request->product_price,
            'product_stock' => $request->product_stock,
            'alert_quantity' => $request->alert_quantity,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'additional_info' => $request->additional_info,
        ]);

        $this->image_upload($request, $product->id,0);
        $this->multiple_image__upload($request, $product->id,0);
        Toastr::success('Data Stored Successfully!');
        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $product = Product::whereSlug($slug)->first();
        // return $product;
        $categories = Category::select(['id','title'])->get();
        return view('backend.pages.product.edit', compact('categories', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, string $slug)
    {
        $product = Product::whereSlug($slug)->first();
        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'product_code' => $request->product_code,
            'product_price' => $request->product_price,
            'product_stock' => $request->product_stock,
            'alert_quantity' => $request->alert_quantity,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'additional_info' => $request->additional_info,
        ]);

        $this->image_upload($request, $product->id,1);
        $this->multiple_image__upload($request, $product->id,1);
        Toastr::success('Data Updated Successfully!');
        return redirect()->route('product.index');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $product = Product::whereSlug($slug)->first();
        if($product->product_image && $product->product_image!="default.jpg"){
            $photo_location = 'storage/product/'.$product->product_image;
            unlink($photo_location);
        }

        $product->delete();

        Toastr::success('Data Deleted Successfully!');
        return redirect()->route('product.index');

    }

    public function image_upload($request, $product_id,$val)
    {
        $product = Product::findorFail($product_id);
        // dd($product->product_image);

        //dd($request->all(), $testimonial, $request->hasFile('client_image'));
        if ($request->hasFile('product_image')) {
            // dd($testimonial->client_image );
            // dd($product->product_image);

            if ($product->product_image != 'default.jpg' && $val==1) {
                //delete old photo
                $photo_location = 'public/storage/product/';
                $old_photo_location = $photo_location . $product->product_image;
                unlink(base_path($old_photo_location));
            }
            // dd($product);
            $manager = new ImageManager(new Driver());
            $uploaded_photo = $request->file('product_image');
            $new_photo_name =$product->id . '.' . $uploaded_photo->getClientOriginalExtension();
            $new_photo_location = 'public/storage/product/'.$new_photo_name;
            // dd($new_photo_location);
            // read image from file system
            $image = $manager->read($uploaded_photo);

            // resize image proportionally to 300px width
            $image->scale(width: 105,height:105);

            $image->toPng()->save(base_path($new_photo_location));

            $check = $product->update([
                'product_image' => $new_photo_name,
            ]);
            // dd($product);
        }
    }

    public function multiple_image__upload($request, $product_id,$val)
    {
        if ($request->hasFile('product_multiple_image')) {

            // delete old photo first
            $multiple_images = ProductImage::where('product_id', $product_id)->get();
            //dd($multiple_images[0]);
            if($val==1){
            foreach ($multiple_images as $multiple_image) {
                //dd($multiple_image->product_multiple_image);
                if ($multiple_image->product_multiple_image != 'default.jpg') {
                    //delete old photo
                    $photo_location = 'public/storage/product/';
                    $old_photo_location = $photo_location . $multiple_image->product_multiple_image;
                    // dd($old_photo_location);
                    unlink(base_path($old_photo_location));
                }
                // delete old value of db table
                $multiple_image->delete();
            }
        }

            $flag = 1; // Assign a flag variable
            foreach ($request->file('product_multiple_image') as $single_photo) {
            $manager = new ImageManager(new Driver());
            // $uploaded_photo = $request->file('product_multiple_image');
            $new_photo_name =$product_id .'-'.$flag.'.'. $single_photo->getClientOriginalExtension();
            $new_photo_location = 'public/storage/product/'.$new_photo_name;

            $image = $manager->read($single_photo);

            // resize image proportionally to 300px width
            $image->scale(width: 600,height:622);

            $image->toPng()->save(base_path($new_photo_location));

            ProductImage::create([
                'product_id' => $product_id,
                'product_multiple_image' => $new_photo_name,
            ]);
            $flag++;
        }

        }
    }


}
