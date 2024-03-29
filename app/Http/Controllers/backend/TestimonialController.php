<?php

namespace App\Http\Controllers\backend;

use App\Models\Testimonial;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
$count=1;
class TestimonialController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$testimonial=Testimonial::latest(['id'])->select(['id','client_name','client_designation','client_image'])->paginate();

       $testimonials = Testimonial::latest('id')->select(['id','client_name', 'client_name_slug','client_designation','client_message','client_image','updated_at'])->paginate(100);
        return view('backend.pages.Testimonial.index',compact(['testimonials']));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.Testimonial.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_designation' => 'required|string|max:255',
            'client_message' => 'required|string',
            'client_image' => 'required|nullable|image|mimes:jpg,png,jpeg|max:1024',
        ]);
       $testimonials= Testimonial::create([
            'client_name' => $request->client_name,
            'client_name_slug' => Str::slug($request->client_name),
            'client_designation'=> $request->client_designation,
            'client_message'=> $request->client_message,
            'client_image' =>$request->client_image,
        ]);

        // $file=$request->File('client_image');
        // dump(Storage::putFileAs('testimonial',$file,'testimonial'.'.'.$file->getClientOriginalExtension()));

       $this->image_upload($request, $testimonials->id,0);

        Toastr::success('Data Store Successfully!');
        return redirect()->route('testimonial.index');
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
        $testimonial = Testimonial::findOrFail($id);
       // dd($testimonial);
        return view('backend.pages.Testimonial.edit', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_designation' => 'required|string|max:255',
            'client_message' => 'required|string',
            'client_image' => 'required|nullable|image|mimes:jpg,png,jpeg|max:1024',
        ]);
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->update([
            'client_name' => $request->client_name,
            'client_name_slug' => Str::slug($request->client_name),
            'client_designation' => $request->client_designation,
            'client_message' => $request->client_message,
            'is_active' => $request->filled('is_active')
        ]);

        $this->image_upload($request, $testimonial->id,1);

        Toastr::success('Data Updated Successfully!!');
        return redirect()->route('testimonial.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $testimonial = testimonial::findOrFail($id);
        if($testimonial->client_image && $testimonial->client_image!="default.jpg"){
            $photo_location = 'assets/storage/testimonial/'.$testimonial->client_image;
            unlink($photo_location);
        }

        $testimonial->delete();
        Toastr::success('Data Deleted Successfully!');
        return redirect()->route('testimonial.index');
    }



    public function image_upload($request, $item_id,$val)
    {

        $testimonial = Testimonial::findorFail($item_id);
        //dd($request->all(), $testimonial, $request->hasFile('client_image'));
        if ($request->hasFile('client_image')) {
            // dd($testimonial->client_image );

            if ($testimonial->client_image != 'default.jpg' && $val==1) {
                //delete old photo
                $photo_location = 'public/assets/storage/testimonial/';
                $old_photo_location = $photo_location . $testimonial->client_image;
                unlink(base_path($old_photo_location));
            }

            $manager = new ImageManager(new Driver());
            $uploaded_photo = $request->file('client_image');
            $new_photo_name =$testimonial->id . '.' . $uploaded_photo->getClientOriginalExtension();
            $new_photo_location = 'public/assets/storage/testimonial/'.$new_photo_name;

            // read image from file system
            $image = $manager->read($uploaded_photo);

            // resize image proportionally to 300px width
            $image->scale(width: 105,height:105);

            $image->toPng()->save(base_path($new_photo_location));

            $check = $testimonial->update([
                'client_image' => $new_photo_name,
            ]);
        }
    }
}
