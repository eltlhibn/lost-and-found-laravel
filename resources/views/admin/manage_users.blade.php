@extends('layouts.app')

@section('title', 'Manage Users - Admin')

@section('content')
<div class="navbar">
  <div class="nav-left">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <a href="{{ route('admin.manageReports') }}">Manage Reports</a>
    <a href="{{ route('admin.users') }}" style="background: #0f2349;">Manage Users</a>
  </div>
</div>

<div class="container" style="max-width: 1000px;">
  <h2 style="color: #1a3b7a; text-align: center; margin-bottom: 25px;">User Management</h2>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Role</th>
        <th>Status</th>
        <th>Created</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($users as $row)
        <tr>
          <td>{{ $row->id }}</td>
          <td><strong>{{ $row->username }}</strong></td>
          <td>{{ $row->email }}</td>
          <td>{{ ucfirst($row->role) }}</td>
          <td>
            <span style="font-weight: bold; color: {{ $row->status === 'active' ? 'green' : 'red' }};">
              {{ ucfirst($row->status) }}
            </span>
          </td>
          <td>{{ $row->created_at ? $row->created_at->format('Y-m-d') : 'N/A' }}</td>
          <td>
            @if ($row->status === 'active')
              <form method="POST" action="{{ route('admin.user.action', $row->id) }}" style="display:inline;">
                @csrf
                <input type="hidden" name="action" value="block">
                <button type="submit" class="btn btn-block">Block</button>
              </form>
            @else
              <form method="POST" action="{{ route('admin.user.action', $row->id) }}" style="display:inline;">
                @csrf
                <input type="hidden" name="action" value="unblock">
                <button type="submit" class="btn btn-unblock">Unblock</button>
              </form>
            @endif

            <form method="POST" action="{{ route('admin.user.action', $row->id) }}" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this user? All their reports will also be removed.');">
              @csrf
              <input type="hidden" name="action" value="delete">
              <button type="submit" class="btn btn-delete">Delete</button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="7" style="text-align: center; color: #777; padding: 25px;">No users found.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
