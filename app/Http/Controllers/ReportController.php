<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    // =========================
    // USER DASHBOARD
    // =========================
    public function dashboard(Request $request)
    {
        $filter = $request->get('filter', 'all');
        $search = $request->get('search', '');

        $query = Report::query();

        if (in_array($filter, ['lost', 'found'])) {
            $query->where('report_type', $filter);
        }

        if ($search) {
            $query->where('item_name', 'like', "%{$search}%");
        }

        $reports = $query->orderByDesc('id')->get();

        return view('user.dashboard', compact('reports', 'filter', 'search'));
    }

    // =========================
    // CREATE FORM
    // =========================
    public function create()
    {
        return view('reports.create');
    }

    // =========================
    // STORE REPORT
    // =========================
    public function store(Request $request)
    {
        $data = $request->validate([
            'item_name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'report_type' => 'required|in:lost,found',
            'date_lost_found' => 'required|date|before_or_equal:today',
            'contact_info' => 'required|string|max:255',
            'verification_question' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('reports', 'public');
        }

        $data['user_id'] = Auth::id();
        $data['status'] = 'open';

        Report::create($data);

        // only submission shows message (OK)
        return back()->with('success', 'Report submitted successfully!');
    }

    // =========================
    // MY REPORTS
    // =========================
    public function myReports()
    {
        $reports = Report::where('user_id', Auth::id())
            ->orderByDesc('id')
            ->get();

        return view('reports.my_reports', compact('reports'));
    }

    // =========================
    // VIEW
    // =========================
    public function show($id)
    {
        $report = Report::findOrFail($id);
        return view('reports.show', compact('report'));
    }

    // =========================
    // EDIT
    // =========================
    public function edit($id)
    {
        $report = Report::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('reports.edit', compact('report'));
    }

    // =========================
    // UPDATE
    // =========================
    public function update(Request $request, $id)
    {
        $report = Report::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $data = $request->validate([
            'report_type' => 'required|in:lost,found',
            'item_name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'date_lost_found' => 'required|date|before_or_equal:today',
            'contact_info' => 'required|string|max:255',
            'verification_question' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('reports', 'public');
        }

        $report->update($data);

        return back()->with('success', 'Report updated successfully!');
    }

    // =========================
    // DELETE (NO MESSAGE)
    // =========================
    public function destroy($id)
    {
        $report = Report::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $report->delete();

        // ✅ no popup
        return back();
    }

    // =========================
    // MARK RESOLVED (NO MESSAGE)
    // =========================
    public function markResolved($id)
    {
        $report = Report::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $report->update(['status' => 'resolved']);

        // ✅ no popup
        return back();
    }

    // =========================
    // DELETE FROM DASHBOARD (NO MESSAGE)
    // =========================
    public function deleteFromDashboard($id)
    {
        $user = Auth::user();

        $query = Report::where('id', $id);

        if ($user->role !== 'admin') {
            $query->where('user_id', $user->id);
        }

        $report = $query->firstOrFail();
        $report->delete();

        // ✅ stay on same dashboard card
        return back();
    }
}
