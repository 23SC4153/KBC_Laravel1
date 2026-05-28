<script>
(function () {
    const state = window.studentEnrollmentState || {
        studentId: null,
        enrolledSubjects: [],
        availableSubjects: [],
    };

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    function escapeHtml(value) {
        return String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function showStatus(type, message) {
        const status = document.getElementById('enrollmentStatusAlert');
        const html = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${escapeHtml(message)}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;

        if (status) {
            status.innerHTML = html;
            return;
        }

        alert(message);
    }

    function updateCount() {
        const badge = document.getElementById('enrolledCountBadge');
        if (badge) {
            badge.textContent = `${(state.enrolledSubjects || []).length} enrolled`;
        }
    }

    function renderEnrolledSubjects() {
        const grid = document.getElementById('enrolledSubjectsGrid');
        if (!grid) {
            return;
        }

        const subjects = state.enrolledSubjects || [];

        if (!subjects.length) {
            grid.innerHTML = `
                <div class="col-12">
                    <div class="alert alert-info mb-3">This student is not enrolled in any subjects yet.</div>
                </div>
            `;
            updateCount();
            return;
        }

        grid.innerHTML = subjects.map((subject) => `
            <div class="col-md-6 col-lg-4">
                <div class="border rounded-3 p-3 h-100" style="background: rgba(13,110,253,0.03); border-color: rgba(13,110,253,0.14) !important;">
                    <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                        <div>
                            <div class="fw-semibold">${escapeHtml(subject.code)}</div>
                            <div class="small text-muted">${escapeHtml(subject.name)}</div>
                        </div>
                        <form action="${escapeHtml(subject.remove_url)}" method="POST" class="js-unenroll-subject-form">
                            <input type="hidden" name="_token" value="${escapeHtml(csrfToken)}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-sm btn-outline-danger">Remove</button>
                        </form>
                    </div>
                    <div class="small text-muted">${escapeHtml(subject.description || 'No description provided.')}</div>
                </div>
            </div>
        `).join('');

        updateCount();
    }

    function renderAvailableSubjects() {
        const select = document.getElementById('singleEnrollSubjectSelect');
        if (!select) {
            return;
        }

        const subjects = state.availableSubjects || [];
        const options = ['<option value="">Choose a subject</option>'];

        subjects.forEach((subject) => {
            options.push(`<option value="${escapeHtml(subject.id)}">${escapeHtml(subject.code)} - ${escapeHtml(subject.name)}</option>`);
        });

        select.innerHTML = options.join('');
        select.value = '';
    }

    function applyEnrollmentState(payload) {
        state.enrolledSubjects = payload.enrolled_subjects || [];
        state.availableSubjects = payload.available_subjects || [];
        renderEnrolledSubjects();
        renderAvailableSubjects();
        showStatus('success', payload.message || 'Enrollment updated successfully.');
    }

    async function postForm(form, methodOverride) {
        const formData = new FormData(form);

        if (methodOverride && methodOverride !== 'POST') {
            formData.set('_method', methodOverride);
        }

        const response = await fetch(form.getAttribute('action'), {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: formData,
        });

        const data = await response.json().catch(() => ({}));

        if (!response.ok) {
            const messages = data.errors ? Object.values(data.errors).flat() : [];
            throw new Error(messages[0] || data.message || 'Unable to complete the request.');
        }

        return data;
    }

    $(document)
        .off('submit.studentEnrollmentAjax', '#singleEnrollForm')
        .on('submit.studentEnrollmentAjax', '#singleEnrollForm', async function (event) {
            event.preventDefault();

            const form = this;
            const selectedSubject = form.querySelector('#singleEnrollSubjectSelect');

            if (!selectedSubject || !selectedSubject.value) {
                showStatus('danger', 'Choose a subject first.');
                return;
            }

            try {
                const data = await postForm(form, 'POST');
                applyEnrollmentState(data);
            } catch (error) {
                showStatus('danger', error.message || 'Unable to enroll subject.');
            }
        });

    $(document)
        .off('submit.studentEnrollmentAjax', '.js-unenroll-subject-form')
        .on('submit.studentEnrollmentAjax', '.js-unenroll-subject-form', async function (event) {
            event.preventDefault();

            if (!confirm('Remove this subject from the student?')) {
                return;
            }

            try {
                const data = await postForm(this, 'DELETE');
                applyEnrollmentState(data);
            } catch (error) {
                showStatus('danger', error.message || 'Unable to remove subject.');
            }
        });

    renderEnrolledSubjects();
    renderAvailableSubjects();
})();
</script>