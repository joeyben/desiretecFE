 <div class="col-md-6 s2-first">
        <h4>Reisewunsch Angaben</h4>
        <p>Dies sind die Angaben zum Reisewunsch.</p>
        <p><b>Kundennachricht:</b><br>
            {{ $wish->description }}
        </p>
    </div>
    <note :wishid="{{ $wish->id }}" :wishnote="{{ json_encode($wish->note) }}"  :lang="{{ json_encode(trans('strings.wishdetails.memo')) }}"></note>


<div class="col-md-12 s2-second">

    <div class="col-md-3">
        <i class="fal fa-plane-departure"></i>
        <input class="data-content" value="{{ $wish->airport }}">
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
        <input class="data-content" value="{{ $wish->destination }}">
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
        <input class="data-content" value="">
    </div>
    <!--<button class="secondary-btn">Daten andern</button>-->
</div>
