<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Reports</title>

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

.navbar h1 {
  font-size: 20px;
  margin: 0;
}

.navbar a {
  color: white;
  margin-left: 20px;
  text-decoration: none;
  font-weight: 500;
}

.navbar a:hover {
  text-decoration: underline;
}

.container {
  padding: 40px;
  max-width: 1100px;
  margin: 0 auto;
}

h2 {
  color: #1a3b7a;
  margin-bottom: 20px;
  text-align: center;
}

table {
  width: 100%;
  border-collapse: collapse;
  background: #fff;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0px 4px 15px rgba(0,0,0,0.1);
  margin: 0 auto;
}

th, td {
  padding: 12px 15px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

th {
  background-color: #1a3b7a;
  color: white;
}

tr:hover {
  background-color: #f1f1f1;
}

img {
  max-width: 80px;
  border-radius: 5px;
}

.actions {
  white-space: nowrap;
}

.action-buttons {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.action-buttons form {
  margin: 0;
}

.btn {
  width: 130px;
  height: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 6px;
  font-size: 13px;
  font-weight: 500;
  text-decoration: none;
  color: white;
  border: none;
  cursor: pointer;
}

.btn-edit { background-color: #007bff; }
.btn-delete { background-color: #dc3545; }
.btn-resolve { background-color: #28a745; }
.btn-view { background-color: #6c757d; }

.status-open { color: red; font-weight: bold; }
.status-resolved { color: green; font-weight: bold; }
</style>
</head>

<body>

<div class="navbar">
  <h1>Lost & Found</h1>
  <div>
    <a href="{{ route('user.dashboard') }}">Dashboard</a>
    <a href="{{ route('reports.create') }}">Report Item</a>
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
  <h2>My Reports</h2>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Type</th>
        <th>Item</th>
        <th>Description</th>
        <th>Location</th>
        <th>Contact</th>
        <th>Date Lost/Found</th>
        <th>Date Reported</th>
        <th>Photo</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>

    <tbody>
    @forelse ($reports as $report)
      <tr>
        <td>{{ $report->id }}</td>
        <td>{{ ucfirst($report->report_type) }}</td>
        <td>{{ $report->item_name }}</td>
        <td>{{ $report->description }}</td>
        <td>{{ $report->location }}</td>
        <td>
          @if ($report->report_type == 'found' && $report->status == 'open')
            (hidden until verified)
          @else
            {{ $report->contact_info ?? 'No contact info provided' }}
          @endif
        </td>

        <!-- FIXED: Format date_lost_found to remove 00:00:00 -->
        <td>{{ $report->date_lost_found ? \Carbon\Carbon::parse($report->date_lost_found)->format('Y-m-d') : 'N/A' }}</td>

        <td>{{ $report->created_at ? \Carbon\Carbon::parse($report->created_at)->format('Y-m-d') : 'N/A' }}</td>

        <td>
          @if ($report->photo)
            <img src="{{ asset('storage/'.$report->photo) }}">
          @else
            No Image
          @endif
        </td>

        <td>
          @if ($report->status === 'resolved')
            <span class="status-resolved">Resolved</span>
          @else
            <span class="status-open">Open</span>
          @endif
        </td>

        <td class="actions">
          <div class="action-buttons">
            <a href="{{ route('reports.edit', $report->id) }}" class="btn btn-edit">Edit</a>

            <form method="POST" action="{{ route('reports.delete', $report->id) }}">
              @csrf
              <input type="hidden" name="page" value="my_reports">
              <button class="btn btn-delete">Delete</button>
            </form>

            @if ($report->status !== 'resolved')
              <form method="POST" action="{{ route('reports.resolve', $report->id) }}">
                @csrf
                <input type="hidden" name="page" value="my_reports">
                <button class="btn btn-resolve">Mark Resolved</button>
              </form>
            @endif

            @if ($report->report_type === 'found')
              <a href="{{ route('reports.show', $report->id) }}" class="btn btn-view">View Answers</a>
            @endif
          </div>
        </td>
      </tr>
    @empty
      <tr>
        <td colspan="11" style="text-align:center;">You haven’t submitted any reports yet.</td>
      </tr>
    @endforelse
    </tbody>
  </table>
</div>

</body>
</html>
