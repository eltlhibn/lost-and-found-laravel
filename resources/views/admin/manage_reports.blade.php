<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Reports - Lost & Found</title>
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
    margin-left: 25px;
    text-decoration: none;
    font-weight: 500;
  }

  .navbar a:hover {
    text-decoration: underline;
  }

  .container {
    padding: 40px;
    max-width: 1100px;
    margin: auto;
  }

  h2 {
    color: #1a3b7a;
    margin-bottom: 20px;
    text-align: center;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0px 4px 15px rgba(0,0,0,0.1);
  }

  th, td {
    padding: 12px;
    border: 1px solid #ddd;
    text-align: center;
    vertical-align: middle;
  }

  th {
    background-color: #1a3b7a;
    color: white;
  }

  tr:nth-child(even) {
    background-color: #f9f9f9;
  }

  .btn-delete {
    padding: 6px 12px;
    background-color: #d9534f;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-size: 13px;
  }

  .btn-delete:hover {
    background-color: #c9302c;
  }

  .report-img {
    max-width: 80px;
    max-height: 80px;
    border-radius: 5px;
  }
</style>
</head>
<body>

<div class="navbar">
  <h1>Lost & Found - Admin</h1>
  <div>
    <a href="/admin/dashboard">Dashboard</a>
    <a href="/admin/users">Manage Users</a>
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
  <h2>Manage Reports</h2>

  <table>
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

    @foreach ($reports as $row)
    <tr>
      <td>{{ $row->id }}</td>
      <td>{{ $row->user->username }}</td>
      <td>{{ $row->report_type }}</td>
      <td>{{ $row->item_name }}</td>
      <td>{{ $row->description }}</td>
      <td>
        @if (!empty($row->photo))
          <img src="{{ asset('storage/' . $row->photo) }}" class="report-img" alt="Report Photo">
        @else
          N/A
        @endif
      </td>
      <td>{{ $row->location }}</td>
      <td>{{ $row->status }}</td>
      <td>
        <form method="POST"
              action="{{ route('admin.reports.delete', $row->id) }}"
              onsubmit="return confirm('Are you sure you want to delete this report?');">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn-delete">Delete</button>
        </form>
      </td>
    </tr>
    @endforeach

  </table>
</div>

</body>
</html>
