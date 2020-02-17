@extends('frontend.layouts.app')

@section('title')
{{ trans('wish.details.tab_title') }}
@endsection

@section('before-scripts')
<script type="application/javascript">
    var brandColor = {!!json_encode(getCurrentWhiteLabelColor()) !!};
</script>
@endsection

@section('after-scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            function isEllipsisActive(element) {
                return (element.offsetWidth < element.scrollWidth);
            }

            if(!isEllipsisActive(document.getElementById("departure-mousehover-value"))) {
                document.getElementById("departure-mousehover").remove();
            }
            if(!isEllipsisActive(document.getElementById("arrival-mousehover-value"))) {
                document.getElementById("arrival-mousehover").remove();
            }
        });

    </script>
@endsection

@section('content')

<section class="section-top">
  <div class="img-background">
    <div class="container">
      <div class="col-md-8 bg-left-content">
        @if ($logged_in_user && ($logged_in_user['role'] === "Seller" || $logged_in_user['role'] === "Executive"))
        <!-- TODO: Get the active agent somehow -->
        <h3>Hallo {{ $logged_agent }},</h3>
        @elseif ($logged_in_user['role'] == ('User') && $wish->owner->last_name !== trans('user.default.last_name'))
        <h3>Hallo {{ $wish->owner->first_name }} {{ $wish->owner->last_name }},</h3>
        @elseif ($logged_in_user['role'] == ('User') && $wish->owner->first_name)
        <h3>Hallo lieber Kunde,</h3>
        @else
        <h3>Hallo,</h3>
        @endif

        @if ($logged_in_user['role'] = ('Seller'))
        <p class="header-p">{!! trans('wish.view.stage.seller_empty',['date' =>
          \Carbon\Carbon::parse($wish->created_at)->format('d.m.Y')]) !!}</p>
        <a href="{{route('frontend.offers.create', ['id' => $wish->id, 'subdomain' => $subdomain])}}"
          class="primary-btn">{{ trans('buttons.wishes.frontend.create_offer')}}</a>
        @elseif (count($wish->offers) > 0)
        <p class="header-p">{!! trans('wish.view.stage.user_offer',['date' =>
          \Carbon\Carbon::parse($wish->created_at)->format('d.m.Y'), 'seller' => $wish->group->users[0]->name]) !!}</p>
        <button class="primary-btn{{ $contactInactivClass }}"
          onclick="scrollToAnchor('angebote')">{{ trans_choice('wish.details.view-offers-button', count($wish->offers), ['count' => count($wish->offers)]) }}</button>
        @elseif (count($wish->messages) > 0 && $wish->messages[count($wish->messages)-1]->user_id !== Auth::user()->id)
        <p class="header-p">{!! trans('wish.view.stage.user_message',['date' =>
          \Carbon\Carbon::parse($wish->created_at)->format('d.m.Y'), 'seller' => $wish->group->users[0]->name]) !!}</p>
        <button class="primary-btn{{ $contactInactivClass }}"
          onclick="scrollToAnchor('messages')">{{ trans('wish.details.view-messages-button') }}</button>
        @else
        @php
        $actionButtonsSet = true;
        @endphp
        <p class="header-p">{!! trans('wish.view.stage.user_empty',['date' =>
          \Carbon\Carbon::parse($wish->created_at)->format('d.m.Y'), 'seller' => $wish->group->users[0]->name]) !!}</p>
        <button class="primary-btn{{ $contactInactivClass }}" data-toggle="modal"
          data-target="#contact_modal">{{ trans('wish.details.kontakt-button') }}</button>
        <button class="secondary-btn{{ $callbackInactivClass }}" data-toggle="modal"
          data-target="#callback">{{ trans('wish.details.callback-button') }}</button>
        @endif
      </div>
    </div>
  </div>
</section>

<section class="section-comments" id="messages">
  <div class="container">
    <div class="col-md-12">
      <h4>
        Neue Nachrichten <i class="fal fa-bell"></i>
      </h4>
      <chat-messages :wishid="{{ $wish->id }}" :userid="{{ $logged_in_user['id'] }}" :groupid="{{ $wish->group_id }}">
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
                <p><b>{{ trans('wish.details.subheadline.customer_wish_description') }}</b><br>
                    {{ $wish->description }}
                </p>
            @else
                <h4>{{ trans('wish.details.subheadline.your_wish') }}</h4>
                <p>{{ trans('wish.details.subheadline.your_wish_sub') }}</p>
                <p><b>{{ trans('wish.details.subheadline.your_wish_description') }}</b><br>
                    {{ $wish->description }}
                </p>
            @endif
        </div>
        @include('frontend.wishes.partial.wish-user-details')
    </div>
</section>

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
      {{ Form::open(['route' => ['frontend.contact.store', $subdomain], 'class' => 'form-horizontal contact_form', 'role' => 'form', 'method' => 'POST', 'id' => 'contact-seller']) }}
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
            <textarea name="message" id="modal-textarea" class="form-control"
              placeholder="@lang('modals.callback.message')"></textarea>
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
      {{ Form::open(['route' => ['frontend.contact.storecallback', $subdomain], 'class' => 'form-horizontal contact_form', 'role' => 'form', 'method' => 'POST', 'id' => 'callback-seller']) }}
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
            <img src="/img/travel-agency.jpg" alt="travel agency">
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
    scrollTop: $("#" + id).offset().top - 75
  }, 1000);
}
</script>

@endsection
