<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::latest()->get();
        if ($request->ajax()) {

            return DataTables::of($categories)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editUrl = route('category.edit', $row->id);
                    $deleteUrl = route('category.destroy', $row->id);

                    $btn = '<div class="d-flex align-items-center gap-3 fs-5">
                                <a href="' . $editUrl . '" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit info">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                
                                <form method="POST" action="' . $deleteUrl . '" class="d-inline m-0 delete-form">
                                ' . csrf_field() . '
                                    ' . method_field('DELETE') . '
                                    <button type="submit" id="delete" class="text-danger border-0 bg-transparent p-0 d-inline-flex align-items-center delete-btn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete" style="cursor: pointer; line-height: 1;">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </div>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $totalCategories = $categories->count();

        return view('admin.category.index', compact('totalCategories'));
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
