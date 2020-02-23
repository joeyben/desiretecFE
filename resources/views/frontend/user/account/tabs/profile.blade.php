<table class="table">
    <tr>
        <th>{{ trans('labels.frontend.user.profile.first_name') }}</th>
        <td>{{ !empty($user->first_name) ? $user->first_name : '' }}</td>
    </tr>
    <tr>
        <th>{{ trans('labels.frontend.user.profile.last_name') }}</th>
        <td>{{ !empty($user->last_name) ? $user->last_name : '' }}</td>
    </tr>
    <tr>
        <th>{{ trans('labels.frontend.user.profile.email') }}</th>
        <td>{{ !empty($user->email) ? $user->email : '' }}</td>
    </tr>
    <tr>
        <th>{{ trans('labels.frontend.user.profile.address') }}</th>
        <td>{{ !empty($user->address) ?  $user->address : '' }}</td>
    </tr>
    <tr>
        <th>{{ trans('labels.frontend.user.profile.zipcode') }}</th>
        <td>{{ !empty($user->zip_code) ? $user->zip_code : '' }}</td>
    </tr>
    <tr>
        <th>{{ trans('labels.frontend.user.profile.city') }}</th>
        <td>{{ !empty($user->city) ? $user->city : '' }}</td>
    </tr>
    <tr>
        <th>{{ trans('labels.frontend.user.profile.country') }}</th>
        <td>{{ !empty($user->country) ? $user->country : '' }}</td>
    </tr>

    <tr>
        <th>{{ trans('labels.frontend.user.profile.created_at') }}</th>
        <td>{{ !empty($user->created_at) ? $user->created_at : '' }}</td>
    </tr>
    <tr>
        <th>{{ trans('labels.frontend.user.profile.last_updated') }}</th>
        <td>{{ !empty($user->updated_at) ? $user->updated_at : '' }}</td>
    </tr>
</table>
