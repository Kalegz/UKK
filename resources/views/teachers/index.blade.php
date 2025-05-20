@extends('components.layouts.app')

@section('content')
    <h1>Teachers</h1>
    <div class="list-group">
        @foreach ($subjects as $subject)
            <a href="{{ route('teachers.bySubject', $subject) }}" class="list-group-item list-group-item-action">{{ $subject }}</a>
        @endforeach
    </div>
@endsection