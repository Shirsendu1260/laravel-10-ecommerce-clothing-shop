<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use DB;
use Auth;
use Validator;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $recent_orders = DB::table('orders')->orderByDesc('id')->take(2)->get();
        $monthly_data_sql = "SELECT m.id AS month_id, m.name AS month_name,
                            IFNULL(d.total_amount, 0) AS total_amount,
                            IFNULL(d.total_ordered_amount, 0) AS total_ordered_amount,
                            IFNULL(d.total_delivered_amount, 0) AS total_delivered_amount,
                            IFNULL(d.total_cancelled_amount, 0) AS total_cancelled_amount FROM months m
                            LEFT JOIN (SELECT DATE_FORMAT(created_at, '%b') AS month_name,
                            MONTH(created_at) AS month_id,
                            SUM(total) AS total_amount,
                            SUM(IF(status='ORD', total, 0)) AS total_ordered_amount,
                            SUM(IF(status='DEL', total, 0)) AS total_delivered_amount,
                            SUM(IF(status='CANC', total, 0)) AS total_cancelled_amount
                            FROM orders WHERE YEAR(created_at) = YEAR(NOW()) GROUP BY YEAR(created_at), MONTH(created_at), DATE_FORMAT(created_at, '%b')
                            ORDER BY MONTH(created_at)) d ON d.month_id = m.id;";
        $monthly_data = DB::select($monthly_data_sql);
        $monthly_data = collect($monthly_data);

        // Create a comma-separated string of total order amounts for each month of the current year.
        // If a month has no orders, its total will be 0. Example: "1200,850,0,950,..."
        $monthly_total_amounts = implode(',', $monthly_data->pluck('total_amount')->toArray());

        $monthly_total_ordered_amounts = implode(',', $monthly_data->pluck('total_ordered_amount')->toArray());
        $monthly_total_delivered_amounts = implode(',', $monthly_data->pluck('total_delivered_amount')->toArray());
        $monthly_total_cancelled_amounts = implode(',', $monthly_data->pluck('total_cancelled_amount')->toArray());

        $total_amount = $monthly_data->sum('total_amount');
        $total_ordered_amount = $monthly_data->sum('total_ordered_amount');
        $total_delivered_amount = $monthly_data->sum('total_delivered_amount');
        $total_cancelled_amount = $monthly_data->sum('total_cancelled_amount');

        return view('admin.index', compact('recent_orders', 'monthly_total_amounts', 'monthly_total_ordered_amounts', 'monthly_total_delivered_amounts', 'monthly_total_cancelled_amounts', 'total_amount', 'total_ordered_amount', 'total_delivered_amount', 'total_cancelled_amount'));
    }

    public function search(Request $request)
    {
        $search_term = '%' . $request->search . '%';
        $searched_products = DB::table('products')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->where(function ($query) use ($search_term) {
                $query->where('products.name', 'like', $search_term)
                    ->orWhere('categories.name', 'like', $search_term)
                    ->orWhere('brands.name', 'like', $search_term);
            })
            ->take(6)
            ->select('products.id', 'products.name', 'products.image', 'products.slug')
            ->get();

        return response()->json(['searched_products' => $searched_products]);
    }

    public function account_details() {
        $admin = Auth::user();
        $countries = DB::table('countries')->get();
        // dd($admin);

        return view('admin.account-details', compact('admin', 'countries'));
    }

    public function update_account_details(Request $request) {
        $admin = User::find(Auth::user()->id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $admin->id . ',id',
            'gender' => 'required|in:M,F,O',
            'phonecode' => 'required',
            'mobile' => 'required|digits:10|numeric',
        ]);

        if($validator->passes()) {
            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->gender = $request->gender;
            $admin->phonecode = $request->phonecode;
            $admin->mobile = $request->mobile;
            $admin->save();

            return redirect()->route('admin_account_details')->with('success', 'Your account details are updated successfully.');
        }
        else {
            return redirect()->route('admin_account_details')->withErrors($validator);
        }
    }

    public function change_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:4',
            'confirm_password' => 'required|same:new_password',
        ]);

        if ($validator->passes()) {
            $admin = Auth::user();

            // If entered old password is incorrect
            if (!Hash::check($request->old_password, $admin->password)) {
                session()->flash('error', 'This does not match your old password, please try again.');

                return response()->json([
                    'status' => false,
                ]);
            }
            // If entered old password is correct
            else {
                if ($request->old_password == $request->new_password) {
                    session()->flash('error', 'The new password cannot be same as the old password.');

                    return response()->json([
                        'status' => false,
                    ]);
                } else {
                    $admin->password = Hash::make($request->new_password);
                    $admin->save();

                    session()->flash('success', 'Password changed successfully.');

                    return response()->json([
                        'status' => true,
                    ]);
                }
            }
        } else {
            $errors = $validator->errors()->all();

            $error_str = '';
            foreach($errors as $error) {
                $error_str = $error_str . $error . '<br>';
            }
            
            session()->flash('error', $error_str);

            return response()->json([
                'status' => false,
            ]);
        }
    }
}
