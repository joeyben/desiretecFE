<script type="application/javascript">
    var brandColor = {!! json_encode($color) !!};
    var layerContent = {!! json_encode($layer_details) !!};
    var domain = {!! json_encode($whitelabel['domain']) !!};
    var wl_name = {!! json_encode($whitelabel['name']) !!};

    var url = window.location.hostname;
    var whitelabelPrefix = (url.indexOf('reise-wunsch.de') !== -1
        || url.indexOf('wish-service.com') !== -1
        || url.indexOf('travelwishservice.com') !== -1
    ) ?  wl_name+"_WL" : wl_name;
</script>

<style>
    .kwp-logo {
        background: transparent url({{ $logo }}) no-repeat left top;
    }
</style>

{{-- Form::open(['route' => 'master.store' , 'method' => 'get', 'class' => '', 'role' => 'form', 'files' => true]) --}}
{{ Form::open() }}


<div class="kwp-middle">
    {{ isset($layer_details['subheadline']) ? $layer_details['subheadline'] : trans('layer.show.subheadline') }}
</div>
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

            <div class="kwp-col-4 airport">
                {{ Form::label('airport', trans('layer.general.airport'), ['class' => 'control-label required']) }}
                {{ Form::text('airport', key_exists('airport', $request) ? $request['airport'] : null, ['class' => 'form-control box-size','autocomplete' => "off", 'placeholder' => trans('layer.placeholder.airport'), 'required' => 'required']) }}
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
            <div class="kwp-col-4 duration-col main-col">
                <div class="kwp-form-group duration-group">
                    <label for="duration-time" class="required">{{ trans('layer.general.duration') }}</label>
                    <span class="duration-time dd-trigger">
                        <span class="txt">15.11.2018 - 17.06.2019, 1 Woche</span>
                        <i class="fal fa-calendar-alt not-triggered"></i>
                        <i class="fal fa-times triggered"></i>
                    </span>
                    <div class="duration-more">
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

            <div class="kwp-col-4 pax-col main-col">
                <div class="kwp-form-group pax-group">
                    <label for="travelers" class="required">{{ trans('whitelabel.layer.general.pax') }}</label>
                    <span class="travelers dd-trigger">
                        <span class="txt">2 Erwachsener</span>
                        <i class="fal fa-users not-triggered"></i>
                        <i class="fal fa-times triggered"></i>
                    </span>
                    <div class="pax-more">
                        <div class="kwp-col-12">
                            {{ Form::label('adults', trans('layer.general.adults'), ['class' => 'control-label required']) }}
                            <div class="kwp-custom-select">
                                {{ Form::select('adults', $adults_arr , key_exists('adults', $request) ? $request['adults'] : null, ['class' => 'form-control box-size', 'required' => 'required']) }}
                            </div>
                            <i class="fal fa-users"></i>
                        </div>
                        <div class="kwp-col-12 kids" style="position: relative;">
                            <div class="kwp-col-12">
                                {{ Form::label('kids', trans('layer.general.kids'), ['class' => 'control-label required']) }}
                                <div class="kwp-custom-select">
                                    {{ Form::select('kids', $kids_arr, key_exists('kids', $request) ? $request['kids'] : null, ['class' => 'form-control box-size']) }}
                                </div>
                                <i class="fal fa-child"></i>
                            </div>
                            <div class="kwp-col-ages">
                                <div class="kwp-form-group">
                                    <label class="main-label">Alter der Kinder bei Rückreise</label>
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
                        <script>dt.childrenAges();</script>
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
                    {{ Form::label('budget', trans('layer.general.budget'), ['class' => 'control-label required']) }}
                    {{ Form::number('budget', key_exists('budget', $request) ? $request['budget'] : null, ['class' => 'form-control box-size hidden', 'placeholder' => trans('layer.placeholder.budget'), 'required' => 'required']) }}
                </div>
                <span class="text">&nbsp;</span>
                <input type="range" min="100" max="10000" value="50"  step="50" id="budgetRange">
            </div>

            <div class="kwp-col-3 white-col stars">
                <div class="kwp-form-group">
                    {{ Form::label('category', trans('layer.general.category'), ['class' => 'control-label required']) }}
                    {{ Form::number('category', key_exists('category', $request) ? $request['category'] : null, ['class' => 'form-control box-size hidden', 'placeholder' => trans('layer.placeholder.category')]) }}

                    <span class="text">ab 0 Sonnen</span>
                    <div class="kwp-star-input">
                        <span class="kwp-star kwp-star-full" data-val="1"></span>
                        <span class="kwp-star" data-val="2"></span>
                        <span class="kwp-star" data-val="3"></span>
                        <span class="kwp-star" data-val="4"></span>
                        <span class="kwp-star" data-val="5"></span>
                    </div>
                    <script>dt.hotelStars();</script>
                </div>
            </div>

            <div class="kwp-col-3 white-col catering">
                {{ Form::label('catering', trans('layer.general.catering'), ['class' => 'control-label required']) }}
                <div class="kwp-custom-select">
                    {{ Form::select('catering', $catering_arr, key_exists('catering', $request) ? $request['catering'] : null,['class' => 'custom-select']) }}
                </div>
                <i class="far fa-chevron-down"></i>
            </div>

        </div>

        <div class="kwp-row text-area-margin">
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
                <button id="submit-button" type="submit" class="primary-btn">Reisewunsch abschicken</button>
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
                  @php
                  $terms_class = 'dt_terms hasError'
                  @endphp
                    <script>
                        dt.Tracking.rawEvent(whitelabelPrefix+'_exitwindow', 'Error on terms', '{{ $error }}');
                    </script>
                @endif
                    {{ Form::checkbox('terms', null, key_exists('terms', $request) && $request['terms']  ? 'true' : null,['class' => $terms_class, 'required' => 'required']) }}
                     <p>Ich habe die <a href="{{isset($whitelabel['domain']) ? $whitelabel['domain'] : ''}}/tnb" id="agb_link" target="_blank">Teilnahmebedingungen</a> und <a id="datenschutz" href="{{ isset($layer_details['privacy']) ? $layer_details['privacy'] : '#'}}" target="_blank" rel="noopener noreferrer">Datenschutzrichtlinien</a> zur Kenntnis genommen und möchte meinen Reisewunsch absenden.</p>
                </div>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}

