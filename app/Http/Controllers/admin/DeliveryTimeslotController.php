<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Validator;

class DeliveryTimeslotController extends Controller
{
    public function index(Request $request) {
        $delivery_timeslots = DB::table('delivery_timeslots')
                                    ->join('delivery_methods', 'delivery_methods.id', '=', 'delivery_timeslots.delivery_method_id')
                                    ->select('delivery_timeslots.*', 'delivery_methods.name as delivery_method_name')
                                    ->orderByDesc('delivery_timeslots.id');

        if (!empty($request->get('search'))) {
            $delivery_timeslots = $delivery_timeslots->where('delivery_timeslots.time_range', 'like', '%' . $request->get('search') . '%');
        }

        $delivery_timeslots = $delivery_timeslots->paginate(perPage: 7);
        // dd($delivery_timeslots);

        return view('admin.delivery-timeslot.index', compact('delivery_timeslots'));
    }

    public function create() {
        $delivery_methods = DB::table('delivery_methods')->where('status', 1)->get();

        return view('admin.delivery-timeslot.create', compact('delivery_methods'));
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            "time_range" => "required",
            "slug" => "required|unique:delivery_timeslots",
            "start" => "required",
            "end" => "required",
            "delivery_method_id" => "required|numeric",
            "status" => "required|in:1,0",
        ]);

        if ($validator->passes()) {
            DB::table('delivery_timeslots')->insert([
                'time_range' => $request->time_range,
                'slug' => $request->slug,
                'start' => $request->start,
                'end' => $request->end,
                'delivery_method_id' => $request->delivery_method_id,
                'status' => $request->status,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            return redirect()->route('admin_delivery_timeslots_index')->with('success', "Delivery timeslot created successfully.");
        } else {
            return redirect()->route('admin_delivery_timeslot_create_page')->withErrors($validator)->withInput();
        }
    }

    public function edit($delivery_timeslot_slug) {
        $delivery_timeslot = DB::table('delivery_timeslots')->where('slug', $delivery_timeslot_slug)->first();
        $delivery_methods = DB::table('delivery_methods')->where('status', 1)->get();

        if (empty($delivery_timeslot)) {
            return redirect()->route('admin_delivery_timeslots_index')->with("error", "Delivery timeslot not found.");
        }

        return view('admin.delivery-timeslot.edit', compact('delivery_timeslot', 'delivery_methods'));
    }

    public function update(Request $request, $delivery_timeslot_slug) {
        $delivery_timeslot = DB::table('delivery_timeslots')->where('slug', $delivery_timeslot_slug)->first();

        if (empty($delivery_timeslot)) {
            return redirect()->route('admin_delivery_timeslots_index')->with("error", "Delivery timeslot not found.");
        }

        $validator = Validator::make($request->all(), [
            "time_range" => "required",
            "slug" => "required|unique:delivery_timeslots,slug," . $delivery_timeslot->id . ",id",
            "start" => "required",
            "end" => "required",
            "delivery_method_id" => "required|numeric",
            "status" => "required|in:1,0",
        ]);

        if ($validator->passes()) {
            DB::table('delivery_timeslots')
                        ->where('id', $delivery_timeslot->id)
                        ->update([
                            'time_range' => $request->time_range,
                            'slug' => $request->slug,
                            'start' => $request->start,
                            'end' => $request->end,
                            'delivery_method_id' => $request->delivery_method_id,
                            'status' => $request->status,
                            'updated_at' => Carbon::now(),
                        ]);

            return redirect()->route('admin_delivery_timeslots_index')->with('success', "Delivery timeslot updated successfully.");
        } else {
            return redirect()->route('admin_delivery_timeslot_edit_page', $delivery_timeslot_slug)->withErrors($validator)->withInput();
        }
    }

    public function destroy($delivery_timeslot_slug) {
        $delivery_timeslot = DB::table('delivery_timeslots')->where('slug', $delivery_timeslot_slug)->first();

        if (empty($delivery_timeslot)) {
            session()->flash("error", "Delivery timeslot not found.");

            return response()->json([
                'status' => false,
                'msg' => 'Delivery timeslot not found.',
            ]);
        }

        DB::table('delivery_timeslots')->where('slug', $delivery_timeslot_slug)->delete();

        session()->flash("success", "Delivery timeslot deleted successfully.");

        return response()->json([
            'status' => true,
            'msg' => 'Delivery timeslot deleted successfully.',
        ]);
    }
}
