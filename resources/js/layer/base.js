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
                console.log('%cPopup: ' + message, 'color: ' + color + '; background: #f5f5f5;');
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
        version: null,
        trackingLabel: null,
        back: false,
        next: false,
        blocked: false,
        isMobile: false,
        mobileCookieId: 'm_desiretec',
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
                if(!dt.PopupManager.isMobile){
                    dt.Tracking.event('shown', this.trackingLabel);
                }
                this.shown = true;
            }
            this.showPopup();

            var data = this.popup.find('form').serializeArray().reduce(function(obj, item) {
                obj[item.name] = item.value;
                return obj;
            }, {});

            return true;
        },
        onPopupFetched: function(data, status, jqxhr) {
            var json;
            try {
                json = JSON.parse(data);
            }
            catch(err) {
                json = JSON.decode(data); /* solution for a website where JSON.parse is not working */
            }
            this.showContent(json.html);
        },
        show: function() {
            Debug.info('::show:start');

            if((this.shown || this.blocked) && !this.version) {
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
        showContent: function(content) {
            this.popupBody.html(content);
            this.popup.find('#back-button').click($.proxy(this.setBack, this));
            this.popup.find('#submit-button').click($.proxy(this.onFormSubmit, this));
            this.popup.find('#next-button').click($.proxy(this.setNext, this));
            //this.popup.find('.kwp-close-btn').click($.proxy(this.closePopup, this));
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
                    this.teaser = jQuery('<div/>', {'class': 'teaser'}).append('<h1>'+this.teaserText+'</h1><i class="fal fa-times"></i>');
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

            if(this.version) {
                part += '&version=';
                part += this.version;
            }

            if(this.back) {
                part += '&back=true'
            }

            if(this.next) {
                part += '&next=true'
            }

            part +=  '&currentUrl=' + window.location.href.split('?')[0];

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

