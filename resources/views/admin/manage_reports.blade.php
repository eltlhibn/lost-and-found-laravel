@extends('layouts.app')

@section('title', 'Manage Reports - Admin')

@push('styles')
<style>
  .report-img {
    max-width: 70px;
    max-height: 70px;
    border-radius: 5px;
    object-fit: cover;
  }
</style>
@endpush

@section('content')
<div class="navbar">
  <div class="nav-left">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <a href="{{ route('admin.manageReports') }}" style="background: #0f2349;">Manage Reports</a>
    <a href="{{ route('admin.users') }}">Manage Users</a>
  </div>
</div>

<div class="container" style="max-width: 1100px;">
  <h2 style="color: #1a3b7a; text-align: center; margin-bottom: 25px;">All Reports</h2>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>User</th>
        <th>Type</th>
        <th>Item</th>
        <th>Description</th>
        <th>Photo</th>
        <th>Location</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($reports as $row)
        <tr>
          <td>{{ $row->id }}</td>
          <td><strong>{{ $row->user ? $row->user->username : 'Deleted User' }}</strong></td>
          <td><strong>{{ strtoupper($row->report_type) }}</strong></td>
          <td>{{ $row->item_name }}</td>
          <td>{{ \Illuminate\Support\Str::limit($row->description, 50) }}</td>
          <td>
            @if (!empty($row->photo))
              <img src="{{ asset('storage/' . $row->photo) }}" class="report-img" alt="Report Photo">
            @else
              <span style="color:#888;">N/A</span>
            @endif
          </td>
          <td>{{ $row->location }}</td>
          <td>
            <span style="font-weight: bold; color: {{ $row->status === 'resolved' ? 'gray' : 'green' }};">
              {{ ucfirst($row->status) }}
            </span>
          </td>
          <td>
            <form method="POST"
                  action="{{ route('admin.reports.delete', $row->id) }}"
                  onsubmit="return confirm('Are you sure you want to delete this report?');">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-delete">Delete</button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="9" style="text-align: center; color: #777; padding: 25px;">No reports found.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
