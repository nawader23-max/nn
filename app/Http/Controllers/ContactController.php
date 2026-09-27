<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('pages.contact');
    }

    public function send(Request $r)
    {
        $r->validate(['name' => 'required', 'email' => 'required|email', 'message' => 'required']);

        return back()->with('success', 'تم استلام رسالتك. سنتواصل معك خلال 24 ساعة.');
    }
}
