<?php

namespace App\Http\Controllers\backend;

use App\Models\Category;
use App\Models\Testimonial;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest('id')->select(['id', 'title', 'slug','updated_at','category_image'])->paginate();
        // return $categories;
        return view('backend.pages.category.index', compact('categories'));
        // return redirect()->route('admin.dashboard');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'title' => 'required|string|max:255|unique:categories,title',
            'category_image' => 'required|nullable|image|mimes:jpg,png,jpeg|max:1024',
            // 'email' => 'required|email',
            // Add validation rules for other fields as needed
        ]);
        // dd($request);
        $categories = Category::create([
            'title'=> $request->title,
            'slug'=> Str::slug($request->title)

        ]);
        // dd($request->category_image);
        $this->image_upload($request, $categories->id,0);


        Toastr::success('Data Store Successfully!');
        return redirect()->route('category.index');
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
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        // dd($category);
        return view('backend.pages.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);
       // dd($request->title,$request->category_image);
        // dd($request->category_image);
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'category_image' => 'required|nullable|image|mimes:jpg,png,jpeg|max:1024',
        ]);

        $category->update([
            'title'=> $request->title,
            'slug'=> Str::slug($request->title)
        ]);
        // dd($category);
        $this->image_upload($request, $category->id,1);

        Toastr::success('Data Update Successfully!');
        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //dd($id);
        $category = Category::findOrFail($id);
        // $category = Category::whereSlug($slug)->first();

        if($category->category_image && $category->category_image!="default.jpg"){
            $photo_location = 'storage/category/'.$category->category_image;
            unlink($photo_location);
        }

        $category->delete();

        Toastr::success('Data Deleted Successfully!');
        return redirect()->route('category.index');
    }


    public function image_upload($request, $item_id,$val)
    {

        $category = Category::findorFail($item_id);
        // dd($category->category_name);

        //dd($request->all(), $testimonial, $request->hasFile('client_image'));
        if ($request->hasFile('category_image')) {
            // dd($testimonial->client_image );
            // dd($category);

            if ($category->category_image != 'default.jpg' && $val==1) {
                //delete old photo
                $photo_location = 'public/storage/category/';
                $old_photo_location = $photo_location . $category->category_image;
                unlink(base_path($old_photo_location));
            }
            // dd($category);
            $manager = new ImageManager(new Driver());
            $uploaded_photo = $request->file('category_image');
            $new_photo_name =$category->id . '.' . $uploaded_photo->getClientOriginalExtension();
            $new_photo_location = 'public/storage/category/'.$new_photo_name;
            // dd($new_photo_location);
            // read image from file system
            $image = $manager->read($uploaded_photo);

            // resize image proportionally to 300px width
            $image->scale(width: 105,height:105);

            $image->toPng()->save(base_path($new_photo_location));

            $check = $category->update([
                'category_image' => $new_photo_name,
            ]);
            // dd($category);
        }
    }
}
