<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use DB;

class AdminpanelUserController extends Controller
{
    public function index(Request $request) {
        $users = DB::table('users')->orderByDesc('id');

        if (!empty($request->get('search'))) {
            $users = $users->where('name', 'like', '%' . $request->get('search') . '%');
            $users = $users->orWhere('email', 'like', '%' . $request->get('search') . '%');
            $users = $users->orWhere('mobile', 'like', '%' . $request->get('search') . '%');
        }

        $users = $users->paginate(perPage: 7);
        // dd($users);

        return view('admin.user.index', compact('users'));
    }

    public function unblock($user_id) {
        $user = User::find($user_id);

        if (empty($user)) {
            session()->flash("error", "User not found.");

            return response()->json([
                'status' => false,
                'msg' => 'User not found.',
            ]);
        }

        $user->status = '1';
        $user->save();

        session()->flash("success", "User unblocked successfully.");

        return response()->json([
            'status' => true,
            'msg' => 'User unblocked successfully.',
        ]);
    }

    public function block($user_id) {
        $user = User::find($user_id);

        if (empty($user)) {
            session()->flash("error", "User not found.");

            return response()->json([
                'status' => false,
                'msg' => 'User not found.',
            ]);
        }

        $user->status = '0';
        $user->save();

        session()->flash("success", "User blocked successfully.");

        return response()->json([
            'status' => true,
            'msg' => 'User blocked successfully.',
        ]);
    }
}
