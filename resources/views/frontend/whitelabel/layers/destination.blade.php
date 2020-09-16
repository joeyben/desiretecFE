@php
    $layerName = 'destination';
@endphp

<div id="{{ $layerName }}" class="td-tab-content">

    <div class="kwp-header-dynamic">
        <div class="kwp-color-overlay"></div>
        <div class="kwp-logo"></div>
        <div class="kwp-header-text"><h1></h1></div>
    </div>

    {{ Form::open() }}

    {{ Form::hidden('airport', '-') }}
    {{ Form::hidden('destination', '-') }}
    {{ Form::hidden('budget', 0) }}
    {{ Form::hidden('adults', 0) }}
    {{ Form::hidden('variant_id', 0) }}

    <div class="kwp-middle"></div>

    <div class="kwp-minimal">
        <div class="kwp-content kwp-with-expansion">
            <div class="kwp-row">
                <div class="kwp-col-4 duration-col main-col">
                    <div class="kwp-form-group duration-group duration-group">
                        <label for="duration-time" class="required">{{ Lang::get('layer.general.duration', [], session()->get('wl-locale')) }}</label>
                        <span class="duration-time duration-time dd-trigger">
                            <span class="txt">15.11.2018 - 17.06.2019, 1 Woche</span>
                            <i class="fal fa-calendar-alt not-triggered"></i>
                            <i class="fal fa-times triggered"></i>
                        </span>
                        <div class="duration-more duration-more">
                            <div class="kwp-col-4">
                                {{ Form::label('earliest_start', Lang::get('layer.general.earliest_start', [], session()->get('wl-locale')), ['class' => 'control-label required']) }}
                                {{ Form::text('earliest_start', key_exists('earliest_start', $request) ? $request['earliest_start'] : null, ['class' => 'form-control box-size', 'placeholder' => Lang::get('layer.general.earliest_start', [], session()->get('wl-locale')), 'required' => 'required', 'readonly']) }}
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
                                {{ Form::label('latest_return', Lang::get('layer.general.latest_return', [], session()->get('wl-locale')), ['class' => 'control-label required']) }}
                                {{ Form::text('latest_return', key_exists('latest_return', $request) ? $request['latest_return'] : null, ['class' => 'form-control box-size', 'placeholder' => Lang::get('layer.general.latest_return', [], session()->get('wl-locale')), 'required' => 'required', 'readonly']) }}
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
                                {{ Form::label('duration', Lang::get('layer.general.duration', [], session()->get('wl-locale')), ['class' => 'control-label required']) }}
                                <div class="kwp-custom-select">
                                    {{ Form::select('duration', array_merge(['0' => Lang::get('layer.general.duration_init', [], session()->get('wl-locale'))], $duration_arr), key_exists('duration', $request) ? $request['duration'] : null, ['class' => 'form-control box-size']) }}
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="kwp-col-12 button">
                                <a href="#">OK</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="kwp-col-4 purpose">
                    {{ Form::label('purpose', Lang::get('layer.general.purpose', [], session()->get('wl-locale')), ['class' => 'control-label required']) }}
                    <div class="kwp-custom-select">
                        {{ Form::select('purpose', $purpose_arr, key_exists('purpose', $request) ? $request['purpose'] : null, ['class' => 'form-control box-size']) }}
                    </div>
                    <i class="far fa-chevron-down"></i>
                </div>
            </div>

            <div class="kwp-row">
                <div class="kwp-col-4 stars">
                    <div class="kwp-form-group">
                        {{ Form::label('category', Lang::get('layer.general.category'), ['class' => 'control-label required']) }}
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

                <div class="kwp-col-4 grey events-interested">
                    <div class="checkbox-wrapper">
                        {{ Form::checkbox('events_interested', null, key_exists('events_interested', $request) ? 'true' : null, ['class' => 'form-control box-size']) }}
                        <span class="checkbox-text">{{ Lang::get('layer.general.events_interested', [], session()->get('wl-locale')) }}</span>
                    </div>
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
                    <button id="submit-button" type="submit" class="submit-button primary-btn">{{ Lang::get('layer.submit', [], session()->get('wl-locale')) }}</button>
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

            var layer = layers.find(l => l.layer.path === layerName);

            var layerVariantId = layer.variant_id !== null ? (layer.variant_id).toString() : '0';
            $("[name='variant_id']").val(layerVariantId);

            var is_pure_autooffers = @json($whitelabel['is_pure_autooffers']);

            dt.translateWordings(translation);

            dt.showTabs(layers);

            dt.showCurrentTab(layerName);

            dt.handleClickTabs();

            dt.fillContent(layer, layers.length > 1);

            dt.applyBrandColor();

            dt.adjustResponsive();

            dt.handleTriggers();

            dt.handleDuration();

            dt.handleHotelStars();

            dt.handleErrors();
        });
    });
</script>
