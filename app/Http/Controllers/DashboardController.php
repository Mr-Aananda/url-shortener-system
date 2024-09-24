<?php

namespace App\Http\Controllers;

use App\Models\Url;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index()
    {
        $totalUsers = User::count();
        $totalUrls = Url::count();
        $userUrls = Url::where('user_id', auth()->id())->count();
        $totalClicks = Url::where('user_id', auth()->id())->sum('click_count');

        return view('dashboard', compact('totalUsers', 'totalUrls', 'userUrls', 'totalClicks'));
    }
}
