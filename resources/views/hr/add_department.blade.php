@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <h2>Add Department</h2>

    <form method="POST" action="{{ route('departments.store') }}">
        @csrf

        <input type="text" name="department_name" class="form-control mb-3" placeholder="Department Name">

        <button class="btn btn-success">Save</button>
    </form>
</div>

@endsection