import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

document.addEventListener('DOMContentLoaded', function () {
    const studentsList = document.getElementById('students-list');

    if (studentsList) {
        function fetchStudents() {
            $.get('/studentss', function (data) {
                $('#students-list').html(data);
            });
        }

        setInterval(function () {
            fetchStudents();
        }, 1000);
    }

    const logoutForm = $('#logout-form');
    const logoutButton = $('#logout-button');
    const logoutModal = $('#logout-modal');
    const logoutConfirm = $('#logout-confirm');
    const logoutCloseButtons = $('.js-close-logout-modal');
    let logoutConfirmed = false;

    function openLogoutModal() {
        logoutModal.fadeIn(120);
        $('body').css('overflow', 'hidden');
    }

    function closeLogoutModal() {
        logoutModal.fadeOut(120);
        $('body').css('overflow', '');
        logoutConfirmed = false;
    }

    if (logoutForm.length) {
        logoutForm.on('submit', function (event) {
            if (!logoutConfirmed) {
                event.preventDefault();
                openLogoutModal();
            }
        });
    }

    logoutButton.on('click', function () {
        openLogoutModal();
    });

    logoutConfirm.on('click', function () {
        logoutConfirmed = true;
        logoutForm.trigger('submit');
    });

    logoutCloseButtons.on('click', function () {
        closeLogoutModal();
    });

    initUserAccountAjaxCrud();
    initStudentAjaxCrud();
});

