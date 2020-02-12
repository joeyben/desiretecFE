@extends('frontend.layouts.app')

@section('content')
    <div class="page-wrapper gradient-grey-orange">
        <div class="shell">

            <main>

                <section class="gallery-section">
                    <div class="shell">
                        <h2>{{ $offer['hotel_data']['data']['Hotelname'] }}</h2>

                        <div class="wrapper">
                            <div class="col-1">
                                <div class="image-1 background-image" style="background-image: url({!! str_replace('180', '600', $offer['hotel_data']['data']['Bildfile'][0]) !!})"></div>
                            </div>
                            <div class="col-2">
                                <div class="image-2 background-image" style="background-image: url({!! str_replace('180', '600', $offer['hotel_data']['data']['Bildfile'][1]) !!})"></div>
                                <div class="image-3 background-image" style="background-image: url({!! str_replace('180', '600', $offer['hotel_data']['data']['Bildfile'][2]) !!})"></div>
                            </div>
                        </div>

                        <a class="btn btn-secondary">Fotogalerie ansehen</a>
                    </div>
                </section>

                <div class="sections-wrapper">

                    <nav class="navigation">
                        <ul>
                            <li class="active">
                                <a onclick="scrollToAnchor('description-section')">
                                    <h4>Beschreibung</h4>
                                </a>
                            </li>
                            <li>
                                <a onclick="scrollToAnchor('equipment-section')">
                                    <h4>Ausstattung</h4>
                                </a>
                            </li>
                            <li>
                                <a onclick="scrollToAnchor('reviews-section')">
                                    <h4>Bewertungen</h4>
                                </a>
                            </li>
                            <li>
                                <a onclick="scrollToAnchor('location-section')">
                                    <h4>Lage</h4>
                                </a>
                            </li>
                        </ul>
                    </nav>

                    <section class="description-section scrollbar" id="description-section">
                        <h2>Beschreibung</h2>

                        <p>
                            {!! $offer['hotel_data']['data']['Text'] !!}
                        </p>
                    </section>

                    <section class="equipment-section" id="equipment-section">
                        <h2>Ausstattung</h2>

                        <ul class="icons">
                            @foreach($offer['data']['hotelOffer']['hotel']['keywordList'] as $keyword)
                                <li>
                                    <div class="icon background-image">
                                        <span class="{{ $keyword }}"></span>
                                    </div>
                                    <h5>{{ getKeywordText($keyword) }}</h5>
                                </li>
                            @endforeach
                        </ul>

                        <a class="accordeon section-accordeon">
                            <h5>mehr anzeigen</h5>
                            <i class="fas fa-plus"></i>
                        </a>
                    </section>

                    <section class="reviews-section" id="reviews-section">
                        <div class="shell">

                            <h2>Bewertungen (<span>2.189</span>)</h2>

                            <div class="ratings-average">
                                <div class="value">
                                    <h3>9,7</h3>
                                </div>
                                <h4>578 Bewertungen</h4>
                            </div>

                            <ul class="ratings-by-category">
                                <li class="category">
                                    <div class="value">
                                        <h4>8,5</h5>
                                    </div>
                                    <h5>Allgemein</h6>
                                </li>
                                <li class="category">
                                    <div class="value">
                                        <h4>8,5</h5>
                                    </div>
                                    <h5>Hotel</h6>
                                </li>
                                <li class="category">
                                    <div class="value">
                                        <h4>8,5</h5>
                                    </div>
                                    <h5>Lage</h6>
                                </li>
                                <li class="category">
                                    <div class="value">
                                        <h4>8,5</h5>
                                    </div>
                                    <h5>Service</h6>
                                </li>
                                <li class="category">
                                    <div class="value">
                                        <h4>8,5</h5>
                                    </div>
                                    <h5>Zimmer</h6>
                                </li>
                                <li class="category">
                                    <div class="value">
                                        <h4>8,5</h5>
                                    </div>
                                    <h5>Gastronomie</h6>
                                </li>
                                <li class="category">
                                    <div class="value">
                                        <h4>8,5</h5>
                                    </div>
                                    <h5>Sport & Unterahltung</h6>
                                </li>
                                <li class="category">
                                    <div class="value">
                                        <h4>8,5</h4>
                                    </div>
                                    <h5>Weiterempfehlung</h5>
                                </li>
                            </ul>

                            <div class="reviews">
                                <h4><span>2.128</span> Bewertungen</h4>

                                <ul>
                                    <li class="review">
                                        <div class="review-head">
                                            <div class="value">
                                                <h4>8,5</h4>
                                            </div>
                                            <div class="text">
                                                <h5>Sehr gutes Hotel, mit kleinen Kritikpunkten</h5>
                                                <h6>Martin (35-45), Female, Dezember 2018</h6>
                                            </div>
                                        </div>

                                        <div class="review-body">
                                            <ul>
                                                <li class="rate">
                                                    <h5>9,6 Lage</h5>
                                                    <p>
                                                        Das Hotel liegt in einem Tal zwischen kleinen Berghöngen und ist somit windgeschützt. Puerto Mogan ist der schönste Küstenort der Inset. Wer Party sucht ist allerdings fehlt am Plotz und so[lte eher Richtung Playa del Ingles ziehen. Der kleine Strand ist 0k, konn aber mit dem großen Dünenstrand von Maspalomas sicherlich
                                                    </p>
                                                </li>
                                            </ul>
                                        </div>

                                        <a class="accordeon">
                                            <h6>Mehr lesen</h6>
                                        </a>

                                    </li>

                                    <li class="review">
                                        <div class="review-head">
                                            <div class="value">
                                                <h4>8,5</h4>
                                            </div>
                                            <div class="text">
                                                <h5>Perfektes Hotel für einen Urloub zu zweit</h5>
                                                <h6>Hannelore (61-75), Paar, Jull 2018</h6>
                                            </div>
                                        </div>

                                        <div class="review-body">
                                            <ul>
                                                <li class="rate">
                                                    <h5>9,6 Lage</h4>
                                                        <p>
                                                            Das Hotel liegt in einem Tal zwischen kleinen Berghöngen und ist somit windgeschützt. Puerto Mogan ist der schönste Küstenort der Inset. Wer Party sucht ist allerdings fehlt am Platz und sollte eher Richtung Playa del Ingles ziehen. Der kleine Strand ist 0k, kann aber mit dem großen Dünenstrand von Maspalomas sicherlich nicht mithalten.
                                                        </p>
                                                </li>
                                                <li class="rate">
                                                    <h5>8,7 Zimmer</h4>
                                                        <p>
                                                            Wir hatten wie immer eine Junior-Suite im Erdgeschoss. Für eine 3- bis 4-köpfige Familie einfoch perfekt. Der kleine Garten bietet Viel Privatsphöre.
                                                        </p>
                                                </li>
                                                <li class="rate">
                                                    <h5>9,5 Service</h4>
                                                        <p>
                                                            Dos Personal ist sehr freundlich und motiviert.
                                                        </p>
                                                </li>
                                                <li class="rate">
                                                    <h5>9,2 Gastronomie</h4>
                                                        <p>
                                                            Dos Buffet-Restaurant ist im Vergleich zu anderen Hotels auf den kanarischen Inseln sehr gut. Gute Auswahl. Wir haben ouch das A-La-Corte Restaurant (Los Guayres') besucht und können es wirklich weiterempfehlen (perfektes Service und sehr gutes Essen).
                                                        </p>
                                                </li>
                                                <li class="rate">
                                                    <h5>9,4 Sport und Unterhaltung</h4>
                                                        <p>
                                                            Alles wos man sich wünschen kann.
                                                        </p>
                                                </li>
                                                <li class="rate">
                                                    <h5>9,8 Hotel</h5>
                                                    <p>
                                                        Jedes Jahr verbringen wir einen IJrloub in diesem Hotel. dos aus unserer Sicht ein exzellentes Preis-Leistung Verhöltnis bittet. Die Anlage ist wunderschön mit dem tropischen Garten- Dos Hotel bitte eine Club- Mitgliedschaft für wiederkehrende Göste, was zusåtzliche Vorteile bitte. Die Junior-Suiten Sind für Familien bestens geeignet und haben im Erdgeschoss sogor kleine private Gortenanteile. Dos Personal ist sehr freundlich und sehr professionnell.
                                                    </p>
                                                </li>
                                            </ul>
                                        </div>

                                        <a class="accordeon">
                                            <h6>Mehr lesen</h6>
                                        </a>

                                    </li>
                                </ul>

                            </div>

                            <a class="accordeon section-accordeon">
                                <h5>mehr anzeigen</h5>
                                <i class="fas fa-plus"></i>
                            </a>

                        </div>
                    </section>

                </div>

                <section class="location-section" id="location-section">
                    <div class="shell">

                        <h2>Lage des hotels</h2>

                        <div class="map background-image"></div>
                    </div>
                </section>

            </main>

            <aside>

                <section class="offer-info-section">
                    <div class="shell">

                        <div class="offer-info">
                            <h4>Reiseangebot Nr. 4242-42</h4>

                            <div class="recommandations">
                                <div class="average">
                                    <h2><?= number_format((int) ($offer['data']['hotelOffer']['hotel']['rating']['overall']) / 10, 1, ',', '.'); ?></h2>
                                </div>
                                <div class="text">
                                    <h6>{{ $offer['data']['hotelOffer']['hotel']['rating']['count'] }} Bewertungen</h6>
                                    <h6>Ausgezeichnet</h6>
                                </div>
                            </div>

                            <div class="price">
                                <h2>{{ number_format($offer['data']['personPrice']['value'], 0, ',', '.') }} <span>&#8364;</span> p.P.</h2>
                            </div>

                            <a class="btn btn-primary">
                                <h5>Angebot prüfen</h5>
                            </a>
                        </div>

                        <div class="dates">
                            <h4>Reisedaten</h4>

                            <ul>
                                @if (count($offer['data']['flightOffer']['flight']['outboundLegList']) > 0)
                                <li>
                                    <div class="hour-location">
                                        <h4>{{ $offer['data']['flightOffer']['flight']['outboundLegList'][0]['departureTime'] }}</h4>
                                        <h5>{{ $offer['data']['flightOffer']['flight']['departureAirport']['code'] }}</h5>
                                    </div>
                                    <div class="duration">
                                        @php
                                            $outTime = explode(':', $offer['data']['flightOffer']['flight']['outboundLegList'][0]['estimatedElapsedTime']);
                                        @endphp
                                        <h6>{{ $outTime[0] }} Std. {{ $outTime[1] }} Min.</h6>
                                        <div class="wrapper">
                                            <div class="horizontal-line"></div>
                                            <i class="fas fa-plane"></i>
                                        </div>
                                        <h6>Direct</h6>
                                    </div>
                                    <div class="hour-location">
                                        <h4>{{ $offer['data']['flightOffer']['flight']['outboundLegList'][0]['arrivalTime'] }}</h4>
                                        <h5>{{ $offer['data']['flightOffer']['flight']['arrivalAirport']['code'] }}</h5>
                                    </div>
                                </li>
                                <li>
                                    <div class="hour-location">
                                        <h4>{{ $offer['data']['flightOffer']['flight']['inboundLegList'][0]['departureTime'] }}</h4>
                                        <h5>{{ $offer['data']['flightOffer']['flight']['arrivalAirport']['code'] }}</h5>
                                    </div>
                                    <div class="duration">
                                        @php
                                            $inTime = explode(':', $offer['data']['flightOffer']['flight']['inboundLegList'][0]['estimatedElapsedTime']);
                                        @endphp

                                        <h6>{{ $inTime[0] }} Std. {{ $inTime[1] }} Min.</h6>
                                        <div class="wrapper">
                                            <div class="horizontal-line"></div>
                                            <i class="fas fa-plane"></i>
                                        </div>
                                        <h6>Direct</h6>
                                    </div>
                                    <div class="hour-location">
                                        <h4>{{ $offer['data']['flightOffer']['flight']['inboundLegList'][0]['arrivalTime'] }}</h4>
                                        <h5>{{ $offer['data']['flightOffer']['flight']['departureAirport']['code'] }}</h5>
                                    </div>
                                </li>
                                @endif
                            </ul>

                            <div class="airline">
                                <div class="avatar avatar-circle size-2" style="background-image: url({{ $offer['data']['tourOperator']['logo'] }});"></div>
                                <h6>{{ $offer['data']['tourOperator']['name'] }}</h6>
                            </div>
                        </div>

                        <div class="contact">
                            <h4>Kontakt</h4>

                            <div class="name wrapper">
                                <i class="far fa-user"></i>
                                <h5>Name Ansprechpartner</h5>
                            </div>
                            <div class="phone wrapper">
                                <i class="fas fa-phone"></i>
                                <h5>040 23 88 59-82</h5>
                            </div>
                            <div class="email wrapper">
                                <i class="far fa-envelope"></i>
                                <a href="mailto: hardcoded@email.com">
                                    <h5>main@reisebuero.de</h5>
                                </a>
                            </div>
                        </div>

                    </div>
                </section>

                <section class="pdf-download-section">
                    <div class="shell">

                        <h4>Alle Information bequem in einem PDF.</h4>

                        <a class="btn btn-secondary">
                            <i class="fas fa-download"></i>
                            <h5>PDF Download</h5>
                        </a>

                    </div>
                </section>

                <section class="highlights-section">
                    <div class="shell">

                        <h4>Reisewunsch</h4>

                        <ul>
                            <li>
                                <div class="icon-background">
                                    <i class="fas fa-home-lg-alt" aria-hidden="true"></i>
                                </div>
                                <h5>{{ $wish->airport }}</h5>
                            </li>
                            <li>
                                <div class="icon-background">
                                    <i class="fas fa-users" aria-hidden="true"></i>
                                </div>
                                <h5>{{ $wish->adults }} Erwachsene</h5>
                            </li>
                            <li>
                                <div class="icon-background">
                                    <i class="far fa-map-marker-check"></i>
                                </div>
                                <h5>{{ $wish->destination }}</h5>
                            </li>
                            <li>
                                <div class="icon-background">
                                    <i class="fas fa-h-square" aria-hidden="true"></i>
                                </div>
                                <h5>{{ $wish->category }} Sterne</h5>
                            </li>
                            <li>
                                <div class="icon-background">
                                    <i class="fas fa-credit-card" aria-hidden="true"></i>
                                </div>
                                <h5>{{ $wish->budget }}€</h5>
                            </li>
                            <li>
                                <div class="icon-background">
                                    <i class="fas fa-bed" aria-hidden="true"></i>
                                </div>
                                <h5>{{ getCateringFromCode($wish->catering) }}</h5>
                            </li>
                            <li>
                                <div class="icon-background">
                                    <i class="fa fa-clock" aria-hidden="true"></i>
                                </div>
                                <h5>{{ $wish->duration }}</h5>
                            </li>
                            <li>
                                <div class="icon-background">
                                    <i class="fas fa-calendar" aria-hidden="true"></i>
                                </div>
                                <h5>{{  \Carbon\Carbon::parse($wish->earliest_start)->format('d.m.Y') }} - {{  \Carbon\Carbon::parse($wish->latest_return)->format('d.m.Y') }}</h5>
                            </li>
                        </ul>

                        <a class="btn btn-secondary">
                            <h5>Neuer Reisewunsch</h5>
                        </a>

                    </div>
                </section>
            </aside>

        </div>
    </div>
@endsection

@section('after-scripts')
    <script type="application/javascript">

        function scrollToAnchor(id) {
            $('html, body').animate({
                scrollTop: $("#"+id).offset().top - 75
            }, 1000);
        }

    </script>
@endsection
