<script type="application/javascript">
    var brandColor = {!! json_encode($color) !!};
    var layerContent = {!! json_encode($layer_details) !!};
    var domain = {!! json_encode($whitelabel['domain']) !!};
    var wl_name = {!! json_encode($whitelabel['name']) !!};
</script>

<link media="all" type="text/css" rel="stylesheet" href="https://www.wish-service.com/fontawsome/css/all.css">

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
                {{ Form::text('destination',  key_exists('destination', $request) ? $request['destination'] : null, ['class' => 'form-control box-size','autocomplete' => "off", 'placeholder' => trans('layer.placeholder.destination'), 'required' => 'required']) }}
                @if ($errors->any() && $errors->get('destination'))
                    @foreach ($errors->get('destination') as $error)
                        <span class="error-input">{{ $error }}</span>
                        <script>
                            dt.Tracking.rawEvent('{{ $whitelabel['name'] }}_exitwindow', 'Error on destination', '{{ $error }}');
                        </script>
                    @endforeach
                @endif
                <i class="fal fa-home"></i>
            </div>

            {{ Form::hidden('airport', '-') }}

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
                                                    dt.Tracking.rawEvent('{{ $whitelabel['name'] }}_exitwindow', 'Error on ages1', '{{ $error }}');
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
                                                    dt.Tracking.rawEvent('{{ $whitelabel['name'] }}_exitwindow', 'Error on ages2', '{{ $error }}');
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
                                                    dt.Tracking.rawEvent('{{ $whitelabel['name'] }}_exitwindow', 'Error on ages3', '{{ $error }}');
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
                                                    dt.Tracking.rawEvent('{{ $whitelabel['name'] }}_exitwindow', 'Error on ages4', '{{ $error }}');
                                                </script>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>dt.childrenAges();</script>
                        <div class="kwp-col-12">
                            {{ Form::label('pets', trans('layer.general.pets'), ['class' => 'control-label required']) }}
                            <div class="kwp-custom-select">
                                {{ Form::select('pets', $pets_arr, key_exists('pets', $request) ? $request['pets'] : null, ['class' => 'form-control box-size', 'required' => 'required']) }}
                            </div>
                            <i class="fal fa-dog-leashed"></i>
                        </div>

                        <hr>

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

            <div class="kwp-col-4 duration-col main-col">
                <div class="kwp-form-group duration-group">
                    <label for="duration-time" class="required">{{trans('layer.general.duration')}}</label>
                    <span class="duration-time dd-trigger">
                        <span class="txt">15.11.2018 - 17.06.2019</span>
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
                                        dt.Tracking.rawEvent('{{ $whitelabel['name'] }}_exitwindow', 'Error on earliest_start', '{{ $error }}');
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
                                        dt.Tracking.rawEvent('{{ $whitelabel['name'] }}_exitwindow', 'Error on latest_return', '{{ $error }}');
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

            <div class="kwp-col-4 destination">
                <div class="kwp-form-group ">
                    {{ Form::label('budget', 'Mietpreis', ['class' => 'control-label required']) }}
                    {{ Form::number('budget', key_exists('budget', $request) ? $request['budget'] : null, ['class' => 'form-control box-size', 'placeholder' => 'Ihr max. Gesamtbudget', 'required' => 'required', 'min' => '1', 'oninput' => 'validity.valid||(value="");']) }}
                    <i class="fal fa-euro-sign"></i>
                    @if ($errors->any() && $errors->get('budget'))
                        @foreach ($errors->get('budget') as $error)
                            <span class="error-input">{{ $error }}</span>
                            <script>
                                dt.Tracking.rawEvent('{{ $whitelabel['name'] }}_exitwindow', 'Error on budget', '{{ $error }}');
                            </script>
                        @endforeach
                    @endif
                </div>
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
                <i class="master-icon--mail"></i>
                <div class="kwp-form-email-hint"></div>
                @if ($errors->any() && $errors->get('email'))
                    @foreach ($errors->get('email') as $error)
                        <span class="error-input">{{ $error }}</span>
                        <script>
                            dt.Tracking.rawEvent('{{ $whitelabel['name'] }}_exitwindow', 'Error on email', '{{ $error }}');
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
                        dt.Tracking.rawEvent('{{ $whitelabel['name'] }}_exitwindow', 'Error on terms', '{{ $error }}');
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

