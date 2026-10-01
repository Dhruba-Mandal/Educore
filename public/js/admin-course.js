
document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Elements
    |--------------------------------------------------------------------------
    */

    const courseForm = document.getElementById('courseForm');
    const departmentSelect = document.getElementById('department_id');
    const durationSelect = document.getElementById('duration_years');
    const subjectMessage = document.getElementById('subjectMessage');
    const subjectLoading = document.getElementById('subjectLoading');

    if (!courseForm || !departmentSelect || !durationSelect) {
        return;
    }

    const subjectUrlTemplate = courseForm.dataset.subjectsUrl;

    /*
    |--------------------------------------------------------------------------
    | Get Old Subjects
    |--------------------------------------------------------------------------
    | Restore selections after Laravel validation errors.
    */

    function getOldSubjects(semester) {
        const container = document.getElementById('subjects-' + semester);

        if (!container || !container.dataset.oldSubjects) {
            return [];
        }

        try {
            const parsed = JSON.parse(container.dataset.oldSubjects);
            return Array.isArray(parsed) ? parsed.map(String) : [];
        } catch (error) {
            console.error('Unable to read old subjects:', error);
            return [];
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Semester Count
    |--------------------------------------------------------------------------
    | 1 year = 2 semesters
    | 2 years = 4 semesters
    | 3 years = 6 semesters
    | 4 years = 8 semesters
    | 5 years = 10 semesters
    */

    function getTotalSemesters() {
        const duration = parseInt(durationSelect.value, 10) || 0;
        return Math.min(Math.max(duration * 2, 0), 10);
    }

    /*
    |--------------------------------------------------------------------------
    | Update Semester Visibility
    |--------------------------------------------------------------------------
    | Semester visibility depends only on the selected duration.
    | This works whether department or duration is selected first.
    */

    function updateSemesters() {
        const totalSemesters = getTotalSemesters();

        for (let semester = 1; semester <= 10; semester++) {
            const container = document.getElementById('subjects-' + semester);

            if (!container) {
                continue;
            }

            const semesterBox = container.closest('.semester-box');

            if (!semesterBox) {
                continue;
            }

            if (semester <= totalSemesters) {
                semesterBox.style.display = '';
            } else {
                semesterBox.style.display = 'none';

                // Clear selections from semesters outside the duration.
                container.querySelectorAll('input[type="checkbox"]').forEach(function (checkbox) {
                    checkbox.checked = false;
                    checkbox.disabled = false;
                });
            }

            updateSelectedCount(semester);
        }

        updateSubjectAvailability();
    }

    /*
    |--------------------------------------------------------------------------
    | Show Subject Message
    |--------------------------------------------------------------------------
    */

    function showSubjectMessage(message, iconClass) {
        if (!subjectMessage) {
            return;
        }

        subjectMessage.style.display = 'flex';
        subjectMessage.innerHTML = '';

        const icon = document.createElement('i');
        icon.className = iconClass || 'fas fa-info-circle';

        subjectMessage.appendChild(icon);
        subjectMessage.appendChild(document.createTextNode(' ' + message));
    }

    /*
    |--------------------------------------------------------------------------
    | Loading Indicator
    |--------------------------------------------------------------------------
    */

    function setLoading(isLoading) {
        if (subjectLoading) {
            subjectLoading.style.display = isLoading ? 'flex' : 'none';
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Clear All Subjects
    |--------------------------------------------------------------------------
    */

    function clearAllSubjects(message) {
        for (let semester = 1; semester <= 10; semester++) {
            const container = document.getElementById('subjects-' + semester);

            if (!container) {
                continue;
            }

            container.innerHTML = '';

            const empty = document.createElement('div');
            empty.className = 'no-subjects';

            const icon = document.createElement('i');
            icon.className = 'fas fa-book-open';

            const text = document.createElement('span');
            text.textContent = message || 'Select a department first';

            empty.appendChild(icon);
            empty.appendChild(text);
            container.appendChild(empty);

            updateSelectedCount(semester);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Escape HTML
    |--------------------------------------------------------------------------
    | Prevent subject names and codes from being inserted as raw HTML.
    */

    function escapeHtml(value) {
        const div = document.createElement('div');
        div.textContent = value == null ? '' : String(value);
        return div.innerHTML;
    }

    /*
    |--------------------------------------------------------------------------
    | Render Subjects
    |--------------------------------------------------------------------------
    | Your Subject model uses subject_id, subject_code and subject_name.
    */

    function renderSubjects(semester, subjects, selectedSubjects) {
        const container = document.getElementById('subjects-' + semester);

        if (!container) {
            return;
        }

        container.innerHTML = '';

        if (!Array.isArray(subjects) || subjects.length === 0) {
            const empty = document.createElement('div');
            empty.className = 'no-subjects';

            const icon = document.createElement('i');
            icon.className = 'fas fa-book-open';

            const text = document.createElement('span');
            text.textContent = 'No subjects available';

            empty.appendChild(icon);
            empty.appendChild(text);
            container.appendChild(empty);

            updateSelectedCount(semester);
            return;
        }

        const selectedIds = Array.isArray(selectedSubjects)
            ? selectedSubjects.map(String)
            : [];

        subjects.forEach(function (subject) {
            // Use the correct primary key from the Subject model.
            const subjectId = String(subject.subject_id);

            if (!subject.subject_id) {
                return;
            }

            const wrapper = document.createElement('label');
            wrapper.className = 'subject-checkbox';

            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.name = 'semester_' + semester + '[]';
            checkbox.value = subjectId;
            checkbox.dataset.subjectId = subjectId;
            checkbox.dataset.semester = String(semester);
            checkbox.checked = selectedIds.includes(subjectId);

            const checkmark = document.createElement('span');
            checkmark.className = 'subject-checkmark';

            const checkIcon = document.createElement('i');
            checkIcon.className = 'fas fa-check';
            checkmark.appendChild(checkIcon);

            const details = document.createElement('span');
            details.className = 'subject-details';

            const code = document.createElement('strong');
            code.textContent = subject.subject_code || ('Subject ' + subjectId);

            const name = document.createElement('span');
            name.textContent = subject.subject_name || '';

            details.appendChild(code);
            details.appendChild(name);

            wrapper.appendChild(checkbox);
            wrapper.appendChild(checkmark);
            wrapper.appendChild(details);

            container.appendChild(wrapper);

            checkbox.addEventListener('change', function () {
                updateSelectedCount(semester);
                updateSubjectAvailability();
            });
        });

        updateSelectedCount(semester);
        updateSubjectAvailability();
    }

    /*
    |--------------------------------------------------------------------------
    | Update Selected Count
    |--------------------------------------------------------------------------
    */

    function updateSelectedCount(semester) {
        const container = document.getElementById('subjects-' + semester);
        const count = document.getElementById('count-' + semester);

        if (!container || !count) {
            return;
        }

        const selected = container.querySelectorAll(
            'input[type="checkbox"]:checked'
        ).length;

        count.textContent = selected + ' selected';
    }

    /*
    |--------------------------------------------------------------------------
    | Prevent Duplicate Subjects
    |--------------------------------------------------------------------------
    | A subject can only be selected in one semester at a time.
    */

    function updateSubjectAvailability() {
        const checkboxes = document.querySelectorAll(
            '.subject-checkbox input[type="checkbox"]'
        );

        const selectedBySubject = new Map();

        checkboxes.forEach(function (checkbox) {
            if (checkbox.checked) {
                selectedBySubject.set(
                    String(checkbox.dataset.subjectId),
                    String(checkbox.dataset.semester)
                );
            }
        });

        checkboxes.forEach(function (checkbox) {
            const subjectId = String(checkbox.dataset.subjectId);
            const semester = String(checkbox.dataset.semester);
            const selectedSemester = selectedBySubject.get(subjectId);

            // Keep the selected checkbox enabled. Disable only duplicates
            // in other semesters.
            checkbox.disabled = Boolean(
                selectedSemester && selectedSemester !== semester
            );
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Load Subjects For Selected Department
    |--------------------------------------------------------------------------
    */

    let requestNumber = 0;

    function loadSubjects(departmentId, restoreOldSelections) {
        const currentRequest = ++requestNumber;

        clearAllSubjects('Loading subjects...');

        if (!departmentId) {
            setLoading(false);
            showSubjectMessage(
                'Please select a department first to load its subjects.'
            );
            clearAllSubjects('Select a department first');
            return;
        }

        if (!subjectUrlTemplate) {
            setLoading(false);
            showSubjectMessage(
                'The subject URL is missing from the course form.',
                'fas fa-exclamation-triangle'
            );
            return;
        }

        setLoading(true);

        if (subjectMessage) {
            subjectMessage.style.display = 'none';
        }

        const url = subjectUrlTemplate.replace(
            '__DEPARTMENT__',
            encodeURIComponent(departmentId)
        );

        fetch(url, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(function (response) {
                if (!response.ok) {
                    throw new Error('Unable to load subjects.');
                }

                return response.json();
            })
            .then(function (subjects) {
                // Ignore older requests if the department changed again.
                if (currentRequest !== requestNumber) {
                    return;
                }

                setLoading(false);

                if (!Array.isArray(subjects) || subjects.length === 0) {
                    clearAllSubjects('No subjects available for this department.');
                    showSubjectMessage(
                        'No active subjects found for this department.'
                    );
                    return;
                }

                if (subjectMessage) {
                    subjectMessage.style.display = 'none';
                }

                const totalSemesters = getTotalSemesters();

                for (let semester = 1; semester <= 10; semester++) {
                    const selectedSubjects = restoreOldSelections
                        ? getOldSubjects(semester)
                        : [];

                    renderSubjects(
                        semester,
                        subjects,
                        selectedSubjects
                    );
                }

                updateSemesters();
            })
            .catch(function (error) {
                if (currentRequest !== requestNumber) {
                    return;
                }

                console.error('Subject loading error:', error);

                setLoading(false);
                clearAllSubjects('Unable to load subjects.');

                showSubjectMessage(
                    'Unable to load subjects. Please try again.',
                    'fas fa-exclamation-triangle'
                );
            });
    }

    /*
    |--------------------------------------------------------------------------
    | Department Change
    |--------------------------------------------------------------------------
    | Load subjects when the department changes.
    */

    departmentSelect.addEventListener('change', function () {
        loadSubjects(this.value, false);
    });

    /*
    |--------------------------------------------------------------------------
    | Duration Change
    |--------------------------------------------------------------------------
    | Update semesters whenever the duration changes, regardless of
    | whether the department has already been selected.
    */

    durationSelect.addEventListener('change', function () {
        updateSemesters();
    });

    /*
    |--------------------------------------------------------------------------
    | Initial Page Load
    |--------------------------------------------------------------------------
    | Show the correct semester sections and restore old selections
    | if the form is being displayed again after validation errors.
    */

    updateSemesters();

    if (departmentSelect.value) {
        loadSubjects(departmentSelect.value, true);
    } else {
        clearAllSubjects('Select a department first');

        showSubjectMessage(
            'Please select a department first to load its subjects.'
        );
    }

});
