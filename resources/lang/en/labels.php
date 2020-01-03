<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'frontend' => [
        'auth' => [
            'login_box_title' => 'Login',
            'remember_me'     => 'Eingeloggt bleiben',
            'login_button'    => 'Login'
        ],
        'passwords' => [
            'forgot_password' => 'Passwort vergessen?'
        ],
        'tokenlogin' => [
            'email' => 'Ihre E-Mail-Adresse'
        ],
        'agents' => [
            'create'     => 'Neuen Agenten erstellen',
            'management' => 'Agenten',
            'table'      => [
                'avatar'           => 'Avatar',
                'name'             => 'Name',
                'display_name'     => 'Anzeigename',
                'status'           => 'Status',
                'created_at'       => 'Erstellt am',
                'createdby'        => 'Erstellt von',
                'id'               => 'ID',
                'actions'          => 'Agent bearbeiten',
            ],
        ],
        'wishes' => [
            'wishes'        => 'Reisewünsche',
            'goto'          => 'Reisewunsch ansehen',
            'created_at'    => 'erstellt am',
            'edit'          => 'Reisewunsch bearbeiten',
            'add-comment'   => 'Kommentar hinzufügen',
            'week'          => ':value Woche|:value Wochen',
            'night'         => ':value Nacht|:value Nächte',
            'table'         => [
                'adults' => ':count Erwachsener|:count Erwachsene',
                'kids'   => '{0}Kein Kinder|Kind|Kinder',
            ]
        ],
        'offers' => [
            'create'          => 'Neues Angebot erstellen',
            'management'      => 'Angebote',
            'offers_for_wish' => 'Angebote für',
            'table'           => [
                'title'     => 'Angebot',
                'status'    => 'Status',
                'createdat' => 'Erstellt in',
                'createdby' => 'Erstellt von',
                'all'       => 'Alle',
            ],
        ],
    ]

];
