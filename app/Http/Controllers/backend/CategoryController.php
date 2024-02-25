<?php

namespace App\Http\Controllers\backend;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest('id')->select(['id', 'title', 'slug','updated_at'])->paginate();
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
            // 'email' => 'required|email',
            // Add validation rules for other fields as needed
        ]);
        Category::create([
            'title'=> $request->title,
            'slug'=> Str::slug($request->title)

        ]);

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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
