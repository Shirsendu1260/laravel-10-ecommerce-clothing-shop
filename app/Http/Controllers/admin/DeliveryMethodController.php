<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use Validator;
use Illuminate\Http\Request;

class DeliveryMethodController extends Controller
{
    public function index(Request $request) {
        $delivery_methods = DB::table('delivery_methods')->orderByDesc('id');

        if (!empty($request->get('search'))) {
            $delivery_methods = $delivery_methods->where('name', 'like', '%' . $request->get('search') . '%');
        }

        $delivery_methods = $delivery_methods->paginate(perPage: 7);
        // dd($delivery_methods);

        return view('admin.delivery-method.index', compact('delivery_methods'));
    }

    public function create() {
        return view('admin.delivery-method.create');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "slug" => "required|unique:delivery_methods",
            "description" => "nullable|string",
            "price" => "required|numeric",
            "status" => "required|in:1,0",
        ]);

        if ($validator->passes()) {
            DB::table('delivery_methods')->insert([
                'name' => $request->name,
                'slug' => $request->slug,
                'description' => $request->description,
                'price' => $request->price,
                'status' => $request->status,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            return redirect()->route('admin_delivery_methods_index')->with('success', "Delivery method created successfully.");
        } else {
            return redirect()->route('admin_delivery_method_create_page')->withErrors($validator)->withInput();
        }
    }

    public function edit($delivery_method_slug) {
        $delivery_method = DB::table('delivery_methods')->where('slug', $delivery_method_slug)->first();

        if (empty($delivery_method)) {
            return redirect()->route('admin_delivery_methods_index')->with("error", "Delivery method not found.");
        }

        return view('admin.delivery-method.edit', compact('delivery_method'));
    }

    public function update(Request $request, $delivery_method_slug) {
        $delivery_method = DB::table('delivery_methods')->where('slug', $delivery_method_slug)->first();

        if (empty($delivery_method)) {
            return redirect()->route('admin_delivery_methods_index')->with('error', "Delivery method not found.");
        }

        $validator = Validator::make($request->all(), [
            "name" => "required",
            "slug" => "required|unique:delivery_methods,slug," . $delivery_method->id . ",id", // Ignoring the row with specified delivery method id in this validation rule
            "description" => "nullable|string",
            "price" => "required|numeric",
            "status" => "required|in:1,0",
        ]);

        if ($validator->passes()) {
            DB::table('delivery_methods')
                ->where('id', $delivery_method->id)
                ->update([
                    'name' => $request->name,
                    'slug' => $request->slug,
                    'description' => $request->description,
                    'price' => $request->price,
                    'status' => $request->status,
                    'updated_at' => Carbon::now(),
                ]);

            return redirect()->route('admin_delivery_methods_index')->with('success', "Delivery method updated successfully.");
        } else {
            return redirect()->route('admin_delivery_method_edit_page', $delivery_method_slug)->withErrors($validator)->withInput();
        }
    }

    public function destroy($delivery_method_slug) {
        $delivery_method = DB::table('delivery_methods')->where('slug', $delivery_method_slug)->first();

        if (empty($delivery_method)) {
            session()->flash("error", "Delivery method not found.");

            return response()->json([
                'status' => false,
                'msg' => 'Delivery method not found.',
            ]);
        }

        DB::table('delivery_methods')->where('slug', $delivery_method_slug)->delete();

        session()->flash("success", "Delivery method deleted successfully.");

        return response()->json([
            'status' => true,
            'msg' => 'Delivery method deleted successfully.',
        ]);
    }
}
