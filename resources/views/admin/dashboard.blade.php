<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - Lost & Found</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      background-color: #f3f7f6;
    }
    .navbar {
      background-color: #1a3b7a;
      color: white;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .navbar h1 { font-size: 20px; margin: 0; }
    .navbar a { color: white; text-decoration: none; font-weight: 500; }
    .container { padding: 40px; max-width: 1000px; margin: auto; }
    .card {
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0px 4px 15px rgba(0,0,0,0.1);
    }
    .btn {
      display: inline-block;
      padding: 12px 20px;
      background-color: #1a3b7a;
      color: white;
      text-decoration: none;
      border-radius: 6px;
      margin-right: 10px;
    }
  </style>
</head>
<body>

<div class="navbar">
  <h1>Lost & Found - Admin</h1>
  <a href="{{ route('logout') }}"
     onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
     Logout
  </a>
</div>

<form id="logout-form" method="POST" action="{{ route('logout') }}">
  @csrf
</form>

<div class="container">
  <div class="card">
    <h2>Welcome, Admin {{ Auth::user()->username }} 👋</h2>
    <p>Here you can manage reports and users.</p>


    <a href="/admin/reports" class="btn">📋 Manage Reports</a>
    <a href="/admin/users" class="btn">👤 Manage Users</a>
  </div>
</div>

</body>
</html>
