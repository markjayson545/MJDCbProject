{{-- $student is optional; falls back to old() values --}}
<style>
.ff-group {
    display: flex;
    flex-direction: column;
    gap: 0.35rem;
}
.ff-group label {
    font-size: 0.72rem;
    font-weight: 700;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: 0.55px;
    font-family: 'Outfit', sans-serif;
}
.ff-group label .req { color: #e94560; margin-left: 2px; }
.ff-group input,
.ff-group textarea,
.ff-group select {
    width: 100%;
    padding: 0.65rem 0.9rem;
    font-size: 0.9rem;
    font-family: 'Outfit', sans-serif;
    color: #1e293b;
    background: #f8fafd;
    border: 1.5px solid #e2e8f0;
    border-radius: 8px;
    outline: none;
    transition: border-color 0.15s ease, box-shadow 0.15s ease, background 0.15s ease;
    -webkit-appearance: none;
}
.ff-group input:focus,
.ff-group textarea:focus,
.ff-group select:focus {
    border-color: #e94560;
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(233, 69, 96, 0.1);
}
.ff-group input::placeholder,
.ff-group textarea::placeholder { color: #94a3b8; }
.ff-group textarea { resize: vertical; min-height: 100px; line-height: 1.55; }
.ff-hint {
    font-size: 0.75rem;
    color: #94a3b8;
    font-family: 'Outfit', sans-serif;
}
</style>

<div class="ff-group">
    <label for="fname">First Name <span class="req">*</span></label>
    <input type="text" name="fname" id="fname"
           value="{{ old('fname', $student['fname'] ?? '') }}"
           required placeholder="e.g. Juan">
</div>

<div class="ff-group">
    <label for="mname">Middle Name</label>
    <input type="text" name="mname" id="mname"
           value="{{ old('mname', $student['mname'] ?? '') }}"
           placeholder="e.g. Santos (optional)">
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
</div>

<div class="ff-group">
    <label for="description">Description</label>
    <textarea name="description" id="description"
              placeholder="Brief description about the student…">{{ old('description', $student['description'] ?? '') }}</textarea>
    <span class="ff-hint">Optional — 280 characters max</span>
</div>
