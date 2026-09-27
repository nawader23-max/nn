<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvestorController extends Controller
{
    public function index()
    {
        return view('pages.investor.index');
    }

    public function opportunities()
    {
        return view('pages.investor.opportunities');
    }

    public function opportunity($id)
    {
        return view('pages.investor.opportunity', compact('id'));
    }

    public function dataRoom()
    {
        return view('pages.investor.data-room');
    }

    public function consultations()
    {
        return view('pages.investor.consultations');
    }

    public function book(Request $r)
    {
        return back()->with('success', 'تم حجز الاستشارة بنجاح');
    }
}
