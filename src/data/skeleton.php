<?php
return [
    'attribute' => [
        'id' => null,
        'name' => null,
        'column' => null,
        'auto' => false,
        'sort_order' => null,
        'type' => null,
        'backend' => null,
        'frontend' => null,
        'description' => null,
        'is_nullable' => false,
        'is_required' => false,
        'is_unique' => false,
        'is_multiple' => false,
        'is_searchable' => false,
        'options_entity' => null,
        'options_callback' => null,
        'options_callback_param' => [],
        'options' => [],
        'actions' => [],
        'action' => null,
        'unique_callback' => null,
        'unique_base' => null,
        'loader' => null,
        'save' => null,
        'delete' => null,
        'validate' => null,
        'edit' => null,
        'view' => null,
        'flag' => [],
        'min' => null,
        'max' => null,
        'step' => null,
        'class' => [],
    ],
    'entity' => [
        'id' => null,
        'name' => null,
        'table' => null,
        'model' => 'flat',
        'controller' => 'entity',
        'actions' => [],
        'description' => null,
        'toolbar' => null,
        'sort_order' => null,
        'attributes' => [],
    ],
    'entity.nestedset' => [
        'attributes' => [
            'lft' => [
                'name' => 'Position Left',
                'column' => 'lft',
                'auto' => true,
                'sort_order' => 9900,
                'type' => 'int',
                'description' => '',
            ],
            'rgt' => [
                'name' => 'Position Right',
                'column' => 'rgt',
                'auto' => true,
                'sort_order' => 9910,
                'type' => 'int',
                'description' => '',
            ],
            'mode' => [
                'name' => 'Mode',
                'sort_order' => 9920,
                'type' => 'varchar.select',
                'description' => '',
                'options' => ['after' => 'After', 'before' => 'Before', 'child' => 'Child'],
                'actions' => ['edit'],
            ],
            'menubasis' => [
                'name' => 'Basis',
                'sort_order' => 9930,
                'type' => 'varchar.select',
                'description' => '',
                'is_required' => true,
                'options_callback' => 'akilli\option_menubasis',
                'options_callback_param' => [':item'],
                'actions' => ['edit'],
                'validate' => 'akilli\validator_menubasis',
            ],
            'level' => [
                'name' => 'Level',
                'sort_order' => 9940,
                'type' => 'int',
                'description' => '',
                'actions' => ['index'],
            ],
            'parent_id' => [
                'name' => 'Parent',
                'sort_order' => 9950,
                'type' => ':id',
                'description' => '',
                'is_nullable' => true,
                'options_entity' => ':entity_id',
                'actions' => ['index'],
                'view' => 'akilli\viewer_option',
            ],
        ],
    ],
    'request' => [
        'id' => 'http.index',
        'action' => 'index',
        'entity' => 'http',
        'base' => '',
        'url' => '',
        'original_path' => '',
        'path' => '',
        'host' => '',
        'scheme' => 'http',
        'is_secure' => false,
        'files' => [],
        'get' => [],
        'post' => [],
        '_old' => [],
    ],
    'section' => [
        'id' => null,
        'type' => null,
        'template' => null,
        'vars' => [],
        'is_active' => true,
        'privilege' => null,
        'parent' => 'root',
        'sort_order' => 0,
        'children' => [],
    ],
];
