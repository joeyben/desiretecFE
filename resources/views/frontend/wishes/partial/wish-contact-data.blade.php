@if ($logged_in_user['role'] == ('Seller') && count($wish->wishDetails->contacts) )
            <h4>Kontaktdaten des Kunden</h4>
            <div class="row">
                <div class="col-md-3 c-info">
                    <i class="fal fa-pencil"></i>
                    <span>{{ $wish->wishDetails->contacts[0]->subject }}</span>
                </div>
                <div class="col-md-3 c-info">
                    <i class="fas fa-user"></i>
                    <span>{{ $wish->wishDetails->contacts[0]->first_name }} {{ $wish->wishDetails->contacts[0]->last_name }}</span>
                </div>
                <div class="col-md-3 c-info c-tel">
                    <i class="fas fa-phone"></i>
                    <a href="tel:{{ $wish->wishDetails->contacts[0]->telephone }}">{{ $wish->wishDetails->contacts[0]->telephone }}</a>
                </div>
                <div class="col-md-3 c-info">
                    <i class="fas fa-envelope"></i>
                    <a href="mailto:{{ $wish->wishDetails->contacts[0]->email }}">{{ $wish->wishDetails->contacts[0]->email }}</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p>
                        &nbsp;
                    </p>
                </div>
                <div class="col-md-12">
                    <h5>Nachricht:</h5>
                    <p>
                        {{ $wish->wishDetails->contacts[0]->message }}
                    </p>
                </div>
            </div>

@elseif ($logged_in_user['role'] == ('User'))
            <h4>Zuständiges Reisebüro</h4>
            <div class="row">
                <div class="col-md-3 c-info">
                    <p>
                        {{ $wish->wishDetails->group->users[0]->name }}</p>
                    @if ($wish->wishDetails->group->users[0]->address)
                        <p>
                            {{ $wish->wishDetails->group->users[0]->address }} <br>
                            {{ $wish->wishDetails->group->users[0]->zip_code }} {{ $wish->wishDetails->group->users[0]->city }}
                        </p>
                    @endif
                </div>
                @if(count($wish->wishDetails->offers) > 0 || count($wish->wishDetails->messages) > 0)
                    <div class="col-md-3 c-info">
                        <i class="fas fa-user"></i>
                        <span>{{ $wish->wishDetails->group->users[0]->agents[0]->name }}</span>
                    </div>
                    @if ($wish->wishDetails->group->users[0]->agents[0]->telephone)
                        <div class="col-md-3 c-info c-tel">
                            <i class="fas fa-phone"></i>
                            <a href="tel:{{ $wish->wishDetails->group->users[0]->agents[0]->telephone }}">{{ $wish->wishDetails->group->users[0]->agents[0]->telephone }}</a>
                        </div>
                    @endif
                    <div class="col-md-3 c-info">
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:{{ $wish->wishDetails->group->users[0]->agents[0]->email }}">{{ $wish->wishDetails->group->users[0]->agents[0]->email }}</a>
                    </div>
                @endif
            </div>
@endif