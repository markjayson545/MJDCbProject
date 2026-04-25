{{-- $degree is optional; used for edit/view forms --}}
<div class="df-group">
    <label for="name">Degree Name <span class="req">*</span></label>
    <input type="text" name="name" id="name"
           value="{{ old('name', $degree['name'] ?? '') }}"
           required placeholder="e.g. Bachelor of Science in Information Technology">
</div>

