<style>
    .data-table {
        width: 100%;
        border-collapse: collapse;
        margin: 1.5rem 0;
        background: #ffffff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    }

    .data-table thead {
        background: linear-gradient(135deg, #e94560 0%, #d13852 100%);
    }

    .data-table thead th {
        padding: 0.95rem 1rem;
        text-align: left;
        font-size: 0.85rem;
        font-weight: 600;
        color: #ffffff;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #c73652;
    }

    .data-table tbody tr {
        border-bottom: 1px solid #e5e7eb;
        transition: background 0.15s ease;
    }

    .data-table tbody tr:hover {
        background: #f9fafb;
    }

    .data-table tbody tr:last-child {
        border-bottom: none;
    }

    .data-table tbody td {
        padding: 0.85rem 1rem;
        font-size: 0.875rem;
        color: #374151;
    }

    .data-table tbody td strong {
        color: #1a1a2e;
        font-weight: 600;
    }

    .data-table .table-meta-row {
        background: #f3f4f6;
        font-weight: 600;
        color: #1a1a2e;
    }

    .data-table .table-meta-row td {
        text-align: center;
        padding: 0.75rem;
        border-top: 2px solid #e5e7eb;
        border-bottom: 2px solid #e5e7eb;
    }

    .data-table .badge {
        display: inline-block;
        padding: 0.25rem 0.65rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .data-table .badge-success {
        background: #d1fae5;
        color: #065f46;
    }

    .data-table .badge-danger {
        background: #fee2e2;
        color: #991b1b;
    }

    .data-table .badge-warning {
        background: #fef3c7;
        color: #92400e;
    }

    .data-table .badge-info {
        background: #dbeafe;
        color: #1e40af;
    }

    @media (max-width: 768px) {
        .data-table {
            font-size: 0.8rem;
        }

        .data-table thead th,
        .data-table tbody td {
            padding: 0.65rem 0.5rem;
        }
    }
</style>

<table class="data-table">
    @yield('table-content')
</table>