Alpine.start();
function initUserAccountAjaxCrud() {
    const root = document.getElementById('user-account-ajax-root');
    const configElement = document.getElementById('user-account-ajax-config');

    if (!root || !configElement) {
        return;
    }

    let config = {};

    try {
        config = JSON.parse(configElement.textContent || '{}');
    } catch (_error) {
        return;
    }

    const roleOptions = config.roles || {};
    const initialStudents = config.students || [];
    const initialTeachers = config.teachers || [];
    const endpoints = config.endpoints || {};
    const roleDescriptions = {
        admin: 'Admin accounts have backend management access and do not require a linked profile.',
        student: 'Student accounts must be linked to one existing student record.',
        teacher: 'Teacher accounts must be linked to one existing teacher record.',
    };

    let deleteUserId = null;
    let currentListUrl = window.location.href;

    const $accountModal = $('#user-account-modal');
    const $deleteModal = $('#delete-account-modal');
    const $viewModal = $('#view-account-modal');
    const $dependencyModal = $('#dependency-modal');
    const $feedback = $('#ajax-feedback');
    const $tableBody = $('#user-account-table-body');
    const $pagination = $('#user-account-pagination');
    const $count = $('#user-account-count');
    const $countLabel = $('#user-account-count-label');
    const $role = $('#modal_role');
    const $studentId = $('#modal_student_id');
    const $teacherId = $('#modal_teacher_id');
    const $accountErrors = $('#account-form-errors');
    const $dependencyErrors = $('#dependency-form-errors');
    const $dependencyType = $('#dependency-form-type');
    const $dependencyDepartmentGroup = $('#dependency_department_group');
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    let accountActionUrl = endpoints.store;
    let dependencyActionUrl = endpoints.storeStudentDependency;

    function showFeedback(message, isError = false) {
        $feedback.text(message).css('color', isError ? '#dc2626' : '#16a34a').show();
    }

    function hideFeedback() {
        $feedback.hide().text('');
    }

    function setAccountCount(nextCount) {
        const normalized = Math.max(0, Number(nextCount));
        $count.text(normalized);
        $countLabel.text(`account${normalized === 1 ? '' : 's'} found`);
    }

    function escapeHtml(value) {
        return String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function normalizeOptions(items) {
        return items.map((item) => {
            const emailLabel = item.email ? ` (${item.email})` : '';

            return {
                id: item.id,
                label: `${item.lname}, ${item.fname}${emailLabel}`,
            };
        });
    }

    function setRoleOptions(selectedRole) {
        const options = ['<option value="">- Select role -</option>'];

        Object.entries(roleOptions).forEach(([value, label]) => {
            const selected = value === selectedRole ? 'selected' : '';
            options.push(`<option value="${value}" ${selected}>${label}</option>`);
        });

        $role.html(options.join(''));
    }

    function setDependencyOptions(selector, items, selectedId, placeholder) {
        const options = [`<option value="">${placeholder}</option>`];

        normalizeOptions(items).forEach((item) => {
            const selected = String(item.id) === String(selectedId) ? 'selected' : '';
            options.push(`<option value="${item.id}" ${selected}>${item.label}</option>`);
        });

        $(selector).html(options.join(''));
    }

    function appendDependencyOption(type, dependency) {
        const isStudent = type === 'student';
        const selector = isStudent ? '#modal_student_id' : '#modal_teacher_id';
        const placeholder = isStudent ? '- Select student -' : '- Select teacher -';
        const currentSelect = $(selector);
        const label = `${escapeHtml(dependency.lname)}, ${escapeHtml(dependency.fname)}${dependency.email ? ` (${escapeHtml(dependency.email)})` : ''}`;

        if (currentSelect.find('option[value=""]').length === 0) {
            setDependencyOptions(selector, [], '', placeholder);
        }

        currentSelect.append(new Option(label, dependency.id, true, true));
        currentSelect.val(String(dependency.id)).trigger('change');
    }

    function updateRoleUX() {
        const selectedRole = $role.val();
        const isStudent = selectedRole === 'student';
        const isTeacher = selectedRole === 'teacher';

        $('#role-help-text').text(roleDescriptions[selectedRole] || 'Select a role to see requirements.');
        $('#student-dependency-group').toggle(isStudent);
        $('#teacher-dependency-group').toggle(isTeacher);

        $studentId.prop('required', isStudent);
        $teacherId.prop('required', isTeacher);

        if (!isStudent) {
            $studentId.val('');
        }

        if (!isTeacher) {
            $teacherId.val('');
        }
    }

    function reloadList(url = currentListUrl) {
        $.ajax({
            url,
            type: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            },
            success: function (html) {
                const $page = $('<div>').html(html);
                const nextBodyHtml = $page.find('#user-account-table-body').html();
                const nextPaginationHtml = $page.find('#user-account-pagination').html();
                const nextCount = $page.find('#user-account-count').text();

                if (nextBodyHtml !== undefined) {
                    $tableBody.html(nextBodyHtml);
                }

                if (nextPaginationHtml !== undefined) {
                    $pagination.html(nextPaginationHtml);
                }

                if (nextCount) {
                    setAccountCount(nextCount);
                }

                currentListUrl = url;
            },
            error: function () {
                showFeedback('Unable to refresh the list right now.', true);
            },
        });
    }

    function resetAccountFields() {
        $accountModal.find('input[type="text"], input[type="email"], input[type="password"]').val('');
    }

    function resetDependencyFields() {
        $dependencyModal.find('input[type="text"], input[type="email"], textarea').val('');
    }

    function buildAccountPayload() {
        const selectedRole = $role.val();

        if (selectedRole !== 'student') {
            $studentId.prop('disabled', true);
        }

        if (selectedRole !== 'teacher') {
            $teacherId.prop('disabled', true);
        }

        let formData = $accountModal.find('input[name], select[name], textarea[name]').serialize();

        $studentId.prop('disabled', false);
        $teacherId.prop('disabled', false);

        if (formData.indexOf('is_active') === -1) {
            formData += `${formData ? '&' : ''}is_active=0`;
        }

        return formData;
    }

    function buildDependencyPayload() {
        return $dependencyModal.find('input[name], select[name], textarea[name]').serialize();
    }

    function resetFormForCreate() {
        $('#account-modal-title').text('Create User Account');
        $('#account-submit-button').text('Create Account');
        accountActionUrl = endpoints.store;
        $('#account-form-method').val('POST');
        $('#account-form-user-id').val('');
        resetAccountFields();
        $('#modal_is_active').prop('checked', true);
        $('#modal_password, #modal_password_confirmation').prop('required', true);
        $('#password-required-marker, #password-confirm-required-marker').show();
        $('#password-help-text').text('Required for new accounts.');
        setRoleOptions('');
        setDependencyOptions('#modal_student_id', initialStudents, '', '- Select student -');
        setDependencyOptions('#modal_teacher_id', initialTeachers, '', '- Select teacher -');
        updateRoleUX();
        $accountErrors.hide().html('');
    }

    function openCreateModal() {
        try {
            hideFeedback();
            resetFormForCreate();
            $accountModal.fadeIn(140);
            $('body').css('overflow', 'hidden');
        } catch (e) {
            console.error(e);
        }
    }

    function openEditModal(userId) {
        hideFeedback();
        $accountErrors.hide().html('');

        $.ajax({
            url: endpoints.show.replace(':id', userId),
            type: 'GET',
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            success: function (response) {
                const account = response.userAccount;
                const studentId = account.student ? account.student.id : '';
                const teacherId = account.teacher ? account.teacher.id : '';

                $('#account-modal-title').text(`Edit User Account #${account.id}`);
                $('#account-submit-button').text('Save Changes');
                accountActionUrl = endpoints.update.replace(':id', account.id);
                $('#account-form-method').val('PUT');
                $('#account-form-user-id').val(account.id);
                $('#modal_username').val(account.username);
                $('#modal_email').val(account.email);
                $('#modal_is_active').prop('checked', Number(account.is_active) === 1);
                $('#modal_password, #modal_password_confirmation').val('').prop('required', false);
                $('#password-required-marker, #password-confirm-required-marker').hide();
                $('#password-help-text').text('Leave blank to keep current password.');

                setRoleOptions(account.role);
                setDependencyOptions('#modal_student_id', response.students || [], studentId, '- Select student -');
                setDependencyOptions('#modal_teacher_id', response.teachers || [], teacherId, '- Select teacher -');
                updateRoleUX();
                $accountModal.fadeIn(140);
                $('body').css('overflow', 'hidden');
            },
            error: function () {
                showFeedback('Unable to load this account right now.', true);
            },
        });
    }

    function closeAccountModal() {
        $accountModal.fadeOut(120);
        $('body').css('overflow', '');
    }

    function openDeleteModal(userId, username, hasDependency = false, depType = '', depName = '') {
        deleteUserId = userId;
        $('#delete-account-name').text(username || `ID ${userId}`);

        if (hasDependency === 'true' || hasDependency === true) {
            $('#dependency-type-display').text(depType);
            $('#dependency-name-display').text(depName);
            $('#delete-dependency-warning').show();
        } else {
            $('#delete-dependency-warning').hide();
        }

        $deleteModal.fadeIn(120);
        $('body').css('overflow', 'hidden');
    }

    function closeDeleteModal() {
        deleteUserId = null;
        $deleteModal.fadeOut(120);
        if (!$accountModal.is(':visible')) {
            $('body').css('overflow', '');
        }
    }

    function openViewModal(userId) {
        const $content = $('#view-account-content');
        $content.html('<p class="ff-hint">Loading account details...</p>');
        $viewModal.fadeIn(120);
        $('body').css('overflow', 'hidden');

        $.ajax({
            url: endpoints.show.replace(':id', userId),
            type: 'GET',
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            success: function (response) {
                const account = response.userAccount;
                const linked = account.student
                    ? `Student - ${escapeHtml(account.student.lname)}, ${escapeHtml(account.student.fname)}`
                    : account.teacher
                        ? `Teacher - ${escapeHtml(account.teacher.lname)}, ${escapeHtml(account.teacher.fname)}`
                        : '-';

                $content.html(`
                    <div class="detail-row"><span class="detail-key">Username</span><span class="detail-val">${escapeHtml(account.username)}</span></div>
                    <div class="detail-row"><span class="detail-key">Email</span><span class="detail-val">${escapeHtml(account.email)}</span></div>
                    <div class="detail-row"><span class="detail-key">Role</span><span class="detail-val">${escapeHtml(account.role)}</span></div>
                    <div class="detail-row"><span class="detail-key">Status</span><span class="detail-val">${Number(account.is_active) === 1 ? 'Active' : 'Inactive'}</span></div>
                    <div class="detail-row"><span class="detail-key">Linked Profile</span><span class="detail-val">${linked}</span></div>
                `);
            },
            error: function () {
                $content.html('<p class="ff-hint" style="color:#ef4444;">Unable to load account details right now.</p>');
            },
        });
    }

    function closeViewModal() {
        $viewModal.fadeOut(120);
        $('body').css('overflow', '');
    }

    function openDependencyModal(type) {
        $dependencyErrors.hide().html('');
        resetDependencyFields();
        $dependencyType.val(type);
        $('#dependency-modal-title').text(type === 'teacher' ? 'Create Teacher Dependency' : 'Create Student Dependency');
        $('#dependency-submit-button').text(type === 'teacher' ? 'Create Teacher' : 'Create Student');
        dependencyActionUrl = type === 'teacher' ? endpoints.storeTeacherDependency : endpoints.storeStudentDependency;
        $dependencyDepartmentGroup.toggle(type === 'teacher');
        $dependencyModal.fadeIn(120);
    }

    function closeDependencyModal() {
        $dependencyModal.fadeOut(120);
    }

    $('#open-create-account-modal').on('click', openCreateModal);
    $(document).on('click', '.js-open-view-modal', function () {
        openViewModal($(this).data('user-id'));
    });
    $(document).on('click', '.js-open-edit-modal', function () {
        openEditModal($(this).data('user-id'));
    });
    $(document).on('click', '.js-open-delete-modal', function () {
        openDeleteModal(
            $(this).data('user-id'),
            $(this).data('username'),
            $(this).data('has-dependency'),
            $(this).data('dependency-type'),
            $(this).data('dependency-name')
        );
    });

    $('.js-close-account-modal, #user-account-modal .ajax-modal-overlay').on('click', closeAccountModal);
    $('.js-close-delete-modal, #delete-account-modal .ajax-modal-overlay').on('click', closeDeleteModal);
    $('.js-close-view-modal, #view-account-modal .ajax-modal-overlay').on('click', closeViewModal);
    $('.js-close-dependency-modal, #dependency-modal .ajax-modal-overlay').on('click', closeDependencyModal);
    $(document).on('click', '.js-open-dependency-modal', function () {
        openDependencyModal($(this).data('dependency-type'));
    });

    $role.on('change', updateRoleUX);

    $('#account-submit-button').on('click', function (event) {
        event.preventDefault();
        $accountErrors.hide().html('');

        const formData = buildAccountPayload();

        const $submitButton = $('#account-submit-button');
        const originalText = $submitButton.text();
        $submitButton.prop('disabled', true).text('Saving...');

        $.ajax({
            url: accountActionUrl,
            type: 'POST',
            data: formData,
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken,
            },
            success: function (response) {
                closeAccountModal();
                showFeedback(response.message || 'Saved successfully.');
                reloadList(currentListUrl);
            },
            error: function (xhr) {
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    const messages = [];
                    Object.values(xhr.responseJSON.errors).forEach((errorMessages) => {
                        messages.push(errorMessages[0]);
                    });
                    $accountErrors.html(messages.join('<br>')).show();
                    return;
                }

                const errorMessage = xhr.responseJSON && xhr.responseJSON.message
                    ? xhr.responseJSON.message
                    : 'Saving failed. Please try again.';
                $accountErrors.text(errorMessage).show();
            },
            complete: function () {
                $submitButton.prop('disabled', false).text(originalText);
            },
        });
    });

    $('#confirm-delete-account').on('click', function () {
        if (!deleteUserId) {
            return;
        }

        const $deleteBtn = $(this);
        $deleteBtn.prop('disabled', true).text('Deleting...');

        $.ajax({
            url: endpoints.destroy.replace(':id', deleteUserId),
            type: 'POST',
            data: {
                _method: 'DELETE',
                _token: csrfToken,
            },
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            success: function (response) {
                closeDeleteModal();
                showFeedback(response.message || 'User account deleted.');
                reloadList(currentListUrl);
            },
            error: function (xhr) {
                closeDeleteModal();
                const errorMessage = xhr.responseJSON && xhr.responseJSON.message
                    ? xhr.responseJSON.message
                    : 'Delete failed. Please try again.';
                showFeedback(errorMessage, true);
            },
            complete: function () {
                $deleteBtn.prop('disabled', false).text('Delete');
            },
        });
    });

    $('#dependency-submit-button').on('click', function (event) {
        event.preventDefault();
        $dependencyErrors.hide().html('');

        const $depSubmitButton = $('#dependency-submit-button');
        const originalDepText = $depSubmitButton.text();
        $depSubmitButton.prop('disabled', true).text('Saving...');

        $.ajax({
            url: dependencyActionUrl,
            type: 'POST',
            data: buildDependencyPayload(),
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken,
            },
            success: function (response) {
                const dependencyType = $dependencyType.val();
                closeDependencyModal();
                showFeedback(response.message || 'Dependency created successfully.');

                if (dependencyType === 'student' && response.student) {
                    appendDependencyOption('student', response.student);
                }

                if (dependencyType === 'teacher' && response.teacher) {
                    appendDependencyOption('teacher', response.teacher);
                }
            },
            error: function (xhr) {
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    const messages = [];
                    Object.values(xhr.responseJSON.errors).forEach((errorMessages) => {
                        messages.push(errorMessages[0]);
                    });
                    $dependencyErrors.html(messages.join('<br>')).show();
                    return;
                }

                const errorMessage = xhr.responseJSON && xhr.responseJSON.message
                    ? xhr.responseJSON.message
                    : 'Dependency creation failed. Please try again.';
                $dependencyErrors.text(errorMessage).show();
            },
            complete: function () {
                $depSubmitButton.prop('disabled', false).text(originalDepText);
            },
        });
    });

    $(document).on('click', '#user-account-pagination a', function (event) {
        event.preventDefault();
        const nextUrl = $(this).attr('href');

        if (!nextUrl) {
            return;
        }

        reloadList(nextUrl);
    });
}

