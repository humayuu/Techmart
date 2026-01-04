<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderBy('id', 'DESC')->paginate(5);
        $totalCategories = $categories->count();
        return view('admin.category.index', compact('categories', 'totalCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|unique:categories,category_name',
        ]);

        // Generate Category Slug
        $categorySlug = Str::slug($request->category_name);

        DB::beginTransaction();

        try {

            Category::create([
                'category_name' => $request->category_name,
                'category_slug' => $categorySlug,
            ]);

            $notification = [
                'message' => 'Category Created Successfully',
                'alert-type' => 'success'
            ];

            DB::commit();

            return redirect()->back()->with($notification);
        } catch (Exception $e) {
            DB::rollBack();


            Log::error('Category creation failed ' . $e->getMessage());

            $notification = [
                'message' => 'Category creation failed ',
                'alert-type' => 'error',
            ];

            return redirect()->back()->with($notification)->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'category_name' => 'required',
        ]);

        // Generate Category Slug
        $categorySlug = Str::slug($request->category_name);

        DB::beginTransaction();

        try {

            $category->update([
                'category_name' => $request->category_name,
                'category_slug' => $categorySlug,
            ]);

            $notification = [
                'message' => 'Category Updated Successfully',
                'alert-type' => 'info'
            ];

            DB::commit();

            return redirect()->route('category.index')->with($notification);
        } catch (Exception $e) {
            DB::rollBack();


            Log::error('Category creation failed ' . $e->getMessage());

            $notification = [
                'message' => 'Category creation failed ',
                'alert-type' => 'error',
            ];

            return redirect()->back()->with($notification)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        DB::beginTransaction();

        try {

            $category->delete();

            $notification = [
                'message' => 'Category Deleted Successfully',
                'alert-type' => 'success'
            ];

            DB::commit();

            return redirect()->back()->with($notification);
        } catch (Exception $e) {
            DB::rollBack();


            Log::error('Category deletion failed ' . $e->getMessage());

            $notification = [
                'message' => 'Category deletion failed ',
                'alert-type' => 'error',
            ];

            return redirect()->back()->with($notification)->withInput();
        }
    }
}
