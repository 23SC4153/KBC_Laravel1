@extends('Student.Student.MainLayout')

@section('title')
    <h1>Edit Subject</h1>
@endsection

@section('subtitle')
    Adjust the subject details without changing the overall layout.
@endsection

@section('content')
    <div class="card text-start" style="max-width: 760px; margin: 2rem auto;">
        <div class="card-ember"></div>

        <div class="d-flex flex-column gap-2 mb-4">
            <h2>Update Subject Record</h2>
            <p class="mb-0">Keep the subject information accurate while preserving the program assignment.</p>
        </div>

        <form action="{{ route('Subject.update', $subject->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="subject-info mb-4">
                <p><strong>Subject ID:</strong> {{ $subject->id }}</p>
                <p><strong>Created:</strong> {{ $subject->created_at->format('M d, Y H:i') }}</p>
                <p><strong>Last Updated:</strong> {{ $subject->updated_at->format('M d, Y H:i') }}</p>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="SubjectCode" class="form-label">Subject Code <span class="text-danger">*</span></label>
                    <input
                        id="SubjectCode"
                        type="text"
                        name="SubjectCode"
                        class="form-control @error('SubjectCode') is-invalid @enderror"
                        placeholder="e.g., CS101"
                        value="{{ old('SubjectCode', $subject->SubjectCode) }}"
                        required
                    >
                    @error('SubjectCode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label for="SubjectName" class="form-label">Subject Name <span class="text-danger">*</span></label>
                    <input
                        id="SubjectName"
                        type="text"
                        name="SubjectName"
                        class="form-control @error('SubjectName') is-invalid @enderror"
                        placeholder="e.g., Introduction to Computer Science"
                        value="{{ old('SubjectName', $subject->SubjectName) }}"
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
                    >{{ old('Description', $subject->Description) }}</textarea>
                    @error('Description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="d-flex flex-wrap gap-3 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Update Subject
                </button>
                <a href="{{ route('Subject.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times me-2"></i>Cancel
                </a>
                <form action="{{ route('Subject.destroy', $subject->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this subject? This action cannot be undone.')">
                        Delete Subject
                    </button>
                </form>
            </div>
        </form>
    </div>
@endsection
