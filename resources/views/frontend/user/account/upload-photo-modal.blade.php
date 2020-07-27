<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{{ trans('user.account.upload_avatar') }}</h4>
      </div>
      <div class="modal-body">
        {{ Form::open(['route' => [ 'frontend.user.profile-picture', $subdomain, 'files' => true]]) }}
        <div class="form-group">
          <label for="profile_pic">
            <img src="{{url('/').'/img/frontend/profile-picture/pic-1.png'}}" height=80 width=80>
            {!! Form::radio('profile_pic') !!}
          </label>
        </div>
        <div class="form-group">
          <label for="profile_pic">
            <img src="{{url('/').'/img/frontend/profile-picture/pic-2.png'}}" height=80 width=80>
            {!! Form::radio('profile_pic') !!}
          </label>
        </div>
        <div class="form-group">
          <label for="profile_pic">
            <img src="{{url('/').'/img/frontend/profile-picture/pic-3.png'}}" height=80 width=80>
            {!! Form::radio('profile_pic') !!}
          </label>
        </div>
        <div class="form-group">
          {!! Form::file('profile_picture', ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
          {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
          {!! Form::reset('Reset', ['class' => 'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('user.account.close_button') }}</button>
      </div>
    </div>

  </div>
</div>
