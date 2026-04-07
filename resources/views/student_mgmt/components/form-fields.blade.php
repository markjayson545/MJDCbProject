{{-- $student is optional; falls back to old() values --}}
<div class="ff-group">
    <label for="fname">First Name <span class="req">*</span></label>
    <input type="text" name="fname" id="fname"
           value="{{ old('fname', $student['fname'] ?? '') }}"
           required placeholder="e.g. Juan">
</div>

<div class="ff-group">
    <label for="mname">Middle Name <span class="req">*</span> </label>
    <input type="text" name="mname" id="mname"
           value="{{ old('mname', $student['mname'] ?? '') }}"
           required placeholder="e.g. Santos">
</div>

<div class="ff-group">
    <label for="lname">Last Name <span class="req">*</span></label>
    <input type="text" name="lname" id="lname"
           value="{{ old('lname', $student['lname'] ?? '') }}"
           required placeholder="e.g. Dela Cruz">
</div>

<div class="ff-group">
    <label for="contactno">Contact Number <span class="req">*</span></label>
    <input type="text" name="contactno" id="contactno"
           value="{{ old('contactno', $student['contactno'] ?? '') }}"
           required placeholder="+63 9XX XXX XXXX">
</div>

<div class="ff-group">
    <label for="email">Email Address <span class="req">*</span></label>
    <input type="email" name="email" id="email"
           value="{{ old('email', $student['email'] ?? '') }}"
           required placeholder="student@example.com">
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
    <span class="ff-hint">Optional — associate a degree to the student</span>
    <button type="button" class="btn btn-ghost" onclick="window.location='{{ route('degrees.index') }}'">
        Manage Degrees
    </button>
</div>

<div class="ff-group">
    <label for="description">Description</label>
    <textarea name="description" id="description"
              placeholder="Brief description about the student…">{{ old('description', $student['description'] ?? '') }}</textarea>
    <span class="ff-hint">Optional — 280 characters max</span>
</div>
