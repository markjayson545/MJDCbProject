{{-- $course is optional; used for edit/view forms --}}
<div class="df-group">
    <label for="title">Subject Title <span class="req">*</span></label>
    <input type="text" name="title" id="title"
           value="{{ old('title', $course['title'] ?? '') }}"
           required placeholder="e.g. Web Development">
</div>

