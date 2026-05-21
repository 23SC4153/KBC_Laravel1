@extends('Student.Student.MainLayout')

@section('title')
    <h1>Add Course</h1>
@endsection

@section('content')
    <div class="card text-start">
        <div class="card-ember"></div>

        <h2>Course Information Form</h2>
        <p class="mb-4">Complete the fields below to create a new course profile.</p>

        @if(session('success'))
            <div class="alert alert-success mb-4">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger mb-4" role="alert">
                <strong>Please review the following:</strong>
                <ul class="mb-0 mt-2 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('Degree.store') }}" method="POST" novalidate>
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="DegreeName" class="form-label">Course Name <span class="text-danger">*</span></label>
                    <input
                        id="DegreeName"
                        type="text"
                        name="DegreeName"
                        class="form-control @error('DegreeName') is-invalid @enderror"
                        value="{{ old('DegreeName') }}"
                        required
                    >
                    @error('DegreeName')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label for="DegreeCode" class="form-label">Course Code <span class="text-danger">*</span></label>
                    <input
                        id="DegreeCode"
                        type="text"
                        name="DegreeCode"
                        class="form-control @error('DegreeCode') is-invalid @enderror"
                        value="{{ old('DegreeCode') }}"
                        required
                    >
                    @error('DegreeCode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label for="Description" class="form-label">Description</label>
                    <textarea
                        id="Description"
                        name="Description"
                        class="form-control @error('Description') is-invalid @enderror"
                        rows="4"
                    >{{ old('Description') }}</textarea>
                    @error('Description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <hr>

            <div class="d-flex flex-wrap gap-2 justify-content-start">
                <button type="submit" class="btn btn-primary">Save Course</button>
                <a href="{{ route('Degree.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </form>
    </div>
@endsection
