<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Report</title>
  <style>
    body { font-family: Arial, sans-serif; background:#f3f7f6; margin:0; padding:0; }
    .navbar {
      background-color: #1a3b7a;
      color: white;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .navbar h1 { font-size: 20px; margin: 0; }
    .navbar a {
      color: white;
      margin-left: 20px;
      text-decoration: none;
      font-weight: 500;
    }
    .container {
      max-width: 900px;
      margin: 30px auto;
      background:#fff;
      padding:30px;
      border-radius:12px;
      box-shadow:0 4px 15px rgba(0,0,0,0.1);
    }
    .info-label { font-weight:bold; width:140px; display:inline-block; }
    .answer-item { padding:15px; border:1px solid #ddd; border-radius:8px; margin-bottom:15px; background:#fafafa; }
    .status-correct { color:green; font-weight:bold; }
    .status-rejected { color:red; font-weight:bold; }
    .status-pending { color:orange; font-weight:bold; }
    textarea { width:100%; min-height:100px; padding:10px; border-radius:8px; }
    .submit-btn { background:#1a3b7a; color:white; padding:8px 14px; border:none; border-radius:6px; }
    .btn { padding:6px 12px; border-radius:6px; border:none; cursor:pointer; }
    .btn-accept { background:green; color:white; }
    .btn-reject { background:red; color:white; }
    .success { color:green; font-weight:bold; margin-bottom:15px; }
  </style>
</head>
<body>

<div class="navbar">
  <h1>Lost & Found</h1>
  <div>
    <a href="{{ route('user.dashboard') }}">Dashboard</a>
    <a href="{{ route('reports.my') }}">My Reports</a>
    <a href="{{ route('logout') }}"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
       Logout
    </a>
  </div>
</div>

<form id="logout-form" method="POST" action="{{ route('logout') }}">
  @csrf
</form>

<div class="container">
  <h2>{{ $report->item_name }}</h2>

  @if(session('success'))
    <p class="success">{{ session('success') }}</p>
  @endif

  <p><span class="info-label">Type:</span> {{ ucfirst($report->report_type) }}</p>
  <p><span class="info-label">Description:</span> {{ $report->description }}</p>
  <p><span class="info-label">Location:</span> {{ $report->location }}</p>
  <p><span class="info-label">Date:</span> {{ $report->date_lost_found }}</p>

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
      {{ $report->contact_info }}
    @else
      (hidden until verified)
    @endif
  </p>

  <hr>

  <h3>Verification Answers</h3>

  @forelse($report->answers as $answer)
    <div class="answer-item">
      <strong>{{ $answer->user->username }}</strong><br>
      {{ $answer->answer }}<br>
      <small>{{ $answer->created_at }}</small><br>

      @if($answer->status === 'correct')
        <span class="status-correct">Correct</span>
      @elseif($answer->status === 'rejected')
        <span class="status-rejected">Rejected</span>
      @else
        <span class="status-pending">Pending</span>
      @endif

      @if(auth()->id() === $report->user_id && $answer->status === 'pending')
        <form method="POST" action="{{ route('answers.updateStatus') }}" style="margin-top:10px;">
          @csrf
          <input type="hidden" name="answer_id" value="{{ $answer->id }}">
          <button name="action" value="correct" class="btn btn-accept">Accept</button>
          <button name="action" value="reject" class="btn btn-reject">Reject</button>
        </form>
      @endif
    </div>
  @empty
    <p>No answers submitted yet.</p>
  @endforelse

  @if(
      auth()->id() !== $report->user_id &&
      $report->report_type === 'found' &&
      !$userAnswer && 
      !$acceptedAnswer
  )
    <hr>
    <h3>Submit Your Answer</h3>

    <form method="POST" action="{{ route('answers.submit') }}">
      @csrf
      <input type="hidden" name="report_id" value="{{ $report->id }}">
      <textarea name="answer" required placeholder="Type your answer here..."></textarea>
      <br><br>
      <button class="submit-btn">Submit Answer</button>
    </form>
  @endif

</div>

</body>
</html>
