var dt = window.dt || {};
var exitIntent = window.exitIntent || {};

(function ($) {

    dt.defaultConfig = {
        baseUrl: 'http://localhost',
        popupPath: '/show',
        popupStore:'/store',
        cssPath: '/css/layer.css'
    };

    dt.popupTemplate = function (variant) {

        var texts = {
            'eil-n1-social': {
                header: 'Dürfen wir Dich beraten?',
                body: 'Unsere besten Reiseberater helfen Dir gerne, Deine persönliche Traumreise zu finden. Probiere es einfach aus! Natürlich kostenlos und unverbindlich.'
            },
            'eil-n1': {
                header: 'Dürfen wir Sie beraten?',
                body: 'Unsere besten Reiseberater helfen Ihnen gerne, Ihre persönliche Traumreise zu finden. Probieren Sie es einfach aus! Natürlich kostenlos und unverbindlich.'
            },
            'eil-n2': {
                header: 'Dürfen wir Sie beraten?',
                body: 'Unsere besten Reiseberater helfen Ihnen gerne, Ihre persönliche Traumreise zu finden. Probieren Sie es einfach aus! Natürlich kostenlos und unverbindlich.'
            },
            'eil-n3': {
                header: 'Dürfen wir Ihnen helfen?',
                body: 'Einer unserer erfahrenen Reiseberater hilft Ihnen gerne, die für Sie passende Reise zu finden. Probieren Sie es einfach kostenlos und unverbindlich aus!'
            },
            'eil-n4': {
                header: 'Dürfen wir Ihnen helfen?',
                body: 'Einer unserer erfahrenen Reiseberater hilft Ihnen gerne, die für Sie passende Reise zu finden. Probieren Sie es einfach kostenlos und unverbindlich aus!'
            },
            'eil-n5': {
                header: 'Dürfen wir Sie beraten?',
                body: 'Unsere besten Reiseberater helfen Ihnen gerne, Ihre persönliche Traumreise zu finden. Probieren Sie es einfach aus! Natürlich kostenlos und unverbindlich.'
            },
            'eil-mobile': {
                header: 'Dürfen wir Sie beraten?',
                body: 'Unsere besten Reiseberater helfen Ihnen gerne, Ihre persönliche Traumreise zu finden!'
            }
        };

        return '' +
            '<div class="kwp-header kwp-variant-' + variant + '">' +
            '<div class="kwp-close-button kwp-close"></div>' +
            '<div class="kwp-overlay"></div>' +
            '<div class="kwp-logo"></div>' +
            '<div class="kwp-header-content">' +
            '<h1>' +
            texts[variant].header + ' <br/>' +
            '</h1>' +
            '<p>' +
            texts[variant].body +
            '</p>' +
            '</div>' +
            '</div>' +
            '<div class="kwp-body '+variant+'-body">' +
            '</div><div style="clear:both;"></div>';
    };





    var KwizzmeFakeTripDataDecoder = $.extend({}, dt.AbstractTripDataDecoder, {
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
            if(isMobile()){
                return 'eil-mobile';
            }else if(getUrlParams('utm_source') && getUrlParams('utm_source') == 'social'){
                return this.getRandomElement([
                    'eil-n1-social'
                ]);
            }else{
                return this.getRandomElement([
                    'eil-n1',
                    'eil-n1',
                    'eil-n2',
                    'eil-n5'
                ]);
            }
        }
    });
    dt.decoders.push(KwizzmeFakeTripDataDecoder);


    dt.initCallbacks = dt.initCallbacks || [];
        dt.initCallbacks.push(function (popup) {
            exitIntent.init();
            document.addEventListener('exit-intent', function (e) {
                if(!exitIntent.checkCookie()) {
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

            var formSent = $('.kwp-content').hasClass('kwp-completed-master');

            this.modal.addClass('tmp-hidden');
            if(!formSent) {
                this.trigger =
                    $('<span/>', {'class': 'trigger-modal'});
                $('body').prepend(this.trigger);
                this.trigger.fadeIn();
                this.trigger.css({
                    'background-color': brandColor,
                });
            }

            this.shown = false;
            $("body").removeClass('mobile-layer');
            $("body, html").css({'overflow':'auto'});

            dt.Tracking.event('close', this.trackingLabel);

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
                ga('dt.send', 'event', 'Mobile Layer', 'Trigger button tap', 'Tablet');
            });
        }

        dt.showMobileLayer = function (e) {
            $(".dt-modal").removeClass('teaser-on').find('.teaser').remove();
            $( ".dt-modal" ).addClass('m-open');
            dt.PopupManager.show();
            $("body, html").css({'overflow':'hidden'});
            //$.cookie(dt.PopupManager.mobileCookieId,'true',dt.PopupManager.cookieOptions);
            ga('dt.send', 'event', 'Mobile Layer', 'Teaser shown', 'Mobile');
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
                $(".dt-modal .kwp-close").on('touchend',function () {
                    dt.PopupManager.closePopup(e);
                });
            }
            dt.PopupManager.init();
            dt.Tracking.init('trendtours_exitwindow','UA-105970361-14');
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

        $( window ).on( "orientationchange", function( event ) {
            $(".dt-modal").css({'top':(document.documentElement.clientHeight - 85)+"px"});
        });

        dt.childrenAges = function () {
            (function ($, children, age) {
                function update() {
                    var val = $(children).val();

                    if (val) {
                        $('.kwp-content').addClass('kwp-show-ages');
                    } else {
                        $('.kwp-content').removeClass('kwp-show-ages');
                    }

                    var i;

                    for (i = 1; i <= 3; ++i) {

                        if (i <= val) {
                            $(age + i).closest('.kwp-custom-select').show();
                        } else {
                            $(age + i).val('').closest('.kwp-custom-select').hide();
                        }

                        if(i == val){
                            $(age + i).closest('.kwp-col-3').addClass('last');
                        }else{
                            $(age + i).closest('.kwp-col-3').removeClass('last');
                        }
                    }

                }

                $(children).on('change keydown blur', update);
                update();
            })(jQuery, '#children', '#age_');
        };

        dt.hotelStars = function () {
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
                var sonnen = cnt === 1 ? "Sonne" : "Sonnen";
                $('.kwp-star-input').parents('.kwp-form-group').find('.text').text("ab "+cnt+" "+sonnen);
            }

            function highlight(cnt) {
                $('.kwp-star-input .kwp-star').each(function () {
                    var val = parseInt($(this).attr('data-val'));

                    if (val <= cnt) {
                        $(this).addClass('kwp-star-full');
                    } else {
                        $(this).removeClass('kwp-star-full');
                    }
                });
                setText(cnt);
            }

            $('.kwp-star-input .kwp-star').hover(function () {
                highlight(parseInt($(this).attr('data-val')));
            }).click(function () {
                setValue(parseInt($(this).attr('data-val')));
                var sonnen = parseInt($(this).attr('data-val')) === 1 ? "Sonne" : "Sonnen";
                $('.kwp-star-input').parents('.kwp-form-group').find('.text').text("ab "+$(this).attr('data-val')+" "+sonnen);
            });

            $('.kwp-star-input').mouseout(function () {
                restoreValue();
            });

            restoreValue();
        };


        dt.agbModal = function (e) {
            e && e.preventDefault();

            var element = null;


            var data_agb = '<section id="c45306" class="csc-default csc-content-text"> <header> <h2 class="csc-header">Bedingungen für die Nutzung des TUI Reisewunschportals</h2></header> <h3>1. Funktion des TUI Reisewunschportals, Nutzungsbedingungen</h3> <p><b>1.1.</b> Die TUI Deutschland GmbH (im Folgenden „TUI“) bietet über das Online-Tool „TUI Reisewunschportal“ (im Folgenden „System") unentgeltlich die technische Möglichkeit, Suchanzeigen nach Reiseangeboten („Reisewünsche“) aufzugeben und so persönlichen Kontakt zu Reiseberatern in teilnehmenden Reisebüros (Filialen und Partneragenturen [andere Legal Entity] der TUI Deutschland GmbH) zum Zwecke einer individuellen Kommunikation herzustellen. </p><p><b>1.2</b>. Für die Nutzung des Systems gelten diese Nutzungsbedingungen, die nach Maßgabe von Ziff. 9.1 geändert werden können. </p><h3>2. Anmeldung</h3> <p><b>2.1. </b> Das System ist über ein entsprechendes Dialogfeld auf der Website www.TUI.com sowie über www.TUI-reisewunsch.com zu erreichen. Die Nutzung des Systems setzt die Anmeldung als Nutzer voraus. </p><p><b>2.2. </b> Die Anmeldung ist nur volljährigen und unbeschränkt geschäftsfähigen Personen gestattet.</p><p><b>2.3. &nbsp;&nbsp;</b>Die Anmeldung erfolgt durch Einsendung der E-Mailadresse sowie des Reisewunsches und ggf. weiterer Suchkriterien (alles zusammenfassend: „Nutzerdaten“) sowie Akzeptanz dieser Nutzungsbedingungen über das Dialogfeld. Sie wird durch Zusendung einer Bestätigungsmail mit einem individuellen Zugangslink durch TUI Deutschland an die angegebene E-Mail-Adresse abgeschlossen. Es besteht kein Anspruch des Nutzers auf Einstellen von Inhalten.</p><p><b>2.4</b>. Über den Zugangslink kann der Nutzer seine Anfrage, einschließlich der Nutzerdaten, im System jederzeit einsehen, anpassen oder durch Betätigung einer entsprechenden Schaltfläche deaktivieren. Passt der Nutzer den Reisewunsch an oder deaktiviert ihn, verschickt das System eine entsprechende Info-Mail an ihn.</p><p><b>2.6</b>. TUI Deutschland überprüft grundsätzlich nicht die Richtigkeit der Nutzerdaten</p><p><b>2.7.</b> TUI behält sich das Recht vor, nach alleinigem Ermessen und ohne Ankündigung den Zugang von Nutzern zum System oder dessen Teilen zu verweigern und/oder den Betrieb des Systems einzustellen.</p><h3>&nbsp;</h3> <h3>3. Reisewünsche, Bearbeitung</h3> <p><b>3.1.</b> Ein Reisewunsch stellt grundsätzlich nur eine unverbindliche Anfrage und kein rechtlich bindendes Angebot dar. </p><p><b>3.2. </b> Die in das System eingegebenen Reisewünsche der Nutzer werden durch das System an ein teilnehmendes, mit TUI Deutschland kooperierendes Reisebüro weitergeleitet, das sich vorher im TUI Reisewunschportal registriert hat und nach eigener Angabe über besondere Kompetenz für das betreffende Zielgebiet verfügt. Die Verteilung erfolgt automatisiert nach den Kriterien: 1. Standort des Nutzers, 2. Expertise eines Reisebüros für das jeweilige Zielgebiet.</p><p><b>3.3.</b> Die Reisewünsche werden nicht veröffentlicht.</p><p><b>3.4.</b> Reisebüros können auf einen Reisewunsch mit einem Angebotsvorschlag gegenüber dem Nutzer reagieren. Auch dieser Vorschlag ist grundsätzlich rechtlich unverbindlich, soweit darin nichts anderes bestimmt ist </p><p><b>3.5.</b> Nachdem ein Reisebüro eine Anfrage bearbeitet und das Ergebnis (Nachfrage bzw. Angebot) in das System eingestellt hat, bekommt der Nutzer eine E-Mail, in der erneut ein Link zu der Anfrage und dem Feedback/ Angebot enthalten ist </p><p><b>3.6.</b> Der Nutzer, welcher den Reisewunsch eingestellt hat, kann auf den Vorschlag hin das Reisebüro kontaktieren. Er ist jedoch nicht verpflichtet, auf einen Vorschlag zu reagieren.</p><p><b>3.7.</b> Der Nutzer kann wählen, über welchen Weg (E-Mail, Telefon, persönlich vor Ort) er weiter mit dem Reisebüro kommunizieren möchte. Solange der Nutzer dem Reisebüro keine Kontaktdaten für einen Direktkontakt mitteilt, erfolgt die beschriebene Kommunikation zwischen Nutzer und Reisebüro ausschließlich über das System als Absender von Nachrichten in beide Richtungen. </p><h3>&nbsp;</h3> <h3>4. Rechtbeziehungen</h3> <p><b>4.1.</b> Die Leistung von TUI Deutschland im Rahmen des Systems ist allein die Übermittlung der Nachrichten zwischen den Nutzern und den Reisebüros. Für die Systembereitstellung können Erfüllungsgehilfen eingesetzt werden. </p><p><b>4.2.</b> Sofern infolge der Nutzung des Systems ein Kontakt zwischen dem Nutzer und einem Reisebüro zustande kommt, bestehen etwaige daraus resultierende Rechtsbeziehungen ausschließlich zwischen diesen Parteien. TUI Deutschland ist hieran nicht beteiligt. Daher ist TUI Deutschland auch nicht für die Erfüllung von Verträgen, die zwischen den Nutzern und den Reisebüros und/oder von diesen vermittelten Leistungsträgern geschlossen wurden, verantwortlich. </p><h3>&nbsp;</h3> <h3>5. Pflichten des Nutzers, Verantwortung für Inhalte</h3> <p><b>5.1.</b> Der Nutzer ist verpflichtet, den Zugangslink geheim zu halten.</p><p><b>5.2.</b> Der Nutzer ist grundsätzlich für alle über seinen Zugangslink vorgenommenen Aktivitäten verantwortlich. Die Regelungen dieses Absatzes gelten nicht, wenn der Nutzer einen etwaigen Missbrauch seines Zugangslinks nicht zu vertreten hat, weil keine Sorgfaltspflichtverletzung des Nutzers vorliegt. Der Nutzer ist verpflichtet, TUI Deutschland umgehend zu informieren, wenn er Anhaltspunkte für einen Missbrauch seines Zugangslinks durch Dritte hat.</p><p><b>5.3.</b> Der Nutzer ist verpflichtet, bei Einstellung von Reisewünschen und sonstigen Inhalten sämtliche geltenden Rechtsvorschriften, Rechte Dritter und diese Nutzungsbedingungen zu beachten. Er ist für die Rechtmäßigkeit, Richtigkeit und Vollständigkeit aller von ihm eingestellten Inhalte verantwortlich und haftet für die Verletzung von Rechtsvorschriften oder von Rechten Dritter durch von ihm eingestellte Inhalte</p><p><b>5.4.</b> TUI Deutschland überprüft die in das System eingestellten Inhalte der Nutzer grundsätzlich nicht und übernimmt für diese keinerlei Haftung. TUI Deutschland behält sich aber das Recht vor, die Inhalte zu überprüfen, auch wenn dafür eine gesetzliche Verpflichtung nicht besteht.</p><p><b>5.5. </b>Der Nutzer erhält etwaige Informationen über die von ihm im System hinterlegte E-Mail-Adresse. Es obliegt ihm, sicherzustellen, dass er unter dieser E-Mail-Adresse erreichbar ist.</p><h3>&nbsp;</h3> <h3>6. Unzulässige Nutzungshandlungen, Maßnahmen bei Verstößen, Freistellung</h3> <p><b>6.1. </b>Die folgenden Nutzungshandlungen sind unzulässig:</p><ul> <li>&nbsp;das Einstellen von anderen Inhalten als Reisewünschen</li></ul> <ul> <li>das Einstellen von unzulässigen Inhalten; unzulässig sind Inhalte, die gegen diese Nutzungsbedingungen oder gegen gesetzliche Verbote oder die guten Sitten verstoßen (z.B. pornografische, volksverhetzende, rassistische oder verfassungswidrige Inhalte, Gewaltdarstellungen, Drohungen, Nötigungen, Ehrverletzungen oder sonst verwerfliche Inhalte) oder Rechte Dritter (insbesondere Persönlichkeits-, Namensrechte oder Rechte zum Schutze geistigen Eigentums wie z.B. Marken- oder Urheberrechte) verletzen; </li></ul> <ul> <li>die Offenlegung und Weitergabe des Zugangslinks zum System;</li></ul> <ul> <li>das automatische Auslesen der auf dem System befindlichen Daten sowie der Aufbau eigener Suchsysteme, Dienste und Verzeichnisse unter Zuhilfenahme der im System abrufbaren Inhalte sowie das vielfache Erstellen inhaltsgleicher Inhalte; </li></ul> <ul> <li>die Verwendung oder das Aufspielen von Dateien, die Viren, beschädigte Dateien, Software oder sonstige Mechanismen oder Inhalte enthalten, welche das System oder dessen Nutzer, deren Rechner, die Server von TUI Deutschland oder die auf den Rechnern der Nutzer oder von TUI Deutschland verwendete Software ausspionieren, attackieren oder in sonstiger Weise beeinträchtigen könnten. </li></ul> <p><b>6.2.</b> TUI Deutschland kann folgende Maßnahmen ergreifen, wenn konkrete Anhaltspunkte dafür bestehen, dass ein Nutzer gesetzliche Vorschriften, Rechte Dritter, diese Bedingungen verletzt, oder wenn TUI Deutschland ein sonstiges berechtigtes Interesse hat: Löschen von Reisewünschen oder sonstigen Inhalten, Verwarnung des Nutzers, Beschränkung der Nutzungsmöglichkeit des Systems durch den Nutzer, so dass u.a. keine Inhalte mehr eingestellt werden können, Löschung des Nutzerkontos.</p><p><b>6.3.</b> Der Nutzer stellt TUI Deutschland von allen Ansprüchen frei, die von Dritten gegen TUI Deutschland aufgrund einer Verletzung ihrer Rechte geltend gemacht werden, soweit der Nutzer diese Rechtsverletzung zu vertreten hat. Die Freistellung umfasst die Übernahme sämtlicher Gerichtskosten und angemessener Anwaltskosten.</p><p><b>6.4.</b> Der Nutzer wird TUI Deutschland bei der Verteidigung gegen die Inanspruchnahme unterstützen und insbesondere unverzüglich alle Informationen zur Verfügung stellen, die für die Prüfung und Abwehr der Ansprüche von Bedeutung sein können</p><p><b>6.5. </b>TUI Deutschland ist im Fall der berechtigten Geltendmachung von Rechten durch einen Dritten berechtigt, dem Dritten den Namen und die E-Mail-Adresse des Nutzers mitzuteilen</p><p><b>6.6. </b>TUI Deutschland ist zur Geltendmachung weiterer gesetzlicher Rechte im Fall von unzulässigen Nutzungshandlungen berechtigt. </p><h3>&nbsp;</h3> <h3>7. Haftungsbeschränkung</h3> <p><b>7.1.</b> TUI Deutschland übernimmt keine Garantie oder Gewähr für die Verfügbarkeit und Funktion des Systems oder der eingestellten Inhalte. TUI Deutschland behält sich vor, das TUI Reisewunschportal (auch ohne vorherige Ankündigung) ganz oder teilweise einzustellen oder den Zugang hierzu ganz oder teilweise einzuschränken, ohne dass hieraus Ansprüche der Nutzer gegenüber TUI Deutschland entstehen. </p><p><b>7.2.</b> . Für eine Haftung von TUI Deutschland auf Schadensersatz gelten unbeschadet der sonstigen gesetzlichen Anspruchsvoraussetzungen folgende Haftungsausschlüsse und Haftungsbegrenzungen: </p><p><b>7.2.1.</b> TUI Deutschland haftet unbeschränkt, soweit die Schadensursache auf Vorsatz oder grober Fahrlässigkeit beruht. Ferner haftet TUI für die leicht fahrlässige Verletzung von wesentlichen Pflichten, deren Verletzung die Erreichung des Vertragszwecks gefährdet, und für die Verletzung von Pflichten auf deren Einhaltung Vertragspartner regelmäßig vertrauen. In diesem Fall haftet TUI jedoch nur für den vorhersehbaren, vertragstypischen Schaden. TUI Deutschland haftet nicht für die leicht fahrlässige Verletzung anderer als der in den vorstehenden Sätzen genannten Pflichten. </p><p><b>7.2.2.</b> Die vorstehenden Haftungsbeschränkungen gelten nicht bei Verletzung von Leben, Körper und Gesundheit, für einen Mangel nach Übernahme von Beschaffenheitsgarantien für die Beschaffenheit eines Produktes und bei arglistig verschwiegenen Mängeln. Die Haftung nach dem Produkthaftungsgesetz bleibt unberührt. Soweit die Haftung von TUI Deutschland ausgeschlossen oder beschränkt ist, gilt dies auch für die persönliche Haftung ihrer Arbeitnehmer, Vertreter und Erfüllungsgehilfen.</p><h3>&nbsp;</h3> <h3> 8. Nutzung Ihrer Daten innerhalb des Reisewunschportals</h3> <p>Für die TUI ist der Schutz Ihrer Privatsphäre und persönlicher Daten von großer Wichtigkeit. Personenbezogene Daten werden im TUI Reisewunschportal nur dann erhoben, verarbeitet und genutzt, sofern dies gesetzlich erlaubt ist oder Sie uns hierzu Ihre Einwilligung erteilt haben. Die Einwilligung erfolgt durch die Bestätigung der Teilnahmebedingungen und dem Klick auf das Feld „Reisewunsch abschicken“. Die nachfolgenden Punkte geben Ihnen einen Überblick darüber, anwelchen Stellen und zu welchem Zweck die TUI die Daten der Interessenten erhebt, verarbeitet und nutzt.</p><p><b>8.1.</b> Informationen zur Datenverarbeitung und zum Datenschutz ergeben sich aus unserer Datenschutzerklärung. Diese finden Sie hier: <a target="_blank" href="https://www.example.com/datenschutz/" target="_top"><span style="font-family:&quot;TUIType&quot;,&quot;sans-serif&quot;">http://www.TUI.com/datenschutz/</span></a><span style="font-family:&quot;TUIType&quot;,&quot;sans-serif&quot;">. </span></p><p><b>8.2.</b> Einsatz von Cookies im Reisewunschportal: Tealium IQ ist ein Tag Management System mit dem Messpixel („Tags“) von Drittanbietern auf den Seiten der TUI Deutschland geladen werden. Beispiele für Drittanbieter sind Google Analytics und DesireTec Conversion Intelligence. Zur Optimierung des Ladens der Messpixel erfasst Tealium über ein Cookie einige personenbezogene (E-Mail-Adresse und IP Adresse) und nicht personenbezogene Daten (Reisewunschdaten). Dieses Cookie verliert nach 12 Monaten seine Gültigkeit.</span></a> </p><p>Die folgenden Informationen werden im Tealium Cookie gespeichert:</p><ul> <li>Zeitstempel des Webseitenbesuchs</li><li>ID für den Seitenaufruf</li><li>ID für den Besucher</li><li>ID für die Reisewunsch Session</li><li>IP Adresse zur regionalen Zusteuerung zum Reisebüro</li><li>Flag (0 oder 1) zur Kennzeichnung des Sessionstarts</li></ul> <p>Wenn Sie sie sich von Tealium und den Messungen der nachfolgenden Drittanbieter ausschließen wollen klicken Sie auf den Link. (<a href="http://www.TUI.com/datenschutz/tracking-einstellungen">http://www.TUI.com/datenschutz/tracking-einstellungen</a>)</p><p><b>8.3.</b> Einsatz von Mauszeiger-Tracking der Firma DesireTec (DesireTec Conversion Intelligence)</p><p>DesireTec Conversion Intelligence ist ein Tracking System, das die Bewegung der Maus (Richtung, Geschwindigkeit, Beschleunigung) misst, um bei der Erfüllung festgelegter Kriterien ein Formular auszuspielen, dass Sie bei Ihrer Suche nach einer Reise unterstützen soll. Über das Tracking findet keine Speicherung personenbezogener Daten statt und es ist keine Wiedererkennung möglich.</p><p>Sollte das Formular ausgespielt werden, wird ein Cookie gespeichert, um ein mehrfaches Auslösen zu verhindern. Dieses speichert ausschließlich die Information, dass das Formular bereits ausgespielt wurde.</p><p><b>8.4.</b> Sofern keine gesetzlichen Speicherpflichten bestehen, können Sie zu jederzeit eine Löschung der von Ihnen zur Verfügung gestellten personenbezogenen Daten durch uns vornehmen lassen. Für Fragen, Wünsche oder Kommentare zum Thema Datenschutz wenden Sie sich bitte per E-Mail an den Datenschutzbeauftragten der TUI Deutschland GmbH: datenschutz@example.de.</p><h3>&nbsp;</h3> <h3>9. Schlussbestimmungen</h3> <p><b>9.1.</b> TUI Deutschland ist berechtigt, Änderungen oder Ergänzungen an diesen Nutzungsbedingungen vorzunehmen, sofern dies dem billigen Ermessen von TUI Deutschland entspricht und für den Nutzer zumutbar ist. Diese werden erst wirksam, nachdem TUI Deutschland dem registrierten Nutzer die Änderung der Nutzungsbedingungen in Textform mitgeteilt hat und der Nutzer dieser Neufassung nicht innerhalb von 6 Wochen ab Zugang mindestens in Textform widerspricht. Der Nutzer wird bei Mitteilung der Änderung auf die Bedeutung seines Schweigens besonders hingewiesen. </p><p><b>9.2.</b> Sofern einzelne oder mehrere Bestimmungen in diesen Nutzungsbedingungen ganz oder teilweise unwirksam oder ungültig sind oder werden, bleibt die Wirksamkeit der übrigen Regelungen und Bestimmungen hiervon unberührt. Die unwirksame oder ungültige Regelung gilt durch eine Regelung ersetzt, die dem Sinn und Zweck der unwirksamen oder ungültigen Regelung in rechtwirksamer Weise wirtschaftlich am nächsten kommt. Gleiches gilt für eventuelle Regelungslücken. </p><p><b>9.3.</b> Streitigkeiten, die im Zusammenhang mit diesen Nutzungsbedingungen oder aufgrund der Nutzung des TUI Reisewunschportals geführt werden unterliegen ausschließlich dem Recht der Bundesrepublik Deutschland. </p><p> <br/> <br/>Mai 2018</p></section><style type="text/css"> .csc-frame-tx-xsocial{display: none;}</style>';

            function show() {
                console.log('in show');
                if (element) {
                    hide();
                }

                element = $('<div class="dt-modal dt-modal-agb" ><div class="kwp"><div class="kwp-close-button kwp-close"></div><div class="kwp-agb-content"></div></div></div>');



                /*$.ajax({
                    url: 'http://example-reisewunsch.com/bundles/csexample/popup/static/agb.html',
                    type: 'GET',
                    crossDomain: true,
                    dataType: 'jsonp',
                    success: function(data) { element.find('.kwp-agb-content').append(data); },
                    error: function() {  },
                });			*/

                element.find('.kwp-agb-content').append(data_agb);
                element.find('.kwp-close').click(hide);
                element.click(function (event) {
                    if (event && event.target && !$(event.target).is(element)) {
                        return;
                    }
                    hide();
                });
                element.appendTo($('body'));
            }

            function hide() {
                element.remove();
                element = null;
            }

            show();

            return false;
        };

        dt.darkGreyLayout = function (e) {
            e && e.preventDefault();
            $(".kw-overlay-notActive").click(function () {
                $(this).fadeOut("slow");
                $("#airport").focus();
            });
        };


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

            // Style variables
            // brandColor is passed through blade
            var brandColorDarker = brandColor;

            var btnPrimaryCss = {
                'background': brandColor,
                'border': '1px solid ' + brandColor,
                'color': '#fff',
            };
            var btnPrimaryHoverCss = {
                'background': brandColorDarker,
                'border': '1px solid ' + brandColorDarker,
                'color': '#fff',
            };
            var btnSecondaryCss = {
                'background': '#fff',
                'border': '1px solid ' + brandColor,
                'color': brandColor,
            };
            var btnSecondaryHoverCss = {
                'background': '#fff',
                'border': '1px solid ' + brandColorDarker,
                'color': brandColorDarker,
            };

            // Apply styles
            var layerButtons = $('.primary-btn, .kwp .pax-col .kwp-form-group .pax-more .button a');
            layerButtons
                .css(btnPrimaryCss)
                .mouseover(function () {
                    $(this).css(btnPrimaryHoverCss);
                }).mouseout(function () {
                    $(this).css(btnPrimaryCss);
                });

            var paxMore = $('.kwp .pax-col .kwp-form-group .pax-more .button a');
            paxMore.css({
                'background': brandColor,
            });

            var durationMore = $('.kwp .duration-col .kwp-form-group .duration-more .button a');
            durationMore.css({
                'background': brandColor,
            });

            var footerLinks = $('.kwp-agb p a');
            footerLinks.css({
                'color': brandColor,
            });

            var checkboxEl = $('.kwp input[type="checkbox"]:checked:after');
            $('<style>.kwp input[type="checkbox"]:checked:after { background-color: ' + brandColor + '; border: 1px solid ' + brandColor + '; }</style>').appendTo('head');

            var footerHref = $('.kwp-agb p a');
            footerHref.css({
                'color': brandColor,
            });

            var mobileLayerHeader = $('.kwp-header.kwp-variant-eil-mobile');
            mobileLayerHeader.css({
                'background': brandColor,
            });

            var successHref = $('.kwp-completed-master a');
            $("<style>.kwp-completed-master a { color: " + brandColor + "; }</style>")
                .appendTo(document.documentElement);
        };

        dt.autocomplete = function(){
            $('#destination').tagsinput({
                maxTags: 3,
                maxChars: 20,
                allowDuplicates: false,
                typeahead: {
                    autoSelect: false,
                    minLength: 3,
                    highlight: true,
                    source: function(query) {
                        return $.get('https://testkurenundwellness.reise-wunsch.com/get-all-destinations', {query: query});
                    }
                }
            });

            $('#airport').tagsinput({
                maxTags: 3,
                maxChars: 20,
                allowDuplicates: false,
                typeahead: {
                    autoSelect: false,
                    minLength: 3,
                    highlight: true,
                    source: function(query) {
                        return $.get('https://testkurenundwellness.reise-wunsch.com/get-all-airports', {query: query});
                    }
                }
            });
            /* END Airports */
            $("#destination, #airport").on('itemAdded', function(event) {
                setTimeout(function(){
                $("input[type=text]",".bootstrap-tagsinput").val("");
                }, 1);
            });
        };

        dt.adjustResponsive = function(){
            if( $(window).outerWidth() <= 768 ) {
                $("body").addClass('mobile-layer');
                $(".dt-modal").addClass('m-open');

                dt.PopupManager.isMobile = true;
                dt.PopupManager.layerShown = true;

                $(".kwp-header").css('background', brandColor);

                $('.error-input').siblings('i').css('bottom', '30px');

                $('.dt-modal .submit-col').detach().appendTo('.footer-col');
            } else {
                $("body").removeClass('mobile-layer');
                $(".dt-modal").removeClass('m-open');

                $(".kwp-header").removeAttr('style');

                $('.footer-col .submit-col').detach().appendTo('.kwp-content .kwp-row:last-child');
            }
        }

    })(jQuery);
