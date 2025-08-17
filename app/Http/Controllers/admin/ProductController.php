<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use DB;
use File;
use Carbon\Carbon;
use Validator;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = DB::table('products')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->select(
                'products.id',
                'products.name',
                'products.image',
                'products.sku',
                'products.slug',
                'products.price',
                'products.actual_price',
                'categories.name as category',
                'brands.name as brand',
                'products.is_featured',
                'products.is_in_stock',
                'products.qty',
                'products.updated_at',
                'products.status'
            )
            ->orderByDesc('products.id');

        if (!empty($request->get('search'))) {
            $products = $products->where('products.name', 'like', '%' . $request->get('search') . '%');
        }

        $products = $products->paginate(perPage: 7);
        // dd($products);

        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        $categories = DB::table('categories')->orderBy('name', 'ASC')->get();
        $brands = DB::table('brands')->orderBy('name', 'ASC')->get();

        return view('admin.product.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $product_id = null;

        $validator = Validator::make($request->all(), [
            "name" => "required",
            "slug" => "required|unique:products",
            "image" => "nullable|image:jpg,jpeg,png",
            "description" => "required",
            "price" => "required|numeric|gte:0",
            "actual_price" => "nullable|numeric|gte:0",
            "sku" => "required|unique:products",
            "qty" => "required|integer",
            "brand_id" => "required|integer",
            "category_id" => "required|integer",
            "available_sizes" => "required",
            "is_featured" => "required|in:1,0",
            "is_in_stock" => "required|in:1,0",
            "status" => "required|in:1,0",
        ]);

        if ($validator->passes()) {
            $product_id = DB::table('products')->insertGetId([
                'name' => $request->name,
                'slug' => $request->slug,
                'short_description' => $request->short_description,
                'description' => $request->description,
                'price' => $request->price,
                'actual_price' => $request->actual_price,
                'sku' => $request->sku,
                'qty' => $request->qty,
                'brand_id' => $request->brand_id,
                'category_id' => $request->category_id,
                'is_featured' => $request->is_featured,
                'available_sizes' => $request->available_sizes,
                'is_in_stock' => $request->is_in_stock,
                'status' => $request->status,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // For saving the product image
            if (!empty($request->image_id)) {
                $temp_image = DB::table('temp_images')->where('id', $request->image_id)->first();

                $file_name_array = explode('.', $temp_image->name);
                // $file_name = $file_name_array[0];
                $ext = last($file_name_array);
                $new_file_name = Carbon::now()->format('YmdHis') . '_' . rand(0, 999) . '.' . $ext;

                // Generate image thumbnail by resizing in dimension 200 X 200
                $source = public_path() . '/uploads/temp_images/' . $temp_image->name; // Image contains here
                $img_manager = new ImageManager(new Driver());
                $image = $img_manager->read($source);
                $image->coverDown(200, 237);
                $thumbnail_upload_path = public_path() . '/uploads/product/thumbnails/';
                if (!file_exists($thumbnail_upload_path)) {
                    mkdir($thumbnail_upload_path, 0777, true);
                }
                $image->save($thumbnail_upload_path . $new_file_name);

                // Update the row with the image filename
                DB::table('products')
                    ->where('id', $product_id)
                    ->update([
                        'image' => $new_file_name,
                        'updated_at' => Carbon::now(),
                    ]);

                // Delete temporary image file from 'temp_images/' folder of local storage
                File::delete(public_path() . '/uploads/temp_images/' . $temp_image->name);
            }

            // For saving the product's gallery images
            if (!empty($request->gal_img_ids)) {
                foreach ($request->gal_img_ids as $gal_img_id) {
                    $temp_image = DB::table('temp_images')->where('id', $gal_img_id)->first();

                    $file_name_array = explode('.', $temp_image->name);
                    // $file_name = $file_name_array[0];
                    $ext = last($file_name_array);
                    $new_file_name = Carbon::now()->format('YmdHis') . '_' . rand(0, 999) . '.' . $ext;

                    // Generate image by resizing in dimension 700 X 700
                    $source = public_path() . '/uploads/temp_images/' . $temp_image->name; // Image contains here
                    $img_manager = new ImageManager(new Driver());
                    $image = $img_manager->read($source);
                    $image->resize(700, 830);
                    $upload_path = public_path() . '/uploads/product/';
                    if (!file_exists($upload_path)) {
                        mkdir($upload_path, 0777, true);
                    }
                    $image->save($upload_path . $new_file_name);

                    // Insert the gallery image data in the table for the product
                    DB::table('product_gallery_images')
                        ->insert([
                            'name' => $new_file_name,
                            'product_id' => $product_id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);

                    // Delete temporary image file from 'temp_images/' folder of local storage
                    File::delete(public_path() . '/uploads/temp_images/' . $temp_image->name);
                }
            }

            // Update how many gallery images are uploaded in the product's record in table
            $gallery_images_count = DB::table('product_gallery_images')->where('product_id', $product_id)->count();
            DB::table('products')->where('id', $product_id)->update(['gallery_images_count' => $gallery_images_count]);

            return redirect()->route('admin_products_index')->with('success', "Product created successfully.");
        } else {
            return redirect()->route('admin_product_create_page')->withErrors($validator)->withInput();
        }
    }

    public function view($product_slug)
    {
        $product = DB::table('products')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->where('products.slug', $product_slug)
            ->select('products.name',
                'products.slug',
                'products.image',
                'products.category_id',
                'categories.name as category',
                'products.brand_id',
                'brands.name as brand',
                'products.available_sizes',
                'products.short_description',
                'products.description',
                'products.price',
                'products.actual_price',
                'products.sku',
                'products.qty',
                'products.is_in_stock',
                'products.is_featured',
                'products.status')
            ->first();

        if (empty($product)) {
            return redirect()->route('admin_products_index')->with("error", "Product not found.");
        }

        return view('admin.product.view', compact('product'));
    }

    public function edit($product_slug)
    {
        $product = DB::table('products')->where('slug', $product_slug)->first();
        $categories = DB::table('categories')->orderBy('name', 'ASC')->get();
        $brands = DB::table('brands')->orderBy('name', 'ASC')->get();

        if (empty($product)) {
            return redirect()->route('admin_products_index')->with("error", "Product not found.");
        }

        return view('admin.product.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, $product_slug)
    {
        $product = DB::table('products')->where('slug', $product_slug)->first();
        $product_id = $product->id;

        if (empty($product)) {
            return redirect()->route('admin_products_index')->with('error', "Product not found.");
        }

        $old_image = $product->image;

        $validator = Validator::make($request->all(), [
            "name" => "required",
            "slug" => "required|unique:products,slug," . $product->id . ",id",
            "image" => "nullable|image:jpg,jpeg,png",
            "description" => "required",
            "price" => "required|numeric|gte:0",
            "actual_price" => "nullable|numeric|gte:0",
            "sku" => "required|unique:products,sku," . $product->id . ",id",
            "qty" => "required|integer",
            "brand_id" => "required|integer",
            "category_id" => "required|integer",
            "available_sizes" => "required",
            "is_featured" => "required|in:1,0",
            "is_in_stock" => "required|in:1,0",
            "status" => "required|in:1,0",
        ]);

        if ($validator->passes()) {
            DB::table('products')
                ->where('id', $product->id)
                ->update([
                    'name' => $request->name,
                    'slug' => $request->slug,
                    'short_description' => $request->short_description,
                    'description' => $request->description,
                    'price' => $request->price,
                    'actual_price' => $request->actual_price,
                    'sku' => $request->sku,
                    'qty' => $request->qty,
                    'brand_id' => $request->brand_id,
                    'category_id' => $request->category_id,
                    'available_sizes' => $request->available_sizes,
                    'is_featured' => $request->is_featured,
                    'is_in_stock' => $request->is_in_stock,
                    'status' => $request->status,
                    'updated_at' => Carbon::now(),
                ]);

            // For saving the product image
            if (!empty($request->image_id)) {
                $temp_image = DB::table('temp_images')->where('id', $request->image_id)->first();

                $file_name_array = explode('.', $temp_image->name);
                // $file_name = $file_name_array[0];
                $ext = last($file_name_array);
                $new_file_name = Carbon::now()->format('YmdHis') . '_' . rand(0, 999) . '.' . $ext;

                // Generate image thumbnail by resizing in dimension 200 X 200
                $source = public_path() . '/uploads/temp_images/' . $temp_image->name; // Image contains here
                $img_manager = new ImageManager(new Driver());
                $image = $img_manager->read($source);
                $image->coverDown(200, 237);
                $thumbnail_upload_path = public_path() . '/uploads/product/thumbnails/';
                if (!file_exists($thumbnail_upload_path)) {
                    mkdir($thumbnail_upload_path, 0777, true);
                }
                $image->save($thumbnail_upload_path . $new_file_name);

                // Update the row with the new image filename
                DB::table('products')
                    ->where('id', $product->id)
                    ->update([
                        'image' => $new_file_name,
                        'updated_at' => Carbon::now(),
                    ]);

                // Delete old image file from 'thumbnails/' folder of local storage
                File::delete($thumbnail_upload_path . $old_image);

                // Delete temporary image file from 'temp_images/' folder of local storage
                File::delete(public_path() . '/uploads/temp_images/' . $temp_image->name);
            }

            // For saving the product's gallery images
            if (!empty($request->gal_img_ids)) {
                foreach ($request->gal_img_ids as $gal_img_id) {
                    $temp_image = DB::table('temp_images')->where('id', $gal_img_id)->first();
                    // dd($temp_image);

                    $file_name_array = explode('.', $temp_image->name);
                    // $file_name = $file_name_array[0];
                    $ext = last($file_name_array);
                    $new_file_name = Carbon::now()->format('YmdHis') . '_' . rand(0, 999) . '.' . $ext;

                    // Generate image by resizing in dimension 700 X 700
                    $source = public_path() . '/uploads/temp_images/' . $temp_image->name; // Image contains here
                    $img_manager = new ImageManager(new Driver());
                    $image = $img_manager->read($source);
                    $image->resize(700, 830);
                    $upload_path = public_path() . '/uploads/product/';
                    if (!file_exists($upload_path)) {
                        mkdir($upload_path, 0777, true);
                    }
                    $image->save($upload_path . $new_file_name);

                    // Insert the gallery image data in the table for the product
                    DB::table('product_gallery_images')
                        ->insert([
                            'name' => $new_file_name,
                            'product_id' => $product_id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);

                    // Delete temporary image file from 'temp_images/' folder of local storage
                    File::delete(public_path() . '/uploads/temp_images/' . $temp_image->name);
                }
            }

            // Update how many gallery images are uploaded in the product's record in table
            $gallery_images_count = DB::table('product_gallery_images')->where('product_id', $product_id)->count();
            DB::table('products')->where('id', $product_id)->update(['gallery_images_count' => $gallery_images_count]);

            return redirect()->route('admin_products_index')->with('success', "Product updated successfully.");
        } else {
            return redirect()->route('admin_product_edit_page', $product_slug)->withErrors($validator)->withInput();
        }
    }

    public function destroy($product_slug) {
        $product = DB::table('products')->where('slug', $product_slug)->first();

        if (empty($product)) {
            session()->flash("error", "Product not found.");

            return response()->json([
                'status' => false,
                'msg' => 'Product not found.',
            ]);
        }

        // Delete product image
        if ($product->image != null) {
            File::delete(public_path() . '/uploads/product/thumbnails/' . $product->image);
        }

        // Delete product's gallery images and related records
        $product_gallery_images = DB::table('product_gallery_images')->where('product_id', $product->id)->get();
        if($product_gallery_images->isNotEmpty()) {
            foreach($product_gallery_images as $product_gallery_img) {
                File::delete(public_path() . '/uploads/product/' . $product_gallery_img->name);
                DB::table('product_gallery_images')->where('id', $product_gallery_img->id)->delete();
            }
        }

        DB::table('products')->where('slug', $product_slug)->delete();

        session()->flash("success", "Product deleted successfully.");

        return response()->json([
            'status' => true,
            'msg' => 'Product deleted successfully.',
        ]);
    }

    public function delete_product_image(Request $request)
    {
        $product_slug = $request->product_slug;

        if (!empty($product_slug)) {
            $product = DB::table('products')->where('slug', $product_slug)->first();

            $is_deleted = File::delete(public_path() . '/uploads/product/thumbnails/' . $product->image);

            DB::table('products')->where('slug', $product_slug)->update(['image' => null]);

            if ($is_deleted == true) {
                return response()->json([
                    'status' => true,
                    'msg' => 'Product image is deleted successfully.',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'msg' => "Unable to delete the product's image.",
                ]);
            }
        }
    }

    public function delete_product_gallery_image($product_gal_img_id) {
        $product_gallery_image = DB::table('product_gallery_images')->where('id', $product_gal_img_id)->first();

        if(!empty($product_gallery_image)) {
            $is_deleted = File::delete(public_path() . '/uploads/product/' . $product_gallery_image->name);

            DB::table('product_gallery_images')->where('id', $product_gal_img_id)->delete();

            // Update how many gallery images are associated in the product's record in table
            $gallery_images_count = DB::table('product_gallery_images')->where('product_id', $product_gallery_image->product_id)->count();
            DB::table('products')->where('id', $product_gallery_image->product_id)->update(['gallery_images_count' => $gallery_images_count]);

            if ($is_deleted == true) {
                return response()->json([
                    'status' => true,
                    'notFound' => false,
                    'msg' => 'Product gallery image is deleted successfully.',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'notFound' => false,
                    'msg' => "Unable to delete the product's gallery image.",
                ]);
            }
        }
        else {
            return response()->json([
                'status' => false,
                'notFound' => true,
                'msg' => "Record not found for the product's gallery image.",
            ]);
        }
    }
}
