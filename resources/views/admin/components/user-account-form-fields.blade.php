{{-- $userAccount is optional; $isEditing toggles password requirements --}}
@php
    $isEditing = $isEditing ?? false;
    $roleOptions = $roles ?? [
        'admin' => 'Admin',
        'student' => 'Student',
        'teacher' => 'Teacher',
    ];
@endphp

<div class="ff-group">
    <label for="username">Username <span class="req">*</span></label>
    <input type="text" name="username" id="username"
           value="{{ old('username', $userAccount['username'] ?? '') }}"
           required placeholder="e.g. markjayson545">
    @error('username')
        <span class="ff-hint" style="color:#ef4444;">{{ $message }}</span>
    @enderror
</div>

<div class="ff-group">
    <label for="email">Email Address <span class="req">*</span></label>
    <input type="email" name="email" id="email"
           value="{{ old('email', $userAccount['email'] ?? '') }}"
           required placeholder="user@example.com">
    @error('email')
        <span class="ff-hint" style="color:#ef4444;">{{ $message }}</span>
    @enderror
</div>

<div class="ff-group">
    <label for="role">Role <span class="req">*</span></label>
    <select name="role" id="role" required>
        <option value="">— Select role —</option>
        @foreach($roleOptions as $value => $label)
            <option value="{{ $value }}" {{ old('role', $userAccount['role'] ?? '') === $value ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
    @error('role')
        <span class="ff-hint" style="color:#ef4444;">{{ $message }}</span>
    @enderror
</div>

<div class="ff-group">
    <label for="is_active">Account Status</label>
    <label class="ff-checkbox-item" for="is_active">
        <input type="checkbox" name="is_active" id="is_active" value="1"
            {{ old('is_active', (int) ($userAccount['is_active'] ?? 0)) ? 'checked' : '' }}>
        <span>Active</span>
    </label>
    @error('is_active')
        <span class="ff-hint" style="color:#ef4444;">{{ $message }}</span>
    @enderror
</div>

<div class="ff-group">
    <label for="password">Password {{ $isEditing ? '' : ' *' }}</label>
    <input type="password" name="password" id="password"
           {{ $isEditing ? '' : 'required' }}
           placeholder="e.g. ••••••••">
    @error('password')
        <span class="ff-hint" style="color:#ef4444;">{{ $message }}</span>
    @enderror
    @if($isEditing)
        <span class="ff-hint">Leave blank to keep the current password.</span>
    @endif
</div>

<div class="ff-group">
    <label for="password_confirmation">Confirm Password {{ $isEditing ? '' : ' *' }}</label>
    <input type="password" name="password_confirmation" id="password_confirmation"
           {{ $isEditing ? '' : 'required' }}
           placeholder="e.g. ••••••••">
    @error('password_confirmation')
        <span class="ff-hint" style="color:#ef4444;">{{ $message }}</span>
    @enderror
</div>

