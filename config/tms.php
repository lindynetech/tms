<?php

return [
    'version' => env('APP_VERSION', '1.0.0'),

    'webaddress' => env('APP_DOMAIN', 'localhost'),

    'support' => '<a href="/#contacts" target="_blank">Support</a>',

    'title' => 'Goals and Time Management System',

    'description' => 'Time and Goals Management System, Manage Your Time By Setting And Commiting To The Most Important Goals',

    'keywords' => 'Time and Goals Management System, Set your goals, Manage Time, Self Improvement, Self Development, Develop Habits, Mindstorm Ideas, Track progress, Change your life',

    'copyright' =>'Copyright &copy; <a href="' . env('APP_URL', 'http://localhost') . '">' . env('APP_DOMAIN', 'localhost') . '</a> ' . date("Y") . '',

    'branding' => env('APP_BRANDING', '1')
];
