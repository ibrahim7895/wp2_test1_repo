@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <h2 class="mb-4">Change Employee Status</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>Name</th>
            <th>Current Status</th>
            <th>Change Status</th>
        </tr>

        @foreach($employees as $emp)
        <tr>
            <td>{{ $emp->firstName }} {{ $emp->lastName }}</td>

            <td>{{  $emp->status->status ?? '' }}</td>

            <td>
                @if(session('user')->account_status == 'hr_manager')
                <form method="POST" action="{{ route('hr.changeStatus', $emp->personal_id) }}">
                    @csrf

                    <select name="employee_status_id" class="form-control mb-1">

                        <option value="1" {{ $emp->employee_status_id == 1 ? 'selected' : '' }}>current employee</option>
                        <option value="2" {{ $emp->employee_status_id == 2 ? 'selected' : '' }}>dismissed</option>
                        <option value="3" {{ $emp->employee_status_id == 3 ? 'selected' : '' }}>Resigned</option>
                        <option value="4" {{ $emp->employee_status_id == 4 ? 'selected' : '' }}>Paid leave</option>

                    </select>

                    <button class="btn btn-warning btn-sm">Update</button>
                </form>
                @else
                    <span class="text-muted">No Permission</span>
                @endif
            </td>
        </tr>
        @endforeach

    </table>
</div>

@endsection