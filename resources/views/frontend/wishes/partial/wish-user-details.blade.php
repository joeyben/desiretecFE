@if ($logged_in_user['role'] == 'Seller')
    <note :wishid="{{ $wish->id }}" :wishnote="{{ json_encode($wish->note) }}"  :lang="{{ json_encode(trans('strings.wishdetails.memo')) }}"></note>
@endif

<div class="col-md-12 s2-second">

    <div class="col-md-3">
        <i class="fal fa-plane-departure"></i>
        <div id="departure-mousehover-value" class="data-content ellipsised">{{ $wish->airport }}</div>
        <span id="departure-mousehover" class="mousehover"></span>
        <div class="departure-tooltip tooltip">
            {{ $wish->airport }}
        </div>
    </div>
    <div class="col-md-3">
        <i class="fal fa-calendar-alt"></i>
        <input class="data-content" value="{{ \Carbon\Carbon::parse($wish->earliest_start)->format('d.m.Y') }} - {{ \Carbon\Carbon::parse($wish->latest_return)->format('d.m.Y') }}">
    </div>
    <div class="col-md-3">
        <i class="fal fa-usd-circle"></i>
        <input class="data-content" value="{{  number_format($wish->budget, 0, ',', '.') }}€">
    </div>
    <div class="col-md-3">
        <i class="fal fa-star"></i>
        <input class="data-content" value="{{ $wish->category }} Sterne">
    </div>

    <div class="col-md-3">
        <i class="fal fa-plane-arrival"></i>
        <div id="arrival-mousehover-value" class="data-content ellipsised">{{ $wish->destination }}</div>
        <span id="arrival-mousehover" class="mousehover"></span>
        <div class="arrival-tooltip tooltip">
            {{ $wish->destination }}
        </div>
    </div>
    <div class="col-md-3">
        <i class="fal fa-users"></i>
        <input class="data-content" value="{{ $wish->adults }}">
    </div>
    <div class="col-md-3">
        <i class="fal fa-child"></i>
        <input class="data-content" value="{{ $wish->kids }}" style="width: 30%">
        @if($wish->ages)
        <div>(
            <?php $count = 0; ?>
            @foreach( explode("/", $wish->ages) as $age)
                @if ($age && $count > 0)
                    ,
                @endif

                @if ($age)
                    {{ $age }}
                    <?php $count++; ?>
                @endif
            @endforeach
        )</div>
        @endif
    </div>
    <div class="col-md-3">
        <i class="fal fa-stopwatch"></i>
        <input class="data-content" value="{{ $wish->duration }}">
    </div>
    <div class="col-md-3">
        <i class="fal fa-utensils"></i>
        <input class="data-content" value="{{ $wish->category }}">
    </div>
</div>
@if ($logged_in_user['role'] = 'Seller' and $wish->extra_params)
<div class="col-md-12 s2-second">
    <b>Weitere vom Kunden ausgewählte Parameter: </b>

    <?php $count = 0; ?>
    @foreach($wish->extra_params as $key => $params)

        @if ($params && $count > 0)
           ,
        @endif

        @if ($params)
            {{ $params }}
            <?php $count++; ?>
        @endif

    @endforeach
</div>
@endif
