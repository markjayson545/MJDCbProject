@props(['value'])

<label {{ $attributes->merge(['class' => 'cyber-label']) }}>
    {{ $value ?? $slot }}
</label>
