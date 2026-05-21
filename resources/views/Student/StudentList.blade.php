@extends('Student.Student.MainLayout')
@section('title', 'Student List')

@section('content')
    <h4 class="page-title">Student List</h4>
    <p>Total Students: {{ count($students) }}</p>

    <table class="table table-bordered table-sm">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Student Name</th>
                <th>Age</th>
                <th>Course / Program</th>
                <th>Year Level</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $index => $student)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $student['name'] }}</td>
                    <td>{{ $student['age'] }}</td>
                    <td>{{ $student['course'] }}</td>
                    <td>
                        @if($student['age'] <= 18)
                            Freshman Student
                        @elseif($student['age'] == 19)
                            Freshman Student
                        @elseif($student['age'] == 20)
                            Sophomore Student
                        @elseif($student['age'] == 21)
                            Junior Student
                        @elseif($student['age'] == 22)
                            Senior Student
                        @else
                            Irregular Student
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No students available.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
