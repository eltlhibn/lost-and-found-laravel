@extends('layouts.app')

@section('title', $report->item_name . ' - Details')

@push('styles')
<style>
  .info-label { font-weight: bold; width: 140px; display: inline-block; color: #555; }
  .answer-item {
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 8px;
    margin-bottom: 15px;
    background: #fafafa;
  }
  .status-correct { color: green; font-weight: bold; }
  .status-rejected { color: red; font-weight: bold; }
  .status-pending { color: orange; font-weight: bold; }
  .btn-accept { background: #28a745; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; }
  .btn-reject { background: #dc3545; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; }
</style>
@endpush

@section('content')
<div class="navbar">
  <div class="nav-left">
    <a href="{{ route('reports.my') }}">← Back to My Reports</a>
    <a href="{{ route('user.dashboard') }}">Dashboard</a>
  </div>
</div>

<div class="container" style="max-width: 800px;">
  <div class="card">
    <h2 style="color: #1a3b7a; margin-top: 0;">{{ $report->item_name }}</h2>

    @if($report->photo)
      <div style="text-align: center; margin-bottom: 20px;">
        <img src="{{ asset('storage/' . $report->photo) }}" style="max-width: 300px; border-radius: 8px;" alt="{{ $report->item_name }}">
      </div>
    @endif

    <p><span class="info-label">Type:</span> <strong>{{ strtoupper($report->report_type) }}</strong></p>
    <p><span class="info-label">Description:</span> {{ $report->description }}</p>
    <p><span class="info-label">Location:</span> {{ $report->location }}</p>
    <p><span class="info-label">Date:</span> {{ $report->date_lost_found ? $report->date_lost_found->format('M d, Y') : 'N/A' }}</p>

    @php
      $acceptedAnswer = $report->answers->firstWhere('status', 'correct');
      $userAnswer = $report->answers->firstWhere('user_id', auth()->id());
    @endphp

    <p>
      <span class="info-label">Contact:</span>
      @if(
        auth()->id() === $report->user_id ||
        ($acceptedAnswer && auth()->id() === $acceptedAnswer->user_id)
      )
        <strong>{{ $report->contact_info }}</strong>
      @else
        <em>(Hidden until verified by owner)</em>
      @endif
    </p>

    @if($report->verification_question)
      <p><span class="info-label">Verification Question:</span> <em>"{{ $report->verification_question }}"</em></p>
    @endif

    <hr style="margin: 25px 0; border: 0; border-top: 1px solid #eee;">

    <h3 style="color: #1a3b7a;">Verification Answers</h3>

    @forelse($report->answers as $answer)
      <div class="answer-item">
        <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
          <strong>{{ $answer->user ? $answer->user->username : 'Deleted User' }}</strong>
          <small style="color: #777;">{{ $answer->created_at ? $answer->created_at->diffForHumans() : '' }}</small>
        </div>
        <p style="margin: 5px 0 10px 0;">{{ $answer->answer }}</p>

        <div>
          Status:
          @if($answer->status === 'correct')
            <span class="status-correct">Correct (Verified)</span>
          @elseif($answer->status === 'rejected')
            <span class="status-rejected">Rejected</span>
          @else
            <span class="status-pending">Pending Review</span>
          @endif
        </div>

        @if(auth()->id() === $report->user_id && $answer->status === 'pending')
          <form method="POST" action="{{ route('answers.updateStatus') }}" style="margin-top: 10px;">
            @csrf
            <input type="hidden" name="answer_id" value="{{ $answer->id }}">
            <button type="submit" name="action" value="correct" class="btn-accept">Accept as Correct</button>
            <button type="submit" name="action" value="reject" class="btn-reject">Reject</button>
          </form>
        @endif
      </div>
    @empty
      <p style="color: #777;">No answers submitted yet.</p>
    @endforelse

    @if(
      auth()->id() !== $report->user_id &&
      $report->report_type === 'found' &&
      !$userAnswer && 
      !$acceptedAnswer
    )
      <hr style="margin: 25px 0; border: 0; border-top: 1px solid #eee;">
      <h3 style="color: #1a3b7a;">Submit Your Answer</h3>

      <form method="POST" action="{{ route('answers.submit') }}">
        @csrf
        <input type="hidden" name="report_id" value="{{ $report->id }}">
        <div class="form-group">
          <textarea name="answer" class="form-control" rows="3" required placeholder="Type your answer to prove ownership..."></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit Answer</button>
      </form>
    @endif
  </div>
</div>
@endsection
