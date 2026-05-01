
@extends('layouts.app')
<style>
    input ,select ,button{
        border-radius: 10px;
    }
    input:hover{
        transform: scale(1.05);
    }
    button:hover{
        background: #eab308;
        transform: scale(1.05);
    }
</style>
@section('content')
<div class="form-container">
    <h2>Add Employee</h2>

    <form method="POST" action="{{ route('hr.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-grid">
            <input name="firstName" placeholder="First Name" id="input1" class="form-control mb-3" required>
            <input name="lastName" placeholder="Last Name" class="form-control mb-3" required>
            <input name="father" placeholder="Father Name" class="form-control mb-3" required>
            <input name="mother" placeholder="mother Name" class="form-control mb-3">
            <input type="date" name="birthday" placeholder="birthday dd/mm/yy" class="form-control mb-3">
            <input name="gender" placeholder="gender" class="form-control mb-3">
            <input name="national_number" placeholder="National Number" class="form-control mb-3 required">
            <input name="phone" placeholder="Phone" class="form-control mb-3">
            <input name="email" placeholder="Email" class="form-control mb-3">
            <input name="address" placeholder="address" class="form-control mb-3">
            <input name="salary" placeholder="Salary" class="form-control mb-3">

            <select name="department_id" class="form-control mb-3">
                <option value="">Select Department</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->department_id }}">
                        {{ $dept->department_name }}
                    </option>
                @endforeach
            </select>

            <select name="role_id" class="form-control mb-3">
                <option value="">Select Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->role_id }}">
                        {{ $role->type }}
                    </option>
                @endforeach
            </select>
            <input type="file" name="image">
        </div>

        <button type="submit">Save Employee</button>
    </form>
</div>

@endsection