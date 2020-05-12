<div id="autoOfferCarousel-{{ $keyNumber }}" class="carousel slide" data-ride="carousel" data-interval="false">
    <div class="carousel-indicators">
        <span class="current">1</span>
        <span>/</span>
        <span class="count">{{ count($images) }}</span>
    </div>
    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        @foreach ($images as $key => $image)
            <a href="{{ $image }}" data-lightbox="image-{{ $keyNumber }}" class="item @if ($key === 1) active @endif">
                <img src="{{ $image }}">
            </a>
        @endforeach
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#autoOfferCarousel-{{ $keyNumber }}" data-slide="prev">
        <i class="fa fa-chevron-left" aria-hidden="true"></i>
        <span class="sr-only">{{ trans('autooffers.carousel.previous') }}</span>
    </a>
    <a class="right carousel-control" href="#autoOfferCarousel-{{ $keyNumber }}" data-slide="next">
        <i class="fa fa-chevron-right" aria-hidden="true"></i>
        <span class="sr-only">{{ trans('autooffers.carousel.next') }}</span>
    </a>
</div>

@section("after-scripts")
<script type="application/javascript">
    $('#autoOfferCarousel-{{ $keyNumber }}').bind('slide.bs.carousel', function (e) {
        var slideTo = $(e.relatedTarget).index();
        console.log(slideTo)
        $(this).find('.carousel-indicators .current').text(slideTo);
    });
</script>
@endsection