@extends('components.layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h2>Students in Class {{ $class }} - {{ $major }}</h2>
            <a href="{{ route('students.index') }}" class="btn btn-secondary mb-3">Back to Classes</a>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>NIS</th>
                        <th>Major</th>
                        <th>PKL Company</th>
                        <th>PKL Teacher</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                        <tr>
                            <td>{{ $student->user->name ?? 'N/A' }}</td>
                            <td>{{ $student->nis ?? 'N/A' }}</td>
                            <td>{{ $student->major ?? 'N/A' }}</td>
                            <td>{{ $student->pklAssignment->company->name ?? 'Not Assigned' }}</td>
                            <td>{{ $student->pklAssignment->teacher->user->name ?? 'Not Assigned' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No students found in this class.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection