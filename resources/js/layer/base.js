var dt = window.dt || {};

var isDtDomain = window.location.href.indexOf("wish-service.com") > -1 
            || window.location.href.indexOf("reise-wunsch.de") > -1 
            || window.location.href.indexOf("travelwishservice.com") > -1;

if(!isDtDomain) {
    jQuery.noConflict(); /* for websites using libraries in conflict with '$' */
}

jQuery(function($) {
    var Debug = {
        enabled: window.dt && window.dt.debug,
        log: function(message, color) {
            if(!this.enabled) {
                return;
            }

            if(typeof color !== undefined) {
                console.log('%cKwizzme Popup: ' + message, 'color: ' + color + '; background: #f5f5f5;');
                return;
            }

            console.log(message);
        },
        error: function(message) {
            this.log(message, '#F42C4C');
        },
        info: function(message) {
            this.log(message, '#30AEEB');
        },
        warning: function(message) {
            this.log(message, '#FFC83C');
        },
        success: function(message) {
            this.log(message, '#0ADF71');
        }
    };

    if (typeof window.dt.PopupManager !== 'undefined') {
        Debug.warning('Popup script is already loaded. Preventing double load.');
        return;
    }

    dt.decoders = [];

    dt.AbstractTripDataDecoder = {
        filterDataDecoders: {},
        filterFormSelector: null,
        name: 'Abstract Decoder',
        matchesUrl: '',
        trim: function(str, pattern) {
            if(typeof pattern === 'undefined') {
                pattern = '\\s';
            }

            var regexp = new RegExp('^(' + pattern + ')+|(' + pattern + ')+$', 'g');

            return str.replace(regexp, '');
        },
        formArrayToObject: function(arr) {
            var obj = {};
            console.log(arr);

            for(var i = 0; i < arr.length; ++i) {
                if (!arr[i]) {
                    /* Sometimes elements are null... Broken jQuery or markup? */
                    continue;
                }

                var name = arr[i].name,
                    value = arr[i].value;

                if(/^.*\[\]$/.test(name)) {
                    name = this.trim(name, '\\s|\\[\\]');

                    if(typeof obj[name] === 'undefined') {
                        obj[name] = [];
                    }

                    obj[name].push(value);
                    continue;
                }

                obj[name] = value;
            }

            return obj;
        },
        decodeFilterData: function(form, formData) {
            var tripData = {};

            for(var prop in this.filterDataDecoders) {
                if(!this.filterDataDecoders.hasOwnProperty(prop)) {
                    continue;
                }

                var val = this.filterDataDecoders[prop].call(this, form, formData);

                if(!val) {
                    continue;
                }

                tripData[prop] = val;
            }

            return tripData;
        },
        getTripData: function() {
            var form = jQuery(this.filterFormSelector),
                formData = this.formArrayToObject(form.serializeArray());

            return this.decodeFilterData(form, formData);
        },
        getSelectText: function(name, value, trimPattern) {
            return this.trim(jQuery(this.filterFormSelector)
                .find('select[name="' + name + '"] option[value="' + value + '"]').text(), trimPattern);
        },
        dictionaryTransformValue: function(dictionary, key, prop) {
            if(!dictionary.hasOwnProperty(key)) {
                return null;
            }

            if(typeof prop !== 'undefined') {
                return dictionary[key][prop];
            }

            return dictionary[key];
        },
        dictionaryTransformArray: function(dictionary, keys, prop) {
            if(typeof keys === 'undefined') {
                return null;
            }

            var result = [];

            for(var i = 0; i < keys.length; ++i) {
                var key = keys[i],
                    value = this.dictionaryTransformValue(dictionary, key, prop);

                if(null === value || jQuery.inArray(value, result) > -1) {
                    continue;
                }

                result.push(value);
            }

            if(result.length == 0) {
                return null;
            }

            return result;
        },
        getTrackingLabel: function(tripData, variant) {
            return variant;
        }
    };

    dt.PopupManager = {
        initialized: false,
        decoder: null,
        popup: null,
        popupBody: null,
        isZeroResult: null,
        variant: null,
        trackingLabel: null,
        back: false,
        next: false,
        blocked: false,
        isMobile: false,
        mobileCookieId: 'm_kiwzzme',
        regionCodes:{},
        testCookieId: 'desiretec',
        shown: false,
        teaser:false,
        teaserText: "Darf ich Sie beraten?",
        init: function() {
            if (this.initialized) {
                Debug.warning('Popup script is already initialized. Preventing double init.');
                return;
            }

            Debug.info('Initializing...');

            this.config = jQuery.extend({}, dt.defaultConfig, window.dt.config);

            this.selectDecoder();

            if (this.decoder) {
                Debug.success('Selected decoder: ' + this.decoder.name);
            }

            this.shown = false;

            this.installStyles();
            this.createPopup();

            if(jQuery.isArray(window.dt.initCallbacks)) {
                for(var i = 0; i < window.dt.initCallbacks.length; ++i) {
                    window.dt.initCallbacks[i](this);
                }
            }

            this.initialized = true;
        },
        setBack: function(event) {
            jQuery('input[name="step"]').val(1);
            this.back = true;
            this.onFormSubmit(event);
        },
        setNext: function(event) {
            this.next = true;
            this.onFormSubmit(event);
        },
        setVariant: function() {
            if (this.decoder && typeof this.decoder.getVariant === 'function') {
                this.variant = this.decoder.getVariant();
            }

            Debug.info('Variant selected: ' + this.variant);
        },
        installStyles: function() {
            jQuery('head').append(
                jQuery('<link rel="stylesheet" type="text/css" media="all" href="' + this.config.baseUrl + this.config.cssPath + '"/>')
            );
        },
        initExitIntent: function () {
            $.exitIntent('enable', { 'sensitivity': 0 });
            $(document).bind('exitintent',
                function() {
                    dt.PopupManager.show();
                });
        },
        selectDecoder: function() {
            for(var i = 0; i < dt.decoders.length; ++i) {
                var decoder = dt.decoders[i],
                    regex = new RegExp(decoder.matchesUrl);

                Debug.info('Trying ' + decoder.name);

                if(regex.test(String(window.location))) {
                    this.decoder = decoder;
                    return;
                }
            }

            Debug.error('No suitable decoder found!');
        },
        fetchPopup: function() {
            var tripData;

            if (this.decoder) {
                tripData = this.decoder.getTripData();

                if (!tripData.is_popup_allowed) {
                    Debug.warning('Popup canceled because popup not allowed here.');
                    return false;
                }

                if(typeof tripData.is_zero_result !== 'undefined') {
                    this.isZeroResult = tripData.is_zero_result;
                }

                this.setVariant();
                this.createPopup();
            } else {
                if (window.dt.force) {
                    tripData = {};
                    this.setVariant();
                    this.createPopup();
                } else {
                    jQuery.error('Popup not allowed.');
                    return false;
                }
            }

            this.trackingLabel = this.decoder.getTrackingLabel(tripData, this.variant);

            this.popupBody.html('<div class="kwp-spinner"></div>');

            tripData.first_fetch = 'yes';

            jQuery.ajax(this.config.baseUrl + this.config.popupPath + this.getQueryPart(), {
                type: 'GET',
                data: tripData,
                dataType: 'html',
                contentType: 'application/x-www-form-urlencoded',
                success: jQuery.proxy(this.onPopupFetched, this),
                xhrFields: {
                    withCredentials: false
                }
            });

            if (typeof window.dt.triggerCallback === 'function') {
                window.dt.triggerCallback();
            }
            if(!this.shown){
                // mixpanel.track(
                //    "Show Layer"
                // );
                dt.Tracking.event('shown', this.trackingLabel);
                this.shown = true;
            }
            this.showPopup();

            var data = this.popup.find('form').serializeArray().reduce(function(obj, item) {
                obj[item.name] = item.value;
                return obj;
            }, {});

            // mixpanel.identify(data.data_id);

            return true;
        },
        onPopupFetched: function(data, status, jqxhr) {
            var json;
            try {
                json = JSON.parse(data);
            }
            catch(err) {
                json = JSON.decode(data); /* solution for website where JSON.parse is not working */
            }
            this.showContent(json.html);
        },
        show: function() {
            Debug.info('::show:start');

            if(this.shown || this.blocked) {
                return;
            }

            this.shown = this.fetchPopup();

            if (this.shown) {
                if (typeof dt.exitIntent !== 'undefined') {
                    dt.exitIntent.setCookie();
                }
            }

            if (this.shown) {
                Debug.info('::shown');
            }
        },
        changeTexts: function(headline, tagline) {
            this.popup.find('.kwp-header-content h1').html(headline);
            this.popup.find('.kwp-header-content p').html(tagline);
        },
        showContent: function(content) {
            this.popupBody.html(content);
            this.popup.find('#back-button').click($.proxy(this.setBack, this));
            this.popup.find('#submit-button').click($.proxy(this.onFormSubmit, this));
            this.popup.find('#next-button').click($.proxy(this.setNext, this));
            this.popup.find('.kwp-close').click($.proxy(this.closePopup, this));
            if($(".kwp-content").hasClass('kwp-completed-tui') || $(".kwp-content").hasClass('kwp-completed')){
                if( dt.PopupManager.isMobile){
                    $(".kwp-header").hide();
                }
                $(".kwp-header").addClass('success');
                $(".kwp-header-content").addClass('hidden-content');
            }else{
                if(dt.PopupManager.decoder.name == "TUI IBE"){

                }else {

                }
            }

        },
        showPopup: function() {
            var self = this;

            this.modal.css('display', 'block');

            setTimeout(function() {
                self.popup.addClass('dt-modal-visible');
                if(self.variant === "steps"){
                    self.popup.addClass('steps');
                }
            }, 2);
            Debug.info('::showPopup');
        },
        onBackdropClick: function(event) {
            if(event && event.target && !jQuery(event.target).is(this.modal)) {
                return;
            }

            this.closePopup(event)
        },
        closePopup: function(event) {
            event.preventDefault();

            this.modal.css('display', 'none');
            this.shown = false;

            dt.Tracking.event('close', this.trackingLabel);
            // mixpanel.track(
            //     "Close Layer"
            // );
        },
        createPopup: function() {
            this.initGA();
            if(null === this.popup) {
                this.popup = jQuery('<div/>', {'class': 'kwp'});

                this.modal =
                    jQuery('<div/>', {'class': 'dt-modal'})
                        .hide()
                        .append(this.popup)
                //.click(jQuery.proxy(this.onBackdropClick, this))
                ;
                if(dt.PopupManager.teaser){
                    this.teaser = jQuery('<div/>', {'class': 'teaser'}).append('<h1>'+this.teaserText+'</h1><i class="fal fa-times"></i>').css('background-color', dt.config.teaserBgColor);
                    this.modal.append(this.teaser);
                }
                jQuery('body').prepend(this.modal);
            }

            var html = dt.popupTemplate;

            if (typeof html === 'function') {
                if (!this.variant) {
                    Debug.warning('Template is object but no variant set, skipping...');
                    return;
                }

                html = html(this.variant);
            }

            this.popup.html(html);
            this.popupBody = this.popup.find('.kwp-body');

        },
        initGA: function(){
            jQuery.ajax(this.config.baseUrl + "/gwl", {
                type: 'GET',
                data: {},
                dataType: 'html',
                contentType: 'application/x-www-form-urlencoded',
                success: jQuery.proxy(this.onHostname, this),
                xhrFields: {
                    withCredentials: false
                }
            });
        },
        onHostname: function (data, status, jqxhr) {
            var json;
            try {
                json = JSON.parse(data);
            }
            catch(err) {
                json = JSON.decode(data); /* solution for website where JSON.parse is not working */
            }
            if(json.success && !json.whitelabel_name.includes('bentour')){
                dt.Tracking.init(json.whitelabel_name + '_exitwindow', 'UA-105970361-21');
            }else{
                return false;
            }
        }, getQueryPart: function() {
            var part = '';

            if (this.variant) {
                part +=  '?variant=' + this.variant;
            }

            if(this.back) {
                part += '&back=true'
            }

            if(this.next) {
                part += '&next=true'
            }

            return part;
        },
        onFormSubmit: function(event) {
            event.preventDefault();

            if(typeof window.dt.conversionCallback === 'function') {
                window.dt.conversionCallback();
            }

            var formData = this.popup.find('form').serialize();
            var data = this.popup.find('form').serializeArray();

            var dataArray = data.reduce(function(obj, item) {
                obj[item.name] = item.value;
                return obj;
            }, {});
            this.popupBody.html('<div class="kwp-spinner"></div>');

            jQuery.ajax(this.config.baseUrl + this.config.popupStore + this.getQueryPart(), {
                type: 'GET',
                data: formData,
                dataType: 'html',
                crossDomain: true,
                contentType: 'application/x-www-form-urlencoded',
                success: jQuery.proxy(this.onPopupFetched, this),
                xhrFields: {
                    withCredentials: false
                }
            });

            dt.Tracking.event('Submit-Button', this.trackingLabel);
            /*  mixpanel.track(
                  "Layer submitted",
                  {
                      "__email": dataArray.__email,
                      "__name": dataArray.__name,
                      "age_1": dataArray.age_1  ? dataArray.age_1: "",
                      "age_2": dataArray.age_2  ? dataArray.age_2: "",
                      "age_3": dataArray.age_3  ? dataArray.age_3: "",
                      "airport": dataArray.airport,
                      "budget": dataArray.budget,
                      "catering": dataArray.catering,
                      "children": dataArray.children,
                      "description": dataArray.description,
                      "destination": dataArray.destination,
                      "duration": dataArray.duration,
                      "earliest_start": dataArray.earliest_start,
                      "hotel_category": dataArray.hotel_category,
                      "latest_return": dataArray.latest_return,
                      "pax": dataArray.pax
                  }
              );

              mixpanel.people.set({
                  "$name": dataArray.__name,
                  "$email": dataArray.__email
              });*/

            this.back = false;
            this.next = false;
        }
    };

    dt.Tracking = {
        isInitialized: false,
        category: 'exit_window',
        init: function(category, TrackingId) {
            if (typeof window.ga === 'undefined') {
                (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
                window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
            }



            ga('create', TrackingId, 'auto', {'name': 'DesireTec'});
            ga('DesireTec.set', 'anonymizeIp', true);

            if(window.dt && window.dt.debug) {
                window.ga_debug = {trace: true};
            }

            this.isInitialized = true;

            if(typeof category !== 'undefined') {
                this.category = category;
            }
        },
        initMixpanel: function(siteId){

            /*(function(e,a){if(!a.__SV){var b=window;try{var c,l,i,j=b.location,g=j.hash;c=function(a,b){return(l=a.match(RegExp(b+"=([^&]*)")))?l[1]:null};g&&c(g,"state")&&(i=JSON.parse(decodeURIComponent(c(g,"state"))),"mpeditor"===i.action&&(b.sessionStorage.setItem("_mpcehash",g),history.replaceState(i.desiredHash||"",e.title,j.pathname+j.search)))}catch(m){}var k,h;window.mixpanel=a;a._i=[];a.init=function(b,c,f){function e(b,a){var c=a.split(".");2==c.length&&(b=b[c[0]],a=c[1]);b[a]=function(){b.push([a].concat(Array.prototype.slice.call(arguments,
                0)))}}var d=a;"undefined"!==typeof f?d=a[f]=[]:f="mixpanel";d.people=d.people||[];d.toString=function(b){var a="mixpanel";"mixpanel"!==f&&(a+="."+f);b||(a+=" (stub)");return a};d.people.toString=function(){return d.toString(1)+".people (stub)"};k="disable time_event track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config reset people.set people.set_once people.increment people.append people.union people.track_charge people.clear_charges people.delete_user".split(" ");
                for(h=0;h<k.length;h++)e(d,k[h]);a._i.push([b,c,f])};a.__SV=1.2;b=e.createElement("script");b.type="text/javascript";b.async=!0;b.src="undefined"!==typeof MIXPANEL_CUSTOM_LIB_URL?MIXPANEL_CUSTOM_LIB_URL:"file:"===e.location.protocol&&"//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js".match(/^\/\//)?"https://cdn.mxpnl.com/libs/mixpanel-2-latest.min.js":"//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js";c=e.getElementsByTagName("script")[0];c.parentNode.insertBefore(b,c)}})(document,window.mixpanel||[]);
            mixpanel.init("a7f133d26ec0d61821d143437f67f6f3");*/


            /*  mixpanel.people.set({
                  "$siteID": siteId
              });
              jQuery('body').on('blur','.dt-modal input[type=text]',function() {
                  mixpanel.track(
                      jQuery(this).attr('name'),
                      {'value':jQuery(this).val()}
                  )
              });*/
        },
        rawEvent: function (category, action, label) {
            ga('DesireTec.send', 'event', category, action, label);
        },
        event: function(action, label) {
            if(!this.isInitialized) {
                return;
            }

            this.rawEvent(this.category, action, label);
        }
    };

    dt.validateEmail = function(field, hint) {
        var $field = jQuery(field),
            $hint = jQuery(hint),
            typos = {
                'tonline.de': 't-online.de',
                't-onlin.de': 't-online.de',
                't-onlne.de': 't-online.de',
                't-oline.de': 't-online.de',
                'frenet.de': 'freenet.de',
                'gemx.de': 'gmx.de',
                'gemx.net': 'gmx.net',
                'gmai.com': 'gmail.com',
                'gmal.com': 'gmail.com',
                'gmil.com': 'gmail.com'
            },
            lastVal = null,
            corrected = null;

        $hint.click(function() {
            if (corrected) {
                $field.val(corrected);
                $hint.hide();
            }
        });

        $field.on('change keyup', function() {
            var val = $field.val().trim();

            if (val === lastVal) {
                return;
            }

            lastVal = val;

            $hint.hide();

            var groups = /^([^@]+)@(.*)$/.exec(val),
                host;

            if (!groups) {
                return;
            }

            host = groups[2];
            corrected = groups[1] + '@' + typos[host];

            if (typos[host] !== undefined) {
                $hint.html('Meinten Sie <strong>' + corrected + '</strong>?');
                $hint.fadeIn(100);
            }
        });
    };

    if(window.dt && window.dt.debug) {
        jQuery(document).keypress(function (e) {
            if (e.charCode == 103) {
                dt.PopupManager.show();
            }
        });
    }

});

