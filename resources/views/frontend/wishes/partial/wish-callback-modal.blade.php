<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="alert alert-success alert-dismissible fade" role="alert">
            <span class="text"></span>
            <a class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </a>
        </div>
        {{ Form::open(['route' => ['frontend.contact.storecallback', $subdomain], 'class' => 'form-horizontal contact_form', 'role' => 'form', 'method' => 'POST', 'id' => 'callback-seller']) }}
        <div class="modal-header d-flex flex-column">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">@lang('modals.callback.title')</h4>
            <p>@lang('modals.callback.sub_title1')<br>
                @lang('modals.callback.sub_title2')
            </p>
        </div>
        <div class="modal-body">
            <div class="container d-flex flex-wrap">
                <div class="col-md-8 modal-body-left">
                    <div class="form-group float-label">
                        <input type="text" class="form-control name" name="first_name" id="first_name_" placeholder="transparent" value="{{ isset($wish->wishDetails->owner->first_name) ? $wish->wishDetails->owner->first_name : '' }}" required>
                        <label for="first_name_">@lang('modals.callback.first_name')</label>
                    </div>
                    <div class="form-group float-label">
                        <input type="text" class="form-control nachname" name="last_name" id="last_name_" placeholder="transparent" value="{{ isset($wish->wishDetails->owner->last_name) ? $wish->wishDetails->owner->last_name : '' }}" required>
                        <label for="last_name_">@lang('modals.callback.last_name')</label>
                    </div>
                    <div class="form-group float-label">
                        <input type="text" class="form-control tel" name="telephone" id="telephone_" placeholder="transparent" required>
                        <label for="telephone_">@lang('modals.callback.tel')</label>
                    </div>
                    <div class="form-group float-label">
                        <select name="period" id="period_" class="form-control">
                            <option value="">@lang('modals.callback.duration')</option>
                            <option value="vormittags" id="">@lang('modals.callback.mornings')</option>
                            <option value="nachmittags" id="">@lang('modals.callback.afternoons')</option>
                            <option value="abends" id="">@lang('modals.callback.evenings')</option>
                        </select>
                    </div>
                    <input type="hidden" name="wish_id" value="{{ $wish->wish_id }}" />
                    <input type="hidden" name="subject" value="no data" />
                    <input type="hidden" name="message" value="no data" />
                    <input type="hidden" name="email" value="no data" />
                    <button type="submit" class="primary-btn">@lang('modals.callback.send')</button>
                </div>

                @if($hasOffers || $hasNewMessage)
                    <div class="col-md-4 modal-body-right">
                        <img title="{{ $wish->wishDetails->lastAgent->name }}" alt="{{ $wish->wishDetails->lastAgent->name }}" src="{{ Storage::disk('s3')->url('img/agent/') }}{{ $wish->wishDetails->lastAgent->avatar }}" />
                        <h4>{{ $wish->wishDetails->lastAgent->name }}</h4>
                        <div class="modal-contact">
                            <div class="mc-tel">
                                <i class="fal fa-phone"></i>
                                <a href="tel:{{ $wish->wishDetails->lastAgent->telephone }}">{{ $wish->wishDetails->lastAgent->telephone }}</a>
                            </div>
                            <div class="mc-mail">
                                <i class="fal fa-envelope"></i>
                                <a href="mailto:{{ $wish->wishDetails->lastAgent->email }}">{{ $wish->wishDetails->lastAgent->email }}</a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-md-4 modal-body-right">
                        <img src="/img/travel-agency.jpg" alt="travel agency">
                        <h4>{{ $wish->wishDetails->group->users[0]->name }}</h4>
                        <p>{{ $wish->wishDetails->group->users[0]->address }}<br>
                            {{ $wish->wishDetails->group->users[0]->zip_code }} {{ $wish->wishDetails->group->users[0]->city }}
                        </p>
                        <div class="modal-contact">
                            <div class="mc-mail">
                                <i class="fal fa-envelope"></i>
                                <a href="mailto:{{ $wish->wishDetails->group->users[0]->email }}">{{ $wish->wishDetails->group->users[0]->email }}</a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="modal-footer">
        </div>
        {{ Form::close() }}
    </div>
</div>
