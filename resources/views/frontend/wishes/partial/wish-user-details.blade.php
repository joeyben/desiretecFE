@if ($logged_in_user['role'] == 'Seller')
    <note :wishid="{{ $wish->wishDetails->id }}" :wishnote="{{ json_encode($wish->wishDetails->note) }}"  :lang="{{ json_encode(trans('strings.wishdetails.memo')) }}"></note>
@endif

<div class="col-md-12 s2-second">

    @if($wish->wishDetails->airport !== '-')
    <div class="col-md-3">
        <i class="fal fa-plane-departure"></i>
        <div id="departure-mousehover-value" class="data-content ellipsised">{{ $wish->wishDetails->airport }}</div>
        <span id="departure-mousehover" class="mousehover"></span>
        <div class="departure-tooltip tooltip">
            {{ $wish->wishDetails->airport }}
        </div>
    </div>
    @endif
    @if($wish->wishDetails->earliest_start !== '0000-00-00' && $wish->wishDetails->latest_return !== '0000-00-00')
    <div class="col-md-3">
        <i class="fal fa-calendar-alt"></i>
        <input class="data-content" value="{{ \Carbon\Carbon::parse($wish->wishDetails->earliest_start)->format('d.m.Y') }} - {{ \Carbon\Carbon::parse($wish->wishDetails->latest_return)->format('d.m.Y') }}">
    </div>
    @endif
    @if($wish->wishDetails->budget !== 0)
    <div class="col-md-3">
        <i class="fal fa-usd-circle"></i>
        <input class="data-content" value="{{  number_format($wish->wishDetails->budget, 0, ',', '.') }}€">
    </div>
    @endif
    @if($wish->wishDetails->category !== 0)
    <div class="col-md-3">
        <i class="fal fa-star"></i>
        <input class="data-content" value="{{ $wish->wishDetails->category }} {{ trans_choice('labels.frontend.wishes.stars', $wish->wishDetails->category) }}">
    </div>
    @endif
    @if($wish->wishDetails->class)
    <div class="col-md-3">
        <i class="fal fa-star"></i>
        <input class="data-content" value="{{ $wish->wishDetails->class }}">
    </div>
    @endif
    @if($wish->wishDetails->destination !== '-')
    <div class="col-md-3">
        <i class="fal fa-plane-arrival"></i>
        <div id="arrival-mousehover-value" class="data-content ellipsised">{{ $wish->wishDetails->destination }}</div>
        <span id="arrival-mousehover" class="mousehover"></span>
        <div class="arrival-tooltip tooltip">
            {{ $wish->wishDetails->destination }}
        </div>
    </div>
    @endif
    @if($wish->wishDetails->adults > 0)
    <div class="col-md-3">
        <i class="fal fa-users"></i>
        <input class="data-content" value="{{ $wish->wishDetails->adults }} {{ trans_choice('labels.frontend.wishes.adults', $wish->wishDetails->adults) }}">
    </div>
    @endif
    @if($wish->wishDetails->kids > 0)
    <div class="col-md-3 kids">
        <i class="fal fa-child"></i>
        <input class="data-content" value="{{ $wish->wishDetails->kids }} {{ trans_choice('labels.frontend.wishes.kids', $wish->wishDetails->kids) }}" >
        @if($wish->wishDetails->ages)
            <span>(</span>
            <span>{{ rtrim($wish->wishDetails->ages,",") }}</span>
            <span>)</span>
        @endif
    </div>
    @endif
    <div class="col-md-3">
        <i class="fal fa-stopwatch"></i>
        <input class="data-content" value="{{ $wish->wishDetails->duration }}">
    </div>
    @if($wish->wishDetails->rooms)
    <div class="col-md-3">
        <i class="fal fa-door-closed"></i>
        <input class="data-content" value="{{ $wish->wishDetails->rooms }} {{ trans_choice('labels.frontend.wishes.rooms', $wish->wishDetails->rooms) }}">
    </div>
    @endif
    @if($wish->wishDetails->pets)
    <div class="col-md-3">
        <i class="fal fa-dog-leashed"></i>
        <input class="data-content" value="{{ trans_choice('labels.frontend.wishes.pets', $wish->wishDetails->pets) }}">
    </div>
    @endif
    @if($wish->wishDetails->catering)
    <div class="col-md-3">
        <i class="fal fa-utensils"></i>
        <input class="data-content" value="{{ $wish->wishDetails->catering }}">
    </div>
    @endif
    @if($wish->wishDetails->purpose)
    <div class="col-md-3">
        <i class="fal fa-suitcase"></i>
        <div id="purpose-mousehover-value" class="data-content ellipsised">{{ $wish->wishDetails->purpose }}</div>
        <span id="purpose-mousehover" class="mousehover"></span>
        <div class="purpose-tooltip tooltip">
            {{ $wish->wishDetails->purpose }}
        </div>
    </div>
    @endif
    @if($wish->wishDetails->version === 'destination')
    <div class="col-md-3">
        <i class="fal fa-theater-masks"></i>
        @if($wish->wishDetails->events_interested === 0)
            <div id="events-interested-mousehover-value" class="data-content ellipsised">{{ trans('labels.frontend.wishes.events_interested_unchecked') }}</div>
            <span id="events-interested-mousehover" class="mousehover"></span>
            <div class="events-interested-tooltip tooltip">
                {{ trans('labels.frontend.wishes.events_interested_unchecked') }}
            </div>
        @else
            <div id="events-interested-mousehover-value" class="data-content ellipsised">{{ trans('labels.frontend.wishes.events_interested_checked') }}</div>
            <span id="events-interested-mousehover" class="mousehover"></span>
            <div class="events-interested-tooltip tooltip">
                {{ trans('labels.frontend.wishes.events_interested_checked') }}
            </div>
        @endif
    </div>
    @endif
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
