<style>
    .info-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-left: 4px solid #e94560;
        border-radius: 8px;
        padding: 1.25rem 1.5rem;
        margin-bottom: 1.25rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .info-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .info-card.blue {
        border-left-color: #0f3460;
    }

    .info-card.green {
        border-left-color: #22c55e;
    }

    .info-card.yellow {
        border-left-color: #f59e0b;
    }

    .info-card-title {
        font-size: 0.8rem;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin: 0 0 0.5rem;
    }

    .info-card-value {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1a1a2e;
        margin: 0;
    }

    .info-card-description {
        font-size: 0.85rem;
        color: #9ca3af;
        margin: 0.5rem 0 0;
    }
</style>

<div class="info-card {{ $color ?? '' }}">
    @if(isset($title))
        <p class="info-card-title">{{ $title }}</p>
    @endif
    <p class="info-card-value">@yield('card-value')</p>
    @if(isset($description))
        <p class="info-card-description">{{ $description }}</p>
    @endif
</div>

