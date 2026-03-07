<style>
    .pattern-section {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .pattern-section-title {
        font-size: 1rem;
        font-weight: 600;
        color: #1a1a2e;
        margin: 0 0 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #e94560;
    }

    .pattern-output {
        font-family: 'Courier New', monospace;
        font-size: 1.1rem;
        line-height: 1.4;
        color: #0f3460;
        font-weight: 600;
        background: #ffffff;
        padding: 1rem;
        border-radius: 6px;
        border: 1px solid #e5e7eb;
    }

    .number-list {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        background: #ffffff;
        padding: 1rem;
        border-radius: 6px;
        border: 1px solid #e5e7eb;
    }

    .number-item {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #e94560, #d13852);
        color: #ffffff;
        font-weight: 700;
        border-radius: 6px;
        box-shadow: 0 2px 4px rgba(233, 69, 96, 0.2);
    }
</style>

<div class="pattern-section">
    @yield('pattern-content')
</div>

