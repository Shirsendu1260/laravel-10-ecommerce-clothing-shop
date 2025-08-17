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

class CategoryController extends Controller
{
    public function index(Request $request) {
        $categories = DB::table('categories')->orderByDesc('id');

        if (!empty($request->get('search'))) {
            $categories = $categories->where('name', 'like', '%' . $request->get('search') . '%');
        }

        $categories = $categories->paginate(perPage: 7);
        // dd($categories);

        return view('admin.category.index', compact('categories'));
    }

    public function create() {
        return view('admin.category.create');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "slug" => "required|unique:categories",
            "image" => "nullable|image:jpg,jpeg,png",
            "status" => "required|in:1,0",
        ]);

        if ($validator->passes()) {
            $category_id = DB::table('categories')->insertGetId([
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
                $thumbnail_upload_path = public_path() . '/uploads/category/thumbnails/';
                if (!file_exists($thumbnail_upload_path)) {
                    mkdir($thumbnail_upload_path, 0777, true);
                }
                $image->save($thumbnail_upload_path . $new_file_name);

                // Update the row with the image filename
                DB::table('categories')
                    ->where('id', $category_id)
                    ->update([
                        'image' => $new_file_name,
                        'updated_at' => Carbon::now(),
                    ]);

                // Delete temporary image file from 'temp_images/' folder of local storage
                File::delete(public_path() . '/uploads/temp_images/' . $temp_image->name);
            }

            return redirect()->route('admin_categories_index')->with('success', "Category created successfully.");
        } else {
            return redirect()->route('admin_category_create_page')->withErrors($validator)->withInput();
        }
    }

    public function edit($category_slug) {
        $category = DB::table('categories')->where('slug', $category_slug)->first();

        if (empty($category)) {
            return redirect()->route('admin_categories_index')->with("error", "Category not found.");
        }

        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, $category_slug) {
        $category = DB::table('categories')->where('slug', $category_slug)->first();

        if (empty($category)) {
            return redirect()->route('admin_categories_index')->with('error', "Category not found.");
        }

        $old_image = $category->image;

        $validator = Validator::make($request->all(), [
            "name" => "required",
            "slug" => "required|unique:categories,slug," . $category->id . ",id", // Ignoring the row with specified category id in this validation rule
            'photo' => 'nullable|image:jpg,jpeg,png',
            "status" => "required|in:1,0",
        ]);

        if ($validator->passes()) {
            // dd('Validation passed');

            DB::table('categories')
                ->where('id', $category->id)
                ->update([
                    'name' => $request->name,
                    'slug' => $request->slug,
                    'status' => $request->status,
                    'updated_at' => Carbon::now(),
                ]);

            // For saving the category image
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
                $thumbnail_upload_path = public_path() . '/uploads/category/thumbnails/';
                if (!file_exists($thumbnail_upload_path)) {
                    mkdir($thumbnail_upload_path, 0777, true);
                }
                $image->save($thumbnail_upload_path . $new_file_name);

                // Update the row with the image filename
                DB::table('categories')
                    ->where('id', $category->id)
                    ->update([
                        'image' => $new_file_name,
                        'updated_at' => Carbon::now(),
                    ]);

                // Delete old image file from 'thumbnails/' folder of local storage
                File::delete($thumbnail_upload_path . $old_image);

                // Delete temporary image file from 'temp_images/' folder of local storage
                File::delete(public_path() . '/uploads/temp_images/' . $temp_image->name);
            }

            return redirect()->route('admin_categories_index')->with('success', "Category updated successfully.");
        } else {
            // dd('Validation failed');

            return redirect()->route('admin_category_edit_page', $category_slug)->withErrors($validator)->withInput();
        }
    }

    public function destroy($category_slug) {
        $category = DB::table('categories')->where('slug', $category_slug)->first();

        if (empty($category)) {
            session()->flash("error", "Category not found.");

            return response()->json([
                'status' => false,
                'msg' => 'Category not found.',
            ]);
        }

        if ($category->image != null) {
            File::delete(public_path() . '/uploads/category/thumbnails/' . $category->image);
        }

        DB::table('categories')->where('slug', $category_slug)->delete();

        session()->flash("success", "Category deleted successfully.");

        return response()->json([
            'status' => true,
            'msg' => 'Category deleted successfully.',
        ]);
    }

    public function delete_category_image(Request $request)
    {
        $category_slug = $request->category_slug;

        if (!empty($category_slug)) {
            $category = DB::table('categories')->where('slug', $category_slug)->first();

            $is_deleted = File::delete(public_path() . '/uploads/category/thumbnails/' . $category->image);

            DB::table('categories')->where('slug', $category_slug)->update(['image' => null]);

            if ($is_deleted == true) {
                return response()->json([
                    'status' => true,
                    'msg' => 'Category image is deleted successfully.',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'msg' => "Unable to delete the category's image.",
                ]);
            }
        }
    }
}
