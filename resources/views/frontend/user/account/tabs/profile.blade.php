<table class="table">
    <tr>
        <th>{{ trans('labels.frontend.user.profile.first_name') }}</th>
        <td>{{ !empty($logged_in_user['first_name']) ? $logged_in_user['first_name'] : '' }}</td>
    </tr>
    <tr>
        <th>{{ trans('labels.frontend.user.profile.last_name') }}</th>
        <td>{{ !empty($logged_in_user['last_name']) ? $logged_in_user['last_name'] : '' }}</td>
    </tr>
    <tr>
        <th>{{ trans('labels.frontend.user.profile.email') }}</th>
        <td>{{ !empty($logged_in_user['email']) ? $logged_in_user['email'] : '' }}</td>
    </tr>
    <tr>
        <th>{{ trans('labels.frontend.user.profile.address') }}</th>
        <td>{{ !empty($logged_in_user['address']) ? $logged_in_user['address'] : '' }}</td>
    </tr>
    <tr>
        <th>{{ trans('labels.frontend.user.profile.zipcode') }}</th>
        <td>{{ !empty($logged_in_user['zip_code']) ? $logged_in_user['zip_code']: '' }}</td>
    </tr>
    <tr>
        <th>{{ trans('labels.frontend.user.profile.city') }}</th>
        <td>{{ !empty($logged_in_user['city']) ? $logged_in_user['city'] : '' }}</td>
    </tr>
    <tr>
        <th>{{ trans('labels.frontend.user.profile.country') }}</th>
        <td>{{ !empty($logged_in_user['country']) ? $logged_in_user['country'] : '' }}</td>
    </tr>

    <tr>
        <th>{{ trans('labels.frontend.user.profile.created_at') }}</th>
        <td>{{ !empty($logged_in_user['created_at']) ? $logged_in_user['created_at'] : '' }}</td>
    </tr>
    <tr>
        <th>{{ trans('labels.frontend.user.profile.last_updated') }}</th>
        <td>{{ !empty($logged_in_user['updated_at']) ? $logged_in_user['updated_at'] : '' }}</td>
    </tr>
</table>
