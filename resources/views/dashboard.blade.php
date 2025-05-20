@extends('components.layouts.app')

@section('content')
    <h1>Welcome to Dashboard</h1>
    <div class="card">
        <div class="card-body">
            <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('images/default-profile.png') }}" alt="Profile" class="rounded-circle" width="100" height="100">
            <h5 class="card-title">{{ $user->name }}</h5>
            @if ($user->isStudent())
                <p>NIS: {{ $user->student->nis }}</p>
                <p>Class: {{ $user->student->class }}</p>
                <p>Major: {{ $user->student->major }}</p>
            @elseif ($user->isTeacher())
                <p>Subject: {{ $user->teacher->subject }}</p>
            @endif
            <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profile</a>
        </div>
    </div>
@endsection