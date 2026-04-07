@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-3 py-2 rounded-md border border-emerald-400/40 bg-emerald-400/15 text-emerald-300 text-xs font-medium uppercase tracking-wider'
            : 'inline-flex items-center px-3 py-2 rounded-md border border-transparent text-slate-300 hover:text-slate-100 hover:bg-cyan-400/10 hover:border-cyan-400/30 text-xs font-medium uppercase tracking-wider transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

