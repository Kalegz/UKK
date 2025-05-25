@extends('components.layouts.app')

@section('content')
    <h1>Students</h1>
    <div class="list-group">
        @foreach ($classes as $item)
            <a href="{{ route('students.byClass', ['class' => $item['class'], 'major' => $item['major']]) }}" 
               class="list-group-item list-group-item-action">
                {{ $item['class'] }} - {{ $item['major'] }}
            </a>
        @endforeach
    </div>
@endsection