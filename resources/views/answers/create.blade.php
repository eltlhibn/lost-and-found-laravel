<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Answer Verification</title>

<style>
body {
  font-family: Arial, sans-serif;
  background:#f3f7f6;
  margin:0;
}

.navbar {
  background:#1a3b7a;
  padding:15px 30px;
  display:flex;
  justify-content:space-between;
  align-items:center;
  color:#fff;
}
.navbar h1 {
  font-size:20px;
  margin:0;
}
.navbar a {
  color:white;
  margin-left:20px;
  text-decoration:none;
  font-weight:500;
}
.navbar a:hover {
  text-decoration:underline;
}


.container {
  max-width:600px;
  margin:40px auto;
  background:#fff;
  padding:30px;
  border-radius:12px;
  box-shadow:0 4px 15px rgba(0,0,0,0.1);
}

h2 {
  text-align:center;
  color:#1a3b7a;
  margin-bottom:20px;
}

textarea {
  width:100%;
  min-height:120px;
  padding:10px;
  border-radius:8px;
  border:1px solid #ccc;
}

.submit-btn {
  margin-top:15px;
  width:100%;
  background:#1a3b7a;
  color:white;
  padding:10px;
  border:none;
  border-radius:8px;
  font-size:16px;
  cursor:pointer;
}

.submit-btn:hover {
  opacity:0.9;
}

.error {
  color:red;
  text-align:center;
  margin-bottom:10px;
}
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
  <h2>Answer Verification Question</h2>

  @if ($errors->any())
    <div class="error">{{ $errors->first() }}</div>
  @endif

  <p><strong>Item:</strong> {{ $report->item_name }}</p>
  <p><strong>Verification Question:</strong><br>
     {{ $report->verification_question }}</p>

  <form method="POST" action="{{ route('answers.submit') }}">
    @csrf
    <input type="hidden" name="report_id" value="{{ $report->id }}">
    <textarea name="answer" required placeholder="Type your answer here..."></textarea>
    <button class="submit-btn">Submit Answer</button>
  </form>
</div>

</body>
</html>
