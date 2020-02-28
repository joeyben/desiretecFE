@extends('frontend.layouts.app')

@section('title')
    {{ trans('general.url.offer') }}
@endsection

@section('before-scripts')
    <script type="application/javascript">
        var brandColor = {!! json_encode(getWhitelabelInfo()['color']) !!};
    </script>
@endsection

@section('content')
    <div class="box box-info">
        @if (session('flash_success'))
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">×</button>
            {{ session('flash_success') }}
        </div>
        @endif
        <div class="box-header">
            <h3 class="mb-30">{{ trans('labels.frontend.offers.management') }}</h3>
        </div>

        <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="offers-table" class="table table-condensed table-hover">
                    <thead class="transparent-bg">
                        <tr>
                            <th>{{ trans('labels.frontend.offers.table.title') }}</th>
                            <th>{{ trans('labels.frontend.offers.table.createdby') }}</th>
                            <th>{{ trans('labels.frontend.offers.table.createdat') }}</th>
                            <th>{{ trans('labels.frontend.offers.table.status') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($offers as $offer)
                            <tr>
                                <td>{!! $offer['title'] !!}</td>
                                <td>{{ $offer['created_by'] }}</td>
                                <td>{{ $offer['created_at'] }}</td>
                                <td>{{ $offer['status'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row-pagination">
                {{ $offers->links() }}
            </div>
        </div>
    </div>
@endsection

@section('after-scripts')
    <script>
        $(document).ready(function() {
            $('.offer .box-body a').css({
                'color': brandColor,
            });
            $('.offer .pagination span.page-link').css({
                'background-color': brandColor,
                'border-color': brandColor,
            });
        });
    </script>
@endsection
