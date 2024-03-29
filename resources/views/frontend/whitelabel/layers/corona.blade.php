@php
    $layerName = 'corona';

    $duration_arr_corona = array_diff($duration_arr, array('exact' => 'Exakt wie angegeben'));

@endphp

<div id="{{ $layerName }}" class="td-tab-content">

    <div class="kwp-header-dynamic">
        <div class="kwp-color-overlay"></div>
        <div class="kwp-logo"></div>
        <div class="kwp-header-text"><h1></h1></div>
    </div>

    {{ Form::open() }}

    {{ Form::hidden('earliest_start', '-') }}
    {{ Form::hidden('latest_return', '-') }}
    {{ Form::hidden('variant_id', 0) }}

    <div class="kwp-middle"></div>

    <div class="kwp-minimal">
        <div class="kwp-content kwp-with-expansion">
            <div class="kwp-row">
                <div class="kwp-col-4 destination">
                    {{ Form::label('destination', Lang::get('layer.general.destination', [], session()->get('wl-locale')), ['class' => 'control-label required']) }}
                    {{ Form::text('destination', key_exists('destination', $request) ? $request['destination'] : null, ['class' => 'form-control box-size','autocomplete' => "off", 'placeholder' => Lang::get('layer.placeholder.destination', [], session()->get('wl-locale')), 'required' => 'required']) }}
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

                <div class="kwp-col-4 airport">
                    {{ Form::label('airport', Lang::get('layer.general.airport', [], session()->get('wl-locale')), ['class' => 'control-label required']) }}
                    {{ Form::text('airport', key_exists('airport', $request) ? $request['airport'] : null, ['class' => 'form-control box-size','autocomplete' => "off", 'placeholder' => Lang::get('layer.placeholder.airport', [], session()->get('wl-locale')), 'required' => 'required']) }}
                    <i class="fal fa-home"></i>
                    @if ($errors->any() && $errors->get('airport'))
                        @foreach ($errors->get('airport') as $error)
                            <span class="error-input">{{ $error }}</span>
                            <script>
                                dt.Tracking.rawEvent(whitelabelPrefix+'_exitwindow', 'Error on airport', '{{ $error }}');
                            </script>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="kwp-row">
                <div class="kwp-col-4 duration">
                    {{ Form::label('duration', Lang::get('layer.general.duration', [], session()->get('wl-locale')), ['class' => 'control-label required']) }}
                    <div class="kwp-custom-select">
                        {{ Form::select('duration', array_merge(['0' => Lang::get('layer.general.duration_init', [], session()->get('wl-locale'))], $duration_arr_corona), key_exists('duration', $request) ? $request['duration'] : null) }}
                    </div>
                    <i class="fal fa-calendar-alt"></i>
                </div>

                <div class="kwp-col-4 pax-col main-col">
                    <div class="kwp-form-group pax-group">
                        <label for="travelers" class="required">{{ Lang::get('whitelabel.layer.general.pax', [], session()->get('wl-locale')) }}</label>
                        <span class="travelers dd-trigger">
                            <span class="txt">{{ trans_choice('labels.frontend.wishes.adults', 1) }}</span>
                            <i class="fal fa-users not-triggered"></i>
                            <i class="fal fa-times triggered"></i>
                        </span>
                        <div class="pax-more">
                            <div class="kwp-col-12">
                                {{ Form::label('adults', Lang::get('layer.general.adults', [], session()->get('wl-locale')), ['class' => 'control-label required']) }}
                                <div class="kwp-custom-select">
                                    {{ Form::select('adults', $adults_arr, key_exists('adults', $request) ? $request['adults'] : null, ['class' => 'form-control box-size', 'required' => 'required']) }}
                                </div>
                                <i class="fal fa-users"></i>
                            </div>
                            <div class="kwp-col-12 kids">
                                <div class="kwp-col-12">
                                    {{ Form::label('kids', Lang::get('layer.general.kids', [], session()->get('wl-locale')), ['class' => 'control-label required']) }}
                                    <div class="kwp-custom-select">
                                        {{ Form::select('kids', $kids_arr, key_exists('kids', $request) ? $request['kids'] : null, ['class' => 'form-control box-size']) }}
                                    </div>
                                    <i class="fal fa-child"></i>
                                </div>
                                <div class="kwp-col-ages">
                                    <div class="kwp-form-group">
                                        <label class="main-label">{{ Lang::get('labels.frontend.kids.travel_age', [], session()->get('wl-locale')) }}</label>
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
            </div>

            <div class="kwp-row">
                <div class="kwp-col-3 rangeslider-wrapper">
                    <div class="kwp-form-group ">
                        {{ Form::label('budget', Lang::get('layer.general.budget', [], session()->get('wl-locale')), ['class' => 'control-label required']) }}
                        {{ Form::number('budget', key_exists('budget', $request) ? $request['budget'] : null, ['class' => 'form-control box-size hidden', 'placeholder' => Lang::get('layer.placeholder.budget', [], session()->get('wl-locale')), 'required' => 'required']) }}
                    </div>
                    <span class="text">&nbsp;</span>
                    <input type="range" min="100" max="10000" value="50"  step="50" id="budgetRange">
                </div>

                <div class="kwp-col-3 stars">
                    <div class="kwp-form-group">
                        {{ Form::label('category', Lang::get('layer.general.category', [], session()->get('wl-locale')), ['class' => 'control-label required']) }}
                        {{ Form::number('category', key_exists('category', $request) ? $request['category'] : 3, ['class' => 'form-control box-size hidden', 'placeholder' => Lang::get('layer.placeholder.category', [], session()->get('wl-locale'))]) }}

                        <span class="text">{{ Lang::get('layer.sun.from', [], session()->get('wl-locale')) }}</span>
                        <div class="kwp-star-input">
                            <span class="kwp-star" data-val="1"></span>
                            <span class="kwp-star" data-val="2"></span>
                            <span class="kwp-star" data-val="3"></span>
                            <span class="kwp-star" data-val="4"></span>
                            <span class="kwp-star" data-val="5"></span>
                        </div>
                    </div>
                </div>

                <div class="kwp-col-3 catering">
                    {{ Form::label('catering', Lang::get('layer.general.catering', [], session()->get('wl-locale')), ['class' => 'control-label required']) }}
                    <div class="kwp-custom-select">
                        {{ Form::select('catering', $catering_arr, key_exists('catering', $request) ? $request['catering'] : null) }}
                    </div>
                    <i class="far fa-chevron-down"></i>
                </div>
            </div>

            <div class="kwp-row">
                <div class="kwp-col-12 description">
                    {{ Form::label('description', Lang::get('layer.general.description', [], session()->get('wl-locale')), ['class' => 'control-label required']) }}
                    {{ Form::textarea('description', key_exists('description', $request) ? $request['description'] : null,['class' => 'form-control', 'placeholder' => Lang::get('layer.placeholder.description', [], session()->get('wl-locale'))]) }}
                    <i class="fal fa-pencil"></i>
                </div>
            </div>

            <div class="kwp-row">
                <div class="kwp-col-4 email-col">
                    {{ Form::label('email', Lang::get('layer.general.email', [], session()->get('wl-locale')), ['class' => 'control-label']) }}
                    {{ Form::text('email', key_exists('email', $request) ? $request['email'] : null, ['class' => 'form-control box-size', 'placeholder' => Lang::get('layer.placeholder.email', [], session()->get('wl-locale')), 'required' => 'required']) }}
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
                    <button id="submit-button" type="submit" class="submit-button primary-btn">{{ Lang::get('popup.submit', [], session()->get('wl-locale')) }}</button>
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
                        <p>{!! Lang::get('layer.terms_tnb', [], session()->get('wl-locale')) !!}</p>
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


            var is_pure_autooffers = @json($whitelabel['is_pure_autooffers']);

            var layer = layers.find(l => l.layer.path === layerName);

            dt.translateWordings(translation);

            dt.showTabs(layers);

            dt.showCurrentTab(layerName);

            dt.handleClickTabs();

            dt.fillContent(layer, layers.length > 1);

            dt.applyBrandColor();

            dt.adjustResponsive();

            dt.handleTriggers();

            dt.handleDestination(is_pure_autooffers);

            dt.handleAirport(is_pure_autooffers);

            dt.hanglePax();

            dt.handleKidsAges();

            dt.handleBudgetRange();

            dt.handleHotelStars();

            dt.handleErrors();

        });
    });
</script>
