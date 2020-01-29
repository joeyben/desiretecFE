@extends('frontend.layouts.app')

@section('title')
     {{ trans('wish.details.tab_title') }}
@endsection

@section('before-scripts')
    <script type="application/javascript">
        var brandColor = {!! json_encode(getCurrentWhiteLabelColor()) !!};
    </script>
@endsection

<link media="all" type="text/css" rel="stylesheet" href="https://mvp.desiretec.com/fontawsome/css/all.css">

@section('content')

    <section class="section-top">

        <div class="img-background">
            <div class="container">
                <div class="col-md-8 bg-left-content">
                        <h3 style="color:#000">Hallo Max Mustermann,</h3>

                        <p class="header-p">Der Reisewunsch wurde am 20.12.2019 an Sie übermittelt. Erstellen Sie jetzt ein Angebot.</p>
                        <a href="{{route('frontend.offers.create', $wish->id)}}" class="primary-btn">{{ trans('buttons.wishes.frontend.create_offer')}}</a>
                </div>
            </div>
        </div>

         <div class="bg-bottom">
                <div class="container">
                    <h4>Kontaktdaten des Kunden</h4>
                    <div class="row">
                        <div class="col-md-3 c-info">
                            <i class="fal fa-pencil"></i>
                            <span style="color:#636b6f">Kontakt</span>
                        </div>
                        <div class="col-md-3 c-info">
                            <i class="fas fa-user"></i>
                            <span style="color:#636b6f">Reisewunschportal Kunde</span>
                        </div>
                        <div class="col-md-3 c-info c-tel">
                            <i class="fas fa-phone"></i>
                            <a href="tel:95996499">95996499</a>
                        </div>
                        <div class="col-md-3 c-info">
                            <i class="fas fa-envelope"></i>
                            <a href="mailto:jo.leisch+mbvmddm@gmail.com">jo.leisch+mbvmddm@gmail.com</a>
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
                                dkaskagkas
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
    </section>

        <section class="section-angebote-2" id="angebote">
            <div class="container">
                <div class="col-md-12 sa2-1">
                    <h4>
                        {{ trans('wish.view.new_offers') }}
                    </h4>
                    <p class="sa2-p1">
                            erstellt
                    </p>
                </div>
            </div>
        </section>

        <section class="section-angebote-2" id="angebote">
            <div class="container">
                <div class="col-md-12 sa2-1">
                    <h4>Angebot</h4>
                    <p class="sa2-p2">
                    <span class="offer-avatar-cnt">
                        <img class="avatar" title="" alt="" src="" />
                        <span class="agent-name"></span>
                    </span>
                        <b></b><br>
                    </p>
                </div>
            </div>
        </section>

        <div class="container">
            <div class="col-md-12">
                <hr class="sad-hr">
            </div>
        </div>

    <section class="section-comments" id="messages">
        <div class="container">
            <div class="col-md-12">
                <h4>
                    Neue Nachrichten <span class="glyphicon glyphicon-bell"></span>
                </h4>
                <chat-messages :wishid="{{ $wish->id }}"></chat-messages>
            </div>
    </section>

        <div class="container">
            <div class="col-md-12">
                <hr class="sad-hr">
            </div>
        </div>

        <div class="container">
            <div class="col-md-12 sa-2">
                <div class="sa-buttons">
                    <button class="primary-btn" data-toggle="modal" data-target="#contact_modal">{{ trans('wish.details.kontakt-button') }}</button>
                    <button class="secondary-btn" data-toggle="modal" data-target="#callback">{{ trans('wish.details.callback-button') }}</button>
                </div>
            </div>
        </div>

    <div class="container">
        <div class="col-md-12">
            <hr class="sad-hr">
        </div>
    </div>

    <section class="section-contact">
        <div class="container">
            @include('frontend.wishes.partial.wish-user-details')
        </div>

    </section>

    <section class="section-contact-mobile">
        <div class="container">

            <div class="panel-group" id="accordion1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion1" href="#content">
                                <div class="col-md-12 s2-first">
                                    <h4>{{ trans('wish.details.subheadline.your_wish') }}</h4>
                                    <p>{{ trans('wish.details.subheadline.your_wish_sub') }}</p>
                                </div>
                                <i class="fal fa-plus"></i>
                                <i class="fal fa-minus"></i>
                        </h4>
                    </div>

                    <div id="content" class="panel-collapse collapse">
                        <div class="panel-body">

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>


    <div class="container">
        <div class="col-md-12">
            <hr class="sad-hr">
        </div>
    </div>

    {{-- @include('frontend.wishes.partials.faq') --}}

    <!-- Modal -->
    <div id="contact_modal" class="modal wish-modal-1 fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="alert alert-success alert-dismissible fade" role="alert">
                    <span class="text"></span>
                    <a class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                {{ Form::open(['route' => 'frontend.contact.store', 'class' => 'form-horizontal contact_form', 'role' => 'form', 'method' => 'POST', 'id' => 'contact-seller']) }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ trans('wish.contact.title') }}</h4>
                    <p>{!! trans('wish.contact.text') !!}</p>
                </div>

                <div class="modal-body">
                    <div class="container-fluid">
                        <p class="statusMsg"></p>
                        <div class="col-md-8 modal-body-left">

                            <div class="group">
                                <input type="text" class="form-control name" name="first_name" id="first_name" value="" required>
                                <label>@lang('modals.callback.first_name')</label>
                            </div>
                            <div class="group">
                                <input type="text" class="form-control nachname" name="last_name" id="last_name" value="" required>
                                <label>@lang('modals.callback.last_name')</label>
                            </div>
                            <div class="group">
                                <input type="text" class="form-control email" name="email" id="email" required value="">
                                <label>@lang('modals.callback.email')</label>
                            </div>
                            <div class="group">
                                <input type="text" class="form-control tel not-required" name="telephone" id="telephone" value="">
                                <label>@lang('modals.callback.tel_opt')</label>
                            </div>
                            <div class="group">
                                <input type="text" class="form-control betreff" name="subject" id="subject" required autocomplete="off">
                                <label>@lang('modals.callback.subject')</label>
                            </div>

                        </div>


                        <div class="col-md-12 modal-body-bottom">
                            <textarea name="message" id="modal-textarea" class="form-control" placeholder="@lang('modals.callback.message')"></textarea>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <input type="hidden" name="wish_id" value="{{ $wish->id }}" />
                    <input type="hidden" name="period" value="no data" />
                    <input type="submit" class="primary-btn wm-1-btn" value="Nachricht absenden" />
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <div id="callback" class="modal wish-modal-1 fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="alert alert-success alert-dismissible fade" role="alert">
                    <span class="text"></span>
                    <a class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                {{ Form::open(['route' => 'frontend.contact.storecallback', 'class' => 'form-horizontal contact_form', 'role' => 'form', 'method' => 'POST', 'id' => 'callback-seller']) }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">@lang('modals.callback.title')</h4>
                    <p>@lang('modals.callback.sub_title1')<br>
                        @lang('modals.callback.sub_title2')
                    </p>
                </div>

                <div class="modal-body">
                    <div class="container-fluid">

                        <div class="col-md-8 modal-body-left">

                            <div class="group">
                                <input type="text" class="form-control name" name="first_name" id="first_name_" value="" required>
                                <label>@lang('modals.callback.first_name')</label>
                            </div>
                            <div class="group">
                                <input type="text" class="form-control nachname" name="last_name" id="last_name_" value="" required>
                                <label>@lang('modals.callback.last_name')</label>
                            </div>
                            <div class="group">
                                <input type="text" class="form-control tel" name="telephone" id="telephone_" required>
                                <label>@lang('modals.callback.tel')</label>
                            </div>
                            <div class="group">
                                <select name="period" id="period_" class="form-control">
                                    <option value="">@lang('modals.callback.duration')</option>
                                    <option value="vormittags" id="">@lang('modals.callback.mornings')</option>
                                    <option value="nachmittags" id="">@lang('modals.callback.afternoons')</option>
                                    <option value="abends" id="">@lang('modals.callback.evenings')</option>
                                </select>
                            </div>

                            <input type="hidden" name="wish_id" value="{{ $wish->id }}" />
                            <input type="hidden" name="subject" value="no data" />
                            <input type="hidden" name="message" value="no data" />
                            <input type="hidden" name="email" value="no data" />

                            <button type="submit" class="primary-btn wm-2-btn">@lang('modals.callback.send')</button>
                        </div>

                        <div class="col-md-4 modal-body-right">
                            <img src="/img/frontend/profile-picture/travel-agency.jpg" alt="">
                            <h4></h4>
                            <p>{<br>

                            </p>
                            <div class="modal-contact">
                                <div class="mc-tel">
                                    <span class="glyphicon glyphicon-earphone"></span>
                                    <a href="tel:08971459535"></a>
                                </div>
                                <div class="mc-mail">
                                    <span class="glyphicon glyphicon-envelope"></span>
                                    <a href="mailto:mail@reisebuero.de"></a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">

                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection

@section('after-scripts')

    <script type="application/javascript">
        function scrollToAnchor(id) {
            $('html, body').animate({
                scrollTop: $("#"+id).offset().top - 75
            }, 1000);
        }
    </script>
@endsection
