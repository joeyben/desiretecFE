@extends('frontend.layouts.app')

@section('title')
    {{ trans('wish.details.tab_title') }}
@endsection

@section('before-scripts')
    <script type="application/javascript">
        var brandColor = {!!json_encode(getCurrentWhiteLabelColor()) !!};
    </script>
@endsection

@php
    $contactInactivClass = count($wish->wishDetails->contacts) ? "" : "";
    $callbackInactivClass = count($wish->wishDetails->callbacks) ? "" : "";
    $actionButtonsSet = false;
    $hasOffers = count($wish->wishDetails->offers) > 0;
    $hasNewMessage = isset($wish->wishDetails->messages) && count($wish->wishDetails->messages) > 0 && $wish->wishDetails->messages[count($wish->wishDetails->messages)-1]->user_id !== $logged_in_user['id'];
    $wish->layer_image = $wish->layer_image ?? 'https://i.imgur.com/lJInLa9.png';
@endphp

@section('content')
    <section class="section-top">
        <div class="img-background" style="background-image: url('<?php echo $wish->layer_image; ?>')">
            <div class="overlay"></div>
            <div class="container">
                <div class="col-md-8 bg-left-content">
                    @if ($logged_in_user && ($logged_in_user['role'] === "Seller" || $logged_in_user['role'] === "Executive"))
                        <h3>{{ trans('wishes.details.hello') }} {{ $currentAgent['name'] }}</h3>
                    @elseif ($logged_in_user['role'] == ('User') && $wish->last_name !== trans('user.default.last_name'))
                        <h3>{{ trans('wishes.details.hello') }} {{ $wish->first_name }} {{ $wish->last_name }},</h3>
                    @elseif ($logged_in_user['role'] == ('User') && $wish->first_name)
                        <h3>{{ trans('wishes.details.hello_user') }},</h3>
                    @else
                        <h3>{{ trans('wishes.details.hello') }},</h3>
                    @endif

                    @if ($logged_in_user['role'] == ('Seller'))
                        <p class="header-p mb-30">{!! trans('wish.view.stage.seller_empty',['date' => \Carbon\Carbon::parse($wish->wishDetails->created_at)->format('d.m.Y')]) !!}</p>
                        <a href="{{route('frontend.offers.create', ['id' => $wish->wish_id, 'subdomain' => $subdomain])}}" class="primary-btn">{{ trans('buttons.wishes.frontend.create_offer')}}</a>
                    @elseif ($hasOffers)
                        <p class="header-p">{!! trans('wish.view.stage.user_offer',['date' => \Carbon\Carbon::parse($wish->wishDetails->created_at)->format('d.m.Y'), 'seller' => (isset($wish->wishDetails->group) ? $wish->wishDetails->group->users[0]->name : '' )]) !!} </p>
                        <button class="primary-btn{{ $contactInactivClass }}" onclick="scrollToAnchor('angebote')">{{ trans_choice('wish.details.view-offers-button', count($wish->wishDetails->offers), ['count' => count($wish->wishDetails->offers)]) }}</button>
                    @elseif ($hasNewMessage)
                        <p class="header-p">{!! trans('wish.view.stage.user_message',['date' => \Carbon\Carbon::parse($wish->wishDetails->created_at)->format('d.m.Y'), 'seller' => $wish->wishDetails->group->users[0]->name]) !!} </p>
                        <button class="primary-btn{{ $contactInactivClass }}" onclick="scrollToAnchor('messages')">{{ trans('wish.details.view-messages-button') }}</button>
                    @else
                        @php
                            $actionButtonsSet = true;
                        @endphp
                        <p class="header-p">{!! trans('wish.view.stage.user_empty',['date' => \Carbon\Carbon::parse($wish->wishDetails->created_at)->format('d.m.Y'), 'seller' => (isset($wish->wishDetails->group) ? $wish->wishDetails->group->users[0]->name : '')]) !!} </p>
                        <button class="primary-btn{{ $contactInactivClass }}" data-toggle="modal" data-target="#contact_modal">{{ trans('wish.details.kontakt-button') }}</button>
                        <button class="secondary-btn{{ $callbackInactivClass }}" data-toggle="modal" data-target="#callback">{{ trans('wish.details.callback-button') }}</button>
                    @endif
                </div>
            </div>
        </div>
    </section>

    @if ($logged_in_user['role'] === "User" || ($logged_in_user['role'] === "Seller" && count($wish->wishDetails->contacts)))
        <section class="section-contact-data">
            <div class="container">
                <div class="col-md-12 d-flex flex-wrap align-items-start justify-content-start">
                    @include('frontend.wishes.partial.wish-contact-data')
                </div>
            </div>
        </section>

        <div class="container">
            <div class="col-md-12">
                <hr class="sad-hr">
            </div>
        </div>
    @endif

    @if ($hasOffers)
        <section class="section-angebote-2" id="angebote">
            <div class="container">
                <div class="col-md-12 sa2-1">
                    <h4>{{ trans('wish.view.new_offers') }}</h4>
                    <p class="sa2-p1">{{ trans_choice('wish.view.offers_title_count', count($wish->wishDetails->offers), ['count' => count($wish->wishDetails->offers)]) }}
                        @if ($logged_in_user['role'] === "Seller")
                            {{ trans('wish.view.offer_created') }}
                        @else
                            {{ trans('wish.view.offer_received') }}
                        @endif
                    </p>
                </div>
            </div>
        </section>

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
                                <b>{{ trans('wish.link.offer_site') }}</b> <a href="{{ (strpos($offer->link,'https://') === false && strpos($offer->link,'http://') === false) ? 'https://'.$offer->link : $offer->link }}" target="_blank" rel="noopener noreferrer">{{ $offer->link }}</a>
                            @endif
                        </p>
                    </div>
                </div>
            </section>
            @if (count($wish->offerFiles) > 0&& isset($wish->offerFiles[$key]) && count($wish->offerFiles[$key]) > 0)
                <section class="section-angebote-download">
                    <div class="container">
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
    @endif


    @if ($logged_in_user['role'] === "User" && ($hasOffers || $hasNewMessage))
        <section class="section-contact-buttons">
            <div class="container">
                <div class="col-md-12 sa-2">
                    <div class="sa-buttons">
                        <button class="primary-btn{{ $contactInactivClass }}" data-toggle="modal" data-target="#contact_modal">{{ trans('wish.details.kontakt-button') }}</button>
                        <button class="secondary-btn{{ $callbackInactivClass }}" data-toggle="modal" data-target="#callback">{{ trans('wish.details.callback-button') }}</button>
                    </div>
                </div>
            </div>
        </section>

        <div class="container">
            <div class="col-md-12">
                <hr class="sad-hr">
            </div>
        </div>
    @endif

    @php
        $translations = [
            "new_message" => trans('wish.details.message.new_message'),
            "me" => trans('wish.details.message.me'),
            "write_message" => trans('wish.details.message.write_message'),
            "save" => trans('wish.details.message.save'),
            "local" => "en"
        ];
        $statusesTrans = array();
    @endphp

    <section class="section-comments" id="messages">
        <div class="container">
            <div class="col-md-12">
                <h4>
                    {{ trans('wish.details.message.new_message') }} <i class="fal fa-bell ml-5"></i>
                </h4>
                <chat-messages :words-trans="{{ json_encode($translations) }}" :wishid="{{ $wish->wish_id }}" :userid="{{ $logged_in_user['id'] }}" :groupid="{{ $wish->group_id }}">
                </chat-messages>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="col-md-12">
            <hr class="sad-hr">
        </div>
    </div>

    <section class="section-contact">
        <div class="container d-flex flex-wrap">
            <div class="col-md-6 s2-first">
                @if ($logged_in_user['role'] == 'Seller' && $wish->description)
                    <h4>{{ trans('wish.details.subheadline.customer_wish') }}</h4>
                    <p>{{ trans('wish.details.subheadline.customer_wish_sub') }}</p>
                    <p><strong>{{ trans('wish.details.subheadline.customer_wish_description') }}</strong></p>
                    <p>{{ $wish->description }}</p>
                @elseif ($wish->description)
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
            if($('#departure-mousehover-value') && !isEllipsisActive(document.getElementById('departure-mousehover-value'))) {
                document.getElementById('departure-mousehover').remove();
            }
            if($('#arrival-mousehover-value').length > 0 && !isEllipsisActive(document.getElementById('arrival-mousehover-value'))) {
                document.getElementById('arrival-mousehover').remove();
            }
        });

        $(document).on('submit', 'form.contact_form', function (event) {
            event.preventDefault();
            var form = $(this);
            var data = form.serializeArray();
            var url = form.attr("action");
            var this_modal = form.parents('.modal');
            $.ajax({
                type: form.attr('method'),
                url: url,
                data: data,
                success: function(data){
                    if(data.success){
                        $('#first_name').val('');
                        $('#last_name').val('');
                        $('#email').val('');
                        $('#telephone').val('');
                        $('#subject').val('');
                        $('#message').val('');
                        this_modal.find('.alert-success').removeClass('fade').find('.text').text(data.message);
                        window.setTimeout(function(){
                            this_modal.modal('toggle');
                            this_modal.find('.alert-success').addClass('fade');
                        }, 3000);
                    }
                },
                error: function (xhr, textStatus, errorThrown) {
                    alert("Error: " + errorThrown);
                }
            });
            return false;
        });
    </script>
@endsection
