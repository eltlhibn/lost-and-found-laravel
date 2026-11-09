@extends('layouts.app')

@section('title', 'Admin Dashboard - Lost & Found')

@section('content')
<div class="navbar">
  <div class="nav-left">
    <a href="{{ route('admin.dashboard') }}" style="background: #0f2349;">Dashboard</a>
    <a href="{{ route('admin.manageReports') }}">Manage Reports</a>
    <a href="{{ route('admin.users') }}">Manage Users</a>
  </div>
</div>

<div class="container">
  <div class="card" style="text-align: center; padding: 40px;">
    <h2 style="color: #1a3b7a; margin-bottom: 10px;">Welcome, Admin {{ Auth::user()->username }} 👋</h2>
    <p style="color: #666; margin-bottom: 30px;">Choose an administrative section below to manage the system.</p>

    <div style="display: flex; justify-content: center; gap: 20px;">
      <a href="{{ route('admin.manageReports') }}" class="btn btn-primary" style="padding: 12px 24px; font-size: 15px;">
        📋 Manage Reports
      </a>
      <a href="{{ route('admin.users') }}" class="btn btn-primary" style="padding: 12px 24px; font-size: 15px;">
        👤 Manage Users
      </a>
    </div>
  </div>
</div>
@endsection
