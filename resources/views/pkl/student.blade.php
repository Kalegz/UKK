@extends('components.layouts.app')

@section('content')
    <h1>Manage PKL</h1>
    @if ($pklAssignment)
        <div class="card mb-3">
            <div class="card-body">
                <h5>Current PKL Assignment</h5>
                <p>Company: {{ $pklAssignment->company->name }}</p>
                <p>Teacher: {{ $pklAssignment->teacher?->user->name ?? 'N/A' }}</p>
                <p>Status: {{ $pklAssignment->teacher_approved ? 'Approved' : 'Pending' }}</p>
            </div>
        </div>
    @endif
    <h2>Assign PKL</h2>
    <form method="POST" action="{{ route('pkl.assign') }}">
        @csrf
        <div class="mb-3">
            <label for="company_id" class="form-label">Select Company</label>
            <select class="form-control @error('company_id') is-invalid @enderror" id="company_id" name="company_id" required>
                <option value="">Select a company</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}" {{ old('company_id', $pklAssignment?->company_id) == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                @endforeach
            </select>
            @error('company_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="teacher_id" class="form-label">Select Teacher</label>
            <select class="form-control @error('teacher_id') is-invalid @enderror" id="teacher_id" name="teacher_id" required>
                <option value="">Select a teacher</option>
                @foreach ($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ old('teacher_id', $pklAssignment?->teacher_id) == $teacher->id ? 'selected' : '' }}>{{ $teacher->user->name }} ({{ $teacher->subject }})</option>
                @endforeach
            </select>
            @error('teacher_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Assign PKL</button>
    </form>
    <h2 class="mt-4">Add New Company</h2>
    <form method="POST" action="{{ route('pkl.company.request') }}">
        @csrf
        <div class="mb-3">
            <label for="company_name" class="form-label">Company Name</label>
            <input type="text" class="form-control @error('company_name') is-invalid @enderror" id="company_name" name="company_name" value="{{ old('company_name') }}" required>
            @error('company_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="company_address" class="form-label">Company Address</label>
            <textarea class="form-control @error('company_address') is-invalid @enderror" id="company_address" name="company_address">{{ old('company_address') }}</textarea>
            @error('company_address')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Submit Company Request</button>
    </form>
@endsection