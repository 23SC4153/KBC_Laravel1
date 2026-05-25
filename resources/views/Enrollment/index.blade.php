@extends('Student.Student.MainLayout')

@section('title')
    <h1>Bulk Enrollment</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Enroll a Student in Subjects</h4>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Select Student</label>
                <select id="studentSelect" class="form-select">
                    <option value="">-- Select Student --</option>
                    @foreach($students as $s)
                        <option value="{{ $s->id }}">{{ $s->lname }}, {{ $s->fname }} (ID: {{ $s->id }})</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Subjects</label>
            <div class="d-flex gap-2 mb-2">
                <button id="selectAllBtn" class="btn btn-sm btn-outline-secondary">Select All</button>
                <button id="clearAllBtn" class="btn btn-sm btn-outline-secondary">Clear All</button>
                <button id="saveEnrollmentBtn" class="btn btn-sm btn-primary">Save Enrollment</button>
            </div>
            <div class="row" id="subjectsGrid">
                @foreach($subjects as $subject)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-check">
                            <input class="form-check-input subject-checkbox" type="checkbox" value="{{ $subject->id }}" id="sub-{{ $subject->id }}">
                            <label class="form-check-label" for="sub-{{ $subject->id }}">{{ $subject->SubjectCode }} - {{ $subject->SubjectName }}</label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    const studentSubjects = @json($mapping);

    function setCheckedForStudent(studentId) {
        const ids = studentSubjects[studentId] || [];
        document.querySelectorAll('.subject-checkbox').forEach(cb => {
            cb.checked = ids.includes(parseInt(cb.value));
        });
    }

    document.getElementById('studentSelect').addEventListener('change', function() {
        const sid = this.value;
        if (!sid) {
            document.querySelectorAll('.subject-checkbox').forEach(cb => cb.checked = false);
            return;
        }
        setCheckedForStudent(sid);
    });

    document.getElementById('selectAllBtn').addEventListener('click', function() {
        document.querySelectorAll('.subject-checkbox').forEach(cb => cb.checked = true);
    });
    document.getElementById('clearAllBtn').addEventListener('click', function() {
        document.querySelectorAll('.subject-checkbox').forEach(cb => cb.checked = false);
    });

    document.getElementById('saveEnrollmentBtn').addEventListener('click', function() {
        const sid = document.getElementById('studentSelect').value;
        if (!sid) { alert('Select a student first.'); return; }
        const selected = Array.from(document.querySelectorAll('.subject-checkbox:checked')).map(cb => cb.value);

        fetch('{{ route('Enrollment.enroll') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({ student_id: sid, subjects: selected })
        }).then(r => r.json()).then(data => {
            alert(data.message || 'Enrollment updated');
            // update local mapping
            studentSubjects[sid] = selected.map(x => parseInt(x));
        }).catch(e => {
            alert('Unable to save enrollment.');
            console.error(e);
        });
    });
</script>

@endsection
