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
    .navbar a:hover { text-decoration: underline; }

    .container {
      max-width: 900px;
      margin: 30px auto;
      background:#fff;
      padding:30px;
      border-radius:12px;
      box-shadow:0 4px 15px rgba(0,0,0,0.1);
    }

    h2 { margin-top:0; color:#1a3b7a; }
    .info-row { margin-bottom:12px; }
    .info-label { font-weight:bold; display:inline-block; width:140px; }

    .answer-section { margin-top:30px; }
    .answer-item {
      padding:15px;
      border:1px solid #ddd;
      border-radius:8px;
      margin-bottom:15px;
      background:#fafafa;
    }

    .status-correct { color:green; font-weight:bold; }
    .status-rejected { color:red; font-weight:bold; }
    .status-pending { color:orange; font-weight:bold; }

    .btn { padding:6px 12px; border:none; border-radius:6px; cursor:pointer; margin-right:6px; }
    .btn-accept { background:green; color:white; }
    .btn-reject { background:red; color:white; }
    .btn:hover { opacity:0.9; }

    textarea {
      width:100%;
      min-height:100px;
      padding:10px;
      border-radius:8px;
      border:1px solid #ccc;
      margin-bottom:10px;
      resize:vertical;
    }

    .submit-btn {
      background:#1a3b7a;
      color:white;
      padding:8px 14px;
      border:none;
      border-radius:6px;
      cursor:pointer;
    }
    .submit-btn:hover { opacity:0.9; }

    .success { color:green; font-weight:bold; margin-top:15px; }
    .warning { color:#e67e22; font-weight:bold; margin-top:15px; }
  </style>
</head>
<body>

  <div class="navbar">
    <h1>Lost & Found</h1>
    <div>
      <a href="{{ route('user.dashboard') }}">Dashboard</a>
      <a href="{{ route('reports.mine') }}">My Reports</a>

      <form method="POST" action="{{ route('logout') }}" style="display:inline;">
        @csrf
        <button class="btn btn-reject">Logout</button>
      </form>
    </div>
  </div>

  <div class="container">
    <h2>{{ $report->item_name }}</h2>

    <div class="info-row"><span class="info-label">Type:</span> {{ ucfirst($report->report_type) }}</div>
    <div class="info-row"><span class="info-label">Description:</span> {{ $report->description }}</div>
    <div class="info-row"><span class="info-label">Location:</span> {{ $report->location }}</div>
    <div class="info-row"><span class="info-label">Date:</span> {{ $report->date_lost_found }}</div>
    <div class="info-row"><span class="info-label">Posted by:</span> {{ $report->owner->username }}</div>

    <div class="answer-section">
      <h3>Verification Answers</h3>

      @forelse ($answers as $a)
        <div class="answer-item">
          <strong>{{ $a->user->username }}</strong><br>
          {!! nl2br(e($a->answer)) !!}<br>
          <small>Submitted on {{ $a->created_at }}</small><br>

          @if ($a->status === 'correct')
            <span class="status-correct">Correct</span>
            <div style="margin-top:6px;font-size:14px;color:#333;">
              Contact the owner to claim your item:<br>
              <strong>{{ $report->contact_info }}</strong>
            </div>
          @elseif ($a->status === 'rejected')
            <span class="status-rejected">Rejected</span>
          @else
            <span class="status-pending">Pending</span>
          @endif

          @if ($isOwner && $a->status === 'pending')
            <form method="POST" action="{{ route('answers.update', $a->id) }}" style="margin-top:10px;">
              @csrf
              @method('PATCH')

              <button name="action" value="correct" class="btn btn-accept">Accept</button>
              <button name="action" value="reject" class="btn btn-reject">Reject</button>
            </form>
          @endif
        </div>
      @empty
        <p>No answers submitted yet.</p>
      @endforelse
    </div>

    @if (session('success'))
      <p class="success">{{ session('success') }}</p>
    @endif

    @if (!$isOwner && !$userAnswered && $report->report_type === 'found' && $report->status === 'open')
      <div style="margin-top:40px;">
        <h3>Submit Your Answer</h3>
        <form method="POST" action="{{ route('answers.store', $report->id) }}">
          @csrf
          <textarea name="answer" placeholder="Type your answer here..." required></textarea>
          <button type="submit" class="submit-btn">Submit Answer</button>
        </form>
      </div>
    @endif

  </div>
</body>
</html>
