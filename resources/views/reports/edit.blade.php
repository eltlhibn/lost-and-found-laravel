@extends('layouts.app')

@section('title', 'Edit Report - Lost & Found')

@section('content')
<div class="navbar">
  <div class="nav-left">
    <a href="{{ route('reports.my') }}">← Back to My Reports</a>
    <a href="{{ route('user.dashboard') }}">Dashboard</a>
  </div>
</div>

<div class="container" style="max-width: 650px;">
  <div class="card">
    <h2 style="color: #1a3b7a; text-align: center; margin-bottom: 25px;">Edit Report</h2>

    <form method="POST" action="{{ route('reports.update', $report->id) }}" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="form-group">
        <label>Report Type</label>
        <select name="report_type" class="form-control" required>
          <option value="lost" {{ old('report_type', $report->report_type) === 'lost' ? 'selected' : '' }}>Lost</option>
          <option value="found" {{ old('report_type', $report->report_type) === 'found' ? 'selected' : '' }}>Found</option>
        </select>
      </div>

      <div class="form-group">
        <label>Item Name</label>
        <input type="text" name="item_name" class="form-control" value="{{ old('item_name', $report->item_name) }}" required>
      </div>

      <div class="form-group">
        <label>Description</label>
        <textarea name="description" class="form-control" rows="3" required>{{ old('description', $report->description) }}</textarea>
      </div>

      <div class="form-group">
        <label>Location</label>
        <input type="text" name="location" class="form-control" value="{{ old('location', $report->location) }}" required>
      </div>

      <div class="form-group">
        <label>Date Lost/Found</label>
        <input type="date" name="date_lost_found" class="form-control" value="{{ old('date_lost_found', $report->date_lost_found ? $report->date_lost_found->format('Y-m-d') : '') }}" required>
      </div>

      <div class="form-group">
        <label>Contact Information</label>
        <input type="text" name="contact_info" class="form-control" value="{{ old('contact_info', $report->contact_info) }}" required>
      </div>

      <div class="form-group" id="verification-container" style="display:none;">
        <label>Verification Question (for Found items)</label>
        <input type="text" name="verification_question" class="form-control" value="{{ old('verification_question', $report->verification_question) }}">
      </div>

      <div class="form-group">
        <label>Current Photo</label>
        <div>
          @if($report->photo)
            <img src="{{ asset('storage/' . $report->photo) }}" style="max-width: 200px; border-radius: 8px; margin: 10px 0;" alt="Current photo">
          @else
            <p style="color:#777; font-style:italic;">No photo uploaded.</p>
          @endif
        </div>
      </div>

      <div class="form-group">
        <label>Replace Photo (Optional)</label>
        <input type="file" name="photo" class="form-control" accept="image/*" onchange="previewPhoto(event)">
        <div id="preview-container" style="text-align: center; margin-top: 10px;">
          <img id="preview" style="max-width: 200px; border-radius: 8px; display: none; margin: 10px auto;" alt="New photo preview">
        </div>
      </div>

      <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px; font-size: 16px;">Update Report</button>
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
