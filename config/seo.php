<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Costa Blanca Location Keywords
    |--------------------------------------------------------------------------
    | Used by the linkify_locations() helper to automatically link the first
    | occurrence of each location name in blog post HTML to the corresponding
    | programmatic landing page (/{type}-for-sale-in-{location}).
    |
    | Keys are the keyword to detect (case-insensitive),
    | values are the URL slug used in the landing page routes.
    */
    'locations' => [
        'Alicante'    => 'alicante',
        'Torrevieja'  => 'torrevieja',
        'Javea'       => 'javea',
        'Dénia'       => 'denia',
        'Denia'       => 'denia',
        'Calpe'       => 'calpe',
        'Altea'       => 'altea',
        'Benidorm'    => 'benidorm',
        'Orihuela'    => 'orihuela',
        'Costa Blanca' => 'costa-blanca',
        'Villamartin' => 'villamartin',
        'Guardamar'   => 'guardamar',
        'Punta Prima' => 'punta-prima',
    ],

    /*
    | Default property type for internal links (used when no type context is available).
    */
    'default_link_type' => 'property',
];
