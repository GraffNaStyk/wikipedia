<?php

return [
    /**
     *  @csrf is used to blocking csrf attack from users,
     *  if this variable is set to true, you need to add for very form
     *  twig variable like {{ csrf() }}, csrf is not checked if your
     *  request is pushed by js Api fetch method !
     */
    'csrf' => false,

    /*
     *  @dev here tou can set developer mode to true or false, if developer mode
     *  is set to true on page have all bugs, if not all logs send to
     *  storage/private/logs like php or sql log.
     */
    'dev' => true,

    /*
     *  @url this is a framework url, default u can set '/' if framework exist
     *  in any sub folder need to add this path there to good working
    */
    'url' => '/wiki/',
    
    /*
     *  @cache_view disable or enable view caching
     */
    'cache_view' => false,
    
    /*
     *  @mail configuration using in framework to send mails.
     *  If array values are empty mail are not configured.
     */
    'mail' => [
        'smtp' => '',
        'user' => '',
        'password' => '',
        'port' => '',
        'from' => '',
        'fromName' => ''
    ],
    
    /*
     *  @model-provider its a defined namespace to all used models for
     *  dynamic function used model with full path
     */
    'model-provider' => 'App\\Model\\',
    
    /*
     *  @http-provider its a defined namespace to default controllers
     *  called by user
     */
    'http-provider' => 'App\\Controllers\\Http\\',
    
    /*
     *  Always loaded libraries css / js from main css / js directory
     *
     */
    'is_loaded' => [
        'css' => [
            'bootstrap', 'slim-select', 'alerts', 'box', 'buttons', 'form', 'modal', 'table', 'loader', 'glightbox.min'
        ],
        
        'js' => [
            'bootstrap', 'slim-select', 'glightbox.min'
        ]
    ],
    
    'items_path' => storage_path('private/items.xml'),
    
    'movements_path' => storage_path('private/movements.xml'),
    
    'spells_path' => storage_path('private/spells.xml'),
    
    'monsters_path' => storage_path('private/monsters.xml'),
    
    'npcs_path' => storage_path('private/npcs'),
    
    'quests_path' => storage_path('private/quest_system.json'),
    
    'achievements_path' => storage_path('private/achievement_system.json'),
    
    'force_update_images' => false
];
