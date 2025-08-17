<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Validator;

class StaticPagesController extends Controller
{
    public function about_us() {
        return view('user.static-pages.about');
    }

    public function legal_and_privacy() {
        return view('user.static-pages.legal-and-privacy');
    }

    public function contact_us() {
        return view('user.static-pages.contact-us');
    }

    public function process_contact_us(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2',
            'email' => 'required|email',
            'subject' => 'required|min:2',
            'message' => 'required|min:2'
        ]);

        if($validator->passes()) {
            DB::table('contact_us')->insert([
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            return redirect()->route('contact_us')->with('success', "Thanks for reaching out with us, we will get back to you soon.");
        }
        else {
            return redirect()->route('contact_us')->withErrors($validator)->withInput();
        }
    }

    public function affiliates() {
        return view('user.static-pages.affiliates');
    }

    public function privacy_policy() {
        return view('user.static-pages.privacy-policy');
    }

    public function terms_and_conditions() {
        return view('user.static-pages.terms-and-conditions');
    }
}
