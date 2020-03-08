@php
    $contactInactivClass = count($wish->wishDetails->contacts) ? "" : "";
    $callbackInactivClass = count($wish->wishDetails->callbacks) ? "" : "";
    $actionButtonsSet = false;
@endphp

@extends('frontend.layouts.app')

@section('title')
{{ trans('wish.details.tab_title') }}
@endsection

@section('before-scripts')
<script type="application/javascript">
    var brandColor = {!!json_encode(getCurrentWhiteLabelColor()) !!};
</script>
@endsection

@section('content')
<section class="section-top">
    <div class="img-background">
        <div class="container">
            <div class="col-md-8 bg-left-content">
                @if ($logged_in_user && ($logged_in_user['role'] === "Seller" || $logged_in_user['role'] === "Executive"))
                    <h3>Hallo, {{ $currentAgent['name'] }}</h3>
                @elseif ($logged_in_user['role'] == ('User') && $wish->last_name !== trans('user.default.last_name'))
                    <h3>Hallo {{ $wish->first_name }} {{ $wish->last_name }},</h3>
                @elseif ($logged_in_user['role'] == ('User') && $wish->first_name)
                    <h3>Hallo lieber Kunde,</h3>
                @else
                    <h3>Hallo,</h3>
                @endif

                @if ($logged_in_user['role'] == ('Seller'))
                    <p class="header-p mb-30">{!! trans('wish.view.stage.seller_empty',['date' => \Carbon\Carbon::parse($wish->created_at)->format('d.m.Y')]) !!}</p>
                    <a href="{{route('frontend.offers.create', ['id' => $wish->wish_id, 'subdomain' => $subdomain])}}" class="primary-btn">{{ trans('buttons.wishes.frontend.create_offer')}}</a>
                @elseif (count($wish->wishDetails->offers) > 0)
                    <p class="header-p">{!! trans('wish.view.stage.user_offer',['date' => \Carbon\Carbon::parse($wish->created_at)->format('d.m.Y'), 'seller' => (isset($wish->wishDetails->group) ? $wish->wishDetails->group->users[0]->name : '' )]) !!} </p>
                    <button class="primary-btn{{ $contactInactivClass }}" onclick="scrollToAnchor('angebote')">{{ trans_choice('wish.details.view-offers-button', count($wish->wishDetails->offers), ['count' => count($wish->wishDetails->offers)]) }}</button>
                @elseif (isset($wish->wishDetails->messages) && count($wish->wishDetails->messages) > 0 && $wish->wishDetails->messages[count($wish->wishDetails->messages)-1]->user_id !== Auth::user()->id)
                    <p class="header-p">{!! trans('wish.view.stage.user_message',['date' => \Carbon\Carbon::parse($wish->created_at)->format('d.m.Y'), 'seller' => $wish->wishDetails->group->users[0]->name]) !!} </p>
                    <button class="primary-btn{{ $contactInactivClass }}" onclick="scrollToAnchor('messages')">{{ trans('wish.details.view-messages-button') }}</button>
                @else
                    @php
                        $actionButtonsSet = true;
                    @endphp
                    <p class="header-p">{!! trans('wish.view.stage.user_empty',['date' => \Carbon\Carbon::parse($wish->created_at)->format('d.m.Y'), 'seller' => (isset($wish->wishDetails->group) ? $wish->wishDetails->group->users[0]->name : '')]) !!} </p>
                    <button class="primary-btn{{ $contactInactivClass }}" data-toggle="modal" data-target="#contact_modal">{{ trans('wish.details.kontakt-button') }}</button>
                    <button class="secondary-btn{{ $callbackInactivClass }}" data-toggle="modal" data-target="#callback">{{ trans('wish.details.callback-button') }}</button>
                @endif

            </div>
        </div>
    </div>

    @if ($logged_in_user['role'] == ('Seller') && count($wish->wishDetails->contacts) )
        <div class="bg-bottom">
            <div class="container">
                <h4>Kontaktdaten des Kunden</h4>
                <div class="row">
                    <div class="col-md-3 c-info">
                        <i class="fal fa-pencil"></i>
                        <span>{{ $wish->wishDetails->contacts[0]->subject }}</span>
                    </div>
                    <div class="col-md-3 c-info">
                        <i class="fas fa-user"></i>
                        <span>{{ $wish->wishDetails->contacts[0]->name }}</span>
                    </div>
                    <div class="col-md-3 c-info c-tel">
                        <i class="fas fa-phone"></i>
                        <a href="tel:{{ $wish->wishDetails->contacts[0]->telephone }}">{{ $wish->wishDetails->contacts[0]->telephone }}</a>
                    </div>
                    <div class="col-md-3 c-info">
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:{{ $wish->wishDetails->contacts[0]->email }}">{{ $wish->wishDetails->contacts[0]->email }}</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p>
                            &nbsp;
                        </p>
                    </div>
                    <div class="col-md-12">
                        <h5>Nachricht:</h5>
                        <p>
                            {{ $wish->wishDetails->contacts[0]->message }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="col-md-12">
                <hr class="sad-hr">
            </div>
        </div>

    @elseif ($logged_in_user['role'] == ('User'))
        <div class="bg-bottom">
            <div class="container">
                <h4>Zuständiges Reisebüro</h4>
                <div class="col-md-3">
                    <p>
                        {{ $wish->wishDetails->group->users[0]->name }}</p>
                    <p>
                        {{ $wish->wishDetails->group->users[0]->address }} <br>
                        {{ $wish->wishDetails->group->users[0]->zip_code }} {{ $wish->wishDetails->group->users[0]->city }}
                    </p>
                </div>
                @if(count($wish->wishDetails->offers) > 0 || count($wish->wishDetails->messages) > 0)
                    <div class="col-md-3 c-info">
                        <i class="fas fa-user"></i>
                        <span>{{ $wish->wishDetails->group->users[0]->agents[0]->name }}</span>
                    </div>
                    <div class="col-md-3 c-info c-tel">
                        <i class="fas fa-phone"></i>
                        <a href="tel:{{ $wish->wishDetails->group->users[0]->agents[0]->telephone }}">{{ $wish->wishDetails->group->users[0]->agents[0]->telephone }}</a>
                    </div>
                    <div class="col-md-3 c-info">
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:{{ $wish->wishDetails->group->users[0]->agents[0]->email }}">{{ $wish->wishDetails->group->users[0]->agents[0]->email }}</a>
                    </div>
                @endif
            </div>
        </div>

        <div class="container">
            <div class="col-md-12">
                <hr class="sad-hr">
            </div>
        </div>

    @endif
</section>

@if (count($wish->wishDetails->offers) > 0 && $logged_in_user['role'] === "Seller" && count($wish->wishDetails->contacts) === 0)
    <div class="container">
        <div class="col-md-12">
            <p>&nbsp;</p>
        </div>
    </div>
@endif

@if (count($wish->wishDetails->offers) > 0)
    <section class="section-angebote-2" id="angebote">
        <div class="container">
            <div class="col-md-12 sa2-1">
                <h4>
                    {{ trans('wish.view.new_offers') }}
                </h4>
                <p class="sa2-p1">{{ trans_choice('wish.view.offers_title_count', count($wish->wishDetails->offers), ['count' => count($wish->wishDetails->offers)]) }}
                    @if ($logged_in_user['role'] === "Seller")
                        erstellt
                    @else
                        erhalten
                    @endif
                </p>
            </div>
        </div>
    </section>
@endif

@foreach($wish->wishDetails->offers as $key => $offer)
    <section class="section-angebote-2" id="angebote">
        <div class="container">
            <div class="col-md-12 sa2-1">
                <h4>Angebot {{ $key+1 }}</h4>
                <p class="sa2-p2">
                    @if (count($wish->agent_name) > 0)
                        <span class="offer-avatar-cnt">
                            <img class="avatar" title="{{ $wish->agent_name[0]->name }}" alt="{{ $wish->agent_name[0]->name }}" src="{{ Storage::disk('s3')->url('img/agent/') }}{{ $wish->agent_name[0]->avatar }}" />
                            <span class="agent-name">{{ $wish->agent_name[0]->name }}</span>
                        </span>
                    @else
                        @if($wish->agent)
                            <span class="offer-avatar-cnt">
                                <img class="avatar" title="{{ $wish->agent->name }}" alt="{{ $wish->agent->name }}" src="{{ Storage::disk('s3')->url('img/agent/') }}{{ $wish->agent->avatar }}" />
                                <span class="agent-name">{{ $wish->agent->name }}</span>
                            </span>
                        @endif
                    @endif
                    <b>{{ $offer->title }}</b><br>
                    {!! nl2br(e($offer->description)) !!}
                    @if ($offer->link)
                        <br><br>
                        <b>Hier geht es zu unserer Angebotsseite:</b> <a href="{{ (strpos($offer->link,'https://') === false && strpos($offer->link,'http://') === false) ? 'https://'.$offer->link : $offer->link }}" target="_blank" rel="noopener noreferrer">{{ $offer->link }}</a>
                    @endif
                </p>
            </div>
        </div>
    </section>
    @if (count($wish->offerFiles) > 0&& isset($wish->offerFiles[$key]) && count($wish->offerFiles[$key]) > 0)
        <section class="section-angebote-download">
            <div class="container">
                <div class="col-md-12">
                    <hr class="sad-hr">
                </div>
                <div class="col-md-12 sa-2">
                    @foreach($wish->offerFiles[$key] as $key => $file)
                        <div class="col-md-4">
                            @if (strpos($file->file, '.pdf') !== false)
                                <i class="fal fa-file-pdf"></i>
                            @else
                                <i class="fal fa-file-image"></i>
                            @endif

                            <a href="{{ Storage::disk('s3')->url('img/offer/' . $file->file) }}" target="_blank">{{ trans('wish.view.offer_number') }} {{ $key+1 }}</a>
                        </div>
                    @endforeach
                </div>
                @if ($logged_in_user['role'] === "User" && count($wish->wishDetails->offers) < ($key - 1))
                    <div class="col-md-12">
                        <hr class="sad-hr">
                    </div>
                @endif
            </div>
        </section>
    @endif
    <div class="container">
        <div class="col-md-12">
            <hr class="sad-hr">
        </div>
    </div>
@endforeach

@if (count($wish->wishDetails->offers) > 0 && $logged_in_user['role'] === "User")
    <div class="container">
        <div class="col-md-12 sa-2">
            <div class="sa-buttons">
                <button class="primary-btn{{ $contactInactivClass }}" data-toggle="modal" data-target="#contact_modal">{{ trans('wish.details.kontakt-button') }}</button>
                <button class="secondary-btn{{ $callbackInactivClass }}" data-toggle="modal" data-target="#callback">{{ trans('wish.details.callback-button') }}</button>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="col-md-12">
            <hr class="sad-hr">
        </div>
    </div>
@endif

@if (count($wish->wishDetails->offers) === 0 && $logged_in_user['role'] === "Seller" && count($wish->wishDetails->contacts) === 0)
    <div class="container">
        <div class="col-md-12">
            <p>&nbsp;</p>
        </div>
    </div>
@endif

<section class="section-comments" id="messages">
    <div class="container">
        <div class="col-md-12">
            <h4>
                Neue Nachrichten <i class="fal fa-bell ml-5"></i>
            </h4>
            <chat-messages :wishid="{{ $wish->wish_id }}" :userid="{{ $logged_in_user['id'] }}" :groupid="{{ $wish->group_id }}">
            </chat-messages>
        </div>
    </div>
</section>

<section class="section-contact">
    <div class="container d-flex flex-wrap">
        <div class="col-md-6 s2-first">
            @if ($logged_in_user['role'] == 'Seller')
                <h4>{{ trans('wish.details.subheadline.customer_wish') }}</h4>
                <p>{{ trans('wish.details.subheadline.customer_wish_sub') }}</p>
                <p><strong>{{ trans('wish.details.subheadline.customer_wish_description') }}</strong></p>
                <p>{{ $wish->description }}</p>
            @else
                <h4>{{ trans('wish.details.subheadline.your_wish') }}</h4>
                <p>{{ trans('wish.details.subheadline.your_wish_sub') }}</p>
                <p><strong>{{ trans('wish.details.subheadline.your_wish_description') }}</strong></p>
                <p>{{ $wish->description }}</p>
            @endif
        </div>
        @include('frontend.wishes.partial.wish-user-details')
    </div>
</section>

<div id="contact_modal" class="modal wish-modal fade" role="dialog">
    @include('frontend.wishes.partial.wish-contact-modal')
</div>

<div id="callback" class="modal wish-modal fade" role="dialog">
    @include('frontend.wishes.partial.wish-callback-modal')
</div>
@endsection

@section('footer')
    @include('frontend.whitelabel.footer')
@endsection

@section('after-scripts')
<script type="application/javascript">

    function scrollToAnchor(id) {
        $('html, body').animate({
            scrollTop: $("#" + id).offset().top - 75
        }, 1000);
    }

    function isEllipsisActive(element) {
        return (element.offsetWidth < element.scrollWidth);
    }

    $(document).ready(function() {
        if(!isEllipsisActive(document.getElementById("departure-mousehover-value"))) {
            document.getElementById("departure-mousehover").remove();
        }
        if(!isEllipsisActive(document.getElementById("arrival-mousehover-value"))) {
            document.getElementById("arrival-mousehover").remove();
        }
    });
</script>
@endsection
