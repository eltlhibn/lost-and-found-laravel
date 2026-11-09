<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>User Dashboard</title>

<style>
body {
  font-family: Arial, sans-serif;
  background:#f3f7f6;
  margin:0;
}

.topbar {
  background:#1a3b7a;
  padding:10px 20px;
  display:flex;
  justify-content:space-between;
  align-items:center;
  color:#fff;
}
.topbar-left {
  font-size:20px;
  font-weight:bold;
  display:flex;
  align-items:center;
  gap:8px;
}
.topbar-right {
  font-size:16px;
  display:flex;
  align-items:center;
  gap:10px;
}
.logout-btn {
  background:#dc3545;
  padding:6px 12px;
  border-radius:6px;
  color:white;
  border:none;
  cursor:pointer;
}

.navbar {
  background:#fff;
  padding:15px 30px;
  display:flex;
  justify-content:space-between;
  align-items:center;
  border-bottom:1px solid #ddd;
}
.nav-left a {
  background:#1a3b7a;
  color:#fff;
  padding:8px 15px;
  border-radius:8px;
  text-decoration:none;
  font-weight:bold;
}
.nav-left a + a { margin-left:10px; }

.nav-center {
  flex:1;
  text-align:center;
}
.filter-btn {
  margin:0 5px;
  padding:8px 20px;
  border:1px solid #ccc;
  border-radius:20px;
  background:#fff;
  color:#333;
  font-weight:bold;
  text-decoration:none;
}
.filter-btn.active {
  background:#1a3b7a;
  color:white;
  border-color:#1a3b7a;
}

.nav-right form {
  display:flex;
}
.search-box {
  padding:8px 12px;
  border:1px solid #ccc;
  border-right:none;
  border-radius:20px 0 0 20px;
  outline:none;
  width:200px;
}
.search-btn {
  padding:8px 15px;
  border:none;
  border-radius:0 20px 20px 0;
  background:#1a3b7a;
  color:white;
  cursor:pointer;
}

.container {
  padding:30px;
  max-width:1200px;
  margin:auto;
  display:grid;
  grid-template-columns:repeat(auto-fill, minmax(320px, 1fr));
  gap:25px;
  margin-top:30px;
}

.card {
  background:#fff;
  border-radius:12px;
  box-shadow:0 4px 15px rgba(0,0,0,0.1);
  padding:20px;
  border-top:5px solid;
}
.card.lost { border-color:#dc3545; }
.card.found { border-color:#28a745; }
.card.resolved { opacity:0.6; }

.card h3 {
  margin:0 0 12px;
  font-size:18px;
  display:flex;
  justify-content:space-between;
  align-items:center;
}

.title-left {
  display:flex;
  align-items:center;
  gap:8px;
}
.label { font-weight:bold; }
.item-name {
  font-weight:600;
  white-space:nowrap;
  overflow:hidden;
  text-overflow:ellipsis;
}

.resolved-badge {
  background:#6c757d;
  color:white;
  padding:3px 8px;
  border-radius:6px;
  font-size:12px;
}

.info-row {
  display:flex;
  margin:6px 0;
}
.info-label {
  font-weight:bold;
  width:110px;
}
.info-value { flex:1; }

.report-photo {
  text-align:center;
  margin:10px 0;
}
.report-photo img {
  max-width:100%;
  max-height:200px;
  border-radius:8px;
  border:1px solid #ddd;
}

.actions {
  margin-top:15px;
  display:grid;
  grid-template-columns: repeat(3, 1fr);
  gap:8px;
}

.actions form {
  margin:0;
}

.actions a,
.actions button {
  width:100%;
  height:36px;
  background:#1a3b7a;
  color:white;
  border-radius:6px;
  text-decoration:none;
  font-size:13px;
  display:flex;
  align-items:center;
  justify-content:center;
  border:none;
  cursor:pointer;
}

.actions a:hover,
.actions button:hover {
  opacity:0.85;
}

.answer-btn {
  margin-top:10px;
  display:block;
  text-align:center;
  padding:8px;
  background:#1a3b7a;
  color:white;
  border-radius:6px;
  text-decoration:none;
  font-weight:none;
}
.answer-btn:hover { opacity:0.9; }
</style>
</head>

<body>

<div class="topbar">
  <div class="topbar-left">🔍 Lost & Found Portal</div>
  <div class="topbar-right">
    Welcome, {{ Auth::user()->username }}
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button class="logout-btn">Logout</button>
    </form>
  </div>
</div>

<div class="navbar">
  <div class="nav-left">
    <a href="{{ route('reports.create') }}">Report Item</a>
    <a href="{{ route('reports.my') }}">My Reports</a>
  </div>

  <div class="nav-center">
    <a href="{{ route('user.dashboard',['filter'=>'all']) }}" class="filter-btn {{ $filter=='all'?'active':'' }}">All</a>
    <a href="{{ route('user.dashboard',['filter'=>'lost']) }}" class="filter-btn {{ $filter=='lost'?'active':'' }}">Lost</a>
    <a href="{{ route('user.dashboard',['filter'=>'found']) }}" class="filter-btn {{ $filter=='found'?'active':'' }}">Found</a>
  </div>

  <div class="nav-right">
    <form method="GET">
      <input type="hidden" name="filter" value="{{ $filter }}">
      <input class="search-box" name="search" value="{{ $search }}" placeholder="Search...">
      <button class="search-btn">🔍</button>
    </form>
  </div>
</div>

<div class="container">
@foreach($reports as $report)
<div class="card {{ $report->report_type }} {{ $report->status=='resolved'?'resolved':'' }}">
  <h3>
    <div class="title-left">
      <span class="label">{{ strtoupper($report->report_type) }}:</span>
      <span class="item-name">{{ $report->item_name }}</span>
    </div>
    @if($report->status=='resolved')
      <span class="resolved-badge">Resolved</span>
    @endif
  </h3>

  @if($report->photo)
    <div class="report-photo">
      <img src="{{ asset('storage/'.$report->photo) }}">
    </div>
  @endif

  <div class="info-row">
    <div class="info-label">Description:</div>
    <div class="info-value">{{ $report->description }}</div>
  </div>

  <div class="info-row">
    <div class="info-label">Location:</div>
    <div class="info-value">{{ $report->location }}</div>
  </div>

  <div class="info-row">
    <div class="info-label">Date:</div>
    <div class="info-value">{{ $report->date_lost_found }}</div>
  </div>

  <div class="info-row">
    <div class="info-label">Contact:</div>
    <div class="info-value">
      @if($report->report_type === 'lost')
        {{ $report->contact_info }}
      @else
        <em>Hidden until verified</em>
      @endif
    </div>
  </div>

  @if(
    $report->report_type === 'found' &&
    $report->status === 'open' &&
    $report->user_id !== Auth::id()
  )
    <a href="{{ route('verification.answer', $report->id) }}" class="answer-btn">
      Answer Question
    </a>
  @endif

  <div class="actions">
    @if($report->user_id === Auth::id() && $report->status=='open')
      <form method="POST" action="{{ route('reports.resolve',$report->id) }}">
        @csrf
        <button>Mark Resolved</button>
      </form>

      <a href="{{ route('reports.edit',$report->id) }}">Edit</a>

      <form method="POST" action="{{ route('reports.delete',$report->id) }}">
        @csrf
        <button>Delete</button>
      </form>
    @endif
  </div>
</div>
@endforeach
</div>

</body>
</html>
