<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Report</title>

  <style>
    body { font-family: Arial, sans-serif; margin:0; background:#f3f7f6; }

    .navbar {
      background-color: #1a3b7a;
      color: white;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .navbar h1 { font-size: 20px; margin: 0; }
    .navbar a {
      color: white;
      margin-left: 20px;
      text-decoration: none;
      font-weight: 500;
    }
    .navbar a:hover { text-decoration: underline; }

    .container { padding:40px; max-width:600px; margin:30px auto; }
    .card { background:#fff; padding:30px; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.1); }
    h2 { color:#1a3b7a; text-align:center; margin-bottom:20px; }

    .form-group { margin-bottom:15px; }
    label { display:block; margin-bottom:5px; font-weight:bold; }
    input, textarea, select {
      width:100%; padding:10px; border-radius:5px; border:1px solid #ccc;
    }
    textarea { resize:vertical; min-height:60px; max-height:120px; }

    .btn-submit {
      background:#1a3b7a;
      color:#fff;
      padding:12px 20px;
      border:none;
      border-radius:8px;
      cursor:pointer;
      font-size:16px;
      width:100%;
    }
    .btn-submit:hover { opacity:0.9; }

    .message { margin-bottom:15px; font-weight:bold; color:green; text-align:center; }
    .error { color:red; text-align:center; }

    #preview-container { text-align:center; margin-top:10px; }
    #preview-container img { max-width:200px; border-radius:10px; margin-top:10px; }
  </style>

  <script>
    function toggleVerification() {
      var type = document.querySelector('select[name="report_type"]').value;
      var qContainer = document.getElementById('verification-container');
      qContainer.style.display = (type === 'found') ? 'block' : 'none';
    }

    function previewPhoto(event) {
      const preview = document.getElementById('preview');
      if (event.target.files && event.target.files[0]) {
        preview.src = URL.createObjectURL(event.target.files[0]);
        preview.style.display = "block";
      }
    }

    function setMaxDate() {
      const today = new Date().toISOString().split("T")[0];
      document.querySelector('input[name="date_lost_found"]').setAttribute("max", today);
    }

    window.addEventListener('DOMContentLoaded', function(){
      toggleVerification();
      setMaxDate();
      document.querySelector('select[name="report_type"]').addEventListener('change', toggleVerification);
    });
  </script>
</head>

<body>

  
  <div class="navbar">
    <h1>Lost & Found</h1>
    <div>
      <a href="{{ route('user.dashboard') }}">Dashboard</a>
      <a href="{{ route('reports.my') }}">My Reports</a>
      <form method="POST" action="{{ route('logout') }}" style="display:inline;">
        @csrf
        <button style="background:none;border:none;color:white;cursor:pointer;margin-left:20px;">
          Logout
        </button>
      </form>
    </div>
  </div>

  <div class="container">
    <div class="card">
      <h2>Edit Report</h2>

      @if(session('success'))
        <p class="message">{{ session('success') }}</p>
      @endif

      @if($errors->any())
        <p class="error">{{ $errors->first() }}</p>
      @endif

      <form method="POST" action="{{ route('reports.update', $report->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
          <label>Type</label>
          <select name="report_type" required>
            <option value="lost" {{ $report->report_type=='lost'?'selected':'' }}>Lost</option>
            <option value="found" {{ $report->report_type=='found'?'selected':'' }}>Found</option>
          </select>
        </div>

        <div class="form-group">
          <label>Item Name</label>
          <input type="text" name="item_name" value="{{ $report->item_name }}" required>
        </div>

        <div class="form-group">
          <label>Description</label>
          <textarea name="description" required>{{ $report->description }}</textarea>
        </div>

        <div class="form-group">
          <label>Location</label>
          <input type="text" name="location" value="{{ $report->location }}" required>
        </div>

        <div class="form-group">
          <label>Date Lost/Found</label>
          <input type="date" name="date_lost_found"
                 value="{{ $report->date_lost_found->format('Y-m-d') }}" required>
        </div>

        <div class="form-group">
          <label>Contact Information</label>
          <input type="text" name="contact_info" value="{{ $report->contact_info }}" required>
        </div>

        <div class="form-group" id="verification-container" style="display:none">
          <label>Verification Question (for FOUND items) — optional</label>
          <input type="text" name="verification_question"
                 value="{{ $report->verification_question }}">
        </div>

        <div class="form-group">
          <label>Current Photo</label><br>
          @if($report->photo)
            <img src="{{ asset('storage/'.$report->photo) }}"
                 width="200"
                 style="border-radius:10px; margin-bottom:10px;">
          @else
            <em>No photo uploaded</em>
          @endif
        </div>

        <div class="form-group">
          <label>Replace Photo (optional)</label>
          <input type="file" name="photo" accept="image/*" onchange="previewPhoto(event)">
          <div id="preview-container">
            <img id="preview" style="display:none;">
          </div>
        </div>

        <button type="submit" class="btn-submit">Update Report</button>
      </form>

    </div>
  </div>

</body>
</html>
