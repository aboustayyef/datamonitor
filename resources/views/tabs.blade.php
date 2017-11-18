<div class="tabs is-boxed">
    <ul>
        <li @if((request()->get('timeframe') == 'month') || (request()->get('timeframe') == '')) class="is-active" @endif><a href="/?timeframe=month">This Month</a></li>
        <li @if(request()->get('timeframe') == 'week') class="is-active" @endif><a href="/?timeframe=week">This Week</a></li>
        <li @if(request()->get('timeframe') == 'today') class="is-active" @endif><a href="/?timeframe=today">Today</a></li>
    </ul>
</div>