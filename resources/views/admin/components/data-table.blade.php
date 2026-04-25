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
