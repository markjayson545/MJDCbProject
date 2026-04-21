{{-- $student is optional; falls back to old() values --}}
<div class="ff-group">
    <label for="fname">First Name <span class="req">*</span></label>
    <input type="text" name="fname" id="fname"
           value="{{ old('fname', $student['fname'] ?? '') }}"
           required placeholder="e.g. Juan">
    @error('fname')
        <span class="ff-hint" style="color:#ef4444;">{{ $message }}</span>
    @enderror
</div>

<div class="ff-group">
    <label for="mname">Middle Name <span class="req">*</span> </label>
    <input type="text" name="mname" id="mname"
           value="{{ old('mname', $student['mname'] ?? '') }}"
           placeholder="e.g. Santos">
    @error('mname')
        <span class="ff-hint" style="color:#ef4444;">{{ $message }}</span>
    @enderror
</div>

<div class="ff-group">
    <label for="lname">Last Name <span class="req">*</span></label>
    <input type="text" name="lname" id="lname"
           value="{{ old('lname', $student['lname'] ?? '') }}"
           required placeholder="e.g. Dela Cruz">
    @error('lname')
        <span class="ff-hint" style="color:#ef4444;">{{ $message }}</span>
    @enderror
</div>

<div class="ff-group">
    <label for="contactno">Contact Number <span class="req">*</span></label>
    <input type="text" name="contactno" id="contactno"
           value="{{ old('contactno', $student['contactno'] ?? '') }}"
           required placeholder="+63 9XX XXX XXXX">
    @error('contactno')
        <span class="ff-hint" style="color:#ef4444;">{{ $message }}</span>
    @enderror
</div>

<div class="ff-group">
    <label for="email">Email Address <span class="req">*</span></label>
    <input type="email" name="email" id="email"
           value="{{ old('email', $student['email'] ?? '') }}"
           required placeholder="student@example.com">
    @error('email')
        <span class="ff-hint" style="color:#ef4444;">{{ $message }}</span>
    @enderror
</div>

<div class="ff-group">
    <label for="user_profile_id">Linked User Profile</label>
    <select name="user_profile_id" id="user_profile_id">
        <option value="">— No linked profile —</option>
        @foreach(($userProfiles ?? []) as $profile)
            <option value="{{ $profile['id'] }}" {{ (string) old('user_profile_id', (string)($student['user_profile_id'] ?? '')) === (string)$profile['id'] ? 'selected' : '' }}>
                {{ $profile['username'] }}
            </option>
        @endforeach
    </select>
    @error('user_profile_id')
        <span class="ff-hint" style="color:#ef4444;">{{ $message }}</span>
    @enderror
    <span class="ff-hint">Optional — link this student to one user profile</span>
    <button type="button" class="btn btn-ghost" onclick="window.location='{{ route('user-profiles.index') }}'">
        Manage User Profiles
    </button>
</div>

<div class="ff-group">
    <label for="degree_id">Degree</label>
    <select name="degree_id" id="degree_id">
        <option value="">— Select degree —</option>
        @foreach(($degrees ?? []) as $deg)
            <option value="{{ $deg['id'] }}" {{ (string) old('degree_id', (string)($student['degree_id'] ?? '')) === (string)$deg['id'] ? 'selected' : '' }}>
                {{ $deg['name'] }}
            </option>
        @endforeach
    </select>
    @error('degree_id')
        <span class="ff-hint" style="color:#ef4444;">{{ $message }}</span>
    @enderror
    <span class="ff-hint">Optional — associate a degree to the student</span>
    <button type="button" class="btn btn-ghost" onclick="window.location='{{ route('degrees.index') }}'">
        Manage Degrees
    </button>
</div>

<div class="ff-group">
    <label for="course_ids">Subjects</label>
    @php
        $selectedCourseIds = collect(old('course_ids', $student['courses'] ?? []))
            ->map(fn ($course) => is_array($course) ? (string) ($course['id'] ?? '') : (string) $course)
            ->filter()
            ->values()
            ->all();
    @endphp
    <div id="course_ids" class="ff-checkbox-list">
        @foreach(($courses ?? []) as $course)
            <label for="course_ids_{{ $course['id'] }}" class="ff-checkbox-item">
                <input
                    type="checkbox"
                    name="course_ids[]"
                    id="course_ids_{{ $course['id'] }}"
                    value="{{ $course['id'] }}"
                    {{ in_array((string) $course['id'], $selectedCourseIds, true) ? 'checked' : '' }}
                >
                <span>{{ $course['title'] }}</span>
            </label>
        @endforeach
    </div>
    @error('course_ids')
        <span class="ff-hint" style="color:#ef4444;">{{ $message }}</span>
    @enderror
    @error('course_ids.*')
        <span class="ff-hint" style="color:#ef4444;">{{ $message }}</span>
    @enderror
    <span class="ff-hint">Optional — select one or more subjects for this student</span>
    <button type="button" class="btn btn-ghost" onclick="window.location='{{ route('courses.index') }}'">
        Manage Subjects
    </button>
</div>

<div class="ff-group">
    <label for="description">Description</label>
    <textarea name="description" id="description"
              placeholder="Brief description about the student…">{{ old('description', $student['description'] ?? '') }}</textarea>
    @error('description')
        <span class="ff-hint" style="color:#ef4444;">{{ $message }}</span>
    @enderror
    <span class="ff-hint">Optional — 280 characters max</span>
</div>

<div class="ff-group">
    <label for="username">Username <span class="req">*</span></label>
    <input type="text" name="username" id="username"
           value="{{ old('username', $student['username'] ?? '') }}"
           required placeholder="e.g. markjayson545">
    @error('username')
    <span class="ff-hint" style="color:#ef4444;">{{ $message }}</span>
    @enderror
</div>

<div class="ff-group">
    <label for="password">Password <span class="req">*</span></label>
    <input type="password" name="password" id="password"
           value="{{ old('password', $student['password'] ?? '') }}"
           required placeholder="e.g. ••••••••">
    @error('password')
    <span class="ff-hint" style="color:#ef4444;">{{ $message }}</span>
    @enderror
</div>


