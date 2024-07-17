<?php

namespace App\Http\Controllers;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard')->with('user', auth()->user());
    }
}
