@if(request()->ajax())
    <div class="card mt-0">
        <div class="card-body">
            <form action="{{ route('Student.enrollSubjects', $student->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="subjects" class="form-label">Select Subjects</label>
                    <select name="subjects[]" id="subjects" class="form-select" multiple size="8">
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ $student->subjects->contains('id', $subject->id) ? 'selected' : '' }}>
                                {{ $subject->SubjectCode }} - {{ $subject->SubjectName }}
                            </option>
                        @endforeach
                    </select>
                    <div class="mt-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="selectAll">Select All</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="clearAll">Clear All</button>
                    </div>
                    <div class="form-text">Hold Ctrl (Windows) or Cmd (Mac) to select multiple subjects.</div>
                </div>
                <button type="submit" class="btn btn-primary">Save Enrollment</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('selectAll')?.addEventListener('click', function() {
            const sel = document.getElementById('subjects');
            for (let i = 0; i < sel.options.length; i++) sel.options[i].selected = true;
        });
        document.getElementById('clearAll')?.addEventListener('click', function() {
            const sel = document.getElementById('subjects');
            for (let i = 0; i < sel.options.length; i++) sel.options[i].selected = false;
        });
    </script>
@else
    @extends('Student.Student.MainLayout')

    @section('title')
        <h1>Enroll Subjects for {{ $student->fname }} {{ $student->lname }}</h1>
    @endsection

    @section('content')
    <div class="card mt-4">
        <div class="card-header">
            <h4>Enroll in Subjects</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('Student.enrollSubjects', $student->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="subjects" class="form-label">Select Subjects</label>
                    <select name="subjects[]" id="subjects" class="form-select" multiple size="8">
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ $student->subjects->contains('id', $subject->id) ? 'selected' : '' }}>
                                {{ $subject->SubjectCode }} - {{ $subject->SubjectName }}
                            </option>
                        @endforeach
                    </select>
                    <div class="mt-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="selectAll">Select All</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="clearAll">Clear All</button>
                    </div>
                    <div class="form-text">Hold Ctrl (Windows) or Cmd (Mac) to select multiple subjects.</div>
                </div>
                <button type="submit" class="btn btn-primary">Save Enrollment</button>
                <a href="{{ route('Student.show', $student->id) }}" class="btn btn-secondary">Back to Student</a>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('selectAll')?.addEventListener('click', function() {
            const sel = document.getElementById('subjects');
            for (let i = 0; i < sel.options.length; i++) sel.options[i].selected = true;
        });
        document.getElementById('clearAll')?.addEventListener('click', function() {
            const sel = document.getElementById('subjects');
            for (let i = 0; i < sel.options.length; i++) sel.options[i].selected = false;
        });
    </script>
    @endsection
@endif
