@extends('layouts.app')

@php($teacher = session('teacher'))
@php($profilePicturePath = $teacher?->userAccount?->profile_picture_path)

@section('title', 'Teacher Dashboard - System >_')

@section('breadcrumb')
    <span class="main-breadcrumb-current">Dashboard</span>
@endsection

@section('page-title', 'Teacher Dashboard')
@section('page-subtitle', 'Overview of your courses and student progress.')

@section('content')
    <!-- Profile Picture Section -->
    <div class="detail-card" style="margin-bottom: 2rem;">
        <div style="text-align: center;">
            <div style="position: relative; display: inline-block;">
                <input type="file" id="teacherProfilePictureInput" accept="image/*" style="display: none;">

                <div id="teacherProfilePictureContainer"
                     style="cursor: pointer; position: relative; display: inline-block; transition: transform 0.2s ease, opacity 0.2s ease;"
                     onmouseover="this.style.opacity='0.8'"
                     onmouseout="this.style.opacity='1'"
                     onclick="document.getElementById('teacherProfilePictureInput').click()">
                    @if(!empty($profilePicturePath))
                        <img id="teacherProfileImage"
                             src="{{ asset('storage/' . $profilePicturePath) }}"
                             alt="Profile Picture"
                             class="student-avatar"
                             style="object-fit: cover; transition: opacity 0.2s ease;">
                    @else
                        <div id="teacherProfileInitials" class="student-avatar" style="transition: opacity 0.2s ease;">
                            {{ strtoupper(substr($teacher->fname ?? 'T', 0, 1) . substr($teacher->lname ?? 'C', 0, 1)) }}
                        </div>
                    @endif

                    <div style="position: absolute; bottom: 0; right: 0; background: rgba(34, 197, 94, 0.9); border-radius: 50%; padding: 8px; display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; cursor: pointer;">
                        <svg fill="white" viewBox="0 0 24 24" width="20" height="20">
                            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path>
                        </svg>
                    </div>
                </div>

                <div id="teacherUploadStatus" style="margin-top: 1rem; display: none;">
                    <div style="color: #86efac; font-size: 0.9rem;">Uploading...</div>
                </div>
            </div>

            <h4 style="margin: 1rem 0 0.5rem; color: var(--clr-text); font-family: 'Fira Code', monospace;">
                {{ $teacher->fname ?? 'Teacher' }} {{ $teacher->lname ?? '' }}
            </h4>
            <p style="margin: 0; color: var(--clr-text-muted); font-size: 0.86rem;">Click profile picture to upload</p>
        </div>
    </div>

    <!-- Stats Overview Grid -->
    <div class="stats-grid">
        <div class="info-card success">
            <p class="info-card-title">Courses Teaching</p>
            <p class="info-card-value">{{ $courseCount ?? 0 }}</p>
            <p class="info-card-description">Active course assignments.</p>
        </div>

        <div class="info-card info">
            <p class="info-card-title">Total Students</p>
            <p class="info-card-value">{{ $studentCount ?? 0 }}</p>
            <p class="info-card-description">Across all courses.</p>
        </div>

        <div class="info-card warning">
            <p class="info-card-title">Avg Class Size</p>
            <p class="info-card-value">{{ $avgClassSize ?? 0 }}</p>
            <p class="info-card-description">Students per course.</p>
        </div>
    </div>

    <!-- Teacher Information Card -->
    <div class="detail-card">
        <h3 class="detail-card-title">Professional Information</h3>
        <div class="detail-card-content">
            <div class="info-row">
                <span class="info-key">First Name</span>
                <span class="info-val">{{ $teacher->fname ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-key">Middle Name</span>
                <span class="info-val">{{ $teacher->mname ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-key">Last Name</span>
                <span class="info-val">{{ $teacher->lname ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-key">Email</span>
                <span class="info-val">{{ $teacher->email ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-key">Contact Number</span>
                <span class="info-val">{{ $teacher->contactno ?? 'N/A' }}</span>
            </div>
            @if($teacher->department)
                <div class="info-row">
                    <span class="info-key">Department</span>
                    <span class="info-val">{{ $teacher->department }}</span>
                </div>
            @endif
            @if($teacher->description)
                <div class="info-row">
                    <span class="info-key">Bio</span>
                    <span class="info-val">{{ $teacher->description }}</span>
                </div>
            @endif
        </div>
    </div>

    <!-- Teaching Courses Section -->
    @if(isset($courses) && $courses->count() > 0)
        <div class="data-table-wrapper">
            <h3 class="table-title">Courses Currently Teaching</h3>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Course ID</th>
                        <th>Course Title</th>
                        <th>Students Enrolled</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($courses as $course)
                        <tr>
                            <td><strong>#{{ $course->id }}</strong></td>
                            <td>{{ $course->title }}</td>
                            <td>{{ $course->students_count ?? $course->students()->count() }}</td>
                            <td><span class="badge badge-success">ACTIVE</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <p class="empty-state-title">No Courses Assigned</p>
            <p class="empty-state-description">You are not currently assigned to any courses. Please contact your administrator to assign courses.</p>
        </div>
    @endif

@endsection

@section('after-scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const profilePictureInput = document.getElementById('teacherProfilePictureInput');
    const uploadStatus = document.getElementById('teacherUploadStatus');
    const profileImage = document.getElementById('teacherProfileImage');
    const profileInitials = document.getElementById('teacherProfileInitials');

    if (!profilePictureInput) return;

    profilePictureInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        uploadStatus.style.display = 'block';
        uploadStatus.innerHTML = '<div style="color: #86efac; font-size: 0.9rem;">Uploading...</div>';

        const formData = new FormData();
        formData.append('profile_picture', file);

        fetch('{{ route("teacher.upload-profile-picture") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (profileImage) {
                    profileImage.src = data.profile_picture_url + '?t=' + new Date().getTime();
                } else {
                    if (profileInitials) profileInitials.style.display = 'none';
                    const img = document.createElement('img');
                    img.id = 'teacherProfileImage';
                    img.src = data.profile_picture_url;
                    img.alt = 'Profile Picture';
                    img.className = 'student-avatar';
                    img.style.objectFit = 'cover';
                    img.style.transition = 'opacity 0.2s ease';
                    document.getElementById('teacherProfilePictureContainer').insertBefore(img, document.getElementById('teacherProfilePictureContainer').querySelector('div:last-child'));
                }

                uploadStatus.innerHTML = '<div style="color: #86efac; font-size: 0.9rem;">✓ Profile picture updated!</div>';
                setTimeout(() => {
                    uploadStatus.style.display = 'none';
                }, 3000);
            } else {
                uploadStatus.innerHTML = '<div style="color: #fda4af; font-size: 0.9rem;">✗ Error: ' + data.message + '</div>';
                setTimeout(() => {
                    uploadStatus.style.display = 'none';
                }, 3000);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            uploadStatus.innerHTML = '<div style="color: #fda4af; font-size: 0.9rem;">✗ Upload failed. Please try again.</div>';
            setTimeout(() => {
                uploadStatus.style.display = 'none';
            }, 3000);
        });

        profilePictureInput.value = '';
    });
});
</script>
@endsection

