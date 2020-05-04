var dt = window.dt || {};
var exitIntent = window.exitIntent || {};

jQuery(function($){
    var scriptSrc = $('script#dt-layer').attr('src');
    var domain = scriptSrc.replace('/js/layer.js','');

    dt.defaultConfig = {
        baseUrl: domain,
        popupPath: '/show',
        popupStore:'/wish/store',
        cssPath: '/css/layer.css',
        teaserBgColor: ''
    };

    var fontAwesomeIcons = jQuery("<link>");
    fontAwesomeIcons.attr({
        rel:  "stylesheet",
        type: "text/css",
        href: "https://www.wish-service.com/fontawsome/css/all.css"
    });
    $("head").append(fontAwesomeIcons);

    dt.popupTemplate = function (variant) {

        return '' +
            '<ul class="kwp-tabs" style="display: none;"></ul>' +
            '<div class="kwp-header"></div>' +
            '<div class="kwp-close-btn"><span></span><span></span></div>' +
            '<div class="kwp-body">' +
            '</div><div style="clear:both;"></div>';
    };

    var DTTripDataDecoder = $.extend({}, dt.AbstractTripDataDecoder, {
        name: 'Master WL',
        matchesUrl: '',
        filterFormSelector: 'body',
        dictionaries: {
            'catering': {
                'AI': 'all-inclusive',
                'AP': 'all-inclusive',
                'FB': 'Vollpension',
                'FP': 'Vollpension',
                'HB': 'Halbpension',
                'HP': 'Halbpension',
                'BB': 'Frühstück',
                'AO': 'ohne Verpflegung',
                'XX': null
            },
            'cateringWeight': {
                'AI': 5,
                'AP': 5,
                'FB': 4,
                'FP': 4,
                'HB': 3,
                'HP': 3,
                'BB': 2,
                'AO': 1,
                'XX': null
            },
            'allowedDestinations': {
                1340: 'Seychellen',
                1196: 'Malediven',
                1333: 'Kapverdische Inseln'
            }
        },
        filterDataDecoders: {
            'catering': function (form, formData) {
                var catering = getUrlParams('catering') ? getUrlParams('catering') : '';
                return catering;
            },
            'hotel_category': function (form, formData) {
                var category = getUrlParams('category') ? getUrlParams('category') : '';
                return category;
            },
            'destination': function (form, formData) {
                var destination = getUrlParams('destination') ? getUrlParams('destination') : '';
                return destination;
            },
            'pax': function (form, formData) {
                var pax = getUrlParams('pax') ? getUrlParams('pax') : '';
                return pax;
            },
            'budget': function (form, formData) {
                var budget = getUrlParams('budget') ? getUrlParams('budget') : '';
                return budget;
            },
            'children': function (form, formData) {
                var kids = getUrlParams('kids') ? getUrlParams('kids') : '';
                return kids;
            },
            'age_1': function (form, formData) {
                var age1 = getUrlParams('age1') ? getUrlParams('age1') : '';
                return age1;
            },
            'age_2': function (form, formData) {
                var age2 = getUrlParams('age2') ? getUrlParams('age2') : '';
                return age2;
            },
            'age_3': function (form, formData) {
                var age3 = getUrlParams('age3') ? getUrlParams('age3') : '';
                return age3;
            },
            'earliest_start': function (form, formData) {
                var dateFrom = getUrlParams('from') ? getUrlParams('from') : '';
                return dateFrom;
            },
            'latest_return': function (form, formData) {
                var dateTo = getUrlParams('to') ? getUrlParams('to') : '';
                return dateTo;
            },
            'duration': function (form, formData) {
                var duration = getUrlParams('duration') ? getUrlParams('duration') : '';
                return duration;
            },
            'airport': function (form, formData) {
                var airport = getUrlParams('airport') ? getUrlParams('airport') : '';
                return airport;
            },
            'is_popup_allowed': function (form, formData) {
                //var step = this.getScope().IbeApi.state.stepNr;
                return true;
            }
        },
        getTripData: function () {
            var form = null,
                formData = null;

            return this.decodeFilterData(form, formData);
        },
        formatDate: function (d) {
            if (!d) {
                return null;
            }

            function pad(val, len) {
                val = String(val);
                len = len || 2;
                while (val.length < len) val = "0" + val;
                return val;
            }

            return pad(d.getDate(), 2) + '.' + pad(d.getMonth() + 1) + '.' + d.getFullYear();
        },
        getScope: function () {
            return null;
        },
        getRandomElement: function (arr) {
            return arr[Math.floor(Math.random() * arr.length)];
        },
        getVariant: function () {
            return 'eil-'+deviceDetector.device;
        }
    });
    dt.decoders.push(DTTripDataDecoder);


    dt.initCallbacks = dt.initCallbacks || [];

        dt.initCallbacks.push(function (popup) {
            exitIntent.init();
            document.addEventListener('exit-intent', function (e) {
                if(!exitIntent.checkCookie() && !popup.shown) {
                    popup.show();
                    // set cookies
                    exitIntent.cookieManager.create("exit_intent", "yes", exitIntent.cookieExp, exitIntent.sessionOnly);
                    var exitIntentNumber = exitIntent.cookieManager.get("exit_intent_number") ? Number(exitIntent.cookieManager.get("exit_intent_number")) + 1 : 1;
                    exitIntent.cookieManager.create("exit_intent_number", exitIntentNumber, exitIntent.cookieExp, exitIntent.sessionOnly);
                }
            }, false);
        });


        dt.PopupManager.closePopup = function(event) {
            event.preventDefault();

            var formSent = $('.kwp-content').hasClass('kwp-completed');

            this.modal.addClass('tmp-hidden');
            if(!formSent && $('.trigger-modal').length === 0) {
                this.trigger =
                    $('<span/>', {'class': 'trigger-modal'});
                $('body').prepend(this.trigger);
                this.trigger.fadeIn();
                if (typeof brandColor !== 'undefined') {
                    this.trigger.css({
                        'background-color': brandColor,
                    });
                }
            }

            this.shown = false;
            $("body").removeClass('mobile-layer');
            $("body, html").css({'overflow':'auto'});

            dt.Tracking.event('close', dt.Tracking.category);

        };


        dt.scrollUpDetect = function (e) {
            dt.PopupManager.layerShown = false;
            $('body').swipe( { swipeStatus:function(event, phase, direction, distance){
                if(parseInt(distance) > 50 && !dt.PopupManager.layerShown){
                    dt.showTeaser(event);
                    dt.PopupManager.layerShown = true;
                }
            }, allowPageScroll:"vertical"} );
        };

        dt.triggerButton = function(e){
            $("body").on('click tap','.trigger-modal',function () {
                $("body").addClass('mobile-layer');
                if(dt.PopupManager.teaserSwiped){
                    dt.showMobileLayer();
                }else{
                    dt.PopupManager.shown = true;
                }
                dt.PopupManager.modal.removeClass('tmp-hidden');
                $(this).remove();
                dt.Tracking.event('Trigger button click', dt.Tracking.category);
            });
        }

        dt.showMobileLayer = function (e) {
            $(".dt-modal").removeClass('teaser-on').find('.teaser').remove();
            $( ".dt-modal" ).addClass('m-open');
            dt.PopupManager.show();
            $(".dt-modal").removeClass('teaser-on');
            $("body, html").css({'overflow':'hidden'});
            //$.cookie(dt.PopupManager.mobileCookieId,'true',dt.PopupManager.cookieOptions);
            //ga('dt.send', 'event', 'Mobile Layer', 'Teaser shown', 'Mobile');
            dt.Tracking.event('Mobile layer shown', dt.Tracking.category);
        };

        dt.showTeaser = function (e) {
            $("body").addClass('mobile-layer');
            $(".dt-modal").addClass('teaser-on').show().find('.teaser').addClass('active').swipe( {
                tap:function(event, target) {
                    dt.showMobileLayer(event);
                },
                swipeLeft:function(event, distance, duration, fingerCount, fingerData, currentDirection) {
                    $(this).addClass('inactive-left');
                    removeLayer(event);
                },
                swipeRight:function(event, distance, duration, fingerCount, fingerData, currentDirection) {
                    $(this).addClass('inactive-right');
                    removeLayer(event);
                }
            });
            if (typeof brandColor !== 'undefined') {
                $(".dt-modal .teaser").css('background-color', brandColor);
            }
            dt.Tracking.event('Mobile Teaser shown', dt.Tracking.category);
        };

        dt.hideTeaser = function (e) {
            $("body").removeClass('mobile-layer');
            $(".dt-modal").remove();
        };

        $(document).ready(function (e) {

            var $event = e;
            if(deviceDetector.device === "phone") {
                dt.PopupManager.teaser = true;
                dt.PopupManager.teaserText = "Dürfen wir Sie beraten?";
                $(".dt-modal .kwp-close-btn").on('touchend',function () {
                    dt.PopupManager.closePopup(e);
                });
            }

            dt.PopupManager.init();

            dt.triggerButton($event);
            if(deviceDetector.device === "phone" && dt.PopupManager.decoder){
                dt.scrollUpDetect();
                dt.PopupManager.isMobile = true;
                $(".dt-modal").css({'top':(document.documentElement.clientHeight - 100)+"px"});
                textareaAutosize();
                $(".dt-modal .teaser").find('i').on('click touchend',function () {
                    dt.hideTeaser($event);
                });
                if(getUrlParams('autoShow')){
                    dt.showMobileLayer();
                    shown = true;
                    $(this).addClass('m-open');
                    $("body, html").css({'overflow':'hidden'});
                }
            }
            if(getUrlParams('autoShow') && !isMobile()){
                dt.PopupManager.show();
            }
        });

        $(window).on( "orientationchange", function( event ) {
            $(".dt-modal").css({'top':(document.documentElement.clientHeight - 85)+"px"});
        });

        $(window).on('resize', function() {
            dt.adjustResponsive();
        });

        // close if click outside the modal
        $(document).mouseup(function(e) {
            if($('.dt-modal-visible').length > 0) {
                var dtModal = $('.dt-modal-visible');
                var datePicker = $('.pika-single');

                if ((!dtModal.is(e.target) && dtModal.has(e.target).length === 0) &&
                    (!datePicker.is(e.target) && datePicker.has(e.target).length === 0)) {
                    dt.PopupManager.closePopup(e);
                }
            }
        });

        function isMobile(){
            if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
                return true;
            } else if( $(window).outerWidth() < 769 ) {
                return true;
            }
            return false;
        }

        function getUrlParams(params){
            var query = window.location.search.substring(1);
            var vars = query.split("&");
            var queryString = null;
            for (var i = 0; i < vars.length; i++) {
                var pair = vars[i].split("=");
                var key = decodeURIComponent(pair[0]);
                var value = decodeURIComponent(pair[1]);

                if (key === params) {
                    queryString = decodeURIComponent(value);
                    break;
                }
            }

            return queryString;
        }

        function getCookie(cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for(var i = 0; i <ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }

        function setCookie(cname, cvalue) {
            document.cookie = cname + "=" + cvalue + ";path=/";
        }

        function removeLayer(e){
            var $event = e;
            setTimeout(function(){
                dt.triggerButton($event);
                dt.PopupManager.closePopup($event);
                dt.PopupManager.teaserSwiped = true;
            }, 500);
        }

        function textareaAutosize(){
            $(document)
                .one('focus.textarea', '.kwp textarea', function(){
                    var savedValue = this.value;
                    this.value = '';
                    this.baseScrollHeight = this.scrollHeight;
                    this.value = savedValue;
                })
                .on('input.textarea', '.kwp textarea', function(){
                    var minRows = this.getAttribute('data-min-rows')|0,
                        rows;
                    this.rows = minRows;
                    rows = Math.ceil((this.scrollHeight - this.baseScrollHeight) / 16);
                    this.rows = minRows + rows;
                });
        }

        dt.applyBrandColor = function () {
            var buttons = $('.kwp .primary-btn, .kwp .pax-more .button a, .kwp .duration-more .button a');
            buttons.css({
                'background': brandColor,
                'border': '1px solid ' + brandColor,
                'color': '#fff',
            });
            buttons.hover(function(){
                $(this).css({
                    'background': '#fff',
                    'border': '1px solid ' + brandColor,
                    'color': brandColor,
                    'transition': 'all 0.3s',
                });
            }, function() {
                $(this).css({
                    'background': brandColor,
                    'border': '1px solid ' + brandColor,
                    'color': '#fff',
                });
            });

            $(".kwp-color-overlay").css('background-color', brandColor);

            $('<style>.kwp input[type="checkbox"]:checked:after { background-color: ' + brandColor + '; border: 1px solid ' + brandColor + '; }</style>').appendTo('head');
        };

        dt.handleDestination = function() {
            $('#destination').tagsinput({
                maxTags: 3,
                maxChars: 20,
                allowDuplicates: false,
                typeahead: {
                    autoSelect: false,
                    minLength: 3,
                    highlight: true,
                    source: function(query) {
                        return $.get(domain + '/destinations', {query: query});
                    }
                }
            });
            $("#destination").on('itemAdded', function(event) {
                setTimeout(function(){
                $("input[type=text]",".bootstrap-tagsinput").val("");
                }, 1);
            });
        };

        dt.handleAirport = function() {
            $('#airport').tagsinput({
                maxTags: 3,
                maxChars: 20,
                allowDuplicates: false,
                typeahead: {
                    autoSelect: false,
                    minLength: 3,
                    highlight: true,
                    source: function(query) {
                        return $.get(domain + '/airports', {query: query});
                    }
                }
            });
            $("#airport").on('itemAdded', function(event) {
                setTimeout(function(){
                $("input[type=text]",".bootstrap-tagsinput").val("");
                }, 1);
            });
        };

        dt.initLayerVersion = function() {
            var matchDomains = false;
            var currentLocation = window.location.href;

            $.each(layers, function(index, layer) {
                if(layer.layer_url.replace(/\/$/, '') == currentLocation.replace(/\/$/, '')) {
                    dt.PopupManager.version = layer.layer.path;
                    matchDomains = true;
                    return false;
                }
            });

            if(!matchDomains) {
                dt.PopupManager.version = layers[0].layer.path;
            }

            dt.PopupManager.show();
        };

        dt.showTabs = function(layers) {
            var hasTabs = layers.length > 0;
            var alreadyShown = $('.kwp-tabs .tab-link').length > 0;

            if(hasTabs && !alreadyShown) {
                $.each(layers, function(index, layer) {
                    var version = layer.layer.path;
                    var li = '<li class="tab-link" data-tab="' + version + '">' + version + '</li>';
                    $(".kwp-tabs").append(li);
                });
                $('.kwp-tabs').show();
            }
        };

        dt.showCurrentTab = function(layerName) {
            $('.kwp-tabs li').removeClass('current');
            $('.tab-content').removeClass('current');
            $('[data-tab=' + layerName + ']').addClass('current');
            $("#" + layerName).addClass('current');
        };

        dt.handleClickTabs = function() {
            $('.kwp-tabs li').click(function(event) {
                event.stopPropagation();
                event.preventDefault();
                event.stopImmediatePropagation();

                $(this).addClass('current');
                dt.PopupManager.version = $(this).attr('data-tab');
                dt.PopupManager.shown = false;
                dt.PopupManager.show();
            });
        }

        dt.fillContent = function(layer, hasTabs) {
            $('.kwp-logo').css({
                'background-image': "url(" + whitelabel.attachments.logo + ")"
            });

            if (layer.headline_color == 'dark') {
                $('.kwp-header-dynamic h1').css({'color': '#454545'});
            } else if (layer.headline_color == 'light') {
                $('.kwp-header-dynamic h1').css({'color': '#fff', 'text-shadow': '0 1px 0 #000'});
            }

            if(!hasTabs) {
                $('.kwp-close-btn').css({'top': '15px'});
                if (layer.headline_color == 'dark') {
                    $('.kwp-close-btn span').css({'background': '#454545', 'height': '1.5px'});
                } else if (layer.headline_color == 'light') {
                    $('.kwp-close-btn span').css({'background': '#fff', 'height': '1.5px'});
                }
            } else {
                $('.kwp-close-btn span').css({'background': '#454545'});
            }

            if (layer.attachments !== undefined && layer.attachments.length != 0) {
                $('.kwp-header-dynamic').css({
                    'background-image': "url(" + layer.attachments[0].url + ")"
                });
            } else {
                $('.kwp-header-dynamic').css({
                    'background': "url(https://i.imgur.com/lJInLa9.png) 48% 68%"
                });
            }

            if(!$(".kwp-content").hasClass('kwp-completed')) {
                $('.kwp-header-text h1').text(layer.headline);
                $('.kwp-middle').text(layer.subheadline);
                $('#datenschutz').attr('href', layer.privacy);
                $('#agb_link').attr('href', whitelabel.domain + '/tnb');
            } else {
                $('.kwp-completed h1').text(layer.headline_success);
                $('.kwp-completed p').text(layer.subheadline_success);
            }
        };

        dt.adjustResponsive = function(){
            if( $(window).outerWidth() <= 768 ) {
                dt.PopupManager.isMobile = true;

                $('.kwp-header-text h1').text('Dürfen wir Sie beraten?');

                $("body").addClass('mobile-layer');
                $(".dt-modal").addClass('m-open');

                $(".kwp-color-overlay").css('opacity', '1');

                $('.error-input').siblings('i').css('bottom', '30px');

                $('.dt-modal .submit-col').detach().appendTo('.footer-col');
            } else {
                dt.PopupManager.isMobile = false;

                $("body").removeClass('mobile-layer');
                $(".dt-modal").removeClass('m-open');

                $(".kwp-color-overlay").css('opacity', '0');

                $('.footer-col .submit-col').detach().appendTo('.kwp-content .kwp-row:last-child');
            }
        };

        dt.handleDuration = function() {
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

            $(".duration-more .button a").click(function(e) {
                e.preventDefault();
                $(this).parents('.duration-col').removeClass('open');
                var from = $("#earliest_start").val();
                var back = $("#latest_return").val();
                var duration = $("#duration option:selected").text();

                $(".duration-time .txt").text(from+" - "+back+", "+duration);
                return false;
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

            $(".duration-time .txt").text($("#earliest_start").val()+" - "+$("#latest_return").val()+", "+$("#duration option:selected").text());

            $("#latest_return").trigger("change");
        };

        dt.handleTriggers = function() {
            $(".dd-trigger").click(function(e) {
                if(!$(this).parents('.main-col').hasClass('open')){
                    $('.main-col').removeClass('open')
                    $(this).parents('.main-col').addClass('open');
                }else
                    $(this).parents('.main-col').removeClass('open');

                $('.kwp-content').animate({ scrollTop: $(this).offset().top}, 500);
            });
        };

        dt.hanglePax = function() {
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

            var pax = $("#adults").val();
            var children_count = parseInt($("#kids").val());
            var children = children_count > 0 ? (children_count == 1 ? ", "+children_count+" Kind" : ", "+children_count+" Kinder")  : "" ;
            var erwachsene = parseInt(pax) > 1 ? "Erwachsene" : "Erwachsener";
            $(".travelers .txt").text(pax+" "+erwachsene+" "+children);
        };

        dt.handleKidsAges = function () {
            (function ($, children, age) {
                function update() {
                    var val = $(children).val();

                    if (val>0) {
                        $('.kwp-col-ages').addClass('kwp-show-ages');
                    } else {
                        $('.kwp-col-ages').removeClass('kwp-show-ages');
                    }

                    var i;

                    for (i = 1; i <= 4; ++i) {

                        if (i <= val) {
                            $(age + i).find('.kwp-custom-select').show();
                        } else {
                            $(age + i +' select').val('').find('.kwp-custom-select').hide();
                            $(age + i).find('.kwp-custom-select').hide();
                        }

                        if(i == val){
                            $(age + i).closest('.kwp-col-3').addClass('last');
                        }else{
                            $(age + i).closest('.kwp-col-3').removeClass('last');
                        }
                    }
                    $( "select[name='ages1']" ).change(function() {
                        $("input[name='ages']").val($("select[name='ages1'] option:selected").text() + '/' + $("select[name='ages2'] option:selected").text() + '/' + $("select[name='ages3'] option:selected").text() + '/' + $("select[name='ages4'] option:selected").text() + '/')
                    });
                    $( "select[name='ages2']" ).change(function() {
                        $("input[name='ages']").val($("select[name='ages1'] option:selected").text() + '/' + $("select[name='ages2'] option:selected").text() + '/' + $("select[name='ages3'] option:selected").text() + '/' + $("select[name='ages4'] option:selected").text() + '/')
                    });
                    $( "select[name='ages3']" ).change(function() {
                        $("input[name='ages']").val($("select[name='ages1'] option:selected").text() + '/' + $("select[name='ages2'] option:selected").text() + '/' + $("select[name='ages3'] option:selected").text() + '/' + $("select[name='ages4'] option:selected").text() + '/')
                    });
                    $( "select[name='ages4']" ).change(function() {
                        $("input[name='ages']").val($("select[name='ages1'] option:selected").text() + '/' + $("select[name='ages2'] option:selected").text() + '/' + $("select[name='ages3'] option:selected").text() + '/' + $("select[name='ages4'] option:selected").text() + '/')
                    });
                }
                $(children).on('change keydown blur', update);
                update();
            })(jQuery, '#kids', '#age_');
        };

        dt.handleBudgetRange = function() {
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
                        var currency = wl_name !== 'Lastminute' ? ' €' : ' CHF';
                        $(".rangeslider-wrapper .text").text("bis "+value+currency);
                        $("#budget").val(""+value);
                    }
                    if(!$(".dt-modal .haserrors").length){
                        $('.dt-modal #submit-button').removeClass('error-button');
                    }
                },
            });

            var range = parseInt($("#budget").val().replace('.',''));
            if(range) {
                $('input[type="range"]').val(range).change();
            }
        };

        dt.handleHotelStars = function () {
            var isLastminute = wl_name === 'Lastminute';

            function restoreValue() {
                var val = $('#category').val();
                if (!val) {
                    val = 0;
                }

                highlight(parseInt(val));
            }

            function setValue(val) {
                $('#category').val(val);
                restoreValue(val);
            }

            function setText(cnt){
                if(!isLastminute) {
                    var sonnen = cnt === 1 ? "Sonne" : "Sonnen";
                } else {
                    var sonnen = cnt === 1 ? "Stern" : "Sterne";
                }
                $('.kwp-star-input').parents('.kwp-form-group').find('.text').text("ab "+cnt+" "+sonnen);
            }

            function highlight(cnt) {
                if(!isLastminute) {
                    $('.kwp-star-input .kwp-star').each(function () {
                        var val = parseInt($(this).attr('data-val'));

                        if (val <= cnt) {
                            $(this).addClass('kwp-star-full');
                        } else {
                            $(this).removeClass('kwp-star-full');
                        }
                    });
                } else {
                    $('.kwp-star-input .fa-star').each(function () {
                        var val = parseInt($(this).attr('data-val'));

                        if (val <= cnt) {
                            $(this).addClass('fas');
                            $(this).removeClass('fal');
                        } else {
                            $(this).removeClass('fas');
                            $(this).addClass('fal');
                        }
                    });
                }
                setText(cnt);
            }

            if(!isLastminute) {
                $('.kwp-star-input .kwp-star').hover(function () {
                    highlight(parseInt($(this).attr('data-val')));
                }).click(function () {
                    setValue(parseInt($(this).attr('data-val')));
                    var sonnen = parseInt($(this).attr('data-val')) === 1 ? "Sonne" : "Sonnen";
                    $('.kwp-star-input').parents('.kwp-form-group').find('.text').text("ab "+$(this).attr('data-val')+" "+sonnen);
                });
            } else {
                $('.kwp-star-input .fa-star').hover(function () {
                    highlight(parseInt($(this).attr('data-val')));
                }).click(function () {
                    setValue(parseInt($(this).attr('data-val')));
                    var sonnen = parseInt($(this).attr('data-val')) === 1 ? "Stern" : "Sterne";
                    $('.kwp-star-input').parents('.kwp-form-group').find('.text').text("ab "+$(this).attr('data-val')+" "+sonnen);
                });
            }

            $('.kwp-star-input').mouseout(function () {
                restoreValue();
            });

            restoreValue();
        };

        dt.handleErrors = function() {
            if($(".dt-modal .haserrors").length){
                $('.dt-modal #submit-button').addClass('error-button');
            }
            if($(".duration-more .haserrors").length){
                $('.duration-group').addClass('haserrors');
            }

            function check_button(){
                if(!$(".dt-modal .haserrors").length){
                    $('.dt-modal #submit-button').removeClass('error-button');
                }
            };
            $( ".haserrors input" ).keydown(function( event ) {
                $(this).parents('.haserrors').removeClass('haserrors');
                check_button();
            });
            $('.haserrors input[type="checkbox"]').change(function () {
                $(this).parents('.haserrors').removeClass('haserrors');
                check_button();
            });
        }

});
