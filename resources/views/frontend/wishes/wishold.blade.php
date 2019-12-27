@extends('frontend.layouts.app')

@section('content')
    <!-- Wish lis Box -->
    <div class="wish-container">
        <div class="wish">
            <div class="image" style="background-image: url({{ Storage::disk('s3')->url('img/wish/' . $wish->featured_image) }})">

            </div>
            <div class="wish-info">
                <div class="person">
                    <ul>
                        <li>
                            <span class="label">{{ trans('wish.view.owner') }}</span>
                            <span class="text">{{ $wish->owner->first_name }} {{ $wish->owner->last_name }}</span>
                        </li>
                        <li>
                            <span class="label">{{ trans('wish.view.email') }}</span>
                            <span class="text">{{ $wish->owner->email }}</span>
                        </li>
                        <li>
                            <span class="label">{{ trans('wish.view.text') }}</span>
                            <span class="text description">{{ $wish->description }}</span>
                        </li>
                    </ul>
                </div>
                <div class="info">
                    <ul>
                        <li>
                            <span class="label">{{ trans('wish.view.title') }}</span>
                            <span class="text">{{ $wish->title }}</span>
                        </li>
                        <li>
                            <span class="label">{{ trans('wish.view.airport') }}</span>
                            <span class="text">{{ $wish->airport }}</span>
                        </li>
                        <li>
                            <span class="label">{{ trans('wish.view.destination') }}</span>
                            <span class="text">{{ $wish->destination }}</span>
                        </li>
                        <li>
                            <span class="label">{{ trans('wish.view.adults') }}</span>
                            <span class="text">{{ $wish->adults }}</span>
                        </li>
                        <li>
                            <span class="label">{{ trans('wish.view.kids') }}</span>
                            <span class="text">{{ $wish->kids }}</span>
                        </li>
                        <li>
                            <span class="label">{{ trans('wish.view.budget') }}</span>
                            <span class="text">{{ $wish->budget }}</span>
                        </li>
                        <li>
                            <span class="label">{{ trans('wish.view.category') }}</span>
                            <span class="text">
                                @for ($i = 0; $i < $wish->category; $i++)
                                    <i class="icon_star"></i>
                                @endfor
                            </span>
                        </li>
                        <li>
                            <span class="label">{{ trans('wish.view.catering') }}</span>
                            <span class="text">{{ $wish->catering }}</span>
                        </li>
                        <li>
                            <span class="label">{{ trans('wish.view.earliest_start') }}</span>
                            <span class="text">{{ $wish->earliest_start }}</span>
                        </li>
                        <li>
                            <span class="label">{{ trans('wish.view.latest_return') }}</span>
                            <span class="text">{{ $wish->latest_return }}</span>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="offer-container">
        <h4>{{ count($wish->offers) }} Offers</h4>
        <?php $i=0; ?>
        @foreach($wish->offers as $key => $offer)
            <div class="offer">
                <img src="{{ Storage::disk('s3')->url('img/agent/' . $avatar[$i]) }}" >
                <div class='offer-info'>
                    <h6>{{ $offer->agent }}</h6>
                    <span class="title">{{ $offer->title }}</span>
                    <p>{{ $offer->description }}</p>
                    <a class="icon_document" href="{{ Storage::disk('s3')->url('img/offer/' . $offer->file) }}"></a>
                </div>
            </div>
            @if(($key+1) < count($wish->offers))
                <hr>
            @endif
        <?php $i++; ?>
        @endforeach
    </div>

    <div class="message-container">
        <h4>{{ trans('wish.view.comment-header') }}</h4>
        <hr>
       <chat-messages :wishid="{{ $wish->id }}" :userid="{{ Auth::user()->id }}" :groupid="{{ $wish->group_id }}"></chat-messages>
    </div>

@endsection

@section('after-scripts')

    <script>

    </script>
@endsection