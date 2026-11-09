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

        
        if ($report->user_id === Auth::id()) {
            abort(403);
        }

        
        $userAnswer = VerificationAnswer::where('report_id', $report->id)
            ->where('user_id', Auth::id())
            ->first();

            if ($userAnswer) {
            return redirect()->route('reports.show', $report->id);
        }

       
        $hasCorrectAnswer = VerificationAnswer::where('report_id', $report->id)
            ->where('status', 'correct')
            ->exists();

        if ($hasCorrectAnswer) {
            return redirect()->route('reports.show', $report->id);
        }

        return view('answers.create', compact('report'));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'report_id' => 'required|exists:reports,id',
            'answer'    => 'required|string',
        ]);

       
        $alreadyAnswered = VerificationAnswer::where('report_id', $request->report_id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($alreadyAnswered) {
            return redirect()->route('reports.show', $request->report_id)
                ->withErrors(['answer' => 'You already submitted an answer for this report.']);
        }

        
        VerificationAnswer::create([
            'report_id' => $request->report_id,
            'user_id'   => Auth::id(),
            'answer'    => $request->answer,
            'status'    => 'pending',
        ]);

        return redirect()
            ->route('reports.show', $request->report_id)
            ->with('success', 'Answer submitted successfully!');
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'answer_id' => 'required|exists:verification_answers,id',
            'action'    => 'required|in:correct,reject',
        ]);

        $answer = VerificationAnswer::with('report')->findOrFail($request->answer_id);

        
        if ($answer->report->user_id !== Auth::id()) {
            abort(403);
        }

        $answer->status = $request->action === 'correct'
            ? 'correct'
            : 'rejected';

        $answer->save();

        return redirect()
            ->route('reports.show', $answer->report_id)
            ->with('success', 'Answer updated successfully!');
    }
}
