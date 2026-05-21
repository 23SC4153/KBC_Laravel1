@extends('Student.Student.MainLayout')

@section('title')
    <h1>Edit Course</h1>
@endsection

@section('content')
    <div class="card text-start">
        <div class="card-ember"></div>

        <h2>Edit Course Information</h2>
        <p class="mb-4">Update the fields below to save course changes.</p>

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

        <form action="{{ route('Degree.update', $degree->id) }}" method="POST" novalidate>
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="DegreeName" class="form-label">Course Name <span class="text-danger">*</span></label>
                    <input
                        id="DegreeName"
                        type="text"
                        name="DegreeName"
                        class="form-control @error('DegreeName') is-invalid @enderror"
                        value="{{ old('DegreeName', $degree->DegreeName) }}"
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
                        value="{{ old('DegreeCode', $degree->DegreeCode) }}"
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
                    >{{ old('Description', $degree->Description) }}</textarea>
                    @error('Description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <hr>

            <div class="d-flex flex-wrap gap-2 justify-content-start">
                <button type="submit" class="btn btn-primary">Update Course</button>
                <a href="{{ route('Degree.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
