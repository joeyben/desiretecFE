@extends('frontend.layouts.app')

@section('title')
    {{ ucfirst(getWhitelabelInfo()['name']) }} {{ trans('autooffer.list.tab_title') }}
@endsection

@section("after-styles")
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/jquery.slick/1.5.5/slick.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/jquery.slick/1.5.5/slick-theme.css" />
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
                        @else
                            {{ trans('autooffer.message.offers', ['destination' => $wish->destination]) }}
                            {{ trans('autooffer.message.callback') }}
                        @endif

                    </h3>
                    @if (count($offers) > 0)
                        <a class="btn btn-primary" onclick="scrollToAnchor('listed-offers-section')">{{ trans('autooffer.offers.goto_button') }}</a>
                    @endif
                </div>
            </section>

            <section class="main-offer-section">
                <div class="shell" id="main-offer-section-shell">
                    <h2>Auf einen Blick</h2>

                    <div class="main-offer">
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
                                    <h4>{{ $wish->adults }} Erwachsene, {{ $wish->kids }} {{ $wish->kids == 1 ? "Kind" : "Kinder" }}</h4>
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
                                    <h4>{{ $wish->budget }}€</h4>
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
            @if (count($offers) > 0)
            <section class="listed-offers-section" id="listed-offers-section">
                <div class="shell">
                    <div class="vertical-line"></div>
                    <h1>Meine Angebote</h1>

                    <ul class="offers">
                        @php
                            $count = 0;
                            $locations = [];
                        @endphp
                        @foreach($offers as $key => $offer)
                            @if (!isset($offer['hotel_data']['hotel']))
                                @continue
                            @endif
                            @php
                                $hotelData = [
                                    'title' => $offer['hotel_data']['hotel']['name'],
                                    'stars' =>  $offer['hotel_data']['hotel']['category'],
                                    'text' => htmlspecialchars($offer['hotel_data']['hotel']['catalogData']['previewText'], ENT_QUOTES),
                                    'longitude' => $offer['hotel_data']['hotel']['location']['longitude'],
                                    'latitude' => $offer['hotel_data']['hotel']['location']['latitude']
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
                                    @if (isset($offer['hotel_data']['hotel']['catalogData']['imageList']))
                                        @foreach($offer['hotel_data']['hotel']['catalogData']['imageList'] as $image)
                                            <div class="slider-item" style="background-image: url({!! str_replace('180', '600', $image) !!})"></div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="right-side">
                                <div class="title">
                                    <h3>{{ $offer['data']['hotelOffer']['hotel']['name'] }}</h3>
                                    <div class="rating">
                                        @for ($i = 0; $i < intval($offer['data']['hotelOffer']['hotel']['category']); $i++)
                                            <i class="fas fa-heart"></i>
                                        @endfor
                                    </div>
                                </div>

                                <div class="location">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <h5>{{ $offer['hotel_data']['hotel']['location']['name'] }}, {{ $offer['hotel_data']['hotel']['location']['region']['name'] }}</h5>
                                </div>

                                <div class="fulfill">
                                    <progress value="{{ $offer['data']['hotelOffer']['hotel']['rating']['recommendation'] }}" max="100"></progress>
                                    <h4> <span>{{ $offer['data']['hotelOffer']['hotel']['rating']['recommendation'] }}%</span> Weiterempfehlung</h4>
                                </div>

                                <div class="recommandations">
                                    <div class="average"><?= number_format((int) ($offer['data']['hotelOffer']['hotel']['rating']['overall']) / 10, 1, ',', '.'); ?></div>
                                    <div class="text">
                                        <h4 class="dark-grey-2">Empfehlenswert</h4>
                                        <h4>{{ $offer['data']['hotelOffer']['hotel']['rating']['count'] }} Bewertungen</h4>
                                    </div>
                                </div>

                                <div class="highlights">
                                    <h4 class="dark-grey-2">Highlights der Unterkunft:</h4>
                                    <ul>
                                        @for ($i = 0; $i < 3; $i++)
                                        <li>
                                            <i class="fal fa-check"></i>
                                            <h4 class="dark-grey">{{ $offer['data']['hotelOffer']['hotel']['keywordHighlights'][$i] }}</h4>
                                        </li>
                                        @endfor
                                    </ul>

                                    <div class="travel-info">
                                        <h4>{{ $offer['data']['hotelOffer']['boardType']['name'] }}</h4>
                                        <h4 data-toggle="tooltip" data-placement="bottom" title="{{ $offer['data']['serviceOffer']['description'] }}">{{ $offer['data']['travelDate']['duration'] }} Tage, {{ \Illuminate\Support\Str::limit($offer['data']['serviceOffer']['description'], 20, "...") }}</h4>
                                    </div>
                                </div>

                                <div class="price">
                                    <h3>{{ number_format($offer['data']['personPrice']['value'], 0, ',', '.') }} <span>&#8364;</span> p.P.</h3>
                                    @php
                                        $hin_arr = explode('-', $offer['data']['travelDate']['fromDate'] );
                                        $year = $hin_arr[0][2].$hin_arr[0][3];
                                        $hin = $hin_arr[2].$hin_arr[1].$year;

                                        $zu_arr = explode('-', $offer['data']['travelDate']['toDate'] );
                                        $year = $zu_arr[0][2].$zu_arr[0][3];
                                        $zu  = $zu_arr[2].$zu_arr[1].$year;

                                        $kids = $wish->ages ? "&children=".$wish->ages : "";

                                        $tourOperators = getWhitelabelInfo()['tourOperators'];
                                        $duration = (int)$offer['data']['travelDate']['duration'] - 1;
                                    @endphp
                                    @if (getWhitelabelInfo()['id'] === 159)
                                        <a class="btn btn-primary" target="_blank" href="https://ibe.traffics.de/1100000160000000/pauschalreise/angebote?giataIdList={{ $offer['hotel_data']['hotel']['giata']['hotelId'] }}&tourOperator={{ $offer['hotel_data']['hotel']['tourOperator']['code'] }}&roomTypeList=&minPricePerPerson={{ $offer['data']['personPrice']['value'] }}&searchDate={{ $hin }}%2C{{ $zu }}%2C{{ $duration }}&minBoardType={{ $offer['data']['hotelOffer']['boardType']['code'] }}&inclusiveList=&adults={{ $wish->adults }}{{ $kids }}&departureAirportList={{ $offer['data']['flightOffer']['flight']['departureAirport']['code'] }}&destinationName={{ $wish->destination }}&regionList={{ $offer['data']['hotelOffer']['hotel']['location']['region']['code'] }}&ref=desiretec">
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                    @else
                                    <a class="btn btn-primary" target="_blank" href="https://reisen.bild.de/buchen/?hotellist={{ $offer['hotel_data']['hotel']['giata']['hotelId'] }}&tourOperator={{ $offer['hotel_data']['hotel']['tourOperator']['code'] }}&productType=pauschal&searchDate={{ $hin }}%2C{{ $zu }}%2C{{ $offer['data']['travelDate']['duration'] }}&hotellist=&regionlist={{ $offer['data']['hotelOffer']['hotel']['location']['region']['code'] }}&departureairportlist={{ $offer['data']['flightOffer']['flight']['departureAirport']['code'] }}&inclusiveList=&keywordList=&tourOperatorList={{ $tourOperators }}&sortBy=price&sortDir=up&navigationStart=1%2C10&navigationOffer=1%2C10&navigationHotel=1%2C10&partnerIdent=bildreisen%2F&action=hoteldetail&filterdest=hotel&maxPricePerPerson={{ $offer['data']['personPrice']['value'] }}&destinationName={{ $wish->destination }}&departureName={{ $wish->airport }}&adults={{ $wish->adults }}{{ $kids }}&minCategory={{ $wish->category }}&recommendation=&roomTypeList=&boardTypeList={{ $offer['data']['hotelOffer']['boardType']['code'] }}&inclusiveListSel=&ref=desiretec">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                    @endif
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
    @if (count($offers) > 0)
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
    @endif

@endsection
