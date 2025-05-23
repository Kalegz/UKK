@extends('components.layouts.app')

@section('content')
    <h1>PKL Guidance</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Student</th>
                <th>Company</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pklAssignments as $assignment)
                <tr>
                    <td><a href="{{ route('profile.show', $assignment->student->user) }}">{{ $assignment->student->user->name }}</a></td>
                    <td>{{ $assignment->company->name }}</td>
                    <td>{{ $assignment->teacher_approved ? 'Approved' : 'Pending' }}</td>
                    <td>
                        @if (!$assignment->teacher_approved)
                            <form action="{{ route('pkl.approve', $assignment) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">Approve</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection