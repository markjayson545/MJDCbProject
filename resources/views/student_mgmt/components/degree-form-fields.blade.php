{{-- $degree is optional; used for edit/view forms --}}
<style>
.df-group {
    display: flex;
    flex-direction: column;
    gap: 0.35rem;
}
.df-group label {
    font-size: 0.72rem;
    font-weight: 700;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: 0.55px;
    font-family: 'Outfit', sans-serif;
}
.df-group label .req { color: #e94560; margin-left: 2px; }
.df-group input,
.df-group textarea,
.df-group select {
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
.df-group input:focus,
.df-group textarea:focus,
.df-group select:focus {
    border-color: #e94560;
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(233, 69, 96, 0.1);
}
.df-group input::placeholder,
.df-group textarea::placeholder { color: #94a3b8; }
</style>

<div class="df-group">
    <label for="name">Degree Name <span class="req">*</span></label>
    <input type="text" name="name" id="name"
           value="{{ old('name', $degree['name'] ?? '') }}"
           required placeholder="e.g. Bachelor of Science in Information Technology">
</div>

