@extends('frontend.layouts.app')

@section('title')
    {{ ucfirst(getWhitelabelInfo()['name']) }} {{ trans('autooffer.list.tab_title') }}
@endsection

@section("after-styles")
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js" />
@endsection

@section('content')
    <main class="main">
        <div class="shell">

            <div class="wave-image"></div>

            <section class="about-section">
                <div class="shell">
                    <h1>{{ trans('autooffer.message.welcome') }}</h1>
                    <h3>
                        @if (count($offers) === 0)
                            {{ trans('autooffer.message.no_offers') }}
                        @elseif ($offers[0]['status'])
                            {{ trans('autooffer.message.offers', ['destination' => $wish->destination]) }}
                        @elseif (!$offers[0]['status'])
                            {{ trans('autooffer.message.advanced_offers') }}
                        @endif
                            {{ trans('autooffer.message.callback') }}
                        </h3>
                    @if (count($offers) > 0)
                        <a class="btn btn-primary" onclick="scrollToAnchor('listed-offers-section')">{{ trans('autooffer.offers.goto_button') }}</a>
                    @endif
                </div>
            </section>

            <section class="main-offer-section">
                <div class="shell" id="main-offer-section-shell">
                    <h2>Auf einen Blick</h2>

                    <div class="main-offer" style="padding-bottom: 0">
                        <div class="offer-info">
                            <div class="agency-info">
                                <div class="avatar avatar-circle size-1"></div>
                                <div class="text">
                                    @if(!(trans('autooffer.contact.company_contact_person') == "autooffer.contact.company_contact_person"))<h3>{{ trans('autooffer.contact.company_contact_person') }}</h3>@endif
                                    @if(!(trans('autooffer.contact.company_name') == "autooffer.contact.company_name"))<h4>{{ trans('autooffer.contact.company_name') }}</h4>@endif
                                    @if(!(trans('autooffer.contact.company_addr') == "autooffer.contact.company_addr"))<h4>{{ trans('autooffer.contact.company_addr') }}</h4>@endif
                                    @if(!(trans('autooffer.contact.company_postal_addr') == "autooffer.contact.company_postal_addr"))<h4>{{ trans('autooffer.contact.company_postal_addr') }}</h4>@endif
                                </div>
                            </div>

                            <div class="agency-contact-info">
                                <ul>
                                    @if(!(trans('autooffer.contact.ansprechpartner') == "autooffer.contact.ansprechpartner"))
                                        <li class="name">
                                            <i class="fal fa-user-circle"></i>
                                            <h4>{{ trans('autooffer.contact.ansprechpartner') }}</h4>
                                        </li>
                                    @endif
                                    @if(!(trans('autooffer.contact.company_telephone') == "autooffer.contact.company_telephone"))
                                        <li class="phone">
                                            <div class="icon-background">
                                                <i class="fal fa-phone" aria-hidden="true"></i>
                                            </div>
                                            <h4>{{ trans('autooffer.contact.company_telephone') }}</h4>
                                        </li>
                                    @endif
                                    @if(!(trans('autooffer.contact.company_email') == "autooffer.contact.company_email"))
                                    <li class="name">
                                        <div class="icon-background">
                                            <i class="fal fa-envelope" aria-hidden="true"></i>
                                        </div>
                                        <h4>{{ trans('autooffer.contact.company_email') }}</h4>
                                    </li>
                                    @endif
                                    @if(!(trans('autooffer.contact.timings') == "autooffer.contact.timings"))
                                    <li class="name">
                                        <div class="icon-background">
                                            <i class="fal fa-clock" aria-hidden="true"></i>
                                        </div>
                                        <h4>{{ trans('autooffer.contact.timings') }}</h4>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>

                        <div class="offer-highlights" id="offer-highlights">
                            <ul>
                                <li>
                                    <div class="icon-background">
                                        <i class="fas fa-home-lg-alt" aria-hidden="true"></i>
                                    </div>
                                    <h4>{{ $wish->airport }}</h4>
                                </li>
                                <li>
                                    <div class="icon-background">
                                        <i class="fas fa-users" aria-hidden="true"></i>
                                    </div>
                                    <h4>{{ $wish->adults }} Erwachsene<br>{{ $wish->kids }} Kind(er)</h4>
                                </li>
                                <li>
                                    <div class="icon-background">
                                        <i class="far fa-map-marker-check"></i>
                                    </div>
                                    <h4>{{ $wish->destination }}</h4>
                                </li>
                                <li>
                                    <div class="icon-background">
                                        <i class="fas fa-h-square" aria-hidden="true"></i>
                                    </div>
                                    <h4>{{ $wish->category }} Sterne</h4>
                                </li>
                                <li>
                                    <div class="icon-background">
                                        <i class="fas fa-credit-card" aria-hidden="true"></i>
                                    </div>
                                    <h4>{{ $wish->budget }}CHF</h4>
                                </li>
                                <li>
                                    <div class="icon-background">
                                        <i class="fas fa-bed" aria-hidden="true"></i>
                                    </div>
                                    <h4>{{ getCateringFromCode($wish->catering) }}</h4>
                                </li>
                                <li>
                                    <div class="icon-background">
                                        <i class="fa fa-clock" aria-hidden="true"></i>
                                    </div>
                                    <h4>{{ $wish->duration }}</h4>
                                </li>
                                <li>
                                    <div class="icon-background">
                                        <i class="fas fa-calendar" aria-hidden="true"></i>
                                    </div>
                                    <h4>{{  \Carbon\Carbon::parse($wish->earliest_start)->format('d.m.Y') }} - {{  \Carbon\Carbon::parse($wish->latest_return)->format('d.m.Y') }}</h4>
                                </li>
                            </ul>

                        </div>
                    </div>
                    @if (count($offers) > 0)
                    <div id="top-map" class="map"></div>
                    @endif
                    <a class="btn btn-secondary" onclick="showMenu()">Reisewunsch ansehen</a>
                </div>

            </section>
            @php
                $count = 0;
                $locations = [];
            @endphp
            @if (count($offers) > 0)
            <section class="listed-offers-section" id="listed-offers-section">
                <div class="shell">
                    <div class="vertical-line"></div>
                    <h1>Meine Angebote</h1>

                    <ul class="offers">

                        @foreach($offers as $key => $offer)
                            @php
                                $hotelData = [
                                    'title' => $offer['hotel_data']['data']['Hotelname'],
                                    'stars' => key_exists('Hotelkategorie', $offer['hotel_data']['data']) ? intval($offer['hotel_data']['data']['Hotelkategorie']) : 0 ,
                                    'text' => $offer['data']['boardType'],
                                    'longitude' => $offer['data']['hotel_geo']['longitude'],
                                    'latitude' => $offer['data']['hotel_geo']['latitude']
                                ];
                                $locations[] = $hotelData;
                            @endphp
                            <li class="offer box-shadow" id="hotel-{{ $key }}">
                                <span class="wish_offer_id">Angebotsnummer: {{ $wish->id }}/{{ $count + 1 }}</span>

                                <div class="left-side">
                                @if ($count === 1)
                                    <div class="label">Unser Tipp</div>
                                @endif
                                <div class="slick-slider">
                                    @if (key_exists('Bildfile', $offer['hotel_data']['data']) and is_array($offer['hotel_data']['data']['Bildfile']))
                                        @foreach($offer['hotel_data']['data']['Bildfile'] as $image)
                                            <div class="slider-item" style="background-image: url({!! str_replace('180', '600', $image) !!})"></div>
                                        @endforeach
                                    @elseif (key_exists('Bildfile', $offer['hotel_data']['data']))
                                        <div class="slider-item" style="background-image: url({!! str_replace('180', '600', $offer['hotel_data']['data']['Bildfile']) !!})"></div>
                                    @endif
                                </div>
                            </div>
                            <div class="right-side">
                                <div class="title">
                                    <h3>{{ $offer['hotel_data']['data']['Hotelname'] }}</h3>
                                    <div class="rating">
                                        @if (key_exists('Hotelkategorie', $offer['hotel_data']['data']))
                                            @for ($i = 0; $i < intval($offer['hotel_data']['data']['Hotelkategorie']); $i++)
                                                <i class="fas fa-heart"></i>
                                            @endfor
                                        @endif
                                    </div>
                                </div>

                                <div class="location">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <h5>{{ $offer['hotel_data']['data']['Stadtname'] }}, {{ $offer['hotel_data']['data']['Landname'] }}</h5>
                                </div>

                                <div class="fulfill">
                                    <progress value="{{ $offer['data']['hotel_reviews']['recommendation'] }}" max="100"></progress>
                                    <h4> <span>{{ $offer['data']['hotel_reviews']['recommendation'] }}%</span> Weiterempfehlung</h4>
                                </div>

                                <div class="recommandations">
                                    <div class="average">{{ $offer['data']['hotel_reviews']['overall'] }}</div>
                                    <div class="text">
                                        <h4 class="dark-grey-2">Empfehlenswert</h4>
                                        <h4>{{ $offer['data']['hotel_reviews']['count'] }} Bewertungen</h4>
                                    </div>
                                </div>

                                <div class="highlights">
                                    <h4 class="dark-grey-2">Highlights der Unterkunft:</h4>
                                    <ul>
                                        @for ($i = 0; $i < 3; $i++)
                                        <li>
                                            <i class="fal fa-check"></i>
                                            <h4 class="dark-grey">{{ trans('hotel.offer.attributes.'.$offer['data']['hotel_attributes'][$i]) }}</h4>
                                        </li>
                                        @endfor
                                    </ul>

                                    <div class="travel-info">
                                        <h4 data-toggle="tooltip" data-placement="bottom" title="{{ $offer['data']['offerFeatures'] }}">{{ $offer['data']['duration'] }} {{ trans('autooffers.offer.nights') }}, {{ \Illuminate\Support\Str::limit($offer['data']['offerFeatures'], 20, "...") }}</h4>
                                        <h4>{{ trans('hotel.offer.boardtype.'.strtolower($offer['data']['boardType'])) }}</h4>
                                    </div>
                                </div>

                                <div class="price">
                                    <div class="info-icons">
                                        @include('frontend.autooffer.parts.hotel-attributes')
                                    </div>
                                    <h3>{{ number_format($offer['data']['price']['value'], 0, ',', '.') }} <span>CHF</span> p.P.</h3>
                                    <a class="btn btn-primary" target="_blank" href="https://badeferien.lastminute.ch/offer?depap={{ $offer['data']['flight']['in']['departure']['airport'] }}&ibe=package&rid=&lang=de-CH&ddate={{ $offer['data']['flight']['in']['departure']['date'] }}&rdate={{ $offer['data']['flight']['out']['arrival']['date'] }}&adult={{ $wish->adults }}&dur={{ $offer['data']['duration'] }}&price=0,{{ $offer['personPrice'] }}&board={{ $wish->catering }}&aid={{ $offer['data']['hotel_id'] }}">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </div>

                            </div>
                        </li>
                            @php
                                $count++;
                            @endphp
                        @endforeach

                    </ul>
                </div>
            </section>
            @endif
        </div>
    </main>
