
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
                    <a href="{{ route('hr.show', $emp->personal_id) }}" class="btn btn-info btn-sm">View Details</a>
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

@endsection