(function($) {
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

        $(".duration-time .txt").text(from+" - "+back);
        return false;
    });

    $(".pax-more .button a").click(function(e) {
        e.preventDefault();
        $(this).parents('.pax-col').removeClass('open');
        var pax = $("#adults").val();
        var children_count = parseInt($("#kids").val());
        var children = children_count > 0 ? (children_count == 1 ? ", "+children_count+" Kind(er)" : ", "+children_count+" Kind(er)")  : "" ;
        var pets = $("#pets").val() !== "0" ? ", "+$( "#pets option:selected" ).text() : "";
        var erwachsene = parseInt(pax) > 1 ? "Erwachsene" : "Erwachsener";
        $(".travelers .txt").text(pax+" "+erwachsene+""+children+ ""+pets);
        return false;
    });

    $(document).ready(function(){


        var whitelabelPrefix = (window.location.indexOf('reise-wunsch.de') !== -1
                                || window.location.indexOf('wish-service.com') !== -1
                                || window.location.indexOf('travelwishservice.com') !== -1
                                ) ?  wl_name+"_WL" : wl_name;

        if (wl_name !== 'bentour') {
            dt.Tracking.init(whitelabelPrefix + '_exitwindow', 'UA-105970361-21');
        }
        
        if($('.kwp-close-button i').length === 0) {
            $('.kwp-close-button').append('<i class="fal fa-times"></i>');
        }

        dt.applyLayerContent();

        dt.applyBrandColor();

        dt.adjustResponsive();

        //dt.autocomplete();

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
            onSelect: function() {
            dt.endDate.setDate(this.getDate()+1);
            dt.endDate.setMinDate(this.getDate());
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
            onSelect: function() {
            validateDuration();
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

        $(".duration-time .txt").text($("#earliest_start").val()+" - "+$("#latest_return").val());
        var $start_date = $("#earliest_start").val().split('.');
        var $end_date = $("#latest_return").val().split('.');

        dt.startDate.setDate($start_date[2]+"."+$start_date[1]+"."+$start_date[0]);
        dt.endDate.setDate($end_date[2]+"."+$end_date[1]+"."+$end_date[0]);
        validateDuration();

        var pax = $("#adults").val();
        var children_count = parseInt($("#kids").val());
        var children = children_count > 0 ? (children_count == 1 ? ", "+children_count+" Kind" : ", "+children_count+" Kinder")  : "" ;
        var pets = $("#pets").val() !== "0" ? ", "+$( "#pets option:selected" ).text() : "";
        var erwachsene = parseInt(pax) > 1 ? "Erwachsene" : "Erwachsener";
        $(".travelers .txt").text(pax+" "+erwachsene+" "+children+ ""+pets);

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
    }

    function validateDuration() {
        if($("#duration").val()){
            return false;
        }
        var days_diff = (dt.endDate.getDate() - dt.startDate.getDate()) / 60000 / 60 / 24;
        var $element = $('#duration > option');
        $element.attr('disabled',false) ;
        $element.each(function() {
            var $value_arr = $(this).val().split("-");
            var $value = $value_arr.length > 1 && $value_arr[1] ? parseInt($value_arr[1]) : ($value_arr.length > 1 ? parseInt($value_arr[0]) : parseInt($value_arr[0])+1 );

            if($value > days_diff){
            $(this).attr('disabled','disabled');
            }
        });
        if($element.parent().val()) {
            $element.removeAttr('selected').parent().val('');
        }
    }
})(jQuery);

</script>
