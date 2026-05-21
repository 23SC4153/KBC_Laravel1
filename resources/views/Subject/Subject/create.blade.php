@extends('Student.Student.MainLayout')

@section('title')
    <h1>Add Subject</h1>
@endsection

@section('content')
    <div class="card text-start">
        <div class="card-ember"></div>

        <h2>Subject Information Form</h2>
        <p class="mb-4">Complete the fields below to create a new subject profile.</p>

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

        <form action="{{ route('Subject.store') }}" method="POST" novalidate>
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="degree_id" class="form-label">Degree Program <span class="text-danger">*</span></label>
                    <select id="degree_id" name="degree_id" class="form-control @error('degree_id') is-invalid @enderror" required>
                        <option value="">Select a degree program</option>
                        @foreach($degrees as $degree)
                            <option value="{{ $degree->id }}" {{ old('degree_id') == $degree->id ? 'selected' : '' }}>
                                {{ $degree->DegreeName }} ({{ $degree->DegreeCode }})
                            </option>
                        @endforeach
                    </select>
                    @error('degree_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label for="SubjectCode" class="form-label">Subject Code <span class="text-danger">*</span></label>
                    <input
                        id="SubjectCode"
                        type="text"
                        name="SubjectCode"
                        class="form-control @error('SubjectCode') is-invalid @enderror"
                        value="{{ old('SubjectCode') }}"
                        placeholder="e.g., CS101"
                        required
                    >
                    @error('SubjectCode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label for="SubjectName" class="form-label">Subject Name <span class="text-danger">*</span></label>
                    <input
                        id="SubjectName"
                        type="text"
                        name="SubjectName"
                        class="form-control @error('SubjectName') is-invalid @enderror"
                        value="{{ old('SubjectName') }}"
                        placeholder="e.g., Introduction to Programming"
                        required
                    >
                    @error('SubjectName')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label for="Description" class="form-label">Description</label>
                    <textarea
                        id="Description"
                        name="Description"
                        class="form-control @error('Description') is-invalid @enderror"
                        rows="4"
                        placeholder="Subject description..."
                    >{{ old('Description') }}</textarea>
                    @error('Description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="d-flex gap-3 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Create Subject
                </button>
                <a href="{{ route('Subject.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
