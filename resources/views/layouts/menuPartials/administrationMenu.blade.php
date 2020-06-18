@include('layouts.menuPartials.collapsedMenu', [
    'permissions' => [
        'administration.users.view',
        'administration.profiles.view'
    ],
    'id' => 'administrationMenu',
    'name' => 'Administración',
    'icon' => 'icon icon-settings',
    'items' => [
        view('layouts.menuPartials.simpleMenu', ['permission' => 'administration.users.view', 'request' => 'administration/users*', 'url' => '/administration/users', 'icon' => 'icon icon-user', 'name' => 'Usuarios']),
        view('layouts.menuPartials.simpleMenu', ['permission' => 'administration.profiles.view', 'request' => 'administration/profiles*', 'url' => '/administration/profiles', 'icon' => 'icon icon-controls', 'name' => 'Perfiles']),
    ]
])
