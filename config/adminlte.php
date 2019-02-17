<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The default title of your admin panel, this goes into the title tag
    | of your page. You can override it per page with the title section.
    | You can optionally also specify a title prefix and/or postfix.
    |
    */

    'title' => 'Artistkhabar Admin',

    'title_prefix' => 'ArtistKhabar | Admin Panel | ',

    'title_postfix' => ' | Developed by Muncha Internet Venture',

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | This logo is displayed at the upper left corner of your admin panel.
    | You can use basic HTML here if you want. The logo has also a mini
    | variant, used for the mini side bar. Make it 3 letters or so
    |
    */

    'logo' => '<b>Artist</b>Khabar',

    'logo_mini' => '<b>A</b>KB',

    /*
    |--------------------------------------------------------------------------
    | Skin Color
    |--------------------------------------------------------------------------
    |
    | Choose a skin color for your admin panel. The available skin colors:
    | blue, black, purple, yellow, red, and green. Each skin also has a
    | ligth variant: blue-light, purple-light, purple-light, etc.
    |
    */

    'skin' => 'blue',

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Choose a layout for your admin panel. The available layout options:
    | null, 'boxed', 'fixed', 'top-nav'. null is the default, top-nav
    | removes the sidebar and places your menu in the top navbar
    |
    */

    'layout' => null,

    /*
    |--------------------------------------------------------------------------
    | Collapse Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we choose and option to be able to start with a collapsed side
    | bar. To adjust your sidebar layout simply set this  either true
    | this is compatible with layouts except top-nav layout option
    |
    */

    'collapse_sidebar' => false,

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Register here your dashboard, logout, login and register URLs. The
    | logout URL automatically sends a POST request in Laravel 5.3 or higher.
    | You can set the request to a GET or POST with logout_method.
    | Set register_url to null if you don't want a register link.
    |
    */

    'dashboard_url' => 'admin/home',

    'logout_url' => 'admin/logout',

    'logout_method' => 'POST',

    'login_url' => 'admin/login',

    'register_url' => 'admin/register',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Specify your menu items to display in the left sidebar. Each menu item
    | should have a text and and a URL. You can also specify an icon from
    | Font Awesome. A string instead of an array represents a header in sidebar
    | layout. The 'can' is a filter on Laravel's built in Gate functionality.
    |
    */

    'menu' => [
        'MAIN NAVIGATION',
        [
            'text'        => 'Artist',
            'icon'        => 'user',
            'submenu'     => [
                [
                    'url' => 'admin/artist',
                    'text' => 'Manage Artist'
                ],[
                    'url' => 'admin/artist/create',
                    'text' => 'Create Artist'
                ],
            ]
        ],
        'QUIZ GAME',
        [
            'text'        => 'Quiz Game',
            'icon'        => 'gamepad',
            'submenu'     => [
                [
                    'text'     => 'Manage quiz',
                    'url'      => 'admin/quiz'
                ], [
                    'text'     => 'New quiz',
                    'url'      => 'admin/quiz/create'
                ],
            ]
        ],
        [
            'text'        => 'Quiz Question',
            'icon'        => 'gamepad',
            'submenu'     => [
                [
                    'text'     => 'Manage questions',
                    'url'      => 'admin/question'
                ], [
                    'text'     => 'New Question',
                    'url'      => 'admin/question/create'
                ],
            ]
        ],[
            'text'         => 'Prizes',
            'icon'         => 'money',
            'submenu'      => [
                [
                    'text'    => 'Manage prizes',
                    'url'     => 'admin/prizes'
                ],[
                    'text'    => 'New prizes',
                    'url'     => 'admin/prizes/create'
                ]
            ]
        ],
        'EXTRAS',
        [
            'text'     => 'Events',
            'icon'     => 'music',
            'submenu'  => [
                [
                    'text'   => 'Manage event',
                    'url'    => 'admin/events'
                ], [
                    'text'   => 'New event',
                    'url'    => 'admin/events/create'
                ]
            ]
        ],
        [
            'text'     => 'Movies',
            'icon'     => 'file-movie-o',
            'submenu'  => [
                [
                    'text'   => 'Manage movie',
                    'url'    => 'admin/movies'
                ], [
                    'text'   => 'New release',
                    'url'    => 'admin/movies/create'
                ]
            ]
        ],
        'USERS',
        [
            'text'     => 'Users',
            'icon'     => 'users',
            'submenu'  => [
                [
                    'text'   => 'Manage users',
                    'url'    => 'admin/users'
                ]
            ]
        ],
        'PHOTOS',
        [
            'text' => 'Gallery',
            'icon' => 'photo',
            'submenu' => [
                [
                    'text' => 'Manage Gallery',
                    'url' => 'admin/gallery'
                ],[
                    'text' => 'Create Gallery',
                    'url' => 'admin/gallery/create'
                ],
            ]
        ],
        'SETTINGS',
        [
            'text'     => 'Application Settings',
            'icon'     => 'gear',
            'submenu'  => [
                [
                    'text' => 'Manage Settings',
                    'url'  => 'admin/settings'
                ],[
                    'text' => 'New Settings',
                    'url'  => 'admin/settings/create'
                ],
            ]
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Choose what filters you want to include for rendering the menu.
    | You can add your own filters to this array after you've created them.
    | You can comment out the GateFilter if you don't want to use Laravel's
    | built in Gate functionality
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Choose which JavaScript plugins should be included. At this moment,
    | only DataTables is supported as a plugin. Set the value to true
    | to include the JavaScript file from a CDN via a script tag.
    |
    */

    'plugins' => [
        'datatables' => true,
        'select2'    => true,
        'chartjs'    => true,
    ],
];
