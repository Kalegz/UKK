@extends('components.layouts.app')

@section('content')
    <h1>{{ $company->name }}</h1>
    <p>Address: {{ $company->address ?? 'N/A' }}</p>
    <h2>PKL Assignments</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Student</th>
                <th>Teacher</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($PKL_Assignment as $assignment)
                <tr>
                    <td><a href="{{ route('profile.show', $assignment->student->user) }}">{{ $assignment->student->user->name }}</a></td>
                    <td>
                        @if ($assignment->teacher)
                            <a href="{{ route('profile.show', $assignment->teacher->user) }}">{{ $assignment->teacher->user->name }}</a>
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $assignment->teacher_approved == 1 ? 'Approved' : 'Pending' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection