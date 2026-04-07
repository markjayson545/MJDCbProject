@props([
    'title' => null,
    'description' => null,
    'color' => null,
])

<div class="info-card {{ $color ?? '' }}">
    @if($title)
        <p class="info-card-title">{{ $title }}</p>
    @endif
    <p class="info-card-value">@yield('card-value')</p>
    @if($description)
        <p class="info-card-description">{{ $description }}</p>
    @endif
</div>
