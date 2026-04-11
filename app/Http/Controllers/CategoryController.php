<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
                                <a href="'.$editUrl.'" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit info">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                
                                <form method="POST" action="'.$deleteUrl.'" class="d-inline m-0 delete-form">
                                '.csrf_field().'
                                    '.method_field('DELETE').'
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
    public function store(StoreCategoryRequest $request)
    {
        $categorySlug = Str::slug($request->category_name);

        Category::create([
            'category_name' => $request->category_name,
            'category_slug' => $categorySlug,
        ]);

        $notification = [
            'message' => 'Category Created Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
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
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $categorySlug = Str::slug($request->category_name);

        $category->update([
            'category_name' => $request->category_name,
            'category_slug' => $categorySlug,
        ]);

        $notification = [
            'message' => 'Category Updated Successfully',
            'alert-type' => 'info',
        ];

        return redirect()->route('category.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        $notification = [
            'message' => 'Category Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }
}
