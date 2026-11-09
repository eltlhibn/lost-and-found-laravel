<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\VerificationAnswer;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{

    public function show($id)
    {
        $report = Report::findOrFail($id);

        return view('verification.answer', compact('report'));
    }

    
    public function submit(Request $request, $id)
    {
        $request->validate([
            'answer' => 'required|string',
        ]);

        $report = Report::findOrFail($id);

        VerificationAnswer::create([
            'report_id' => $report->id,
            'user_id' => Auth::id(),
            'answer' => $request->answer,
        ]);

        return redirect()
            ->route('user.dashboard')
            ->with('success', 'Answer submitted. Waiting for verification.');
    }
}
