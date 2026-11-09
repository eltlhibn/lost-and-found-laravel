<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\VerificationAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{

    public function showForm($id)
    {
        $report = Report::where('id', $id)
            ->where('report_type', 'found')
            ->where('status', 'open')
            ->firstOrFail();

        return view('answers.create', compact('report'));
    }


    public function submit(Request $request)
    {
        $request->validate([
            'report_id' => 'required|exists:reports,id',
            'answer' => 'required|string',
        ]);


        $alreadyAnswered = VerificationAnswer::where('report_id', $request->report_id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($alreadyAnswered) {
            return back()->withErrors([
                'answer' => 'You already submitted an answer for this report.'
            ]);
        }

        VerificationAnswer::create([
            'report_id' => $request->report_id,
            'user_id' => Auth::id(),
            'answer' => $request->answer,
            'status' => 'pending',
        ]);

        return redirect()->route('user.dashboard');
    }
}
