<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use File;
use Illuminate\Http\Request;
use Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AddonProductController extends Controller
{
    public function index(Request $request)
    {
        $addon_products = DB::table('addon_products')
            ->join('categories', 'categories.id', '=', 'addon_products.category_id')
            ->join('brands', 'brands.id', '=', 'addon_products.brand_id')
            ->select(
                'addon_products.id',
                'addon_products.name',
                'addon_products.image',
                'addon_products.sku',
                'addon_products.slug',
                'addon_products.price',
                'categories.name as category',
                'brands.name as brand',
                'addon_products.is_in_stock',
                'addon_products.qty',
                'addon_products.updated_at',
                'addon_products.status'
            )
            ->orderByDesc('addon_products.id');

        if (!empty($request->get('search'))) {
            $addon_products = $addon_products->where('addon_products.name', 'like', '%' . $request->get('search') . '%');
        }

        $addon_products = $addon_products->paginate(perPage: 7);
        // dd($addon_products);

        return view('admin.addon-product.index', compact('addon_products'));
    }

    public function create()
    {
        $categories = DB::table('categories')->orderBy('name', 'ASC')->get();
        $brands = DB::table('brands')->orderBy('name', 'ASC')->get();

        return view('admin.addon-product.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $addon_product_id = null;

        $validator = Validator::make($request->all(), [
            "name" => "required",
            "slug" => "required|unique:addon_products",
            "image" => "nullable|image:jpg,jpeg,png",
            "price" => "required|numeric|gte:0",
            "sku" => "required|unique:addon_products",
            "qty" => "required|integer",
            "brand_id" => "required|integer",
            "category_id" => "required|integer",
            "is_in_stock" => "required|in:1,0",
            "status" => "required|in:1,0",
        ]);

        if ($validator->passes()) {
            $addon_product_id = DB::table('addon_products')->insertGetId([
                'name' => $request->name,
                'slug' => $request->slug,
                'price' => $request->price,
                'sku' => $request->sku,
                'qty' => $request->qty,
                'brand_id' => $request->brand_id,
                'category_id' => $request->category_id,
                'is_in_stock' => $request->is_in_stock,
                'status' => $request->status,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // For saving the addon product image
            if (!empty($request->image_id)) {
                $temp_image = DB::table('temp_images')->where('id', $request->image_id)->first();

                $file_name_array = explode('.', $temp_image->name);
                // $file_name = $file_name_array[0];
                $ext = last($file_name_array);
                $new_file_name = Carbon::now()->format('YmdHis') . '_' . rand(0, 999) . '.' . $ext;

                // Generate image thumbnail by resizing in dimension 400 X 474
                $source = public_path() . '/uploads/temp_images/' . $temp_image->name; // Image contains here
                $img_manager = new ImageManager(new Driver());
                $image = $img_manager->read($source);
                $image->coverDown(400, 474);
                $thumbnail_upload_path = public_path() . '/uploads/addon-product/thumbnails/';
                if (!file_exists($thumbnail_upload_path)) {
                    mkdir($thumbnail_upload_path, 0777, true);
                }
                $image->save($thumbnail_upload_path . $new_file_name);

                // Update the row with the image filename
                DB::table('addon_products')
                    ->where('id', $addon_product_id)
                    ->update([
                        'image' => $new_file_name,
                        'updated_at' => Carbon::now(),
                    ]);

                // Delete temporary image file from 'temp_images/' folder of local storage
                File::delete(public_path() . '/uploads/temp_images/' . $temp_image->name);
            }

            return redirect()->route('admin_addon_products_index')->with('success', "Addon product created successfully.");
        } else {
            return redirect()->route('admin_addon_product_create_page')->withErrors($validator)->withInput();
        }
    }

    public function view($addon_product_slug)
    {
        $addon_product = DB::table('addon_products')
            ->join('brands', 'brands.id', '=', 'addon_products.brand_id')
            ->join('categories', 'categories.id', '=', 'addon_products.category_id')
            ->where('addon_products.slug', $addon_product_slug)
            ->select('addon_products.name',
                'addon_products.slug',
                'addon_products.image',
                'addon_products.category_id',
                'categories.name as category',
                'addon_products.brand_id',
                'brands.name as brand',
                'addon_products.price',
                'addon_products.sku',
                'addon_products.qty',
                'addon_products.is_in_stock',
                'addon_products.status')
            ->first();

        if (empty($addon_product)) {
            return redirect()->route('admin_addon_products_index')->with("error", "Addon product not found.");
        }

        return view('admin.addon-product.view', compact('addon-product'));
    }

    public function edit($addon_product_slug)
    {
        $addon_product = DB::table('addon_products')->where('slug', $addon_product_slug)->first();
        $categories = DB::table('categories')->orderBy('name', 'ASC')->get();
        $brands = DB::table('brands')->orderBy('name', 'ASC')->get();

        if (empty($addon_product)) {
            return redirect()->route('admin_addon_products_index')->with("error", "Addon product not found.");
        }

        return view('admin.addon-product.edit', compact('addon_product', 'categories', 'brands'));
    }

    public function update(Request $request, $addon_product_slug)
    {
        $addon_product = DB::table('addon_products')->where('slug', $addon_product_slug)->first();

        if (empty($addon_product)) {
            return redirect()->route('admin_addon_products_index')->with('error', "Addon product not found.");
        }

        $old_image = $addon_product->image;

        $validator = Validator::make($request->all(), [
            "name" => "required",
            "slug" => "required|unique:addon_products,slug," . $addon_product->id . ",id",
            "image" => "nullable|image:jpg,jpeg,png",
            "price" => "required|numeric|gte:0",
            "sku" => "required|unique:addon_products,sku," . $addon_product->id . ",id",
            "qty" => "required|integer",
            "brand_id" => "required|integer",
            "category_id" => "required|integer",
            "is_in_stock" => "required|in:1,0",
            "status" => "required|in:1,0",
        ]);

        if ($validator->passes()) {
            DB::table('addon_products')
                ->where('id', $addon_product->id)
                ->update([
                    'name' => $request->name,
                    'slug' => $request->slug,
                    'price' => $request->price,
                    'sku' => $request->sku,
                    'qty' => $request->qty,
                    'brand_id' => $request->brand_id,
                    'category_id' => $request->category_id,
                    'is_in_stock' => $request->is_in_stock,
                    'status' => $request->status,
                    'updated_at' => Carbon::now(),
                ]);

            // For saving the addon product image
            if (!empty($request->image_id)) {
                $temp_image = DB::table('temp_images')->where('id', $request->image_id)->first();

                $file_name_array = explode('.', $temp_image->name);
                // $file_name = $file_name_array[0];
                $ext = last($file_name_array);
                $new_file_name = Carbon::now()->format('YmdHis') . '_' . rand(0, 999) . '.' . $ext;

                // Generate image thumbnail by resizing in dimension 400 X 474
                $source = public_path() . '/uploads/temp_images/' . $temp_image->name; // Image contains here
                $img_manager = new ImageManager(new Driver());
                $image = $img_manager->read($source);
                $image->coverDown(400, 474);
                $thumbnail_upload_path = public_path() . '/uploads/addon-product/thumbnails/';
                if (!file_exists($thumbnail_upload_path)) {
                    mkdir($thumbnail_upload_path, 0777, true);
                }
                $image->save($thumbnail_upload_path . $new_file_name);

                // Update the row with the new image filename
                DB::table('addon_products')
                    ->where('id', $addon_product->id)
                    ->update([
                        'image' => $new_file_name,
                        'updated_at' => Carbon::now(),
                    ]);

                // Delete old image file from 'thumbnails/' folder of local storage
                File::delete($thumbnail_upload_path . $old_image);

                // Delete temporary image file from 'temp_images/' folder of local storage
                File::delete(public_path() . '/uploads/temp_images/' . $temp_image->name);
            }

            return redirect()->route('admin_addon_products_index')->with('success', "Addon product updated successfully.");
        } else {
            return redirect()->route('admin_addon_product_edit_page', $addon_product_slug)->withErrors($validator)->withInput();
        }
    }

    public function destroy($addon_product_slug) {
        $addon_product = DB::table('addon_products')->where('slug', $addon_product_slug)->first();

        if (empty($addon_product)) {
            session()->flash("error", "Addon product not found.");

            return response()->json([
                'status' => false,
                'msg' => 'Addon product not found.',
            ]);
        }

        // Delete addon product image
        if ($addon_product->image != null) {
            File::delete(public_path() . '/uploads/addon-product/thumbnails/' . $addon_product->image);
        }

        DB::table('addon_products')->where('slug', $addon_product_slug)->delete();

        session()->flash("success", "Addon product deleted successfully.");

        return response()->json([
            'status' => true,
            'msg' => 'Addon product deleted successfully.',
        ]);
    }

    public function delete_addon_product_image(Request $request)
    {
        $addon_product_slug = $request->addon_product_slug;

        if (!empty($addon_product_slug)) {
            $addon_product = DB::table('addon_products')->where('slug', $addon_product_slug)->first();

            $is_deleted = File::delete(public_path() . '/uploads/addon-product/thumbnails/' . $addon_product->image);

            DB::table('addon_products')->where('slug', $addon_product_slug)->update(['image' => null]);

            if ($is_deleted == true) {
                return response()->json([
                    'status' => true,
                    'msg' => 'Addon product image is deleted successfully.',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'msg' => "Unable to delete the addon product's image.",
                ]);
            }
        }
    }
}
