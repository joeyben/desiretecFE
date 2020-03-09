<div class="footer">
    <div class="container">
        <div class="col-md-12">
            <ul class="d-flex justify-content-center flex-wrap">
                @foreach (getWhitelabelInfo()['footers'] as $footer)
                     <li>
                        <a href="{{ $footer['url'] }}" target="_blank" class="link-btn-secondary">{{ $footer['name'] }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
