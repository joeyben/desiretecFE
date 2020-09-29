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
                                    <h4>{{ $wish->budget }}{{ trans('autooffer.list.currency') }}</h4>
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
                                    <h4>{{ transformDuration($wish->duration) }}</h4>
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
                                $data = $offer['data'];
                                //dd($data);
                                $category = isset($data['ratings']) ? intval($data['ratings']['@attributes']['max_score'][0]) : 0;
                                $hotelData = [
                                    'title' => html_entity_decode($data['title']['text']),
                                    'stars' => $category,
                                    'text' => '',
                                    'longitude' => $data['location']['geo']['longitude'],
                                    'latitude' => $data['location']['geo']['latitude']
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
                                        @foreach($data['images']['image'] as $image)
                                            <div class="slider-item" style="background-image: url({!! str_replace('180', '600', $image) !!})"></div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="right-side">
                                <div class="title">
                                    <h3 class="ellipsised">{{ htmlspecialchars(html_entity_decode($data['title']['text'])) }}</h3>
                                    <span class="mousehover"></span>
                                    <div class="tooltip">{{ htmlspecialchars(html_entity_decode($data['title']['text'])) }}</div>

                                    <div class="rating">
                                        @for ($i = 0; $i < $category; $i++)
                                            <i class="fas fa-heart"></i>
                                        @endfor
                                    </div>
                                </div>

                                <div class="location">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <h5>{{ $data['location']['city'] }}, {{ $data['location']['country'] }}</h5>
                                </div>
                                @isset($data['ratings'])
                                <div class="fulfill">
                                    <progress value="{{ $data['ratings']['@attributes']['max_score'][0] }}" max="5"></progress>
                                    <h4> <span>{{ $data['ratings']['@attributes']['max_score'] }}%</span> Weiterempfehlung</h4>
                                </div>

                                <div class="recommandations">
                                    <div class="average">{{ $data['ratings']['@attributes']['max_score'] }}</div>
                                    <div class="text">
                                        <h4 class="dark-grey-2">Empfehlenswert</h4>
                                        <h4>{{ $data['ratings']['@attributes']['max_score'] }} Bewertungen</h4>
                                    </div>
                                </div>
                                @endisset
                                <div class="description">
                                    <p>
                                        {{ \Illuminate\Support\Str::limit($data['description']['text'][0], 150, $end='...') }}
                                    </p>
                                    <p>
                                        {{ \Illuminate\Support\Str::limit($data['description']['text'][1], 150, $end='...') }}
                                    </p>
                                </div>
                                <div class="highlights">
                                    <h4 class="dark-grey-2">Highlights der Unterkunft:</h4>
                                    <ul>
                                        @php
                                            $amenitiesCount =  count($data['amenities']['amenity']) >= 3 ? 3 : count($data['amenities']['amenity']);
                                        @endphp

                                        @for ($i = 0; $i < $amenitiesCount; $i++)
                                            @isset($data['amenities']['amenity'][$i])
                                            <li>
                                                <i class="fal fa-check"></i>
                                                <h4 class="dark-grey">{{ $data['amenities']['amenity'][$i] }}</h4>
                                            </li>
                                            @endisset
                                        @endfor

                                    </ul>

                                    <div class="travel-info">
                                        <h4>{{ $data['@attributes']['type'] }}</h4>
                                    </div>
                                </div>

                                <div class="price">
                                    <div class="info-icons">
                                    </div>
                                    @php
                                        $price =  isset($data['prices']['range'][0])  ? $data['prices']['range'][0]['price'] : $data['prices']['range']['price'];
                                    @endphp
                                    <h3>{{ number_format($price, 0, ',', '.') }} <span>{{ trans('autooffer.list.currency') }}</span> p.P.</h3>
                                    <a class="btn btn-primary" target="_blank" href="#">
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
    @include('frontend.whitelabel.footer')
@endsection

@section('before-scripts')
    <script type="application/javascript">
        var brandColor = {!! json_encode(getWhitelabelInfo()['color']) !!};
    </script>
@endsection

@section('after-scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.slick/1.5.5/slick.min.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAE60OtWg7HL-wqOpGHcRGAD6HpYzAh6t4"></script>

    <script type="application/javascript">

        $(document).ready(function(){
            $('.about-section h3 a').css({'color': brandColor});
            $('.listed-offers-section .vertical-line').css({'background-color': brandColor});
            $('.fas.fa-heart, .fal.fa-check, .offers .fulfill span, .fas.fa-map-marker-alt').css({'color': brandColor});
            $('.offers .recommandations .average').css({'border-color': brandColor});
            $('.offers .label').css({'color': brandColor});
            $('head').append('<style>' +
                'progress::-webkit-progress-value { background: ' + brandColor + ' !important; } ' +
                '.offers .slick-slider i { color: ' + brandColor + '; }' +
                '</style>');

            if($('.offers .info-icons').length === 0) {
                $('.offers .highlights').css({'padding-bottom': '15px'});
            }

            $('.slick-slider').slick({
                dots: false,
                infinite: true,
                speed: 300,
                slidesToShow: 1,
                prevArrow: '<div class="btn arrow-left"><i class="fa fa-chevron-left"></i></div>',
                nextArrow: '<div class="btn arrow-right"><i class="fa fa-chevron-right"></i></div>'
            });

            $('[data-toggle="tooltip"]').tooltip();

            $('.ellipsised').each(function() {
                var isEllipsisActive = $(this)[0].offsetWidth < $(this)[0].scrollWidth;
                if(!isEllipsisActive) {
                    $(this).siblings('.tooltip').remove();
                }
            });
        });

        function scrollToAnchor(id) {
            $('html, body').animate({
                scrollTop: $("#"+id).offset().top - 75
            }, 1000);
        }

        function showMenu() {
            $('#offer-highlights').detach().appendTo('#main-offer-section-shell');
            $('#offer-highlights').css('height', '275px');
            $('#offer-highlights').toggle();
        }

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
