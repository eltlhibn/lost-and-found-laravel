<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        if ($user->role !== 'admin') {
            abort(403);
        }

        return view('admin.dashboard', [
            'username' => $user->username,
        ]);
    }

    public function manageReports()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $reports = Report::with('user')
            ->orderByDesc('id')
            ->get();

        return view('admin.manage_reports', compact('reports'));
    }

    public function deleteReport($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $report = Report::findOrFail($id);
        $report->delete();

        return back()->with('success', 'Report deleted successfully.');
    }

    public function manageUsers()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $users = User::orderBy('id')->get();

        return view('admin.manage_users', compact('users'));
    }

    public function userAction(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        if ($id == Auth::id()) {
            return back()->with('error', 'You cannot perform this action on yourself.');
        }

        $user = User::findOrFail($id);

        switch ($request->action) {
            case 'block':
                $user->status = 'blocked';
                $user->save();
                return back()->with('success', 'User blocked successfully.');

            case 'unblock':
                $user->status = 'active';
                $user->save();
                return back()->with('success', 'User unblocked successfully.');

            case 'delete':
                $user->reports()->delete();
                $user->delete();

                return back()->with('success', 'User deleted successfully.');

            default:
                return back()->with('error', 'Invalid action.');
        }
    }
}
