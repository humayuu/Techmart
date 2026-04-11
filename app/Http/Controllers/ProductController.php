<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Throwable;
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
                        return '<span class="text-dark fw-semibold fs-5">Rs. '.number_format((float) $row->selling_price, 2).'</span>';
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
    public function store(StoreProductRequest $request)
    {
        $slug = Str::slug($request->product_name);
        $status = 'active';

        $thumbnailDestination = public_path('images/products/thumbnail');
        if (! is_dir($thumbnailDestination)) {
            mkdir($thumbnailDestination, 0755, true);
        }

        $additionalDestination = public_path('images/products/additional_images');
        if (! is_dir($additionalDestination)) {
            mkdir($additionalDestination, 0755, true);
        }

        $manager = new ImageManager(new Driver);

        $fileName = null;
        $additionalImages = [];

        if ($img = $request->file('thumbnail')) {
            $fileName = uniqid('thumbnail_').'.'.$img->getClientOriginalExtension();
            $manager->read($img)->resize(300, 300)->save($thumbnailDestination.'/'.$fileName);
        }

        if ($multipleImages = $request->file('images')) {
            foreach ($multipleImages as $img) {
                $multiFileName = uniqid('additional_img_').'.'.$img->getClientOriginalExtension();
                $manager->read($img)->resize(800, 800)->save($additionalDestination.'/'.$multiFileName);
                $additionalImages[] = $multiFileName;
            }
        }

        try {
            DB::transaction(function () use ($request, $slug, $status, $fileName, $additionalImages) {
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
            });
        } catch (Throwable $e) {
            if ($fileName && file_exists($thumbnailDestination.'/'.$fileName)) {
                unlink($thumbnailDestination.'/'.$fileName);
            }
            foreach ($additionalImages as $imgName) {
                $path = $additionalDestination.'/'.$imgName;
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            Log::error('Product creation failed '.$e->getMessage());

            return redirect()->back()->with([
                'message' => 'Product creation failed ',
                'alert-type' => 'error',
            ])->withInput();
        }

        return redirect()->route('product.index')->with([
            'message' => 'Product created Successfully',
            'alert-type' => 'success',
        ]);
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
    public function update(UpdateProductRequest $request, string $id)
    {
        $product = Product::findOrFail($id);

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

        $fileName = $product->product_thumbnail;
        $oldImages = json_decode($product->product_multiple_image, true) ?? [];
        $additionalImages = $oldImages;

        $newThumbnail = null;
        $newAdditionalImages = [];

        $filesToDeleteAfterCommit = [];

        if ($img = $request->file('thumbnail')) {
            $newThumbnail = uniqid('thumbnail_').'.'.$img->getClientOriginalExtension();
            $manager->read($img)->resize(300, 300)->save($thumbnailDestination.'/'.$newThumbnail);

            if ($product->product_thumbnail) {
                $filesToDeleteAfterCommit[] = $thumbnailDestination.'/'.$product->product_thumbnail;
            }

            $fileName = $newThumbnail;
        }

        if ($multipleImg = $request->file('images')) {
            foreach ($multipleImg as $img) {
                $multiFileName = uniqid('additional_img_').'.'.$img->getClientOriginalExtension();
                $manager->read($img)->resize(800, 800)->save($additionalDestination.'/'.$multiFileName);
                $newAdditionalImages[] = $multiFileName;
            }

            foreach ($oldImages as $oldImg) {
                $filesToDeleteAfterCommit[] = $additionalDestination.'/'.$oldImg;
            }

            $additionalImages = $newAdditionalImages;
        }

        try {
            DB::transaction(function () use ($request, $product, $slug, $fileName, $additionalImages) {
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
            });
        } catch (Throwable $e) {
            if ($newThumbnail && file_exists($thumbnailDestination.'/'.$newThumbnail)) {
                unlink($thumbnailDestination.'/'.$newThumbnail);
            }
            foreach ($newAdditionalImages as $imgName) {
                $path = $additionalDestination.'/'.$imgName;
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

        foreach ($filesToDeleteAfterCommit as $path) {
            if (file_exists($path)) {
                unlink($path);
            }
        }

        return redirect()->route('product.index')->with([
            'message' => 'Product Updated Successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        $thumbnail = $product->product_thumbnail;
        $additionalImage = json_decode($product->product_multiple_image);

        $product->delete();

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
    }

    /**
     *  Update Product Status
     */
    public function ProductStatus($id)
    {
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
    }
}
