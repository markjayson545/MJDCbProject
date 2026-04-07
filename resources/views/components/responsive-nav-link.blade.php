@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full px-4 py-2 border-l-4 border-emerald-400 text-start text-sm font-medium text-emerald-300 bg-emerald-400/15'
            : 'block w-full px-4 py-2 border-l-4 border-transparent text-start text-sm font-medium text-slate-300 hover:text-slate-100 hover:bg-cyan-400/10 hover:border-cyan-400/40 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