<script>

jQuery(function($){
  $(document).ready(function () {

        if($('.kwp-close-button i').length === 0) {
            $('.kwp-close-button').append('<i class="fal fa-times"></i>');
        }

        dt.applyLayerContent();

        dt.applyBrandColor();

        dt.adjustResponsive();

        dt.autocomplete();

        $("#earliest_start, #latest_return").on('change paste keyup input', function(){
            var earliest_start_arr = $("#earliest_start").val().split('.');
            var latest_return_arr = $("#latest_return").val().split('.');
            var earliest_start = new Date(earliest_start_arr[2], earliest_start_arr[1]-1, earliest_start_arr[0]);
            var latest_return = new Date(latest_return_arr[2], latest_return_arr[1]-1, latest_return_arr[0]);
            var diff_nights = Math.round((latest_return-earliest_start)/(1000*60*60*24));
            var diff_days =  diff_nights + 1;
            var options = document.getElementById("duration").getElementsByTagName("option");
            for (var i = 0; i < options.length; i++) {
                if(options[i].value.includes('-')){
                    var days = options[i].value.split('-');
                    if(days[1].length){
                        (parseInt(days[0]) <= parseInt(diff_days))
                            ? options[i].disabled = false
                            : options[i].disabled = true;
                    } else {
                        (parseInt(days[0]) <= parseInt(diff_days))
                            ? options[i].disabled = false
                            : options[i].disabled = true;
                    }
                } else if (options[i].value == "exact" || options[i].value == "" || !options[i].value.length) {
                    options[i].disabled = false;
                } else {
                    (parseInt(options[i].value) <= parseInt(diff_nights))
                        ? options[i].disabled = false
                        : options[i].disabled = true;
                }
            }

            return true;
        });

        $(".dd-trigger").click(function(e) {
            if(!$(this).parents('.main-col').hasClass('open')){
                $('.main-col').removeClass('open')
                $(this).parents('.main-col').addClass('open');
            }else
                $(this).parents('.main-col').removeClass('open');

            $('.kwp-content').animate({ scrollTop: $(this).offset().top}, 500);
        });

        $(".duration-more .button a").click(function(e) {
            e.preventDefault();
            $(this).parents('.duration-col').removeClass('open');
            var from = $("#earliest_start").val();
            var back = $("#latest_return").val();
            var duration = $("#duration option:selected").text();

            $(".duration-time .txt").text(from+" - "+back+", "+duration);
            return false;
        });

        $(".pax-more .button a").click(function(e) {
            e.preventDefault();
            $(this).parents('.pax-col').removeClass('open');
            var pax = $("#adults").val();
            var children_count = parseInt($("#kids").val());
            var children = children_count > 0 ? (children_count == 1 ? ", "+children_count+" Kind" : ", "+children_count+" Kinder")  : "" ;

            var erwachsene = parseInt(pax) > 1 ? "Erwachsene" : "Erwachsener";
            $(".travelers .txt").text(pax+" "+erwachsene+" "+children);
            return false;
        });

        $('#budgetRange').rangeslider({
            polyfill: false,
            onInit: function() {
                $('.rangeslider__handle').on('mousedown touchstart mousemove touchmove', function(e) {
                    e.preventDefault();
                })
            },
            fillClass: 'rangeslider__fill',
            onSlide: function(position, value) {
                if($(".rangeslider-wrapper .haserrors").length)
                    $(".rangeslider-wrapper .haserrors").removeClass('haserrors');

                if(value === 10000){
                    $(".rangeslider-wrapper .text").text("beliebig");
                    $("#budget").val("beliebig");
                }else if(value === 100){
                    $(".rangeslider-wrapper .text").html("&nbsp;");
                    $("#budget").val("");
                }else{
                    $(".rangeslider-wrapper .text").text("bis "+value+" €");
                    $("#budget").val(""+value);
                }
                check_button();
            },
        });


        dt.startDate = new Pikaday({
            field: document.getElementById('earliest_start'),
            format: 'dd.mm.YYYY',
            defaultDate: '01.01.2019',
            firstDay: 1,
            minDate: new Date(),
            toString: function(date, format) {
                // you should do formatting based on the passed format,
                // but we will just return 'D/M/YYYY' for simplicity
                const day = date.getDate() < 10 ? "0" + date.getDate() : date.getDate();
                const month = (date.getMonth() + 1) < 10 ? "0" + (date.getMonth() + 1) : (date.getMonth() + 1);
                const year = date.getFullYear();
                return day+"."+month+"."+year;
            },
            i18n: {
                previousMonth: 'Vormonat',
                nextMonth: 'Nächsten Monat',
                months: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
                weekdays: ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
                weekdaysShort: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa']
            },
            onSelect: function(date) {
                var dateFrom = this.getDate();
                var dateTo = dt.endDate.getDate();
                if(dateFrom >= dateTo){
                    var d = date.getDate();
                    var m = date.getMonth();
                    var y = date.getFullYear();
                    var updatedDate = new Date(y, m, d);
                    dt.endDate.setMinDate(updatedDate);
                    updatedDate = new Date(y, m, d+7);
                    dt.endDate.setDate(updatedDate);
                }
            },
            onOpen: function() {

            },
        });
        dt.endDate = new Pikaday({
            field: document.getElementById('latest_return'),
            format: 'dd.mm.YYYY',
            defaultDate: '01.01.2019',
            firstDay: 1,
            toString: function(date, format) {
                // you should do formatting based on the passed format,
                // but we will just return 'D/M/YYYY' for simplicity
                const day = date.getDate() < 10 ? "0" + date.getDate() : date.getDate();
                const month = (date.getMonth() + 1) < 10 ? "0" + (date.getMonth() + 1) : (date.getMonth() + 1);
                const year = date.getFullYear();
                return day+"."+month+"."+year;
            },
            i18n: {
                previousMonth: 'Vormonat',
                nextMonth: 'Nächsten Monat',
                months: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
                weekdays: ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
                weekdaysShort: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa']
            }
        });

        if(!$("#earliest_start").val()){
            var date = new Date();
            date.setDate(date.getDate() + 3);
            var d = date.getDate();
            var m = date.getMonth()+1;
            var y = date.getFullYear();
            if (d < 10) {
                d = "0" + d;
            }
            if (m < 10) {
                m = "0" + m;
            }
            $("#earliest_start").val(d+"."+m+"."+y);
        }

        if(!$("#latest_return").val()){
            var date = new Date();
            date.setDate(date.getDate() + 10);
            var d = date.getDate();
            var m = date.getMonth()+1;
            var y = date.getFullYear();
            if (d < 10) {
                d = "0" + d;
            }
            if (m < 10) {
                m = "0" + m;
            }
            $("#latest_return").val(d+"."+m+"."+y);
        }

        var range = parseInt($("#budget").val().replace('.',''));
        if(range)
            $('input[type="range"]').val(range).change();

        $(".duration-time .txt").text($("#earliest_start").val()+" - "+$("#latest_return").val()+", "+$("#duration option:selected").text());
        var pax = $("#adults").val();
        var children_count = parseInt($("#kids").val());
        var children = children_count > 0 ? (children_count == 1 ? ", "+children_count+" Kind" : ", "+children_count+" Kinder")  : "" ;
        var erwachsene = parseInt(pax) > 1 ? "Erwachsene" : "Erwachsener";
        $(".travelers .txt").text(pax+" "+erwachsene+" "+children);

        if($(".dt-modal .haserrors").length){
            $('.dt-modal #submit-button').addClass('error-button');
        }

        if($(".duration-more .haserrors").length){
            $('.duration-group').addClass('haserrors');
        }

        $( ".haserrors input" ).keydown(function( event ) {
            $(this).parents('.haserrors').removeClass('haserrors');
            check_button();
        });
        $('.haserrors input[type="checkbox"]').change(function () {
            $(this).parents('.haserrors').removeClass('haserrors');
            check_button();
        });
        $("#latest_return").trigger("change");
    });

    function check_button(){
        if(!$(".dt-modal .haserrors").length){
            $('.dt-modal #submit-button').removeClass('error-button');
        }
    };
});

</script>
