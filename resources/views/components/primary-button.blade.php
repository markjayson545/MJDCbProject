<button {{ $attributes->merge(['type' => 'submit', 'class' => 'cyber-btn-primary']) }}>
    {{ $slot }}
</button>
