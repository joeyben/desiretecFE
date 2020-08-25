@extends('frontend.layouts.app')

@section('title')
    {{ ucfirst(getWhitelabelInfo()['name']) }} {{ trans('wish.list.tab_title') }}
@endsection

@section('before-scripts')
    <script type="application/javascript">
        var brandColor = {!! json_encode(getWhitelabelInfo()['color']) !!};
    </script>
@endsection

@section('content')
    @php
        $whitelabelName = getWhitelabelInfo()['name'];
        $translations = [
            "count" => trans_choice('labels.frontend.wishes.wishes', 1),
            "count_plural" => trans_choice('labels.frontend.wishes.wishes', 999),
            "adults" => trans_choice('labels.frontend.wishes.adults', 1),
            "adults_plural" => trans_choice('labels.frontend.wishes.adults', 999),
            "kids" => trans_choice('labels.frontend.wishes.kids', 1),
            "kids_plural" => trans_choice('labels.frontend.wishes.kids', 999),
            "rooms" => trans_choice('labels.frontend.wishes.rooms', 1),
            "rooms_plural" => trans_choice('labels.frontend.wishes.rooms', 999),
            "pets" => trans_choice('labels.frontend.wishes.pets', 1),
            "pets_plural" => trans_choice('labels.frontend.wishes.pets', 999),
            "created_at" => trans('labels.frontend.wishes.created_at'),
            "search_placeholder" => trans('strings.wishlist.search'),
            "goto_btn" => trans('labels.frontend.wishes.goto'),
            "wishes_date_until" => trans('labels.frontend.wishes.wishes_date_until'),
            "offer_ex" => trans('strings.wishlist.offer_ex'),
            "is_interested_events" => trans('labels.frontend.wishes.events_interested_checked'),
            "not_interested_events" => trans('labels.frontend.wishes.events_interested_unchecked'),
        ];
        $statusesTrans = [
            trans('menus.list.status.new'),
            trans('menus.list.status.offer_created'),
            trans('menus.list.status.completed'),
            trans('menus.list.status.all'),
        ];
    @endphp
    <wish-list
        wl-name="{{ json_encode($whitelabelName) }}"
        user-role="{{ json_encode($logged_in_user['role']) }}"
        statuses-trans="{{ json_encode($statusesTrans) }}"
        words-trans="{{ json_encode($translations) }}" >
    </wish-list>
@endsection

@section('footer')
    @include('frontend.whitelabel.footer')
@endsection

@section('after-scripts')
    <script>
        $(document).ready(function() {
            $('.selectpicker').selectpicker();
        });
    </script>
@endsection
