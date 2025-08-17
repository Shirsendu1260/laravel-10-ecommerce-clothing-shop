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

class BrandController extends Controller
{
    public function index(Request $request) {
        $brands = DB::table('brands')->orderByDesc('id');

        if (!empty($request->get('search'))) {
            $brands = $brands->where('name', 'like', '%' . $request->get('search') . '%');
        }

        $brands = $brands->paginate(perPage: 7);
        // dd($brands);

        return view('admin.brand.index', compact('brands'));
    }

    public function create() {
        return view('admin.brand.create');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "slug" => "required|unique:brands",
            "image" => "nullable|image:jpg,jpeg,png",
            "status" => "required|in:1,0",
        ]);

        if ($validator->passes()) {
            $brand_id = DB::table('brands')->insertGetId([
                'name' => $request->name,
                'slug' => $request->slug,
                'status' => $request->status,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // For saving the brand image
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
                $image->coverDown(200, 200);
                $thumbnail_upload_path = public_path() . '/uploads/brand/thumbnails/';
                if (!file_exists($thumbnail_upload_path)) {
                    mkdir($thumbnail_upload_path, 0777, true);
                }
                $image->save($thumbnail_upload_path . $new_file_name);

                // Update the row with the image filename
                DB::table('brands')
                    ->where('id', $brand_id)
                    ->update([
                        'image' => $new_file_name,
                        'updated_at' => Carbon::now(),
                    ]);

                // Delete temporary image file from 'temp_images/' folder of local storage
                File::delete(public_path() . '/uploads/temp_images/' . $temp_image->name);
            }

            return redirect()->route('admin_brands_index')->with('success', "Brand created successfully.");
        } else {
            return redirect()->route('admin_brand_create_page')->withErrors($validator)->withInput();
        }
    }

    public function edit($brand_slug) {
        $brand = DB::table('brands')->where('slug', $brand_slug)->first();

        if (empty($brand)) {
            return redirect()->route('admin_brands_index')->with("error", "Brand not found.");
        }

        return view('admin.brand.edit', compact('brand'));
    }

    public function update(Request $request, $brand_slug) {
        $brand = DB::table('brands')->where('slug', $brand_slug)->first();

        if (empty($brand)) {
            return redirect()->route('admin_brands_index')->with('error', "Brand not found.");
        }

        $old_image = $brand->image;

        $validator = Validator::make($request->all(), [
            "name" => "required",
            "slug" => "required|unique:brands,slug," . $brand->id . ",id", // Ignoring the row with specified brand id in this validation rule
            'photo' => 'nullable|image:jpg,jpeg,png',
            "status" => "required|in:1,0",
        ]);

        if ($validator->passes()) {
            DB::table('brands')
                ->where('id', $brand->id)
                ->update([
                    'name' => $request->name,
                    'slug' => $request->slug,
                    'status' => $request->status,
                    'updated_at' => Carbon::now(),
                ]);

            // For saving the brand image
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
                $image->coverDown(200, 200);
                $thumbnail_upload_path = public_path() . '/uploads/brand/thumbnails/';
                if (!file_exists($thumbnail_upload_path)) {
                    mkdir($thumbnail_upload_path, 0777, true);
                }
                $image->save($thumbnail_upload_path . $new_file_name);

                // Update the row with the image filename
                DB::table('brands')
                    ->where('id', $brand->id)
                    ->update([
                        'image' => $new_file_name,
                        'updated_at' => Carbon::now(),
                    ]);

                // Delete old image file from 'thumbnails/' folder of local storage
                File::delete($thumbnail_upload_path . $old_image);

                // Delete temporary image file from 'temp_images/' folder of local storage
                File::delete(public_path() . '/uploads/temp_images/' . $temp_image->name);
            }

            return redirect()->route('admin_brands_index')->with('success', "Brand updated successfully.");
        } else {
            return redirect()->route('admin_brand_edit_page', $brand_slug)->withErrors($validator)->withInput();
        }
    }

    public function destroy($brand_slug) {
        $brand = DB::table('brands')->where('slug', $brand_slug)->first();

        if (empty($brand)) {
            session()->flash("error", "Brand not found.");

            return response()->json([
                'status' => false,
                'msg' => 'Brand not found.',
            ]);
        }

        if ($brand->image != null) {
            File::delete(public_path() . '/uploads/brand/thumbnails/' . $brand->image);
        }

        DB::table('brands')->where('slug', $brand_slug)->delete();

        session()->flash("success", "Brand deleted successfully.");

        return response()->json([
            'status' => true,
            'msg' => 'Brand deleted successfully.',
        ]);
    }

    public function delete_brand_image(Request $request)
    {
        $brand_slug = $request->brand_slug;

        if (!empty($brand_slug)) {
            $brand = DB::table('brands')->where('slug', $brand_slug)->first();

            $is_deleted = File::delete(public_path() . '/uploads/brand/thumbnails/' . $brand->image);

            DB::table('brands')->where('slug', $brand_slug)->update(['image' => null]);

            if ($is_deleted == true) {
                return response()->json([
                    'status' => true,
                    'msg' => 'Brand image is deleted successfully.',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'msg' => "Unable to delete the brand's image.",
                ]);
            }
        }
    }
}
