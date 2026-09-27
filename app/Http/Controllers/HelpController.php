<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelpController extends Controller
{
    public function index()
    {
        return view('pages.help');
    }

    public function article($slug)
    {
        return view('pages.help-article', compact('slug'));
    }

    public function search(Request $r)
    {
        return view('pages.help', ['query' => $r->q]);
    }
}
