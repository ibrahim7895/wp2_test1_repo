@extends('layouts.app')

@section('content')

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="container mt-5">
    <h2>Departments</h2>

    <a href="{{ route('departments.create') }}" class="btn btn-success mb-3">Add Department</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>

        @foreach($departments as $dept)
        <tr>
            <td>{{ $dept->department_id }}</td>
            <td>{{ $dept->department_name }}</td>

            <td>
                <a href="{{ route('departments.edit', $dept->department_id) }}" class="btn btn-primary btn-sm">Edit</a>

                <form method="POST" action="{{ route('departments.delete', $dept->department_id) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach

    </table>
</div>

@endsection