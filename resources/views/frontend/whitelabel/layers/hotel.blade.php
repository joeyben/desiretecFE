@php
    $layerName = 'hotel';
@endphp

<div id="{{ $layerName }}" class="td-tab-content">

    <div class="kwp-header-dynamic">
        <div class="kwp-color-overlay"></div>
        <div class="kwp-logo"></div>
        <div class="kwp-header-text"><h1></h1></div>
    </div>

    {{ Form::open() }}

    {{ Form::hidden('airport', '-') }}
    {{ Form::hidden('category', 0) }}
    {{ Form::hidden('budget', 0) }}

    <div class="kwp-middle"></div>

    <div class="kwp-minimal">
        <div class="kwp-content kwp-with-expansion">
            <div class="kwp-row">
                <div class="kwp-col-4 destination">
                    {{ Form::label('destination', trans('layer.general.destination'), ['class' => 'control-label required']) }}
                    {{ Form::text('destination', key_exists('destination', $request) ? $request['destination'] : null, ['class' => 'form-control box-size','autocomplete' => "off", 'placeholder' => trans('layer.placeholder.destination'), 'required' => 'required']) }}
                    <i class="fal fa-globe-europe"></i>
                    @if ($errors->any() && $errors->get('destination'))
                        @foreach ($errors->get('destination') as $error)
                            <span class="error-input">{{ $error }}</span>
                            <script>
                                dt.Tracking.rawEvent(whitelabelPrefix+'_exitwindow', 'Error on destination', '{{ $error }}');
                            </script>
                        @endforeach
                    @endif
                </div>

                <div class="kwp-col-4 duration-col main-col">
                    <div class="kwp-form-group duration-group duration-group">
                        <label for="duration-time" class="required">{{ trans('layer.general.duration') }}</label>
                        <span class="duration-time duration-time dd-trigger">
                            <span class="txt">15.11.2018 - 17.06.2019, 1 Woche</span>
                            <i class="fal fa-calendar-alt not-triggered"></i>
                            <i class="fal fa-times triggered"></i>
                        </span>
                        <div class="duration-more duration-more">
                            <div class="kwp-col-4">
                                {{ Form::label('earliest_start', trans('layer.general.earliest_start'), ['class' => 'control-label required']) }}
                                {{ Form::text('earliest_start', key_exists('earliest_start', $request) ? $request['earliest_start'] : null, ['class' => 'form-control box-size', 'placeholder' => trans('layer.general.earliest_start'), 'required' => 'required', 'readonly']) }}
                                @if ($errors->any() && $errors->get('earliest_start'))
                                    @foreach ($errors->get('earliest_start') as $error)
                                        <span class="error-input">{{ $error }}</span>
                                        <script>
                                            dt.Tracking.rawEvent(whitelabelPrefix+'_exitwindow', 'Error on earliest_start', '{{ $error }}');
                                        </script>
                                    @endforeach
                                @endif
                            </div>
                            <div class="kwp-col-4">
                                {{ Form::label('latest_return', trans('layer.general.latest_return'), ['class' => 'control-label required']) }}
                                {{ Form::text('latest_return', key_exists('latest_return', $request) ? $request['latest_return'] : null, ['class' => 'form-control box-size', 'placeholder' => trans('layer.general.latest_return'), 'required' => 'required', 'readonly']) }}
                                @if ($errors->any() && $errors->get('latest_return'))
                                    @foreach ($errors->get('latest_return') as $error)
                                        <span class="error-input">{{ $error }}</span>
                                        <script>
                                            dt.Tracking.rawEvent(whitelabelPrefix+'_exitwindow', 'Error on latest_return', '{{ $error }}');
                                        </script>
                                    @endforeach
                                @endif
                            </div>
                            <div class="kwp-col-12">
                                {{ Form::label('duration', trans('layer.general.duration'), ['class' => 'control-label required']) }}
                                <div class="kwp-custom-select">
                                    {{ Form::select('duration', array_merge(['0' => trans('layer.general.duration_init')], $duration_arr), key_exists('duration', $request) ? $request['duration'] : null, ['class' => 'form-control box-size']) }}
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="kwp-col-12 button">
                                <a href="#">OK</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="kwp-row">
                <div class="kwp-col-4 pax-col main-col">
                    <div class="kwp-form-group pax-group">
                        <label for="travelers" class="required">{{ trans('whitelabel.layer.general.pax') }}</label>
                        <span class="travelers dd-trigger">
                            <span class="txt">{{ trans_choice('labels.frontend.wishes.adults', 1) }}</span>
                            <i class="fal fa-users not-triggered"></i>
                            <i class="fal fa-times triggered"></i>
                        </span>
                        <div class="pax-more">
                            <div class="kwp-col-12">
                                {{ Form::label('adults', trans('layer.general.adults'), ['class' => 'control-label required']) }}
                                <div class="kwp-custom-select">
                                    {{ Form::select('adults', $adults_arr, key_exists('adults', $request) ? $request['adults'] : null, ['class' => 'form-control box-size', 'required' => 'required']) }}
                                </div>
                                <i class="fal fa-users"></i>
                            </div>
                            <div class="kwp-col-12 kids">
                                <div class="kwp-col-12">
                                    {{ Form::label('kids', trans('layer.general.kids'), ['class' => 'control-label required']) }}
                                    <div class="kwp-custom-select">
                                        {{ Form::select('kids', $kids_arr, key_exists('kids', $request) ? $request['kids'] : null, ['class' => 'form-control box-size']) }}
                                    </div>
                                    <i class="fal fa-child"></i>
                                </div>
                                <div class="kwp-col-ages">
                                    <div class="kwp-form-group">
                                        <label class="main-label">{{ trans('labels.frontend.kids.travel_age') }}</label>
                                        <input name="ages" type="hidden">
                                        <div id="age_1" class="kwp-col-3">
                                            <i class="master-icon--aircraft-down"></i>
                                            <div class="kwp-custom-select" style="display: none">
                                                {{ Form::select('ages1', $ages_arr,key_exists('ages1', $request) ? $request['ages1'] : null, ['class' => 'form-control box-size', 'required' => 'required']) }}
                                            </div>
                                            @if ($errors->any() && $errors->get('ages1'))
                                                @foreach ($errors->get('ages1') as $error)
                                                    <span class="error-input">{{ $error }}</span>
                                                    <script>
                                                        dt.Tracking.rawEvent(whitelabelPrefix+'_exitwindow', 'Error on ages1', '{{ $error }}');
                                                    </script>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div id="age_2" class="kwp-col-3">
                                            <i class="master-icon--aircraft-down"></i>
                                            <div class="kwp-custom-select" style="display: none">
                                                {{ Form::select('ages2', $ages_arr,key_exists('ages2', $request) ? $request['ages2'] : null, ['class' => 'form-control box-size', 'required' => 'required']) }}
                                            </div>
                                            @if ($errors->any() && $errors->get('ages2'))
                                                @foreach ($errors->get('ages2') as $error)
                                                    <span class="error-input">{{ $error }}</span>
                                                    <script>
                                                        dt.Tracking.rawEvent(whitelabelPrefix+'_exitwindow', 'Error on ages2', '{{ $error }}');
                                                    </script>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div id="age_3" class="kwp-col-3">
                                            <i class="master-icon--aircraft-down"></i>
                                            <div class="kwp-custom-select" style="display: none">
                                                {{ Form::select('ages3', $ages_arr,key_exists('ages3', $request) ? $request['ages3'] : null, ['class' => 'form-control box-size', 'required' => 'required']) }}
                                            </div>
                                            @if ($errors->any() && $errors->get('ages3'))
                                                @foreach ($errors->get('ages3') as $error)
                                                    <span class="error-input">{{ $error }}</span>
                                                    <script>
                                                        dt.Tracking.rawEvent(whitelabelPrefix+'_exitwindow', 'Error on ages3', '{{ $error }}');
                                                    </script>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div id="age_4" class="kwp-col-3">
                                            <i class="master-icon--aircraft-down"></i>
                                            <div class="kwp-custom-select" style="display: none">
                                                {{ Form::select('ages4', $ages_arr,key_exists('ages4', $request) ? $request['ages4'] : null, ['class' => 'form-control box-size', 'required' => 'required']) }}
                                            </div>
                                            @if ($errors->any() && $errors->get('ages4'))
                                                @foreach ($errors->get('ages4') as $error)
                                                    <span class="error-input">{{ $error }}</span>
                                                    <script>
                                                        dt.Tracking.rawEvent(whitelabelPrefix+'_exitwindow', 'Error on ages4', '{{ $error }}');
                                                    </script>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="kwp-col-12 button">
                                <a href="#">OK</a>
                            </div>
                        </div>
                        @if ($errors->any() && $errors->get('ages1'))
                            @foreach ($errors->get('ages1') as $error)
                                <span class="error-input">{{ $error }}</span>
                            @endforeach
                        @endif
                        @if ($errors->any() && $errors->get('ages2'))
                            @foreach ($errors->get('ages2') as $error)
                                <span class="error-input">{{ $error }}</span>
                            @endforeach
                        @endif
                        @if ($errors->any() && $errors->get('ages3'))
                            @foreach ($errors->get('ages3') as $error)
                                <span class="error-input">{{ $error }}</span>
                            @endforeach
                        @endif
                        @if ($errors->any() && $errors->get('ages4'))
                            @foreach ($errors->get('ages4') as $error)
                                <span class="error-input">{{ $error }}</span>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="kwp-col-4 rooms">
                    {{ Form::label('rooms', trans('layer.general.rooms'), ['class' => 'control-label required']) }}
                    <div class="kwp-custom-select">
                        {{ Form::select('rooms', $rooms_arr, key_exists('rooms', $request) ? $request['rooms'] : null) }}
                    </div>
                    <i class="fal fa-door-closed"></i>
                </div>
            </div>

            <div class="kwp-row">
                <div class="kwp-col-12 description">
                    {{ Form::label('description', trans('layer.general.description'), ['class' => 'control-label required']) }}
                    {{ Form::textarea('description', key_exists('description', $request) ? $request['description'] : null,['class' => 'form-control', 'placeholder' => trans('layer.placeholder.description')]) }}
                    <i class="fal fa-pencil"></i>
                </div>
            </div>

            <div class="kwp-row">
                <div class="kwp-col-4 email-col">
                    {{ Form::label('email', trans('layer.general.email'), ['class' => 'control-label']) }}
                    {{ Form::text('email', key_exists('email', $request) ? $request['email'] : null, ['class' => 'form-control box-size', 'placeholder' => trans('layer.placeholder.email'), 'required' => 'required']) }}
                    <i class="fal fa-envelope"></i>
                    <div class="kwp-form-email-hint"></div>
                    @if ($errors->any() && $errors->get('email'))
                        @foreach ($errors->get('email') as $error)
                            <span class="error-input">{{ $error }}</span>
                            <script>
                                dt.Tracking.rawEvent(whitelabelPrefix+'_exitwindow', 'Error on email', '{{ $error }}');
                            </script>
                        @endforeach
                    @endif
                </div>

                <div class="kwp-col-4 white-col submit-col">
                    <button id="submit-button" type="submit" class="submit-button primary-btn">{{ trans('layer.submit') }}</button>
                </div>
            </div>
        </div>

        <div class="kwp-footer">
            <div class="kwp-row">
                <div class="kwp-col-12 white-col footer-col">
                    <div class="kwp-agb">
                        @php
                            $terms_class = 'dt_terms'
                        @endphp

                        @if ($errors->any() && $errors->get('terms'))
                            @foreach ($errors->get('terms') as $error)
                                @php
                                    $terms_class = 'dt_terms hasError'
                                @endphp
                                <script>
                                    dt.Tracking.rawEvent(whitelabelPrefix+'_exitwindow', 'Error on terms', '{{ $error }}');
                                </script>
                            @endforeach
                        @endif

                        {{ Form::checkbox('terms', null, key_exists('terms', $request) && $request['terms']  ? 'true' : null,['class' => $terms_class, 'required' => 'required']) }}
                        <p>{!! trans('layer.terms_tnb') !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{ Form::close() }}

</div>

<script>
    jQuery(function($){
        $(document).ready(function () {

            var translation = @json($translation);

            var layerName = @json($layerName);

            var layer = layers.find(l => l.layer.path === layerName);

            var is_pure_autooffers = @json($whitelabel['is_pure_autooffers']);

            dt.translateWordings(translation);

            dt.showTabs(layers);

            dt.showCurrentTab(layerName);

            dt.handleClickTabs();

            dt.fillContent(layer, layers.length > 1);

            dt.applyBrandColor();

            dt.adjustResponsive();

            dt.handleTriggers();

            dt.handleDestination(is_pure_autooffers);

            dt.handleDuration();

            dt.hanglePax();

            dt.handleKidsAges();

            dt.handleErrors();
        });
    });
</script>
