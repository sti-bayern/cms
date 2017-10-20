<?php
return [
    '_all_' => [
        'root' => [
            'section' => 'tpl',
            'tpl' => 'layout/root.phtml',
            'parent_id' => null,
        ],
        'head' => [
            'section' => 'tpl',
            'tpl' => 'layout/head.phtml',
            'priv' => 'account-user',
        ],
        'top' => [
            'section' => 'container',
        ],
        'toolbar' => [
            'section' => 'tpl',
            'tpl' => 'layout/toolbar.phtml',
            'priv' => 'account-user',
            'parent_id' => 'top',
            'sort' => -2,
        ],
        'header' => [
            'section' => 'tpl',
            'tpl' => 'layout/header.phtml',
            'parent_id' => 'top',
            'sort' => -1,
        ],
        'msg' => [
            'section' => 'msg',
            'tpl' => 'layout/msg.phtml',
        ],
        'left' => [
            'section' => 'container',
            'vars' => ['tag' => 'aside'],
        ],
        'main' => [
            'section' => 'container',
        ],
        'right' => [
            'section' => 'container',
            'vars' => ['tag' => 'aside'],
        ],
        'bottom' => [
            'section' => 'container',
        ],
    ],
    'act-admin' => [
        'content' => [
            'section' => 'tpl',
            'tpl' => 'ent/admin.phtml',
            'parent_id' => 'main',
        ],
        'pager' => [
            'section' => 'pager',
            'tpl' => 'ent/pager.phtml',
            'parent_id' => 'content',
        ],
        'search' => [
            'section' => 'tpl',
            'tpl' => 'ent/search.phtml',
            'parent_id' => 'right',
        ],
        'create' => [
            'section' => 'tpl',
            'tpl' => 'ent/create.phtml',
            'priv' => '*/edit',
            'parent_id' => 'right',
        ],
        'import' => [
            'section' => 'tpl',
            'tpl' => 'ent/import.phtml',
            'priv' => '*/import',
            'parent_id' => 'right',
        ],
    ],
    'act-index' => [
        'content' => [
            'section' => 'tpl',
            'tpl' => 'ent/index.phtml',
            'parent_id' => 'main',
        ],
        'pager' => [
            'section' => 'pager',
            'tpl' => 'ent/pager.phtml',
            'parent_id' => 'content',
        ],
        'search' => [
            'section' => 'tpl',
            'tpl' => 'ent/search.phtml',
            'parent_id' => 'right',
        ],
    ],
    'act-edit' => [
        'content' => [
            'section' => 'tpl',
            'tpl' => 'ent/edit.phtml',
            'parent_id' => 'main',
        ],
    ],
    'act-view' => [
        'content' => [
            'section' => 'tpl',
            'tpl' => 'ent/view.phtml',
            'parent_id' => 'main',
        ],
    ],
    'app/denied' => [
        'content' => [
            'section' => 'tpl',
            'tpl' => 'app/error.phtml',
            'parent_id' => 'main',
        ],
    ],
    'app/error' => [
        'content' => [
            'section' => 'tpl',
            'tpl' => 'app/error.phtml',
            'parent_id' => 'main',
        ],
    ],
    'app/js' => [
        'root' => [
            'tpl' => 'app/app.js',
        ],
    ],
    'account/password' => [
         'content' => [
            'section' => 'tpl',
            'tpl' => 'account/password.phtml',
            'parent_id' => 'main',
        ],
    ],
    'account/login' => [
        'header' => [
            'active' => false,
        ],
        'content' => [
            'section' => 'tpl',
            'tpl' => 'account/login.phtml',
            'parent_id' => 'main',
        ],
    ],
    'page/index' => [
        'nav' => [
            'section' => 'nav',
            'parent_id' => 'top',
            'vars' => ['mode' => 'top'],
        ],
        'subnav' => [
            'section' => 'nav',
            'parent_id' => 'right',
            'vars' => ['mode' => 'sub'],
        ],
    ],
    'page/view' => [
        'nav' => [
            'section' => 'nav',
            'parent_id' => 'top',
            'vars' => ['mode' => 'top'],
        ],
        'subnav' => [
            'section' => 'nav',
            'parent_id' => 'right',
            'vars' => ['mode' => 'sub'],
        ],
    ],
];
