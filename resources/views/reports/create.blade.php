@extends('layouts.app')

@section('title', 'Report Lost/Found Item')

@section('content')
<div class="navbar">
  <div class="nav-left">
    <a href="{{ route('user.dashboard') }}">← Back to Dashboard</a>
    <a href="{{ route('reports.my') }}">My Reports</a>
  </div>
</div>

<div class="container" style="max-width: 650px;">
  <div class="card">
    <h2 style="color: #1a3b7a; text-align: center; margin-bottom: 25px;">Report Lost / Found Item</h2>

    <form method="POST" action="{{ route('reports.store') }}" enctype="multipart/form-data">
      @csrf

      <div class="form-group">
        <label>Report Type</label>
        <select name="report_type" class="form-control" required>
          <option value="lost" {{ old('report_type') === 'lost' ? 'selected' : '' }}>Lost</option>
          <option value="found" {{ old('report_type') === 'found' ? 'selected' : '' }}>Found</option>
        </select>
      </div>

      <div class="form-group">
        <label>Item Name</label>
        <input type="text" name="item_name" class="form-control" value="{{ old('item_name') }}" placeholder="e.g., Black Leather Wallet" required>
      </div>

      <div class="form-group">
        <label>Description</label>
        <textarea name="description" class="form-control" rows="3" placeholder="Describe distinguishing details, brands, color, etc." required>{{ old('description') }}</textarea>
      </div>

      <div class="form-group">
        <label>Location</label>
        <input type="text" name="location" class="form-control" value="{{ old('location') }}" placeholder="Where was it lost or found?" required>
      </div>

      <div class="form-group">
        <label>Date Lost/Found</label>
        <input type="date" name="date_lost_found" class="form-control" value="{{ old('date_lost_found') }}" required>
      </div>

      <div class="form-group">
        <label>Contact Information</label>
        <input type="text" name="contact_info" class="form-control" value="{{ old('contact_info') }}" placeholder="Phone number, email, or social handle" required>
      </div>

      <div class="form-group" id="verification-container" style="display:none;">
        <label>Verification Question (Required for Found items)</label>
        <input type="text" name="verification_question" class="form-control" value="{{ old('verification_question') }}" placeholder="e.g., What keychain was attached?">
        <small style="color: #666;">Only the rightful owner should know the answer to this.</small>
      </div>

      <div class="form-group">
        <label>Upload Photo (Optional)</label>
        <input type="file" name="photo" class="form-control" accept="image/*" onchange="previewPhoto(event)">
        <div id="preview-container" style="text-align: center; margin-top: 10px;">
          <img id="preview" style="max-width: 200px; border-radius: 8px; display: none; margin: 10px auto;" alt="Photo Preview">
        </div>
      </div>

      <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px; font-size: 16px;">Submit Report</button>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
function toggleVerification() {
  const type = document.querySelector('select[name="report_type"]').value;
  const qContainer = document.getElementById('verification-container');
  qContainer.style.display = (type === 'found') ? 'block' : 'none';
}

function previewPhoto(event) {
  const preview = document.getElementById('preview');
  if (event.target.files && event.target.files[0]) {
    preview.src = URL.createObjectURL(event.target.files[0]);
    preview.style.display = "block";
  } else {
    preview.src = "";
    preview.style.display = "none";
  }
}

function setMaxDate() {
  const today = new Date().toISOString().split("T")[0];
  const dateInput = document.querySelector('input[name="date_lost_found"]');
  if (dateInput) {
    dateInput.setAttribute("max", today);
  }
}

window.addEventListener('DOMContentLoaded', function(){
  toggleVerification();
  setMaxDate();
  document.querySelector('select[name="report_type"]').addEventListener('change', toggleVerification);
});
</script>
@endpush
