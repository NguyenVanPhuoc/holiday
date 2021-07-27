<?php

return [
    /*
    * post type manage banner by country
    */
    'post_banner' => [
        [ 'type' => 'tour', 'name' => 'Tour'],
        [ 'type' => 'article', 'name' => 'Article'], //blog
        [ 'type' => 'highlight', 'name' => 'Places to visit'],
        [ 'type' => 'travel_tip', 'name' => 'Tip & Guide'],
        [ 'type' => 'thing_to_do', 'name' => 'Things To Do'],
        [ 'type' => 'hotel', 'name' => 'Accommodation'],
        [ 'type' => 'cultural', 'name' => 'Cultural insight'],
        [ 'type' => 'market', 'name' => 'Market Guide'],
    ],
    'post_same_level_country_travel' => [
        'travel_tip', 'cultural', 
        'region', 
        'highlight', 
        'hotel',  
        'destination', 
        'article', 
        'thing_to_do', 
        'country_tour_style', 
        'country_tour_duration',
        'country_category_blog',
        'market',
    ],
    'post_level_1' => [
        'page', 
        'consultant',
        'blogger',
    ],
    
];