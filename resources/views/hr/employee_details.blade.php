@extends('layouts.app')

@section('content')

<div class="container mt-4">
    <h2>Employee Details</h2>

    <div class="card p-4 shadow">

        <p><strong>First Name:</strong> {{ $employee->firstName }}</p>
        <p><strong>Last Name:</strong> {{ $employee->lastName }}</p>
        <p><strong>Father:</strong> {{ $employee->father }}</p>
        <p><strong>Mother:</strong> {{ $employee->mother }}</p>
        <p><strong>Birthday:</strong> {{ $employee->birthday }}</p>
        <p><strong>Gender:</strong> {{ $employee->gender }}</p>
        <p><strong>National Number:</strong> {{ $employee->national_number }}</p>
        <p><strong>Phone:</strong> {{ $employee->phone }}</p>
        <p><strong>Email:</strong> {{ $employee->email }}</p>
        <p><strong>Address:</strong> {{ $employee->address }}</p>
        <p><strong>Salary:</strong> {{ $employee->salary }}</p>
        <p><strong>Department ID:</strong> {{ $employee->department_id }}</p>
        <p><strong>Role ID:</strong> {{ $employee->role_id }}</p>

        @if($employee->upload_file)
            <p><strong>Image:</strong></p>
            <img src="{{ asset('storage/' . $employee->upload_file) }}" width="120">
        @endif

        <br>
        <a href="{{ route('hr.employees') }}" class="btn btn-secondary">Back</a>
    </div>
</div>

@endsection