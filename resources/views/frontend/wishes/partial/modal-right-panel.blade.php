@if(count($wish->offers) > 0 || count($wish->sellerMessages) > 0)
    <div class="col-md-4 modal-body-right">
        <img title="{{ $wish->group->users[0]->currentAgent[0]->name }}" alt="{{ $wish->group->users[0]->currentAgent[0]->name }}" src="{{ Storage::disk('s3')->url('img/agent/') }}{{ $wish->group->users[0]->currentAgent[0]->avatar }}" />
        <h4>{{ $wish->group->users[0]->currentAgent[0]->name }}</h4>
        <div class="modal-contact">
            <div class="mc-tel">
                <span class="glyphicon glyphicon-earphone"></span>
                <a href="tel:{{ $wish->group->users[0]->currentAgent[0]->telephone }}">{{ $wish->group->users[0]->currentAgent[0]->telephone }}</a>
            </div>
            <div class="mc-mail">
                <span class="glyphicon glyphicon-envelope"></span>
                <a href="mailto:mail@reisebuero.de">@if(count($wish->group->users[0]->currentAgent)){{ $wish->group->users[0]->currentAgent[0]->email }}@endif</a>
            </div>
        </div>
    </div>
@else
    <div class="col-md-4 modal-body-right">
        <img src="/img/frontend/profile-picture/travel-agency.jpg" alt="">
        <h4>{{ $wish->group->users[0]->name }}</h4>
        <p>{{ $wish->group->users[0]->address }}<br>
            {{ $wish->group->users[0]->zip_code }} {{ $wish->group->users[0]->city }}
        </p>
        <div class="modal-contact">
            <div class="mc-mail">
                <span class="glyphicon glyphicon-envelope"></span>
                <a href="mailto:mail@reisebuero.de">{{ $wish->group->users[0]->email }}</a>
            </div>
        </div>
    </div>
@endif