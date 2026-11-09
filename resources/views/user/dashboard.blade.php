@extends('layouts.app')

@section('title', 'User Dashboard - Lost & Found')

@push('styles')
<style>
  .card-item {
    background: #fff;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    border-left: 6px solid #1a3b7a;
  }
  .card-item.lost { border-left-color: #d9534f; }
  .card-item.found { border-left-color: #5cb85c; }
  .card-item.resolved { opacity: 0.75; }

  .card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
  }
  .card-title {
    font-size: 18px;
    font-weight: bold;
    display: flex;
    gap: 8px;
    align-items: center;
  }
  .label-type {
    font-size: 13px;
    padding: 3px 8px;
    border-radius: 4px;
    color: white;
  }
  .lost .label-type { background: #d9534f; }
  .found .label-type { background: #5cb85c; }

  .resolved-badge {
    background: #6c757d;
    color: white;
    font-size: 12px;
    padding: 4px 10px;
    border-radius: 12px;
  }

  .report-photo {
    margin-bottom: 15px;
    text-align: center;
  }
  .report-photo img {
    max-width: 100%;
    max-height: 250px;
    border-radius: 8px;
    object-fit: cover;
  }

  .info-row {
    display: flex;
    margin-bottom: 8px;
    font-size: 14px;
  }
  .info-label {
    width: 120px;
    font-weight: bold;
    color: #555;
  }
  .info-value { flex: 1; }

  .actions {
    display: flex;
    gap: 10px;
    margin-top: 15px;
    padding-top: 12px;
    border-top: 1px solid #eee;
    align-items: center;
  }

  .answer-btn {
    display: inline-block;
    padding: 8px 15px;
    background: #1a3b7a;
    color: white;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 500;
    margin-top: 10px;
  }
</style>
@endpush

@section('content')
<div class="navbar">
  <div class="nav-left">
    <a href="{{ route('reports.create') }}">+ Report Item</a>
    <a href="{{ route('reports.my') }}">My Reports</a>
  </div>

  <div class="nav-center">
    <a href="{{ route('user.dashboard', ['filter' => 'all']) }}" class="filter-btn {{ $filter === 'all' ? 'active' : '' }}">All</a>
    <a href="{{ route('user.dashboard', ['filter' => 'lost']) }}" class="filter-btn {{ $filter === 'lost' ? 'active' : '' }}">Lost</a>
    <a href="{{ route('user.dashboard', ['filter' => 'found']) }}" class="filter-btn {{ $filter === 'found' ? 'active' : '' }}">Found</a>
  </div>

  <div class="nav-right">
    <form method="GET" action="{{ route('user.dashboard') }}">
      <input type="hidden" name="filter" value="{{ $filter }}">
      <input class="search-box" name="search" value="{{ $search }}" placeholder="Search items...">
      <button class="search-btn">🔍</button>
    </form>
  </div>
</div>

<div class="container">
  @forelse($reports as $report)
    <div class="card-item {{ $report->report_type }} {{ $report->status === 'resolved' ? 'resolved' : '' }}">
      <div class="card-header">
        <div class="card-title">
          <span class="label-type">{{ strtoupper($report->report_type) }}</span>
          <span>{{ $report->item_name }}</span>
        </div>
        @if($report->status === 'resolved')
          <span class="resolved-badge">Resolved</span>
        @endif
      </div>

      @if($report->photo)
        <div class="report-photo">
          <img src="{{ asset('storage/' . $report->photo) }}" alt="{{ $report->item_name }}">
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
        <div class="info-value">{{ $report->date_lost_found->format('M d, Y') }}</div>
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

      @if($report->report_type === 'found' && $report->status === 'open' && $report->user_id !== Auth::id())
        <a href="{{ route('verification.answer', $report->id) }}" class="answer-btn">
          Answer Verification Question
        </a>
      @endif

      @if($report->user_id === Auth::id() && $report->status === 'open')
        <div class="actions">
          <form method="POST" action="{{ route('reports.resolve', $report->id) }}">
            @csrf
            <button type="submit" class="btn btn-success">Mark Resolved</button>
          </form>

          <a href="{{ route('reports.edit', $report->id) }}" class="btn btn-primary">Edit</a>

          <form method="POST" action="{{ route('reports.destroy', $report->id) }}" onsubmit="return confirm('Are you sure you want to delete this report?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
          </form>
        </div>
      @endif
    </div>
  @empty
    <div class="card" style="text-align: center; color: #777;">
      <p>No reports found.</p>
    </div>
  @endforelse
</div>
@endsection
