<style>
.mjdc-table-wrap {
    overflow: hidden;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 2px 8px rgba(0,0,0,0.04);
}
.mjdc-table {
    width: 100%;
    border-collapse: collapse;
    background: #ffffff;
    font-family: 'Outfit', sans-serif;
}
.mjdc-table thead {
    background: linear-gradient(135deg, #e94560 0%, #c83550 100%);
}
.mjdc-table thead th {
    padding: 1rem 1.25rem;
    text-align: left;
    font-size: 0.75rem;
    font-weight: 700;
    color: #ffffff;
    text-transform: uppercase;
    letter-spacing: 0.65px;
    white-space: nowrap;
}
.mjdc-table tbody tr {
    border-bottom: 1px solid #e2e8f0;
    transition: background 0.12s ease;
}
.mjdc-table tbody tr:last-child { border-bottom: none; }
.mjdc-table tbody tr:hover  { background: #f8fafd; }
.mjdc-table tbody td {
    padding: 0.9rem 1.25rem;
    font-size: 0.875rem;
    color: #1e293b;
    vertical-align: middle;
}
.mjdc-table tbody td strong { color: #1a1a2e; font-weight: 600; }
.mjdc-table tfoot td {
    padding: 0.75rem 1.25rem;
    font-size: 0.8rem;
    color: #64748b;
    background: #f8fafd;
    border-top: 1px solid #e2e8f0;
}
/* Badges used inside tables */
.t-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.2rem 0.7rem;
    border-radius: 999px;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.4px;
}
.t-badge-success { background: #d1fae5; color: #065f46; }
.t-badge-danger  { background: #fee2e2; color: #991b1b; }
.t-badge-warning { background: #fef3c7; color: #92400e; }
.t-badge-info    { background: #dbeafe; color: #1e40af; }
.t-badge-emerald { background: #d1fae5; color: #065f46; }
.t-badge-amber   { background: #fef3c7; color: #92400e; }
.t-badge-orange  { background: #ffedd5; color: #9a3412; }
.t-badge-rose    { background: #ffe4e6; color: #9f1239; }
/* High-specificity rules to prevent white text in table body */
.data-table tbody td,
.data-table tbody td * {
    color: #1e293b !important;
}

.data-table tbody td .student-name,
.data-table tbody td .student-name * {
    color: #1a1a2e !important;
    font-weight: 600 !important;
}
</style>

@if(isset($slot) && trim($slot) !== '')
    <div class="mjdc-table-wrap">{{ $slot }}</div>
@else
    <div class="mjdc-table-wrap">
        <table class="mjdc-table">
            @if(isset($thead))
                <thead><tr>{!! $thead !!}</tr></thead>
            @endif
            <tbody>{!! $tbody ?? '' !!}</tbody>
        </table>
    </div>
@endif
