@extends('layouts.master')
@section('content')
    <div class="container">
        <h1>Student Information System</h1>

        @if (session('success'))
            <p>{{ session('success') }}</p>
        @endif
    </div>

    <div class="container">
        <h2>{{ isset($editStudent) ? 'Edit Student' : 'Add Student' }}</h2>
        <form action="{{ isset($editStudent) ? route('student.update', $editStudent->id) : route('student.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @if (isset($editStudent))
                @method('PUT')
            @endif

            <input type="text" name="student_id" placeholder="Student ID" value="{{ old('student_id', $editStudent->student_id ?? '') }}" required>
            <input type="file" name="profile_image" accept="image/*" {{ isset($editStudent) ? '' : 'required' }}>
            @if (isset($editStudent) && $editStudent->profile_image)
                <img src="{{ asset('storage/' . $editStudent->profile_image) }}" alt="Current profile" width="80" height="80">
            @endif
            <input type="text" name="f_name" placeholder="First Name" value="{{ old('f_name', $editStudent->f_name ?? '') }}" required>
            <input type="text" name="l_name" placeholder="Last Name" value="{{ old('l_name', $editStudent->l_name ?? '') }}" required>
            <input type="email" name="email" placeholder="Email" value="{{ old('email', $editStudent->email ?? '') }}" required>
            <input type="text" name="phone" placeholder="Phone" value="{{ old('phone', $editStudent->phone ?? '') }}" required>
            <input type="text" name="address" placeholder="Address" value="{{ old('address', $editStudent->address ?? '') }}" required>
            <input type="text" name="course" placeholder="Course" value="{{ old('course', $editStudent->course ?? '') }}" required>
            <select name="year" required>
                <option value="">Select Year</option>
                @foreach (['1st Year', '2nd Year', '3rd Year', '4th Year'] as $yearOption)
                    <option value="{{ $yearOption }}" {{ old('year', $editStudent->year ?? '') === $yearOption ? 'selected' : '' }}>
                        {{ $yearOption }}
                    </option>
                @endforeach
            </select>

            @if ($errors->any())
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <button type="submit">{{ isset($editStudent) ? 'Update' : 'Submit' }}</button>
            @if (isset($editStudent))
                <a href="{{ route('student.index') }}">Cancel</a>
            @endif
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Profile Image</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Course</th>
                <th>Year</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($students as $student)
                <tr>
                    <td>{{ $student->student_id }}</td>
                    <td>
                        @if ($student->profile_image)
                            <img src="{{ asset('storage/' . $student->profile_image) }}" alt="{{ $student->f_name }} profile" width="50" height="50">
                        @else
                            No image
                        @endif
                    </td>
                    <td>{{ $student->f_name }}</td>
                    <td>{{ $student->l_name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->phone }}</td>
                    <td>{{ $student->address }}</td>
                    <td>{{ $student->course }}</td>
                    <td>{{ $student->year }}</td>
                    <td>
                        <a href="{{ route('student.edit', $student->id) }}">Edit</a>
                        <form action="{{ route('student.destroy', $student->id) }}" method="post" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete this student?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10">No students found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
