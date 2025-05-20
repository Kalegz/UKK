@extends('components.layouts.app')

@section('content')
    <h1>Companies</h1>
    <div class="list-group">
        @foreach ($companies as $company)
            <a href="{{ route('companies.show', $company) }}" class="list-group-item list-group-item-action">{{ $company->name }}</a>
        @endforeach
    </div>
@endsection