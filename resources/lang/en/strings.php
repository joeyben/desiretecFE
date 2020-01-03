<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Strings Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used in strings throughout the system.
    | Regardless where it is placed, a string can be listed here so it is easily
    | found in a intuitive way.
    |
    */
    'wishlist' => [
        'search' => 'Wunsch Nummer Suchen'
    ],
    'backend' => [
        'access' => [
            'users' => [
                'delete_user_confirm'  => 'Are you sure you want to delete this user permanently? Anywhere in the application that references this user\'s id will most likely error. Proceed at your own risk. This can not be un-done.',
                'if_confirmed_off'     => '(Falls Auto - Bestätigung aus ist)',
                'restore_user_confirm' => 'Diesen User in seinem Ursprungszustand wiederherstellen?',
            ],
        ],

        'dashboard' => [
            'title'   => 'Admin Dashboard',
            'welcome' => 'Willkommen',
        ],

        'general' => [
            'all_rights_reserved' => 'All Rights Reserved.',
            'are_you_sure'        => 'Sind Sie sicher?',
            'boilerplate_link'    => 'Laravel AdminPanel',
            'continue'            => 'Weiter',
            'member_since'        => 'Member since',
            'minutes'             => 'Minuten',
            'search_placeholder'  => 'Suchen...',
            'timeout'             => 'Sie wurden aus Sicherheitsgründen auf Grund von Inaktivität ausgeloggt.',

            'see_all' => [
                'messages'      => 'Alle Nachrichten anzeigen',
                'notifications' => 'Alle anzeigen',
                'tasks'         => 'Alle Aufgaben anzeigen',
            ],

            'status' => [
                'online'  => 'Online',
                'offline' => 'Offline',
            ],

            'you_have' => [
                'messages'      => '{0} You don\'t have messages|{1} You have 1 message|[2,Inf] You have :number messages',
                'notifications' => '{0} You don\'t have notifications|{1} You have 1 notification|[2,Inf] You have :number notifications',
                'tasks'         => '{0} You don\'t have tasks|{1} You have 1 task|[2,Inf] You have :number tasks',
            ],
        ],

        'search' => [
            'empty'      => 'Bitte geben Sie einen Suchbegriff.',
            'incomplete' => 'You must write your own search logic for this system.',
            'title'      => 'Suchergebnisse',
            'results'    => 'Suchergebnisse für :query',
        ],

        'welcome' => '<p>This is the AdminLTE theme by <a href="https://almsaeedstudio.com/" target="_blank">https://almsaeedstudio.com/</a>. This is a stripped down version with only the necessary styles and scripts to get it running. Download the full version to start adding components to your dashboard.</p>
<p>All the functionality is for show with the exception of the <strong>Access Management</strong> to the left. This boilerplate comes with a fully functional access control library to manage users/roles/permissions.</p>
<p>Keep in mind it is a work in progress and their may be bugs or other issues I have not come across. I will do my best to fix them as I receive them.</p>
<p>Hope you enjoy all of the work I have put into this. Please visit the <a href="https://github.com/rappasoft/laravel-5-boilerplate" target="_blank">GitHub</a> page for more information and report any <a href="https://github.com/rappasoft/Laravel-5-Boilerplate/issues" target="_blank">issues here</a>.</p>
<p><strong>This project is very demanding to keep up with given the rate at which the master Laravel branch changes, so any help is appreciated.</strong></p>
<p>- Viral Solani</p>',
    ],

    'emails' => [
        'auth' => [
            'error'                   => 'Whoops!',
            'greeting'                => 'Hello!',
            'regards'                 => 'Regards,',
            'trouble_clicking_button' => 'If you’re having trouble clicking the ":action_text" button, copy and paste the URL below into your web browser:',
            'thank_you_for_using_app' => 'Thank you for using our application!',

            'password_reset_subject'    => 'Reset Password',
            'password_cause_of_email'   => 'You are receiving this email because we received a password reset request for your account.',
            'password_if_not_requested' => 'If you did not request a password reset, no further action is required.',
            'reset_password'            => 'Click here to reset your password',

            'click_to_confirm' => 'Click here to confirm your account:',
        ],
    ],

    'frontend' => [
        'test' => 'Test',

        'tests' => [
            'based_on' => [
                'permission' => 'berechtigungsbasiert - ',
                'role'       => 'rollenbasiert - ',
            ],

            'js_injected_from_controller' => 'Javascript Injected from a Controller',

            'using_blade_extensions' => 'Using Blade Extensions',

            'using_access_helper' => [
                'array_permissions'     => 'Using Access Helper with Array of Permission Names or ID\'s where the user does have to possess all.',
                'array_permissions_not' => 'Using Access Helper with Array of Permission Names or ID\'s where the user does not have to possess all.',
                'array_roles'           => 'Using Access Helper with Array of Role Names or ID\'s where the user does have to possess all.',
                'array_roles_not'       => 'Using Access Helper with Array of Role Names or ID\'s where the user does not have to possess all.',
                'permission_id'         => 'Using Access Helper with Permission ID',
                'permission_name'       => 'Using Access Helper with Permission Name',
                'role_id'               => 'Using Access Helper with Role ID',
                'role_name'             => 'Using Access Helper with Role Name',
            ],

            'view_console_it_works'          => 'View console, you should see \'it works!\' which is coming from FrontendController@index',
            'you_can_see_because'            => 'You can see this because you have the role of \':role\'!',
            'you_can_see_because_permission' => 'You can see this because you have the permission of \':permission\'!',
        ],

        'user' => [
            'change_email_notice'  => 'Wenn Sie Ihre E-Mail-Adresse ändern, werden Sie ausgeloggt, bis Sie Ihre neue E-Mail-Adresse bestätigt haben.',
            'email_changed_notice' => 'Sie müssen Ihre E-Mail-Adresse bestätigen, bevor Sie sich erneut einloggen können.',
            'profile_updated'      => 'Profil erfolgreich aktualisiert.',
            'password_updated'     => 'Passwort erfolgreich geändert.',
        ],

        'welcome_to' => 'Willkommen zum :place',
    ],
];
