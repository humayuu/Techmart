<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Function for Redirect to Product Add page
     */
    public function ProductAddPage()
    {
        $brands = Brand::orderBy('id', 'DESC')->get();
        $categories = Category::orderBy('id', 'DESC')->get();
        return view('admin.product.add', compact('brands', 'categories'));
    }

    /**
     * Function for Redirect to All Product page
     */
    public function ProductPage()
    {
        $products = Product::with('brand', 'category')
            ->orderBy('id', 'DESC')
            ->paginate(5);
        $totalProducts = Product::count();
        return view('admin.product.index', compact('products', 'totalProducts'));
    }


    /**
     * Function for Store new Product
     */
    public function ProductStore(Request $request)
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

        // Create upload Directory
        $destinationPath = public_path('images/products/');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }


        // Create Product Slug & status 
        $slug = Str::slug($request->product_name);
        $status = 'active';

        DB::beginTransaction();

        try {
            // Upload Product Thumbnail
            $thumbnail = null;
            $fileName = null;

            if ($image = $request->file('thumbnail')) {
                $fileName = uniqid('product_') . time() . '.' . $image->getClientOriginalExtension();
                $image->move($destinationPath, $fileName);
                $thumbnail = 'images/products/' . $fileName;
            }


            // Upload Additional Images
            $additionalImages = [];
            if ($multipleImages = $request->file('images')) {
                foreach ($multipleImages as $index => $img) {
                    $additionalFilename = uniqid('product_') . '_' . $index . '_' . time() . '.' . $img->getClientOriginalExtension();
                    $img->move($destinationPath, $additionalFilename);
                    $additionalImages[] = 'images/products/' . $additionalFilename;
                }
            }

            Product::create([
                'brand_id' => $request->brand,
                'category_id' => $request->category,
                'product_name' => $request->product_name,
                'product_slug' => $slug,
                'product_code' => $request->product_code,
                'product_qty' => $request->quantity,
                'product_tags' =>  $request->tags,
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,
                'selling_price' => $request->selling_price,
                'discount_price' => $request->discount_price,
                'product_thumbnail' => $thumbnail,
                'product_multiple_image' => json_encode($additionalImages),
                'featured' => $request->is_featured ?? 0,
                'special_offer' =>  $request->special_offer ?? 0,
                'product_weight' => $request->weight,
                'other_info' =>  $request->other_info,
                'status' => $status
            ]);

            $notification = [
                'message' => 'Product created Successfully',
                'alert-type' => 'success'
            ];
            DB::commit();
            return redirect()->route('product.page')->with($notification);
        } catch (Exception $e) {
            DB::rollBack();

            if ($thumbnail && file_exists(public_path($thumbnail))) {
                unlink(public_path($thumbnail));
            }

            foreach ($additionalImages as $img) {
                if (file_exists(public_path($img))) {
                    unlink(public_path($img));
                }
            }

            Log::error('Product creation failed ' . $e->getMessage());

            $notification = [
                'message' => 'Product creation failed ',
                'alert-type' => 'error',
            ];

            return redirect()->back()->with($notification)->withInput();
        }
    }

    /**
     * Function for Product View
     */

    public function ProductView($id) {}
}
