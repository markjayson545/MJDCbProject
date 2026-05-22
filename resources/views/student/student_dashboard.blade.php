@extends('layouts.app')

@php($student = session('student'))
@php($profilePicturePath = $student?->userAccount?->profile_picture_path)

@section('title', 'Student Dashboard - System >_')

@section('breadcrumb')
    <span class="main-breadcrumb-current">Dashboard</span>
@endsection

@section('page-title', 'Student Dashboard')
@section('page-subtitle', 'Overview of your academic progress and enrolled courses.')

@section('content')
    <!-- Quick Actions -->
{{--    <div class="quick-actions">--}}
{{--        <a href="{{ route('student.password.edit') }}" class="quick-action-btn">--}}
{{--            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"--}}
{{--                      d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>--}}
{{--            </svg>--}}
{{--            Update Password--}}
{{--        </a>--}}
{{--        <a href="{{ route('student.dashboard') }}" class="quick-action-btn">--}}
{{--            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"--}}
{{--                      d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>--}}
{{--            </svg>--}}
{{--            Refresh--}}
{{--        </a>--}}
{{--    </div>--}}

    <!-- Stats Overview Grid -->
    <div class="stats-grid">
        <div class="info-card green">
            <p class="info-card-title">Enrolled Courses</p>
            <p class="info-card-value">{{ $student->courses->count() ?? 0 }}</p>
            <p class="info-card-description">Active course enrollments.</p>
        </div>

        <div class="info-card blue">
            <p class="info-card-title">Degree Program</p>
            <p class="info-card-value">{{ $student->degree?->name ?? 'N/A' }}</p>
            <p class="info-card-description">Current academic track.</p>
        </div>

        <div class="info-card green">
            <p class="info-card-title">Account Status</p>
            <p class="info-card-value">ACTIVE</p>
            <p class="info-card-description">Account is in good standing.</p>
        </div>
    </div>

    <!-- Student Information Card -->
    <div class="detail-card">
        <!-- Profile Picture Section -->
        <div style="text-align: center; margin-bottom: 2rem;">
            <div style="position: relative; display: inline-block;">
                <!-- Hidden file input -->
                <input type="file" id="profilePictureInput" accept="image/*" style="display: none;">

                <!-- Profile Picture Display (Clickable) -->
                <div id="profilePictureContainer"
                     style="cursor: pointer; position: relative; display: inline-block; transition: transform 0.2s ease, opacity 0.2s ease;"
                     onmouseover="this.style.opacity='0.8'"
                     onmouseout="this.style.opacity='1'"
                     onclick="document.getElementById('profilePictureInput').click()">
                    @if(!empty($profilePicturePath))
                        <img id="profileImage"
                             src="{{ asset('storage/' . $profilePicturePath) }}"
                             alt="Profile Picture"
                             class="student-avatar"
                             style="object-fit: cover; transition: opacity 0.2s ease;">
                    @else
                        <div id="profileInitials" class="student-avatar" style="transition: opacity 0.2s ease;">
                            {{ strtoupper(substr($student->fname, 0, 1) . substr($student->lname, 0, 1)) }}
                        </div>
                    @endif

                    <!-- Upload Icon Overlay -->
                    <div style="position: absolute; bottom: 0; right: 0; background: rgba(34, 197, 94, 0.9); border-radius: 50%; padding: 8px; display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; cursor: pointer;">
                        <svg fill="white" viewBox="0 0 24 24" width="20" height="20">
                            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Upload Status -->
                <div id="uploadStatus" style="margin-top: 1rem; display: none;">
                    <div style="color: #86efac; font-size: 0.9rem;">Uploading...</div>
                </div>
            </div>

            <h4 style="margin: 1rem 0 0.5rem; color: var(--clr-text); font-family: 'Fira Code', monospace;">
                {{ $student->fname }} {{ $student->lname }}
            </h4>
            <p style="margin: 0; color: var(--clr-text-muted); font-size: 0.86rem;">Click profile picture to upload</p>
        </div>

        <h3 class="detail-card-title">Personal Information</h3>
        <div class="detail-card-content">
            <div class="info-row">
                <span class="info-key">First Name</span>
                <span class="info-val">{{ $student->fname }}</span>
            </div>
            <div class="info-row">
                <span class="info-key">Middle Name</span>
                <span class="info-val">{{ $student->mname ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-key">Last Name</span>
                <span class="info-val">{{ $student->lname }}</span>
            </div>
            <div class="info-row">
                <span class="info-key">Contact Number</span>
                <span class="info-val">{{ $student->contactno ?? 'N/A' }}</span>
            </div>
            @if($student->description)
                <div class="info-row">
                    <span class="info-key">Description</span>
                    <span class="info-val">{{ $student->description }}</span>
                </div>
            @endif
        </div>
    </div>

    @if($student->degree && $student->degree->courses->count() > 0)
        <div class="data-table-wrapper">
            <h3 class="table-title">Degree Subjects</h3>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Subject ID</th>
                        <th>Subject Title</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($student->degree->courses as $course)
                        <tr>
                            <td><strong>#{{ $course->id }}</strong></td>
                            <td>{{ $course->title }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <p class="empty-state-title">No Degree Subjects</p>
            <p class="empty-state-description">Your degree program does not have subjects assigned yet.</p>
        </div>
    @endif

    <!-- Enrolled Courses Section -->
    @if($student->courses->count() > 0)
        <div class="data-table-wrapper">
            <h3 class="table-title">Enrolled Courses</h3>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Course ID</th>
                        <th>Course Title</th>
                        <th>Enrollment Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($student->courses as $course)
                        <tr>
                            <td><strong>#{{ $course->id }}</strong></td>
                            <td>{{ $course->title }}</td>
                            <td>{{ $course->pivot->created_at->format('M d, Y') }}</td>
                            <td><span class="badge badge-success">ENROLLED</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <p class="empty-state-title">No Courses Enrolled</p>
            <p class="empty-state-description">You are not currently enrolled in any courses. Please contact your advisor to enroll.</p>
        </div>
    @endif

@endsection

@section('after-scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const profilePictureInput = document.getElementById('profilePictureInput');
    const uploadStatus = document.getElementById('uploadStatus');
    const profileImage = document.getElementById('profileImage');
    const profileInitials = document.getElementById('profileInitials');

    profilePictureInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        // Show upload status
        uploadStatus.style.display = 'block';
        uploadStatus.innerHTML = '<div style="color: #86efac; font-size: 0.9rem;">Uploading...</div>';

        // Create FormData
        const formData = new FormData();
        formData.append('profile_picture', file);

        // Upload the file
        fetch('{{ route("student.upload-profile-picture") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the profile image
                if (profileImage) {
                    profileImage.src = data.profile_picture_url + '?t=' + new Date().getTime();
                } else {
                    // If no image existed, hide initials and create image
                    if (profileInitials) profileInitials.style.display = 'none';
                    const img = document.createElement('img');
                    img.id = 'profileImage';
                    img.src = data.profile_picture_url;
                    img.alt = 'Profile Picture';
                    img.className = 'student-avatar';
                    img.style.objectFit = 'cover';
                    img.style.transition = 'opacity 0.2s ease';
                    document.getElementById('profilePictureContainer').insertBefore(img, document.getElementById('profilePictureContainer').querySelector('div:last-child'));
                }

                // Update status
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

        // Reset input
        profilePictureInput.value = '';
    });
});
</script>
@endsection

