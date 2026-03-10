<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::with('brand', 'category')
            ->latest()
            ->get();
        if ($request->ajax()) {

            return DataTables::of($products)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    if ($row->product_thumbnail) {
                        $imageUrl = asset('images/products/thumbnail/'.$row->product_thumbnail);

                        return '<img src="'.$imageUrl.'" alt="Product Image" class="img-thumbnail w-75 rounded">';
                    }

                    return '<span class="text-muted">No Image</span>';
                })
                ->addColumn('brand', function ($row) {
                    if ($row->brand) {
                        return '<span class="text-dark fw-semibold fs-6">'.$row->brand->brand_name.'</span>';
                    }

                    return '<span class="text-muted fst-italic">No Brand</span>';
                })
                ->addColumn('category', function ($row) {
                    if ($row->category) {
                        return '<span class="text-dark fw-semibold fs-6">'.$row->category->category_name.'</span>';
                    }

                    return '<span class="text-muted fst-italic fs-6">No Category</span>';
                })
                ->addColumn('selling_price', function ($row) {
                    if ($row->selling_price) {
                        return '<span class="text-dark fw-semibold fs-5">$'.$row->selling_price.'</span>';
                    }

                    return '<span class="text-muted fst-italic fs-6">No Category</span>';
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == 'active') {
                        return '<span class="badge bg-primary fs-6">Active</span>';
                    } else {
                        return '<span class="badge bg-secondary fs-6">Inactive</span>';
                    }
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('product.edit', $row->id);
                    $deleteUrl = route('product.destroy', $row->id);
                    $statusUrl = route('product.status', $row->id);
                    $detailUrl = route('product.show', $row->id);
                    $class = $row->status == 'active' ? 'success' : 'dark';
                    $icon = $row->status == 'active' ? 'thumbs-up' : 'thumbs-down';

                    $btn = '<div class="d-flex align-items-center gap-3 fs-5">

                      <a href="'.$detailUrl.'"
                      class="text-secondary fs-4 " data-bs-toggle="tooltip"
                      data-bs-placement="bottom" title="View Info">
                      <i class="bi bi-eye-fill"></i>
                      </a>
                            <a href="'.$editUrl.'" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit info">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <a href="'.$statusUrl.'"
                            class="text-'.$class.'" data-bs-toggle="tooltip"
                            data-bs-placement="bottom" title="Edit info">
                            <i class="bi bi-hand-'.$icon.'-fill"></i>
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
                ->rawColumns(['selling_price', 'brand', 'category', 'image', 'status', 'action'])
                ->make(true);
        }

        $totalProducts = $products->count();

        return view('admin.product.index', compact('totalProducts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::orderBy('id', 'DESC')->get();
        $categories = Category::orderBy('id', 'DESC')->get();

        return view('admin.product.create', compact('brands', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Fields validations
        $request->validate([
            'brand' => 'required',
            'category' => 'required',
            'product_name' => 'required|unique:products,product_name|min:5|max:100',
            'product_code' => 'required',
            'selling_price' => 'required',
            'discount_price' => 'required',
            'quantity' => 'required',
            'weight' => 'required',
            'tags' => 'required',
            'short_description' => 'required',
            'long_description' => 'required',
            'thumbnail' => 'required|mimes:jpeg,jpg,png|max:2048',
            'images.*' => 'required|mimes:jpeg,jpg,png|max:2048', // 2MB
            'other_info' => 'required',
        ]);

        // Create Product Slug & status
        $slug = Str::slug($request->product_name);
        $status = 'active';

        DB::beginTransaction();

        // Create Directory for Thumbnail
        $thumbnailDestination = public_path('images/products/thumbnail');
        if (! is_dir($thumbnailDestination)) {
            mkdir($thumbnailDestination, 0755, true);
        }

        // Create Directory for Additional Images
        $additionalDestination = public_path('images/products/additional_images');
        if (! is_dir($additionalDestination)) {
            mkdir($additionalDestination, 0755, true);
        }

        $manager = new ImageManager(new Driver);

        $fileName = null;
        $multiFileName = null;
        $additionalImages = [];

        try {
            // Upload Product Thumbnail
            if ($img = $request->file('thumbnail')) {
                $fileName = uniqid('thumbnail_').'.'.$img->getClientOriginalExtension();
                $manager->read($img)->resize(300, 300)->save($thumbnailDestination.'/'.$fileName);
            }

            // Upload Additional Images
            if ($multipleImages = $request->file('images')) {
                foreach ($multipleImages as $img) {
                    $multiFileName = uniqid('additional_img_').'.'.$img->getClientOriginalExtension();
                    $manager->read($img)->resize(800, 800)->save($additionalDestination.'/'.$multiFileName);
                    $additionalImages[] = $multiFileName;
                }
            }

            Product::create([
                'brand_id' => $request->brand,
                'category_id' => $request->category,
                'product_name' => $request->product_name,
                'product_slug' => $slug,
                'product_code' => $request->product_code,
                'product_qty' => $request->quantity,
                'product_tags' => $request->tags,
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,
                'selling_price' => $request->selling_price,
                'discount_price' => $request->discount_price,
                'product_thumbnail' => $fileName,
                'product_multiple_image' => json_encode($additionalImages),
                'featured' => $request->is_featured ?? 0,
                'special_offer' => $request->special_offer ?? 0,
                'product_weight' => $request->weight,
                'other_info' => $request->other_info,
                'status' => $status,
            ]);
            DB::commit();

            return redirect()->route('product.index')->with([
                'message' => 'Product created Successfully',
                'alert-type' => 'success',
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            if ($fileName && file_exists(public_path('images/products/thumbnail/'.$fileName))) {
                unlink(public_path($fileName));
            }

            foreach ($additionalImages as $img) {
                if (file_exists(public_path($img))) {
                    unlink(public_path($img));
                }
            }

            Log::error('Product creation failed '.$e->getMessage());

            return redirect()->back()->with([
                'message' => 'Product creation failed ',
                'alert-type' => 'error',
            ])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        $brands = Brand::orderBy('id', 'DESC')->get();
        $categories = Category::orderBy('id', 'DESC')->get();
        $images = json_decode($product->product_multiple_image);

        return view('admin.product.show', compact('product', 'brands', 'categories', 'images'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $brands = Brand::orderBy('id', 'DESC')->get();
        $categories = Category::orderBy('id', 'DESC')->get();
        $product = Product::findOrFail($id);
        $images = json_decode($product->product_multiple_image);

        return view('admin.product.edit', compact('product', 'brands', 'categories', 'images'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'brand' => 'required',
            'category' => 'required',
            'product_name' => 'required|unique:products,product_name,'.$id.'|min:5|max:100',
            'product_code' => 'required',
            'selling_price' => 'required|numeric|min:0',
            'discount_price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'weight' => 'required',
            'tags' => 'required',
            'short_description' => 'required',
            'long_description' => 'required',
            'thumbnail' => 'nullable|mimes:jpeg,jpg,png|max:2048',
            'images.*' => 'nullable|mimes:jpeg,jpg,png|max:2048',
            'other_info' => 'required',
        ]);

        $slug = Str::slug($request->product_name);

        $thumbnailDestination = public_path('images/products/thumbnail');
        if (! is_dir($thumbnailDestination)) {
            mkdir($thumbnailDestination, 0755, true);
        }

        $additionalDestination = public_path('images/products/additional_images');
        if (! is_dir($additionalDestination)) {
            mkdir($additionalDestination, 0755, true);
        }

        $manager = new ImageManager(new Driver);

        // urrent DB values
        $fileName = $product->product_thumbnail;
        $oldImages = json_decode($product->product_multiple_image, true) ?? [];
        $additionalImages = $oldImages;

        // Track newly uploaded files for rollback cleanup
        $newThumbnail = null;
        $newAdditionalImages = [];

        // Track old files to delete AFTER successful commit
        $filesToDeleteAfterCommit = [];

        DB::beginTransaction();

        try {
            // Upload new thumbnail
            if ($img = $request->file('thumbnail')) {
                $newThumbnail = uniqid('thumbnail_').'.'.$img->getClientOriginalExtension();
                $manager->read($img)->resize(300, 300)->save($thumbnailDestination.'/'.$newThumbnail);

                // Schedule old thumbnail for deletion after commit
                if ($product->product_thumbnail) {
                    $filesToDeleteAfterCommit[] = $thumbnailDestination.'/'.$product->product_thumbnail;
                }

                $fileName = $newThumbnail;
            }

            // Upload new additional images
            if ($multipleImg = $request->file('images')) {
                foreach ($multipleImg as $img) {
                    $multiFileName = uniqid('additional_img_').'.'.$img->getClientOriginalExtension();
                    $manager->read($img)->resize(800, 800)->save($additionalDestination.'/'.$multiFileName);
                    $newAdditionalImages[] = $multiFileName;
                }

                // Schedule old additional images for deletion after commit
                foreach ($oldImages as $oldImg) {
                    $filesToDeleteAfterCommit[] = $additionalDestination.'/'.$oldImg;
                }

                $additionalImages = $newAdditionalImages;
            }

            $product->update([
                'brand_id' => $request->brand,
                'category_id' => $request->category,
                'product_name' => $request->product_name,
                'product_slug' => $slug,
                'product_code' => $request->product_code,
                'product_qty' => $request->quantity,
                'product_tags' => $request->tags,
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,
                'selling_price' => $request->selling_price,
                'discount_price' => $request->discount_price,
                'product_thumbnail' => $fileName,
                'product_multiple_image' => json_encode($additionalImages),
                'featured' => $request->is_featured ?? 0,
                'special_offer' => $request->special_offer ?? 0,
                'product_weight' => $request->weight,
                'other_info' => $request->other_info,
            ]);

            DB::commit();

            foreach ($filesToDeleteAfterCommit as $path) {
                if (file_exists($path)) {
                    unlink($path);
                }
            }

            return redirect()->route('product.index')->with([
                'message' => 'Product Updated Successfully',
                'alert-type' => 'success',
            ]);

        } catch (Exception $e) {
            DB::rollBack();

            if ($newThumbnail && file_exists($thumbnailDestination.'/'.$newThumbnail)) {
                unlink($thumbnailDestination.'/'.$newThumbnail);
            }
            foreach ($newAdditionalImages as $img) {
                $path = $additionalDestination.'/'.$img;
                if (file_exists($path)) {
                    unlink($path);
                }
            }

            Log::error('Product Update failed: '.$e->getMessage());

            return redirect()->back()->with([
                'message' => 'Product Update failed',
                'alert-type' => 'error',
            ])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $product = Product::findOrFail($id);

            $thumbnail = $product->product_thumbnail;
            $additionalImage = json_decode($product->product_multiple_image);

            DB::beginTransaction();

            $product->delete();

            DB::commit();

            // Delete old slider image
            if ($thumbnail && file_exists(public_path('images/products/thumbnail/'.$thumbnail))) {
                unlink(public_path('images/products/thumbnail/'.$thumbnail));
            }

            if (! empty($additionalImage)) {
                foreach ($additionalImage as $img) {
                    if (! empty($img) && file_exists(public_path('images/products/additional_images/'.$img))) {
                        unlink(public_path('images/products/additional_images/'.$img));
                    }
                }
            }

            return redirect()->back()->with([
                'message' => 'Product Deleted Successfully',
                'alert-type' => 'success',
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Product Deletion failed '.$e->getMessage());

            return redirect()->back()->with([
                'message' => 'Product Deletion failed',
                'alert-type' => 'error',
            ]);
        }
    }

    /**
     *  Update Product Status
     */
    public function ProductStatus($id)
    {
        try {
            $product = Product::findOrFail($id);
            $newStatus = ($product->status == 'active') ? 'inactive' : 'active';

            $product->update([
                'status' => $newStatus,
            ]);

            $notification = [
                'message' => 'Status Update Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->back()->with($notification);
        } catch (Exception $e) {
            Log::error('Status Update failed '.$e->getMessage());

            $notification = [
                'message' => 'Status Update failed',
                'alert-type' => 'error',
            ];

            return redirect()->back()->with($notification);
        }
    }
}
