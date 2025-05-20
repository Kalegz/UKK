@extends('components.layouts.app')

@section('content')
    <h1>Profile</h1>
    <div class="card">
        <div class="card-body">
            <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('images/default-profile.png') }}" alt="Profile" class="rounded-circle" width="100" height="100">
            <h5 class="card-title">{{ $user->name }}</h5>
            <p class="card-text">Role: {{ ucfirst($user->role) }}</p>
            @if ($user->isStudent())
                <p>NIS: {{ $user->student->nis }}</p>
                <p>Class: {{ $user->student->class }}</p>
                <p>Major: {{ $user->student->major }}</p>
                @if ($user->student->pklAssignment)
                    <p>Company: {{ $user->student->pklAssignment->company->name }}</p>
                    <p>Teacher: {{ $user->student->pklAssignment->teacher?->user->name ?? 'N/A' }}</p>
                    <p>Status: {{ $user->student->pklAssignment->teacher_approved ? 'Approved' : 'Pending' }}</p>
                @endif
            @elseif ($user->isTeacher())
                <p>Subject: {{ $user->teacher->subject }}</p>
            @endif
            @if (auth()->user()->id === $user->id)
                <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profile</a>
            @endif
        </div>
    </div>
@endsection