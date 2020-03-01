<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="alert alert-success alert-dismissible fade" role="alert">
            <span class="text"></span>
            <a class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </a>
        </div>
        {{ Form::open(['route' => ['frontend.contact.store', $subdomain], 'class' => 'form-horizontal contact_form', 'role' => 'form', 'method' => 'POST', 'id' => 'contact-seller']) }}
        <div class="modal-header d-flex flex-column">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">{{ trans('wish.contact.title') }}</h4>
            <p>{!! trans('wish.contact.text') !!}</p>
        </div>
        <div class="modal-body">
            <div class="container d-flex flex-wrap">
                <p class="statusMsg"></p>
                <div class="col-md-8 modal-body-left">
                    <div class="form-group float-label">
                        <input type="text" class="form-control name" name="first_name" id="first_name" placeholder="transparent" value="" required>
                        <label for="first_name">@lang('modals.callback.first_name')</label>
                    </div>
                    <div class="form-group float-label">
                        <input type="text" class="form-control nachname" name="last_name" id="last_name" placeholder="transparent" value="" required>
                        <label for="last_name">@lang('modals.callback.last_name')</label>
                    </div>
                    <div class="form-group float-label">
                        <input type="text" class="form-control email" name="email" id="email" placeholder="transparent" value="" required>
                        <label for="email">@lang('modals.callback.email')</label>
                    </div>
                    <div class="form-group float-label">
                        <input type="text" class="form-control tel not-required" name="telephone" id="telephone" placeholder="transparent" value="">
                        <label for="telephone">@lang('modals.callback.tel_opt')</label>
                    </div>
                    <div class="form-group float-label">
                        <input type="text" class="form-control betreff" name="subject" id="subject" placeholder="transparent" autocomplete="off" required>
                        <label for="subject">@lang('modals.callback.subject')</label>
                    </div>
                </div>

                @if(count($wish->wishDetails->offers) > 0 || (isset($wish->wishDetails->sellerMessages) && count($wish->wishDetails->sellerMessages) > 0 ))
                    <div class="col-md-4 modal-body-right">
                        <img title="{{ $wish->agent->name }}" alt="{{ $wish->agent->name }}" src="{{ Storage::disk('s3')->url('img/agent/') }}{{ $wish->agent->avatar }}" />
                        <h4>{{ $wish->agent->name }}</h4>
                        <div class="modal-contact">
                            <div class="mc-tel">
                                <i class="fal fa-phone"></i>
                                <a href="tel:{{ $wish->agent->telephone }}">{{ $wish->agent->telephone }}</a>
                            </div>
                            <div class="mc-mail">
                                <i class="fal fa-envelope"></i>
                                <a href="mailto:{{ $wish->agent->email }}">{{ $wish->agent->email }}</a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-md-4 modal-body-right">
                        <img src="/img/travel-agency.jpg" alt="">
                        <h4>{{ $wish->wishDetails->group->users[0]->name }}</h4>
                        <p>{{ $wish->wishDetails->group->users[0]->address }}<br>
                            {{ $wish->wishDetails->group->users[0]->zip_code }} {{ $wish->wishDetails->group->users[0]->city }}
                        </p>
                        <div class="modal-contact">
                            <div class="mc-mail">
                                <span class="glyphicon glyphicon-envelope"></span>
                                <a href="mailto:{{ $wish->wishDetails->group->users[0]->email }}">{{ $wish->wishDetails->group->users[0]->email }}</a>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="col-md-12 modal-body-bottom">
                    <div class="form-group float-label">
                        <textarea name="message" class="form-control" id="modal-textarea" placeholder="transparent"></textarea>
                        <label for="modal-textarea">@lang('modals.callback.message')</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <input type="hidden" name="wish_id" value="{{ $wish->wish_id }}" />
            <input type="hidden" name="period" value="no data" />
            <input type="submit" class="primary-btn" value="Nachricht absenden" />
        </div>
        {{ Form::close() }}
    </div>
</div>
