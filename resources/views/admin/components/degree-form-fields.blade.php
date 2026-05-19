{{-- $degree is optional; used for edit/view forms --}}
<div class="df-group">
    <label for="name">Degree Name <span class="req">*</span></label>
    <input type="text" name="name" id="name"
           value="{{ old('name', $degree['name'] ?? '') }}"
           required placeholder="e.g. Bachelor of Science in Information Technology">
</div>

<div class="df-group">
    <label for="course_ids">Subjects</label>
    @php
        $selectedCourseIds = collect(old('course_ids', $degree['courses'] ?? []))
            ->map(fn ($course) => is_array($course) ? (string) ($course['id'] ?? '') : (string) $course)
            ->filter()
            ->values()
            ->all();
    @endphp
    <div id="course_ids" class="ff-checkbox-list">
        @forelse(($courses ?? []) as $course)
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
        @empty
            <span class="ff-hint">No subjects available yet.</span>
        @endforelse
    </div>
    @error('course_ids')
        <span class="ff-hint" style="color:#ef4444;">{{ $message }}</span>
    @enderror
    @error('course_ids.*')
        <span class="ff-hint" style="color:#ef4444;">{{ $message }}</span>
    @enderror
    <span class="ff-hint">Optional — select subjects that belong to this degree</span>
    <button type="button" class="btn btn-ghost" onclick="window.location='{{ route('admin.courses.index') }}'">
        Manage Subjects
    </button>
</div>
