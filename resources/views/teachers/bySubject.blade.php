@extends('components.layouts.app')

@section('content')
    <h1>Teachers for {{ $subject }}</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Subject</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($teachers as $teacher)
                <tr>
                    <td><a href="{{ route('profile.show', $teacher->user) }}">{{ $teacher->user->name }}</a></td>
                    <td>{{ $teacher->subject }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection