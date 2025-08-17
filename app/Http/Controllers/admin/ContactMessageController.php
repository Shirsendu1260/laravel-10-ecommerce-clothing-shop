<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index(Request $request) {
        $contact_messages = DB::table('contact_us')->orderByDesc('id');

        if (!empty($request->get('search'))) {
            $contact_messages = $contact_messages->where('name', 'like', '%' . $request->get('search') . '%');
            $contact_messages = $contact_messages->orWhere('email', 'like', '%' . $request->get('search') . '%');
        }

        $contact_messages = $contact_messages->paginate(perPage: 7);
        // dd($contact_messages);

        return view('admin.message.index', compact('contact_messages'));
    }

    public function details($contact_message_id) {
        $contact_message = DB::table('contact_us')->where('id', $contact_message_id)->first();

        return view('admin.message.details', compact('contact_message'));
    }

    public function reply(Request $request, $contact_message_id) {
        $contact_message = DB::table('contact_us')->where('id', $contact_message_id)->first();

        if(empty($contact_message)) {
            return redirect()->route('admin_contact_messages_index')->with('error', 'Record not found.');
        }

        // Mail sending logic here

        $row_updated = DB::table('contact_us')->where('id', $contact_message_id)->update(['is_replied' => '1']);

        if($row_updated == 1) {
            return redirect()->route('admin_contact_messages_details_page', $contact_message->id)->with('success', 'Your response has been sent.');
        }
        else {
            return redirect()->route('admin_contact_messages_details_page', $contact_message->id)->with('error', 'Unable to send response.');
        }
    }
}
