<?php

return [
    'common' => [
        'actions' => 'Actions',
        'create' => 'Create',
        'edit' => 'Edit',
        'update' => 'Update',
        'search' => 'Search...',
        'back' => 'Back to Index',
        'are_you_sure' => 'Are you sure?',
        'no_items_found' => 'No items found',
        'created' => 'Successfully created',
        'saved' => 'Saved successfully',
        'removed' => 'Successfully removed',
    ],

    'users' => [
        'name' => 'Users',
        'index_title' => 'Users List',
        'create_title' => 'Create User',
        'edit_title' => 'Edit User',
        'show_title' => 'Show User',
        'inputs' => [
            'name' => 'Nom',
            'email' => 'Email',
            'password' => 'Mot de passe',
        ],
    ],

    'reservations' => [
        'name' => 'Reservations',
        'index_title' => 'Reservations List',
        'create_title' => 'Create Reservation',
        'edit_title' => 'Edit Reservation',
        'show_title' => 'Show Reservation',
        'inputs' => [
            'date' => 'Date',
            'begin_at' => 'Heure de début',
            'end_at' => 'Heure de fin',
            'description' => 'Description',
            'user_id' => 'Utilisateur',
            'room_id' => 'Salle',
        ],
    ],

    'rooms' => [
        'name' => 'Rooms',
        'index_title' => 'Rooms List',
        'create_title' => 'Create Room',
        'edit_title' => 'Edit Room',
        'show_title' => 'Show Room',
        'inputs' => [
            'name' => 'Nom',
        ],
    ],

    'roles' => [
        'name' => 'Roles',
        'index_title' => 'Roles List',
        'create_title' => 'Create Role',
        'edit_title' => 'Edit Role',
        'show_title' => 'Show Role',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'permissions' => [
        'name' => 'Permissions',
        'index_title' => 'Permissions List',
        'create_title' => 'Create Permission',
        'edit_title' => 'Edit Permission',
        'show_title' => 'Show Permission',
        'inputs' => [
            'name' => 'Name',
        ],
    ],
];