function initStudentAjaxCrud() {
    const $deleteModal = $('#delete-student-modal');
    const $confirmBtn = $('#confirm-delete-student');
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    let deleteStudentId = null;

    if (!$deleteModal.length) {
        return;
    }

    $(document).on('click', '.js-open-student-delete-modal', function () {
        deleteStudentId = $(this).data('student-id');
        $('#delete-student-name-display').text($(this).data('student-name'));
        $deleteModal.fadeIn(120);
        $('body').css('overflow', 'hidden');
    });

    $('.js-close-student-delete-modal, #delete-student-modal .ajax-modal-overlay').on('click', function () {
        $deleteModal.fadeOut(120);
        $('body').css('overflow', '');
        deleteStudentId = null;
    });

    $confirmBtn.on('click', function () {
        if (!deleteStudentId) {
            return;
        }

        const originalText = $confirmBtn.text();
        $confirmBtn.prop('disabled', true).text('Deleting...');

        $.ajax({
            url: `/admin/students/${deleteStudentId}`,
            type: 'POST',
            data: {
                _method: 'DELETE',
                _token: csrfToken,
            },
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            success: function (response) {
                $deleteModal.fadeOut(120);
                $('body').css('overflow', '');

                // Show temporary success feedback if possible, or just reload
                if (window.showGlobalFeedback) {
                    window.showGlobalFeedback(response.message || 'Student deleted successfully.');
                } else {
                    alert(response.message || 'Student deleted successfully.');
                }

                window.location.reload(); // Simplest way for students list right now
            },
            error: function (xhr) {
                const errorMessage = xhr.responseJSON && xhr.responseJSON.message
                    ? xhr.responseJSON.message
                    : 'Failed to delete student.';
                alert(errorMessage);
                $confirmBtn.prop('disabled', false).text(originalText);
            }
        });
    });
}

