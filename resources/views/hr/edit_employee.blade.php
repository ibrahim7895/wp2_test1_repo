<style>
    .search-box {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}

.search-box input {
    padding: 8px;
    border-radius: 8px;
    border: none;
}

.search-box button {
    padding: 8px 15px;
    border: none;
    border-radius: 8px;
    background: #facc15;
    cursor: pointer;
}
</style>
@extends('layouts.app')

@section('content')

<h2>Edit Employee</h2>

<form method="POST" action="{{ route('hr.update', $employee->personal_id) }}">
    @csrf
    @method('PUT')

    <input name="firstName" value="{{ $employee->firstName }}" class="form-control mb-3">
    <input name="lastName" value="{{ $employee->lastName }}" class="form-control mb-3">
    <input name="father" value="{{ $employee->father }}" class="form-control mb-3">
    <input name="mother" value="{{ $employee->mother }}" class="form-control mb-3">
    <input name="birthday" value="{{ $employee->birthday }}" class="form-control mb-3">
    <input name="gender" value="{{ $employee->gender }}" class="form-control mb-3">
    <input name="phone" value="{{ $employee->phone }}" class="form-control mb-3">
    <input name="email" value="{{ $employee->email }}" class="form-control mb-3">
    <input name="salary" value="{{ $employee->salary }}" class="form-control mb-3">
    <select name="department_id" class="form-control mb-3">
        @foreach($departments as $dept)
            <option value="{{ $dept->department_id }}"
                {{ $employee->department_id == $dept->department_id ? 'selected' : '' }}>
                {{ $dept->department_name }}
            </option>
        @endforeach
    </select>
    <select name="role_id" class="form-control mb-3">
        <option value="">Select Role</option>

        @foreach($roles as $role)
            <option value="{{ $role->role_id }}"
                {{ $employee->role_id == $role->role_id ? 'selected' : '' }}>
                {{ $role->type }}
            </option>
        @endforeach
    </select>
    <img src="{{ asset('uploads/' . $employee->upload_file) }}" width="100">
    <button class="btn btn-success">Update</button>
</form>

@endsection