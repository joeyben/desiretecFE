var dt = window.dt || {};
var exitIntent = window.exitIntent || {};

jQuery(function($){

    var scriptSrc = $('script#dt-layer').attr('src');
    var domain = scriptSrc.indexOf("/js/layer-njq.js") >= 0 ? scriptSrc.replace('/js/layer-njq.js','') : scriptSrc.replace('/js/layer.js','');

    dt.defaultConfig = {
        baseUrl: domain,
        popupPath: '/show',
        popupStore:'/wish/store',
        wlDataPath: '/wlData',
        cssPath: '/css/layer.css',
        wlBrandColor: ''
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

    var MasterIBETripDataDecoder = $.extend({}, dt.AbstractTripDataDecoder, {
        decodeDate: function (raw) {
            var r = /\w+\.\s+(\d+\.\d+.\d+)/.exec(raw);

            if (r === null || r.length !== 2) {
                return null;
            }

            return r[1];
        },
        name: 'TUI IBE',
        matchesUrl: 'www.tui.com/(hotel|pauschalreisen|last-minute)(/[a-z-]+)*/suchen|tuicom-itest.tui-interactive.com/(hotel|pauschalreisen|last-minute)(/[a-z-]+)*/suchen|www.tui.com/de/(hotel|pauschalreisen|last-minute)(/[a-z-]+)*/suchen|airtours.de|https://tui.reise-wunsch.de|https://tui.travelwishservice.com|https://tui.wish-service.com',
        filterFormSelector: '#ibeContainer',
        dictionaries: {
            'catering': {
                'AI': '5',
                'AP': '5',
                'FB': '4',
                'FP': '4',
                'HB': '3',
                'HP': '3',
                'BB': '2',
                'AO': '1',
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
                var lowestBoardWeigth = 100,
                    lowestBoard = null,
                    boardTypes = formData.boardTypes
                ;

                if (!boardTypes || !boardTypes.length) {
                    return null;
                }

                for (var i = 0; i < boardTypes.length; ++i) {
                    var board = boardTypes[i],
                        weight = this.dictionaries.cateringWeight[board]
                    ;

                    if (!weight) {
                        continue;
                    }

                    if (weight < lowestBoardWeigth) {
                        lowestBoard = board;
                        lowestBoardWeigth = weight;
                    }
                }
                return this.dictionaryTransformValue(this.dictionaries.catering, lowestBoard);
            },
            'category': function (form, formData) {
                return formData.category;
            },
            'destination': function (form, formData) {
                var dest = null;

                if (utag_data.destination_country_searched && this.getScope().IbeApi.state.stepNr == 4) {
                    dest = utag_data.destination_country_searched;

                    if (dest === 'Vereinigte Arabische Emirate') {
                        dest = decodeURIComponent(utag_data.destination_city_searched);
                    }

                    if(dest === 'Thailand') {
                        dest = decodeURIComponent(utag_data.search_destination);

                        if(dest == 'undefined') {
                            dest = 'Thailand';
                        }
                    }

                } else if (formData.destination) {
                    dest = formData.destination.name;
                }

                if (dest && dest.trim() == 'Portugal') {
                    return 'Algarve';
                }

                return dest;
            },
            'adults': function (form, formData) {
                var adults = 0;
                $.each(formData.travellers,function(key,value){
                    adults += parseInt(value.adults);
                });
                return adults;
            },
            'budget': function (form, formData) {
                return formData.maxPrice;
            },
            'kids': function (form, formData) {
                var childs = 0;
                $.each(formData.travellers,function(key,value){
                    childs += parseInt(value.children.length);
                });
                childs = childs > 3 ? 3 : childs;
                return childs;
            },
            'ages1': function (form, formData) {
                var ages = [];
                $.each(angular.element('#ibeContainer').scope().filters.state.travellers,function(key,value){

                    $.each(value.children,function(key_,children){
                        ages.push(children);
                    });

                });
                return ages.length > 0 ? ages[0] : 0;
            },
            'ages2': function (form, formData) {
                var ages = [];
                $.each(angular.element('#ibeContainer').scope().filters.state.travellers,function(key,value){

                    $.each(value.children,function(key_,children){
                        ages.push(children);
                    });

                });
                return ages.length > 1 ? ages[1] : 0;
            },
            'ages3': function (form, formData) {
                var ages = [];
                $.each(angular.element('#ibeContainer').scope().filters.state.travellers,function(key,value){

                    $.each(value.children,function(key_,children){
                        ages.push(children);
                    });

                });
                return ages.length > 2 ? ages[2] : 0;
            },
            'earliest_start': function (form, formData) {
                return this.formatDate(formData.startDate);
            },
            'latest_return': function (form, formData) {
                return this.formatDate(formData.endDate);
            },
            'duration': function (form, formData) {
                if (formData.duration.trim() === 'default') {
                    return null;
                }

                return formData.duration;
            },
            'extra': function (form, formData) {
                if("environmentAttributes" in formData)
                    return formData.environmentAttributes.concat(formData.familyAttributes).concat(formData.sportAttributes).join(',');
                else
                    return '';
            },
            'room_type': function (form, formData) {
                return formData.roomTypes.join(',');
            },
            'airport': function (form, formData) {
                var self = this;
                return formData.departureAirports.map(function (airport) {
                    return self.getAirportName(airport);
                }).join(', ');
            },
            /* Extra Variabels ****************************************************************************************/
            /* Lage */
            'locationAttributes': function (form, formData) {
                var locationAttributes = getUrlParams('locationAttributes') ? getUrlParams('locationAttributes') : '';
                return this.getExtraVariable(locationAttributes, 'locationAttributes');
            },
            /* Ausstattung und Service */
            'facilityAttributes': function (form, formData) {
                var facilityAttributes = getUrlParams('facilityAttributes') ? getUrlParams('facilityAttributes') : '';
                return this.getExtraVariable(facilityAttributes, 'facilityAttributes');
            },
            /* Reisethemen */
            'travelAttributes': function (form, formData) {
                var travelAttributes = getUrlParams('travelAttributes') ? getUrlParams('travelAttributes') : '';
                return this.getExtraVariable(travelAttributes, 'travelAttributes');
            },
            /* Reisethemen */
            'maxStopOver': function (form, formData) {
                var maxStopOver = getUrlParams('maxStopOver') ? getUrlParams('maxStopOver') : '';
                return this.getExtraVariable(maxStopOver, 'maxStopOver');
            },
            /* Orte */
            'cities': function (form, formData) {
                var cities = getUrlParams('cities') ? getUrlParams('cities') : '';
                return this.getExtraVariable(cities, 'cities');
            },
            /* Gästebewertungen */
            'ratings': function (form, formData) {
                var ratings = getUrlParams('ratings') ? getUrlParams('ratings') : '';
                return this.getExtraVariable(ratings, 'ratings');
            },
            /* Weiterempfehlung */
            'recommendationRate': function (form, formData) {
                var recommendationRate = getUrlParams('recommendationRate') ? getUrlParams('recommendationRate') : '';
                return this.getExtraVariable(recommendationRate, 'recommendationRate');
            },
            /* Gesamtpreis */
            'minPrice': function (form, formData) {
                var minPrice = getUrlParams('minPrice') ? getUrlParams('minPrice') : '';
                return this.getExtraVariable(minPrice, 'minPrice');
            },
            /* Zimmertyp */
            'roomType': function (form, formData) {
                var roomType = getUrlParams('roomType') ? getUrlParams('roomType') : '';
                return this.getExtraVariable(roomType, 'roomType');
            },
            /* Angebote */
            'earlyBird': function (form, formData) {
                var earlyBird = getUrlParams('earlyBird') ? getUrlParams('earlyBird') : '';
                return this.getExtraVariable(earlyBird, 'earlyBird');
            },
            /* Angebote */
            'familyAttributes': function (form, formData) {
                var familyAttributes = getUrlParams('familyAttributes') ? getUrlParams('familyAttributes') : '';
                return this.getExtraVariable(familyAttributes, 'familyAttributes');
            },
            /* Angebote */
            'wellnessAttributes': function (form, formData) {
                var wellnessAttributes = getUrlParams('wellnessAttributes') ? getUrlParams('wellnessAttributes') : '';
                return this.getExtraVariable(wellnessAttributes, 'wellnessAttributes');
            },
            /* Angebote */
            'sportAttributes': function (form, formData) {
                var sportAttributes = getUrlParams('sportAttributes') ? getUrlParams('sportAttributes') : '';
                return this.getExtraVariable(sportAttributes, 'sportAttributes');
            },
            /* Angebote */
            'airlines': function (form, formData) {
                var airlines = getUrlParams('airlines') ? getUrlParams('airlines') : '';
                return this.getExtraVariable(airlines, 'airlines');
            },
            /* Angebote */
            'hotelChains': function (form, formData) {
                var hotelChains = getUrlParams('hotelChains') ? getUrlParams('hotelChains') : '';
                return this.getExtraVariable(hotelChains, 'hotelChains');
            },
            /* Angebote */
            'operators': function (form, formData) {
                var operators = getUrlParams('operators') ? getUrlParams('operators') : '';
                return this.getExtraVariable(operators, 'operators');
            },
            /* END Extra Variabels ************************************************************************************/
            'is_popup_allowed': function (form, formData) {
                //var step = this.getScope().IbeApi.state.stepNr;
                return true;
            }
        },
        getCountryId: function () {
            var destination = this.getScope().filters.state.destination,
                countryId;

            if (!destination) {
                return null;
            }

            if (destination.regionId) {
                countryId = this.getCountryIdFromRegionId(destination.regionId);
            } else {
                countryId = destination.countryId || this.getScope().IbeApi.state.data.country.countryId;
            }

            return countryId;
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
            if (!this.scope) {
                this.scope = angular.element(this.filterFormSelector).scope();
            }

            return this.scope;
        },
        getAirportName: function (code) {
            if (!this.airports) {
                this.airports = {};

                var data = this.getScope().IbeApi.state.referenceData.airports.slice();

                data = data.concat([
                    {code: 'WEST', name: 'Deutschland West'},
                    {code: 'EAST', name: 'Deutschland Ost'},
                    {code: 'NORTH', name: 'Deutschland Nord'},
                    {code: 'SOUTH', name: 'Deutschland Süd'}
                ]);

                for (var i = 0; i < data.length; ++i) {
                    this.airports[data[i].code] = data[i].name;
                }
            }
            return this.airports[code];
        },
        getCountryIdFromRegionId: function (code) {
            if (!this.regions) {
                this.regions = {};

                var data = this.getScope().IbeApi.state.referenceData.destinations;

                for (var i = 0; i < data.length; ++i) {
                    this.regions[data[i].regionId || data[i].countryId] = data[i].countryId;
                }
            }

            return this.regions[code];
        },
        getTripData: function () {
            var form = $(this.filterFormSelector),
                formData = this.getScope().filters.state;

            return this.decodeFilterData(form, formData);
        },
        getRandomElement: function (arr) {
            return arr[Math.floor(Math.random() * arr.length)];
        },
        getVariant: function () {
            return this.getRandomElement([
                'eil-'+deviceDetector.device,
            ]);
        },
        getTrackingLabel: function (tripData, variant) {
            return variant;
        },
        getExtraVariable: function(extraVar, attrName, splitChar){
            splitChar = (splitChar === undefined) ? ';' : splitChar;
            var attributesArr = [];
            if(extraVar != ''){
                var attributes = extraVar.split(splitChar);
                $.each(attributes, function(i, e){
                    var item = attrName+'_'+e;
                    attributesArr.push($('label[for='+item+']').attr('title'));
                });
            }
            if(attributesArr.length == 0){
                return '';
            }
            return attributesArr.join(', ');
        }
    });

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

    if(domain.includes('tui')
        && !window.location.hostname.includes('wish-service')
        && !window.location.hostname.includes('travelwishservice.com')
        && !window.location.hostname.includes('reise-wunsch.de')
    ){
        dt.decoders.push(MasterIBETripDataDecoder);
    }else{
        dt.decoders.push(DTTripDataDecoder);
    }

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


        dt.closePopup = function(event) {
            event.preventDefault();

            var formSent = $('.kwp-content').hasClass('kwp-completed');

            dt.PopupManager.modal.addClass('tmp-hidden');
            if(!formSent && $('.trigger-modal').length === 0 && !domain.includes('tui')) {
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

            dt.PopupManager.modal.shown = false;
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
                if(deviceDetector.device === "phone") {
                    $("body").addClass('mobile-layer');
                    if (dt.PopupManager.teaserSwiped) {
                        dt.showMobileLayer();
                    } else {
                        dt.PopupManager.shown = true;
                    }
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
            setCookie(dt.PopupManager.mobileCookieId, 'true');
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
            dt.Tracking.event('Mobile Teaser shown', dt.Tracking.category);
        };

        dt.hideTeaser = function (e) {
            $("body").removeClass('mobile-layer');
            $(".dt-modal").remove();
        };

        $(document).ready(function (e) {

            if(domain.includes('tui') && deviceDetector.device === "phone"){
                return false;
            }

            jQuery.ajax(dt.defaultConfig.baseUrl + dt.defaultConfig.wlDataPath, {
                type: 'GET',
                contentType: 'application/x-www-form-urlencoded',
                xhrFields: {
                    withCredentials: false
                },
                success: function(response){
                    dt.defaultConfig.wlBrandColor = response.data.color;
                    $(".dt-modal .teaser").css('background-color', dt.defaultConfig.wlBrandColor);
                }
            });

            var $event = e;
            if(deviceDetector.device === "phone") {
                dt.PopupManager.teaser = true;
                dt.PopupManager.teaserText = "Dürfen wir Sie beraten?";
            }

            dt.PopupManager.init();

            if(!domain.includes('tui')) {
                dt.triggerButton($event);
            }

            if(deviceDetector.device === "phone" && dt.PopupManager.decoder && !getCookie(dt.PopupManager.mobileCookieId)){
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

            $("body").on('click touchend','.dt-modal .kwp-close-btn',function (e) {
                dt.closePopup(e);
            });
        });

        $(window).on( "orientationchange", function( event ) {
            $(".dt-modal").css({'top':(document.documentElement.clientHeight - 85)+"px"});
        });

        $(window).on('resize', function() {
            dt.adjustResponsive();
        });

        // close if click outside the modal
        $(document).mouseup(function(e) {
            // if(!domain.includes('tui')) {
            //     return false;
            // }
            // if($('.dt-modal-visible').length > 0) {
            //     var dtModal = $('.dt-modal-visible');
            //     var datePicker = $('.pika-single');

            //     if ((!dtModal.is(e.target) && dtModal.has(e.target).length === 0) &&
            //         (!datePicker.is(e.target) && datePicker.has(e.target).length === 0)) {
            //             dt.closePopup(e);
            //     }
            // }
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
                if(!domain.includes('tui')) {
                    dt.triggerButton($event);
                }
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

        dt.handleDestination = function(is_pure_autooffer) {
            $('#destination').tagsinput({
                maxTags: 3,
                maxChars: 20,
                allowDuplicates: false,
                freeInput: !is_pure_autooffer,
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

        dt.handleAirport = function(is_pure_autooffer) {
            $('#airport').tagsinput({
                maxTags: 3,
                maxChars: 20,
                allowDuplicates: false,
                freeInput: !is_pure_autooffer,
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

        $('body').on('blur', '#destination', function() {
            $(this).trigger(jQuery.Event('keypress', {which: 13}));
        });

        dt.initLayers = function() {
            var currentLocation = window.location.href.replace('https://', '').replace('http://', '');
            var notMatchedIndexes = [];

            $.each(layers, function(layerIndex, layer) {
                var matchLayerHosts = false;

                $.each(layer.hosts, function(hostIndex, host) {
                    if (host.replace(/\/$/, '') === currentLocation.replace(/\/$/, '')) {
                        matchLayerHosts = true;
                    }
                });

                if (!matchLayerHosts) {
                    notMatchedIndexes.push(layerIndex);
                }
            });

            if(layers.length !== notMatchedIndexes.length) {
                while(notMatchedIndexes.length) {
                    layers.splice(notMatchedIndexes.pop(), 1);
                }
            }

            dt.PopupManager.version = layers[0].layer.path;
            dt.PopupManager.show();
        };

        dt.showTabs = function(layers) {
            var hasTabs = layers.length > 1;
            var alreadyShown = $('.kwp-tabs .tab-link').length > 1;

            if(hasTabs && !alreadyShown) {
                $.each(layers, function(index, layer) {
                    var version = layer.layer.path;
                    var name = layer.layer.name;
                    var li = '<li class="tab-link" data-tab="' + version + '">' + name + '</li>';
                    $(".kwp-tabs").append(li);
                });
                if(layers.length > 6) {
                    $('.kwp-tabs').css('height', '80px');
                }
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
                'background-image': "url(" + layer.logo + ")"
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

            if(domain.includes('schlosshotel')) {
                $('.kwp-close-btn').css({'background': '#fff'});
                $('.kwp-close-btn span').css({'background': '#8b2939', 'height': '1.5px', 'top': '7px'});
            }

            if (layer.visual !== undefined) {
                $('.kwp-header-dynamic').css({
                    'background-image': "url(" + layer.visual + ")"
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
                var text = dt.translation ? dt.translation.layer_title : "Dürfen wir Sie beraten?";
                $('.kwp-header-text h1').text(text);

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
                var options = document.getElementById("duration") ? document.getElementById("duration").getElementsByTagName("option") : [];
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

        dt.hanglePax = function(adultLabel) {
            $(".pax-more .button a").click(function(e) {
                e.preventDefault();
                $(this).parents('.pax-col').removeClass('open');
                var pax = $("#adults").val();
                var children_count = parseInt($("#kids").val());
                var children = children_count > 0 ? (children_count == 1 ? ", "+children_count+" "+dt.translation.kid : ", "+children_count+" "+dt.translation.kids)  : "" ;

                var erwachsene = parseInt(pax) > 1 || parseInt(pax) == 0 ? dt.translation.adults : dt.translation.adult;
                $(".travelers .txt").text(pax+" "+erwachsene+" "+children);
                return false;
            });

            var pax = $("#adults").val();
            var children_count = parseInt($("#kids").val());
            var children = children_count > 0 ? (children_count == 1 ? ", "+children_count+" "+dt.translation.kid : ", "+children_count+" "+dt.translation.kids)  : "" ;
            var erwachsene = parseInt(pax) > 1 || parseInt(pax) == 0 ? dt.translation.adults : dt.translation.adult;
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
                        $(".rangeslider-wrapper .text").text(dt.translation.price_until+" "+value+currency);
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

            var sonne_txt = dt.translation ? dt.translation.sonne : "Sonne";
            var sonnen_txt = dt.translation ? dt.translation.sonnen : "Sonnen";

            var stern_txt = dt.translation ? dt.translation.stern : "Stern";
            var sterne_txt = dt.translation ? dt.translation.sterne : "Sterne";

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
                    var sonnen = cnt === 1 ? sonne_txt : sonnen_txt;
                } else {
                    var sonnen = cnt === 1 ? stern_txt : sterne_txt;
                }
                $('.kwp-star-input').parents('.kwp-form-group').find('.text').text(dt.translation.stars_from+" "+cnt+" "+sonnen);
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
                    var sonnen = parseInt($(this).attr('data-val')) === 1 ? sonne_txt : sonnen_txt;
                    $('.kwp-star-input').parents('.kwp-form-group').find('.text').text(dt.translation.stars_from+" "+$(this).attr('data-val')+" "+sonnen);
                });
            } else {
                $('.kwp-star-input .fa-star').hover(function () {
                    highlight(parseInt($(this).attr('data-val')));
                }).click(function () {
                    setValue(parseInt($(this).attr('data-val')));
                    var sonnen = parseInt($(this).attr('data-val')) === 1 ? stern_txt : sterne_txt;
                    $('.kwp-star-input').parents('.kwp-form-group').find('.text').text(dt.translation.stars_from+" "+$(this).attr('data-val')+" "+sonnen);
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

        dt.translateWordings = function (translation) {
            dt.translation = translation;
        }
});
