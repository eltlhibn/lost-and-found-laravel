<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Users - Lost & Found</title>
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
    }

    th {
      background-color: #1a3b7a;
      color: white;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    .btn {
      padding: 6px 12px;
      border-radius: 5px;
      font-size: 13px;
      text-decoration: none;
      margin: 2px;
      display: inline-block;
    }

    .btn-block { background-color: #d9534f; color: white; }
    .btn-unblock { background-color: #5cb85c; color: white; }
    .btn-delete { background-color: #f0ad4e; color: white; }
  </style>
</head>
<body>

<div class="navbar">
  <h1>Lost & Found - Admin</h1>
  <div>
    <a href="/admin/dashboard">Dashboard</a>
    <a href="/admin/reports">Manage Reports</a>
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
  <h2>Manage Users</h2>

  <table>
    <tr>
      <th>ID</th>
      <th>Username</th>
      <th>Email</th>
      <th>Role</th>
      <th>Status</th>
      <th>Created</th>
      <th>Actions</th>
    </tr>

    @foreach ($users as $row)
    <tr>
      <td>{{ $row->id }}</td>
      <td>{{ $row->username }}</td>
      <td>{{ $row->email }}</td>
      <td>{{ $row->role }}</td>
      <td>{{ $row->status }}</td>
      <td>{{ $row->created_at }}</td>
      <td>
        @if ($row->status === 'active')
          <a href="/admin/user-action/{{ $row->id }}?action=block"
             class="btn btn-block">Block</a>
        @else
          <a href="/admin/user-action/{{ $row->id }}?action=unblock"
             class="btn btn-unblock">Unblock</a>
        @endif

        <a href="/admin/user-action/{{ $row->id }}?action=delete"
           class="btn btn-delete"
           onclick="return confirm('Are you sure you want to delete this user?');">
           Delete
        </a>
      </td>
    </tr>
    @endforeach

  </table>
</div>

</body>
</html>
