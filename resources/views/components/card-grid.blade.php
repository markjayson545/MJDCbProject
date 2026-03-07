<style>
    .card-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }

    .stat-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
    }

    .stat-card-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .stat-card-icon.red {
        background: rgba(233, 69, 96, 0.1);
        color: #e94560;
    }

    .stat-card-icon.blue {
        background: rgba(15, 52, 96, 0.1);
        color: #0f3460;
    }

    .stat-card-icon.green {
        background: rgba(34, 197, 94, 0.1);
        color: #22c55e;
    }

    .stat-card-icon.yellow {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }

    .stat-card-icon svg {
        width: 24px;
        height: 24px;
    }

    .stat-card-label {
        font-size: 0.8rem;
        font-weight: 500;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin: 0 0 0.5rem;
    }

    .stat-card-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1a1a2e;
        margin: 0 0 0.25rem;
    }

    .stat-card-change {
        font-size: 0.75rem;
        color: #22c55e;
        font-weight: 600;
    }

    .stat-card-change.negative {
        color: #e94560;
    }

    @media (max-width: 640px) {
        .card-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="card-grid">
    @yield('cards-content')
</div>

