@extends('components.layouts.app')

@section('content')
    <h1>Students</h1>
    <div class="list-group">
        @foreach ($classes as $class)
            <a href="{{ route('students.byClass', $class) }}" class="list-group-item list-group-item-action">{{ $class }}</a>
        @endforeach
    </div>
@endsection