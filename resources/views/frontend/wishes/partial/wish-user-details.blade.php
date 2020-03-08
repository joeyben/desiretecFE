@if ($logged_in_user['role'] == 'Seller')
    <note :wishid="{{ $wish->wishDetails->id }}" :wishnote="{{ json_encode($wish->wishDetails->note) }}"  :lang="{{ json_encode(trans('strings.wishdetails.memo')) }}"></note>
@endif

<div class="col-md-12 s2-second">

    <div class="col-md-3">
        <i class="fal fa-plane-departure"></i>
        <div id="departure-mousehover-value" class="data-content ellipsised">{{ $wish->wishDetails->airport }}</div>
        <span id="departure-mousehover" class="mousehover"></span>
        <div class="departure-tooltip tooltip">
            {{ $wish->wishDetails->airport }}
        </div>
    </div>
    <div class="col-md-3">
        <i class="fal fa-calendar-alt"></i>
        <input class="data-content" value="{{ \Carbon\Carbon::parse($wish->wishDetails->earliest_start)->format('d.m.Y') }} - {{ \Carbon\Carbon::parse($wish->wishDetails->latest_return)->format('d.m.Y') }}">
    </div>
    <div class="col-md-3">
        <i class="fal fa-usd-circle"></i>
        <input class="data-content" value="{{  number_format($wish->wishDetails->budget, 0, ',', '.') }}€">
    </div>
    <div class="col-md-3">
        <i class="fal fa-star"></i>
        <input class="data-content" value="{{ $wish->wishDetails->category }} {{ trans_choice('labels.frontend.wishes.stars', $wish->wishDetails->category) }}">
    </div>

    <div class="col-md-3">
        <i class="fal fa-plane-arrival"></i>
        <div id="arrival-mousehover-value" class="data-content ellipsised">{{ $wish->wishDetails->destination }}</div>
        <span id="arrival-mousehover" class="mousehover"></span>
        <div class="arrival-tooltip tooltip">
            {{ $wish->wishDetails->destination }}
        </div>
    </div>
    <div class="col-md-3">
        <i class="fal fa-users"></i>
        <input class="data-content" value="{{ $wish->wishDetails->adults }} {{ trans_choice('labels.frontend.wishes.adults', $wish->wishDetails->adults) }}">
    </div>
    <div class="col-md-3">
        <i class="fal fa-child"></i>
        <input class="data-content" value="{{ $wish->wishDetails->kids }} {{ trans_choice('labels.frontend.wishes.kids', $wish->wishDetails->kids) }}" style="width: 30%">
        @if($wish->wishDetails->ages)
        <div>(
            <?php $count = 0; ?>
            @foreach( explode("/", $wish->wishDetails->ages) as $age)
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
        <input class="data-content" value="{{ $wish->wishDetails->duration }}">
    </div>
    <div class="col-md-3">
        <i class="fal fa-utensils"></i>
        <input class="data-content" value="{{ $wish->wishDetails->catering }}">
    </div>
</div>
@if ($logged_in_user['role'] = 'Seller' and $wish->wishDetails->extra_params)
<div class="col-md-12 s2-second">
    <b>Weitere vom Kunden ausgewählte Parameter: </b>

    <?php $count = 0; ?>
    @foreach($wish->wishDetails->extra_params as $key => $params)

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
