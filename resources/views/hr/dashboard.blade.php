@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <h2 class="mb-4 text-center">HR Dashboard</h2>

    <div class="row g-4">

        <!-- Add Employee -->
        <div class="col-md-4">

            <a href="{{ route('hr.create') }}" class="text-decoration-none">
                <div class="card text-center shadow p-4">
                    <h5>Add Employee</h5>
                </div>
            </a>
        </div>

        <!-- View Employees -->
        <div class="col-md-4">
            <a href="/hr/employees" class="text-decoration-none">
                <div class="card text-center shadow p-4">
                    <h5>Manage Employees</h5>
                </div>
            </a>
        </div>

        <!-- Manage Departments -->
        <div class="col-md-4">
            <a href="{{ route('departments.index') }}" class="text-decoration-none">
                <div class="card text-center shadow p-4">
                    <h5>Manage Departments</h5>
                </div>
            </a>
        </div>

        <!-- Employee Status -->
        <div class="col-md-4">
            <a  href="{{ route('hr.statusPage') }}" class="text-decoration-none">
                <div class="card text-center shadow p-4">
                    <h5>Change Employee Status</h5>
                </div>
            </a>
        </div>

    </div>
</div>

@endsection