<?php
return [
    /**
     * Container
     */
    'container' => [
        'call' => 'block\container',
        'cfg' => [
            'tag' => null,
        ],
    ],
    'html' => [
        'call' => 'block\html',
    ],
    /**
     * Content
     */
    'msg' => [
        'call' => 'block\msg',
    ],
    'title' => [
        'call' => 'block\title',
        'cfg' => [
            'text' => null,
        ],
    ],
    /**
     * Template
     */
    'tpl' => [
        'call' => 'block\tpl',
    ],
    'meta' => [
        'call' => 'block\meta',
        'tpl' => 'meta.phtml',
    ],
    /**
     * View
     */
    'view' => [
        'call' => 'block\view',
        'cfg' => [
            'attr_id' => [],
            'data' => [],
            'entity_id' => null,
            'id' => null,
        ],
    ],
    /**
     * Index
     */
    'index' => [
        'call' => 'block\index',
        'tpl' => 'index.phtml',
        'cfg' => [
            'attr_id' => [],
            'crit' => [],
            'entity_id' => null,
            'filter' => [],
            'limit' => [10, 20, 50, 0],
            'link' => null,
            'order' => ['id' => 'desc'],
            'pager' => null,
            'parent_id' => null,
            'search' => [],
            'sort' => false,
            'title' => null,
        ],
    ],
    'filter' => [
        'call' => 'block\filter',
        'tpl' => 'filter.phtml',
        'cfg' => [
            'attr' => [],
            'data' => [],
            'q' => null,
            'search' => false,
        ],
    ],
    'pager' => [
        'call' => 'block\pager',
        'tpl' => 'pager.phtml',
        'cfg' => [
            'cur' => null,
            'limit' => null,
            'limits' => [],
            'pages' => 10,
            'size' => null,
        ],
    ],
    /**
     * DB
     */
    'db' => [
        'call' => 'block\db',
        'cfg' => [
            'entity_id' => null,
            'id' => null,
        ],
    ],
    'dblock' => [
        'call' => 'block\dblock',
        'cfg' => [
            'attr_id' => ['title', 'file', 'content'],
            'data' => [],
        ],
    ],
    /**
     * Form
     */
    'edit' => [
        'call' => 'block\edit',
        'tpl' => 'form.phtml',
        'cfg' => [
            'attr_id' => [],
        ],
    ],
    'profile' => [
        'call' => 'block\profile',
        'tpl' => 'form.phtml',
        'cfg' => [
            'attr_id' => [],
        ],
    ],
    'login' => [
        'call' => 'block\login',
        'tpl' => 'form.phtml',
    ],
    /**
     * Navigation
     */
    'nav' => [
        'call' => 'block\nav',
        'cfg' => [
            'data' => [],
            'tag' => 'nav',
            'title' => null,
            'toggle' => false,
        ],
    ],
    'menu' => [
        'call' => 'block\menu',
        'cfg' => [
            'root' => false,
            'submenu' => false,
            'tag' => 'nav',
            'toggle' => false,
            'url' => null,
        ],
    ],
    'toolbar' => [
        'call' => 'block\toolbar',
    ],
    'breadcrumb' => [
        'call' => 'block\breadcrumb',
    ],
];
