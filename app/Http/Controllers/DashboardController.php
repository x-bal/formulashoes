<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function cart()
    {
        $title = 'My Cart';
        $user = User::find(auth()->user()->id);

        return view('dashboard.mycart', compact('title', 'user'));
    }
}
