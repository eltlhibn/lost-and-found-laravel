<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Lost & Found')</title>
  <style>
    * { box-sizing: border-box; }
    body {
      font-family: Arial, sans-serif;
      background: #f3f7f6;
      margin: 0;
      color: #333;
    }
    .topbar {
      background: #1a3b7a;
      padding: 12px 24px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      color: #fff;
    }
    .topbar a {
      color: #fff;
      text-decoration: none;
    }
    .topbar-left {
      font-size: 20px;
      font-weight: bold;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .topbar-right {
      font-size: 15px;
      display: flex;
      align-items: center;
      gap: 15px;
    }
    .logout-btn {
      background: #dc3545;
      padding: 6px 14px;
      border-radius: 6px;
      color: white;
      border: none;
      cursor: pointer;
      font-size: 14px;
    }
    .logout-btn:hover { background: #c82333; }

    .navbar {
      background: #fff;
      padding: 12px 24px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid #ddd;
      gap: 15px;
      flex-wrap: wrap;
    }
    .nav-left { display: flex; align-items: center; gap: 10px; }
    .nav-left a {
      background: #1a3b7a;
      color: #fff;
      padding: 8px 15px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: 500;
      font-size: 14px;
    }
    .nav-left a:hover { opacity: 0.9; }

    .nav-center { display: flex; gap: 8px; }
    .filter-btn {
      padding: 6px 16px;
      border: 1px solid #ccc;
      border-radius: 20px;
      background: #fff;
      color: #333;
      font-weight: bold;
      text-decoration: none;
      font-size: 13px;
    }
    .filter-btn.active {
      background: #1a3b7a;
      color: white;
      border-color: #1a3b7a;
    }

    .nav-right form { display: flex; }
    .search-box {
      padding: 8px 12px;
      border: 1px solid #ccc;
      border-right: none;
      border-radius: 20px 0 0 20px;
      outline: none;
      width: 200px;
    }
    .search-btn {
      padding: 8px 15px;
      border: none;
      border-radius: 0 20px 20px 0;
      background: #1a3b7a;
      color: white;
      cursor: pointer;
    }

    .container {
      max-width: 1000px;
      margin: 30px auto;
      padding: 0 20px;
    }

    .alert {
      padding: 12px 18px;
      border-radius: 6px;
      margin-bottom: 20px;
      font-size: 14px;
    }
    .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

    .card {
      background: #fff;
      border-radius: 10px;
      padding: 24px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.08);
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }
    th, td {
      padding: 12px;
      border: 1px solid #ddd;
      text-align: center;
      vertical-align: middle;
    }
    th { background-color: #1a3b7a; color: white; }
    tr:nth-child(even) { background-color: #f9f9f9; }

    .btn {
      padding: 6px 12px;
      border-radius: 5px;
      font-size: 13px;
      text-decoration: none;
      display: inline-block;
      cursor: pointer;
      border: none;
    }
    .btn-primary { background: #1a3b7a; color: white; }
    .btn-danger, .btn-delete, .btn-block { background: #dc3545; color: white; }
    .btn-success, .btn-unblock { background: #28a745; color: white; }
    .btn:hover { opacity: 0.9; }

    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; margin-bottom: 5px; font-weight: bold; font-size: 14px; }
    .form-control {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      box-sizing: border-box;
      font-size: 14px;
    }
  </style>
  @stack('styles')
</head>
<body>

@auth
  <div class="topbar">
    <div class="topbar-left">
      <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard') }}">
        🔍 Lost & Found Portal
      </a>
    </div>
    <div class="topbar-right">
      <span>Welcome, <strong>{{ Auth::user()->username }}</strong> ({{ ucfirst(Auth::user()->role) }})</span>
      <form method="POST" action="{{ route('logout') }}" style="margin:0;">
        @csrf
        <button type="submit" class="logout-btn">Logout</button>
      </form>
    </div>
  </div>
@endauth

@if(session('success'))
  <div class="container" style="margin-top:20px; margin-bottom:0;">
    <div class="alert alert-success">{{ session('success') }}</div>
  </div>
@endif

@if(session('error') || $errors->any())
  <div class="container" style="margin-top:20px; margin-bottom:0;">
    <div class="alert alert-danger">
      {{ session('error') }}
      @if($errors->any())
        <ul style="margin:0; padding-left:20px;">
          @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
      @endif
    </div>
  </div>
@endif

@yield('content')

@stack('scripts')
</body>
</html>
