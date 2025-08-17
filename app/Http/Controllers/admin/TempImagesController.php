<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use File;
use Illuminate\Http\Request;

class TempImagesController extends Controller
{
    public function create(Request $request)
    {
        $image = $request->image;

        if (!empty($image)) {
            $ext = $image->getClientOriginalExtension();
            $temp_name = Carbon::now()->format('YmdHis') . '_' . rand(0, 999);
            $new_file_name = $temp_name . '.' . $ext;

            $temp_image_id = DB::table('temp_images')->insertGetId([
                'name' => $new_file_name,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            $image->move(public_path() . '/uploads/temp_images/', $new_file_name);

            return response()->json([
                'status' => true,
                'image_id' => $temp_image_id,
                'newFileName' => $new_file_name,
                'imagePath' => asset('uploads/temp_images/' . $new_file_name),
                'msg' => 'Image uploaded successfully.',
            ]);
        }
    }

    public function images_create(Request $request) {
        $images = $request->images;
        $hidden_inputs = '';

        if(count($images) != 0) {
            foreach($images as $image) {
                $ext = $image->getClientOriginalExtension();
                $temp_name = Carbon::now()->format('YmdHis') . '_' . rand(0, 999);
                $new_file_name = $temp_name . '.' . $ext;

                $temp_image_id = DB::table('temp_images')->insertGetId([
                    'name' => $new_file_name,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

                $image->move(public_path() . '/uploads/temp_images/', $new_file_name);

                $hidden_inputs = $hidden_inputs . "<input type='hidden' name='gal_img_ids[]' value='" . $temp_image_id . "'>";
            }
        }

        return response()->json([
            'status' => true,
            'hidden_inputs' => $hidden_inputs,
            'msg' => 'Images uploaded successfully.',
        ]);
    }

    public function delete(Request $request)
    {
        if (!empty($request->temp_img_id)) {
            $temp_image = DB::table('temp_images')->where('id', $request->temp_img_id)->first();

            // Delete temporary image file from 'temp_images/' folder of local storage
            $is_deleted = File::delete(public_path() . '/uploads/temp_images/' . $temp_image->name);

            // Delete record from database
            $temp_image->delete();

            if ($is_deleted == true) {
                return response()->json([
                    'status' => true,
                    'msg' => 'Image deleted successfully.',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'msg' => 'Unable to delete the image.',
                ]);
            }
        }
    }
}
