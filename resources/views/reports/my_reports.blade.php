@extends('layouts.app')

@section('title', 'My Reports - Lost & Found')

@push('styles')
<style>
  .btn-action {
    display: inline-block;
    padding: 6px 10px;
    border-radius: 4px;
    font-size: 12px;
    color: white;
    text-decoration: none;
    border: none;
    cursor: pointer;
    margin: 2px 0;
  }
  .btn-edit { background: #0275d8; }
  .btn-delete { background: #d9534f; }
  .btn-resolve { background: #5cb85c; }
  .btn-view { background: #1a3b7a; }
  .btn-action:hover { opacity: 0.85; }

  .status-badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: bold;
    color: white;
  }
  .status-open { background: #5cb85c; }
  .status-resolved { background: #6c757d; }
  .table-img {
    max-width: 70px;
    max-height: 70px;
    border-radius: 4px;
    object-fit: cover;
  }
</style>
@endpush

@section('content')
<div class="navbar">
  <div class="nav-left">
    <a href="{{ route('user.dashboard') }}">← Back to Dashboard</a>
    <a href="{{ route('reports.create') }}">+ Report Item</a>
  </div>
</div>

<div class="container" style="max-width: 1200px;">
  <h2 style="color: #1a3b7a; text-align: center; margin-bottom: 25px;">My Submitted Reports</h2>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Type</th>
        <th>Item</th>
        <th>Description</th>
        <th>Location</th>
        <th>Contact</th>
        <th>Date</th>
        <th>Photo</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($reports as $report)
        <tr>
          <td>{{ $report->id }}</td>
          <td><strong>{{ strtoupper($report->report_type) }}</strong></td>
          <td>{{ $report->item_name }}</td>
          <td>{{ \Illuminate\Support\Str::limit($report->description, 50) }}</td>
          <td>{{ $report->location }}</td>
          <td>
            @if ($report->report_type === 'found' && $report->status === 'open')
              <em>(hidden until verified)</em>
            @else
              {{ $report->contact_info ?? 'N/A' }}
            @endif
          </td>
          <td>{{ $report->date_lost_found ? $report->date_lost_found->format('Y-m-d') : 'N/A' }}</td>
          <td>
            @if ($report->photo)
              <img src="{{ asset('storage/' . $report->photo) }}" class="table-img" alt="Photo">
            @else
              <span style="color:#888;">No Photo</span>
            @endif
          </td>
          <td>
            <span class="status-badge {{ $report->status === 'resolved' ? 'status-resolved' : 'status-open' }}">
              {{ ucfirst($report->status) }}
            </span>
          </td>
          <td style="white-space: nowrap;">
            <a href="{{ route('reports.edit', $report->id) }}" class="btn-action btn-edit">Edit</a>

            @if ($report->status !== 'resolved')
              <form method="POST" action="{{ route('reports.resolve', $report->id) }}" style="display:inline;">
                @csrf
                <button type="submit" class="btn-action btn-resolve">Resolve</button>
              </form>
            @endif

            @if ($report->report_type === 'found')
              <a href="{{ route('reports.show', $report->id) }}" class="btn-action btn-view">Answers</a>
            @endif

            <form method="POST" action="{{ route('reports.destroy', $report->id) }}" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this report?');">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn-action btn-delete">Delete</button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="10" style="text-align: center; color: #777; padding: 25px;">
            You have not submitted any reports yet.
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
