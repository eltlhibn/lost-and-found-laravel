<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $filter = $request->get('filter', 'all');
        $search = $request->get('search', '');

        $reports = Report::query()
            ->when($filter !== 'all', function ($query) use ($filter) {
                $query->where('report_type', $filter);
            })
            ->when($search, function ($query) use ($search) {
                $query->where('item_name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('location', 'like', "%{$search}%");
            })
            ->latest()
            ->get();

        return view('user.dashboard', [
            'user' => $user,
            'reports' => $reports,
            'filter' => $filter,
            'search' => $search
        ]);
    }
}
