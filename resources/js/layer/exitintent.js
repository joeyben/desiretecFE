var timeoutID;

window.exitIntent = {
    delay: 5,
    showOnDelay: false,
    cookieExp: 0,
    sessionOnly: false,
    inactivitySeconds: 5,
    showPerSessionNumber: 1,

    // Object for handling cookies, taken from QuirksMode
    // http://www.quirksmode.org/js/cookies.html
    cookieManager: {
        // Create a cookie
        create: function (name, value, days, sessionOnly) {
            var expires = "";

            if (sessionOnly)
                expires = "; expires=0";
            else if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toGMTString();
            }

            document.cookie = name + "=" + value + expires + "; path=/";
        },

        // Get the value of a cookie
        get: function (name) {
            var nameEQ = name + "=";
            var ca = document.cookie.split(";");

            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == " ") c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
            }

            return null;
        },

        // Delete a cookie
        erase: function (name) {
            this.create(name, "", -1);
        }
    },

    // Handle exit intent cookie
    checkCookie: function () {
        //&& this.cookieManager.get("exit_intent_number") >= exitIntent.showPerSessionNumber
        return this.cookieManager.get("exitintent") == "yes";
    },

    createEvent: function (type, bubbles, cancelable) {
        // Crete event on the old-fashioned way (which works with IE)
        // Create the event.
        var event = document.createEvent('Event');

        // Define that the event name
        event.initEvent(type, bubbles, cancelable);

        // Dispatch the event.
        document.dispatchEvent(event);
    },

    // Event listener initialisation for all browsers
    addEvent: function (obj, event, callback) {
        if (obj.addEventListener)
            obj.addEventListener(event, callback, false);
        else if (obj.attachEvent)
            obj.attachEvent("on" + event, callback);
    },

    resetTimer: function () {
        //clearTimeout(timeoutID);

        // timeoutID = setTimeout(this.goInactive, this.inactivitySeconds * 1000);
        //exitIntent.startTimer();
    },

    startTimer: function () {
        // wait {inactivitySeconds} seconds before calling goInactive
        //timeoutID = setTimeout(exitIntent.goInactive, exitIntent.inactivitySeconds * 1000);
    },

    goInactive: function () {
        exitIntent.createEvent('exitintent', true, true);
    },


    // Load event listeners for the popup
    loadEvents: function () {
        // Track mouseout event on document
        this.addEvent(document, "mouseout", function (e) {
            e = e ? e : window.event;

            // If this is an autocomplete element.
            if (e.target.tagName.toLowerCase() == "input")
                return;

            // Get the current viewport width.
            var vpWidth = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);

            // If the current mouse X position is within 50px of the right edge
            // of the viewport, return.
            if (e.clientX >= (vpWidth - 50))
                return;

            // If the current mouse Y position is not within 50px of the top
            // edge of the viewport, return.
            if (e.clientY >= 50)
                return;

            // Reliable, works on mouse exiting window and
            // user switching active program
            var from = e.relatedTarget || e.toElement;
            if (!from) {
                if (exitIntent.showOnDelay) {
                    setTimeout(function () {
                        this.createEvent('exitintent', true, true);
                    }, exitIntent.delay * 1000);
                } else {
                    this.createEvent('exitintent', true, true);
                }
            }
        }.bind(this));

        // detect user inactivity

        this.addEvent(document, "mousemove", this.resetTimer);
        this.addEvent(document, "mousedown", this.resetTimer);
        this.addEvent(document, "keypress", this.resetTimer);
        this.addEvent(document, "DOMMouseScroll", this.resetTimer);
        this.addEvent(document, "mousewheel", this.resetTimer);
        this.addEvent(document, "touchmove", this.resetTimer);
        this.addEvent(document, "MSPointerMove", this.resetTimer);

        //this.startTimer();

    },

    // Set user defined options for the popup
    setOptions: function (opts) {
        this.delay = (typeof opts.delay === 'undefined') ? this.delay : opts.delay;
        this.showOnDelay = (typeof opts.showOnDelay === 'undefined') ? this.showOnDelay : opts.showOnDelay;
        this.cookieExp = (typeof opts.cookieExp === 'undefined') ? this.cookieExp : opts.cookieExp;
        this.sessionOnly = (typeof opts.cookieExp === 'undefined') ? this.cookieExp : opts.sessionOnly;
        this.inactivitySeconds = (typeof opts.inactivitySeconds === 'undefined') ? this.inactivitySeconds : opts.inactivitySeconds;
        this.showPerSessionNumber = (typeof opts.showPerSessionNumber === 'undefined') ? this.showPerSessionNumber : opts.showPerSessionNumber;
    },

    // Ensure the DOM has loaded
    domReady: function (callback) {
        (document.readyState === "interactive" || document.readyState === "complete") ? callback() : this.addEvent(document, "DOMContentLoaded", callback);
    },

    // Initialize
    init: function (opts) {
        // Handle options
        if (typeof opts !== 'undefined')
            this.setOptions(opts);

        // Once the DOM has fully loaded
        this.domReady(function () {
            // Delete existing cookies
            if (exitIntent.sessionOnly) {
                exitIntent.cookieManager.erase("exitintent");
                exitIntent.cookieManager.erase("exit_intent_number");
            }

            // Handle the cookie
            if (exitIntent.checkCookie()) return;

            exitIntent.loadEvents();
        });
    }
};
