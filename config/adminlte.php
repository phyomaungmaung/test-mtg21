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

    'title' => 'AICTA',

    'title_prefix' => '',

    'title_postfix' => '',

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

    'logo' => '<b>ASEAN</b>ICT AWARD',

    'logo_mini' => '<b>A</b>ICTA',

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

    'dashboard_url' => '/',

    'logout_url' => 'logout',

    'logout_method' => null,

    'login_url' => 'login',

    'register_url' => 'register',

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
        ' ',
        [
            'text' => 'User',
            'url'  => 'user',
            'can'  => 'view-user',
            'icon' => 'users',
            'icon_color'=>'aqua',
        ],
        [
            'text'        => 'Candidate',
            'url'         => 'candidate',
            'can'          =>'list-candidate',
            'icon'        => 'users',
            'icon_color'    =>'#efefef',

        ],
        [
            'text'        => 'Judge',
            'url'         => 'judge',
            'can'          =>'list-judge',
            'icon'        => 'users',
            'icon_color'    =>'red',

        ],
        [
            'text'        => 'Form',
            'url'         => "application/create",
            'icon'        => 'pencil',
            'icon_color'    =>'#efefef',
            'role'=>['Candidate' ],

        ],
//        [
//            'text'        => 'PDF Summision',
//            'url'         => "application/formcreate",
//            'icon'        => 'file-pdf-o',
//            'icon_color'    =>'#efefef',
//            'can'          =>'pdf-form',
//
//        ],
        [
            'text'        => 'List Application',
            'url'         => "application",
            'icon'        => 'pencil',
            'icon_color'    =>'#efefef',
            'can'          =>'list-form',

        ],
        [
            'text'        => 'Asean Application',
            'url'         => "aseanapp",
            'icon'        => 'list',
            'icon_color'    =>'#efefef',
            'can'          =>'list-aseanapp',

        ],
        [
            'text'        => 'Final Judging',
            'url'         => "finalapp",
            'icon'        => 'list',
            'icon_color'    =>'#efefef',
            'can'          =>'list-final-judge',

        ],
        [
            'text'        => 'Result',
            'url'         => "result",
            'icon'        => 'list-ol',
            'icon_color'    =>'#efefef',
            'can'          =>'list-result',

        ],

        [
            'text'        => 'Send Alert Mail',
            'url'         => "mail",
            'icon'        => 'envelope',
            'icon_color'    =>'#efefef',
            'can'          =>'list-from',

        ],

        [
            'text'        => 'Guideline',
            'url'         => "guideline/help",
            'icon'        => 'question',
            'icon_color'    =>'#efefef',

        ],

        [
            'text'        => 'Guideline List',
            'url'         => "guideline",
            'icon'        => 'bars',
            'icon_color'    =>'#efefef',
            'can'          =>'list-guideline'

        ],
        [
            'text'        => 'Videos',
            'url'         => "video",
            'icon'        => 'youtube-play',
            'icon_color'    =>'#efefef',
            'can'          =>'list-video'

        ],

        ' ',
        [
            'text' => 'Profile',
            'url'  => 'user/profile',
            'icon' => 'user',
        ],
        [
            'text' => 'Change Password',
            'url'  => 'user/password',
            'icon' => 'lock',
        ],

        ' ',
        [
            'text'        => 'Category',
            'url'         => 'category',
            'icon'        => 'database',
            'icon_color'    =>'#efefef',
            'can'          =>'view-category',
        ],
        [
            'text'        => 'Role',
            'url'         => 'role',
            'icon'        => 'bars',
            'icon_color'    =>'blue',
            'can'          =>'list-role',
        ],
        [
            'text'       => 'Country',
            'icon_color' => 'red',
            'icon'      =>'flag',
            'url'       =>'country',
            'can'          =>'view-country',
        ],
        [
            'text'        => 'Setting',
            'url'         => 'setting',
            'icon'        => 'cog',
            'icon_color'    =>'yellow',
            'can'          =>'view-setting',
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
//        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        App\filters\MyGate::class,
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
        'chartjs'    => false,
    ],
];
