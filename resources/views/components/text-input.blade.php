@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'cyber-input']) }}>
