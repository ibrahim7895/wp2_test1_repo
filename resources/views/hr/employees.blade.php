
@extends('layouts.app')

@section('title', 'Employees')

@section('content')
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
button:hover{
    background: #eab308;
    transform: scale(1.05);
}
</style>
<h2 class="mb-4">Employees</h2>
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <form method="GET" action="{{ route('hr.employees') }}" style="margin-bottom: 20px;">
        <input type="text" name="firstName" placeholder="First Name" value="{{ request('firstName') }}">
        <input type="text" name="father" placeholder="Father Name" value="{{ request('father') }}">
        <input type="text" name="lastName" placeholder="Last Name" value="{{ request('lastName') }}">
        <button type="submit">Search</button>
    </form>

<table class="table table-striped table-hover">
 
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Department</th>
            <th>Salary</th>
            <th>Actions</th>
        </tr>


    <form method="GET" action="{{ route('hr.employees') }}" style="margin-bottom:20px;">

    <select name="department_id">
        <option value="">All Departments</option>

        @foreach($departments as $dept)
            <option value="{{ $dept->department_id }}"
                {{ request('department_id') == $dept->department_id ? 'selected' : '' }}>
                {{ $dept->department_name }}
            </option>
        @endforeach
    </select>

    <button type="submit">Filter</button>
</form>

        @foreach($employees as $emp)
        <tr>
            <td>{{ $emp->personal_id }}</td>
            <td>{{ $emp->firstName }}</td>
            <td>{{ $emp->lastName }}</td>
            <td>{{ $emp->phone }}</td>
            <td>{{ $emp->email }}</td>
            <td>{{ $emp->department->department_name ?? 'No Department' }}</td>
            <td>{{ $emp->salary }}</td>
            <td>
                    <button
                        type="button"
                        class="btn btn-info btn-sm"
                        onclick="showDetails(
                            '{{ $emp->firstName }}',
                            '{{ $emp->lastName }}',
                            '{{ $emp->father }}',
                            '{{ $emp->mother }}',
                            '{{ $emp->phone }}',
                            '{{ $emp->email }}',
                            '{{ $emp->address }}',
                            '{{ $emp->salary }}',
                            '{{ $emp->department_name ?? 'No Department' }}'
                        )">
                        View Details
                    </button>
                    <a href="{{ route('hr.edit', $emp->personal_id) }}" class="btn btn-primary btn-sm">Edit</a>

                    <form method="POST" action="{{ route('hr.delete', $emp->personal_id) }}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm"
                            onclick="return confirm('Are you sure?')">
                            Delete
                        </button>
                    </form>
                </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div id="detailsModal" style="display:none; 
    position:fixed; 
    top:20%; 
    left:30%; 
    width:40%; 
    background:white; 
    border:1px solid #ccc; 
    padding:20px; 
    box-shadow:0 0 10px gray;
    z-index:999;">

    <h3>Employee Details</h3>

    <p><strong>First Name:</strong> <span id="d_firstName"></span></p>
    <p><strong>Last Name:</strong> <span id="d_lastName"></span></p>
    <p><strong>Father Name:</strong> <span id="d_father"></span></p>
    <p><strong>Mother Name:</strong> <span id="d_mother"></span></p>
    <p><strong>Phone:</strong> <span id="d_phone"></span></p>
    <p><strong>Email:</strong> <span id="d_email"></span></p>
    <p><strong>Address:</strong> <span id="d_address"></span></p>
    <p><strong>Salary:</strong> <span id="d_salary"></span></p>
    <p><strong>Department:</strong> <span id="d_department"></span></p>

    <button onclick="closeDetails()">Close</button>
</div>

<script>
function showDetails(firstName, lastName, father, mother, phone, email, address, salary, department) {
    document.getElementById('d_firstName').innerText = firstName;
    document.getElementById('d_lastName').innerText = lastName;
    document.getElementById('d_father').innerText = father;
    document.getElementById('d_mother').innerText = mother;
    document.getElementById('d_phone').innerText = phone;
    document.getElementById('d_email').innerText = email;
    document.getElementById('d_address').innerText = address;
    document.getElementById('d_salary').innerText = salary;
    document.getElementById('d_department').innerText = department;

    document.getElementById('detailsModal').style.display = 'block';
}

function closeDetails() {
    document.getElementById('detailsModal').style.display = 'none';
}
</script>
@endsection