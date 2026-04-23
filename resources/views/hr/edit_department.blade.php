@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <h2>Edit Department</h2>

    <form method="POST" action="{{ route('departments.update', $department->department_id) }}">
        @csrf

        <input type="text" name="department_name"
            value="{{ $department->department_name }}"
            class="form-control mb-3">

        <button class="btn btn-primary">Update</button>
    </form>
</div>

@endsection