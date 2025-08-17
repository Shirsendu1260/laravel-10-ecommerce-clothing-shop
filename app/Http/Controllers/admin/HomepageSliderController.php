<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use File;
use Carbon\Carbon;
use Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class HomepageSliderController extends Controller
{
    public function index(Request $request) {
        $slides = DB::table('slides')->orderByDesc('id');

        if (!empty($request->get('search'))) {
            $slides = $slides->where('name', 'like', '%' . $request->get('search') . '%');
        }

        $slides = $slides->paginate(perPage: 7);
        // dd($slides);

        return view('admin.slide.index', compact('slides'));
    }

    public function create() {
        return view('admin.slide.create');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            "tagline" => "required|min:2",
            "title" => "required|min:2",
            "subtitle" => "required|min:2",
            "link" => "required|url",
            "image" => "nullable|image:jpg,jpeg,png",
            "status" => "required|in:1,0",
        ]);

        if ($validator->passes()) {
            $slide_id = DB::table('slides')->insertGetId([
                'tagline' => $request->tagline,
                'title' => $request->title,
                'subtitle' => $request->subtitle,
                'link' => $request->link,
                'status' => $request->status,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // For saving the slide image
            if (!empty($request->image_id)) {
                $temp_image = DB::table('temp_images')->where('id', $request->image_id)->first();

                // Generate image thumbnail by resizing in dimension 200 X 300
                $source = public_path() . '/uploads/temp_images/' . $temp_image->name; // Image contains here
                $img_manager = new ImageManager(new Driver());
                $image = $img_manager->read($source);
                $image->coverDown(200, 300);
                $thumbnail_upload_path = public_path() . '/uploads/slide/thumbnails/';
                if (!file_exists($thumbnail_upload_path)) {
                    mkdir($thumbnail_upload_path, 0777, true);
                }
                $image->save($thumbnail_upload_path . $temp_image->name);

                // Move the actual image to a seperate folder
                $upload_path = public_path() . '/uploads/slide/';
                if (!file_exists($upload_path)) {
                    mkdir($upload_path, 0777, true);
                }
                File::move($source, $upload_path . $temp_image->name); // Move the file

                // Update the row with the image filename
                DB::table('slides')
                    ->where('id', $slide_id)
                    ->update([
                        'image' => $temp_image->name,
                        'updated_at' => Carbon::now(),
                    ]);

                // Delete temporary image file from 'temp_images/' folder of local storage
                File::delete(public_path() . '/uploads/temp_images/' . $temp_image->name);
            }

            return redirect()->route('admin_slides_index')->with('success', "Slide created successfully.");
        } else {
            return redirect()->route('admin_slide_create_page')->withErrors($validator)->withInput();
        }
    }

    public function edit($slide_id) {
        $slide = DB::table('slides')->where('id', $slide_id)->first();

        if (empty($slide)) {
            return redirect()->route('admin_slides_index')->with("error", "Slide not found.");
        }

        return view('admin.slide.edit', compact('slide'));
    }

    public function update(Request $request, $slide_id) {
        $slide = DB::table('slides')->where('id', $slide_id)->first();

        if (empty($slide)) {
            return redirect()->route('admin_slides_index')->with('error', "Slide not found.");
        }

        $old_image = $slide->image;

        $validator = Validator::make($request->all(), [
            "tagline" => "required|min:2",
            "title" => "required|min:2",
            "subtitle" => "required|min:2",
            "link" => "required|url",
            "image" => "nullable|image:jpg,jpeg,png",
            "status" => "required|in:1,0",
        ]);

        if ($validator->passes()) {
            DB::table('slides')
                ->where('id', $slide->id)
                ->update([
                    'tagline' => $request->tagline,
                    'title' => $request->title,
                    'subtitle' => $request->subtitle,
                    'link' => $request->link,
                    'status' => $request->status,
                    'updated_at' => Carbon::now(),
                ]);

            // For saving the slide image
            if (!empty($request->image_id)) {
                $temp_image = DB::table('temp_images')->where('id', $request->image_id)->first();

                // Generate image thumbnail by resizing in dimension 200 X 300
                $source = public_path() . '/uploads/temp_images/' . $temp_image->name; // Image contains here
                $img_manager = new ImageManager(new Driver());
                $image = $img_manager->read($source);
                $image->coverDown(200, 300);
                $thumbnail_upload_path = public_path() . '/uploads/slide/thumbnails/';
                if (!file_exists($thumbnail_upload_path)) {
                    mkdir($thumbnail_upload_path, 0777, true);
                }
                $image->save($thumbnail_upload_path . $temp_image->name);

                // Move the actual image to a seperate folder
                $upload_path = public_path() . '/uploads/slide/';
                if (!file_exists($upload_path)) {
                    mkdir($upload_path, 0777, true);
                }
                File::move($source, $upload_path . $temp_image->name); // Move the file

                // Update the row with the image filename
                DB::table('slides')
                    ->where('id', $slide->id)
                    ->update([
                        'image' => $temp_image->name,
                        'updated_at' => Carbon::now(),
                    ]);

                // Delete old image file from 'thumbnails/' folder of local storage
                File::delete($thumbnail_upload_path . $old_image);

                // Delete temporary image file from 'temp_images/' folder of local storage
                File::delete(public_path() . '/uploads/temp_images/' . $temp_image->name);
            }

            return redirect()->route('admin_slides_index')->with('success', "Slide updated successfully.");
        } else {
            return redirect()->route('admin_slide_edit_page', $slide_id)->withErrors($validator)->withInput();
        }
    }

    public function destroy($slide_id) {
        $slide = DB::table('slides')->where('id', $slide_id)->first();

        if (empty($slide)) {
            session()->flash("error", "Slide not found.");

            return response()->json([
                'status' => false,
                'msg' => 'Slide not found.',
            ]);
        }

        if ($slide->image != null) {
            File::delete(public_path() . '/uploads/slide/thumbnails/' . $slide->image);
        }

        DB::table('slides')->where('id', $slide_id)->delete();

        session()->flash("success", "Slide deleted successfully.");

        return response()->json([
            'status' => true,
            'msg' => 'Slide deleted successfully.',
        ]);
    }

    public function delete_slide_image(Request $request)
    {
        $slide_id = $request->slide_id;

        if (!empty($slide_id)) {
            $slide = DB::table('slides')->where('id', $slide_id)->first();

            $is_deleted = File::delete(public_path() . '/uploads/slide/thumbnails/' . $slide->image);

            DB::table('slides')->where('id', $slide_id)->update(['image' => null]);

            if ($is_deleted == true) {
                return response()->json([
                    'status' => true,
                    'msg' => 'Slide image is deleted successfully.',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'msg' => "Unable to delete the slide's image.",
                ]);
            }
        }
    }
}