@endsection

@section('footer')
    <div class="footer">
        <div class="container">
            <div class="col-md-12">
                <ul class="list-inline" id="copyright-year">
                    @foreach (footers_by_whitelabel() as $footer)
                        <li class="list-inline-item">
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('after-scripts')

    <!-- jquery -->
    <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAE60OtWg7HL-wqOpGHcRGAD6HpYzAh6t4"></script>

    <!-- sllick slider -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.slick/1.5.5/slick.min.js"></script>


    <script type="application/javascript">

        $(document).ready(function(){
            var brandColor = {!! json_encode(getCurrentWhiteLabelColor()) !!};

            $('.btn-primary').css({
                'background': brandColor,
                'border': '1px solid ' + brandColor,
                'color': '#fff',
            });
            $('.btn-secondary').css({
                'background': '#fff',
                'border': '1px solid ' + brandColor,
                'color': brandColor,
            });
            $('.about-section h3 a').css({'color': brandColor});
            $('.listed-offers-section .vertical-line').css({'background-color': brandColor});
            $('.fas.fa-heart, .fal.fa-check, .offers .fulfill span, .fas.fa-map-marker-alt, .offers .slick-slider i').css({'color': brandColor});
            $('.offers .recommandations .average').css({'border-color': brandColor});
            $('head').append('<style> progress::-webkit-progress-value { background: ' + brandColor + ' !important; } </style>');

            if($('.offers .info-icons').length === 0) {
                $('.offers .highlights').css({'padding-bottom': '15px'});
            }
        });

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })

        function scrollToAnchor(id) {
            $('html, body').animate({
                scrollTop: $("#"+id).offset().top - 75
            }, 1000);
        }

        function showMenu() {
            $('#offer-highlights').detach().appendTo('#main-offer-section-shell');
            $('#offer-highlights').css('height', '210px');
            $('#offer-highlights').toggle();

            // TODO: Fix animation
            // $('#offer-highlights').animate({
            //     height: '180px'
            // }, 500);
        }

        $('.slick-slider').slick({
            dots: false,
            infinite: true,
            speed: 300,
            slidesToShow: 1,
            prevArrow: '<div class="btn arrow-left"><i class="fa fa-chevron-left"></i></div>',
            nextArrow: '<div class="btn arrow-right"><i class="fa fa-chevron-right"></i></div>'
        });

    </script>

    <script>
        var locations = JSON.parse('{!! json_encode($locations) !!}');
        var center = new google.maps.LatLng(locations[0].longitude, locations[0].latitude);

        function initialize() {
            var bounds = new google.maps.LatLngBounds();
            var mapOptions = {
                zoom: 12,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                center: center,
                mapTypeControl: false
            };

            map = new google.maps.Map(document.getElementById('top-map'), mapOptions);


            for(var i = 0; i < locations.length; i++){
                addMarker(locations[i], map, bounds, i)
            }
            map.fitBounds(bounds);
        }

        function addMarker(location, map, bounds, key) {
            var stars = "";
            for(var i = 0; i< location.stars; i++){
                stars += '<i class="fas fa-heart"></i>';
            }
            var contentString = '<div>'+
                '<div id="siteNotice">'+
                '</div>'+
                '<div id="bodyContent">'+
                '<p><b>'+location.title+'</b> '+stars+'<br>'+location.text.substring(0, 75)+'</p>'+
                '</div>'+
                '</div>';

            var infowindow = new google.maps.InfoWindow({
                content: contentString,
                maxWidth: 200,
                disableAutoPan: true
            });

            var marker = new google.maps.LatLng(location.latitude, location.longitude);

            var markerObj = new google.maps.Marker({
                map: map,
                position: marker,
                key: key
            });

            markerObj.addListener('click', function(e) {
                scrollToHotel(this.key)
            });

            markerObj.addListener('mouseover', function() {
                infowindow.open(map, markerObj);
            });

            markerObj.addListener('mouseout', function() {
                infowindow.close();
            });

            bounds.extend(marker);
        }
        function scrollToHotel(key) {
            var offset = $('#hotel-'+key).offset().top;
            $('html, body').animate({
                scrollTop: offset - 100
            }, 750);
        }
        initialize();
    </script>
@endsection
