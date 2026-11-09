@extends('layouts.app')

@section('title', 'Answer Verification - ' . $report->item_name)

@section('content')
<div class="navbar">
  <div class="nav-left">
    <a href="{{ route('user.dashboard') }}">← Back to Dashboard</a>
  </div>
</div>

<div class="container" style="max-width: 600px;">
  <div class="card">
    <h2 style="color: #1a3b7a; text-align: center; margin-bottom: 20px;">Answer Verification Question</h2>

    <div style="background: #eef3fc; border-left: 4px solid #1a3b7a; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
      <p style="margin: 0 0 8px 0;"><strong>Found Item:</strong> {{ $report->item_name }}</p>
      <p style="margin: 0;"><strong>Question from finder:</strong> <em>"{{ $report->verification_question }}"</em></p>
    </div>

    <form method="POST" action="{{ route('answers.submit') }}">
      @csrf
      <input type="hidden" name="report_id" value="{{ $report->id }}">
      <div class="form-group">
        <label for="answer">Your Answer</label>
        <textarea id="answer" name="answer" class="form-control" rows="4" required placeholder="Type your answer here to prove this item is yours..."></textarea>
      </div>
      <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px; font-size: 16px;">Submit Answer</button>
    </form>
  </div>
</div>
@endsection
