<?php
return [
    'role' => [
        'name' => 'Roles',
        'type' => 'db',
        'act' => [
            'admin' => ['name'],
            'delete' => [],
            'edit' => [],
        ],
        'attr' => [
            'id' => [
                'name' => 'ID',
                'auto' => true,
                'type' => 'int',
            ],
            'name' => [
                'name' => 'Name',
                'type' => 'text',
                'required' => true,
                'unique' => true,
                'searchable' => true,
                'maxlength' => 50,
            ],
            'priv' => [
                'name' => 'Privileges',
                'type' => 'checkbox',
                'opt' => 'priv',
            ],
        ],
    ],
    'account' => [
        'name' => 'Accounts',
        'type' => 'db',
        'act' => [
            'admin' => ['name', 'role'],
            'delete' => [],
            'edit' => [],
            'login' => [],
            'logout' => [],
            'password' => [],
        ],
        'attr' => [
            'id' => [
                'name' => 'ID',
                'auto' => true,
                'type' => 'int',
            ],
            'name' => [
                'name' => 'Name',
                'type' => 'text',
                'required' => true,
                'unique' => true,
                'searchable' => true,
                'maxlength' => 50,
            ],
            'password' => [
                'name' => 'Password',
                'type' => 'password',
                'required' => true,
                'minlength' => 8,
            ],
            'role' => [
                'name' => 'Role',
                'type' => 'ent',
                'required' => true,
                'ent' => 'role',
            ],
        ],
    ],
    'url' => [
        'name' => 'URL',
        'type' => 'db',
        'act' => [
            'admin' => ['name', 'target', 'redirect'],
            'delete' => [],
            'edit' => ['name', 'target', 'redirect'],
        ],
        'attr' => [
            'id' => [
                'name' => 'ID',
                'auto' => true,
                'type' => 'int',
            ],
            'name' => [
                'name' => 'Name',
                'type' => 'text',
                'required' => true,
                'unique' => true,
                'searchable' => true,
                'filter' => 'path',
            ],
            'target' => [
                'name' => 'Target',
                'type' => 'text',
                'required' => true,
                'searchable' => true,
                'filter' => 'path',
            ],
            'redirect' => [
                'name' => 'Redirect',
                'type' => 'int',
                'frontend' => 'select',
                'nullable' => true,
                'opt' => [301 => 301, 302 => 302, 303 => 303, 304 => 304, 305 => 305, 307 => 307, 308 => 308],
            ],
        ],
    ],
    'file' => [
        'name' => 'Files',
        'type' => 'db',
        'act' => [
            'admin' => ['name', 'size'],
            'asset' => [],
            'browser' => ['name', 'size'],
            'delete' => [],
            'edit' => ['name', 'info'],
        ],
        'attr' => [
            'id' => [
                'name' => 'ID',
                'auto' => true,
                'type' => 'int',
            ],
            'name' => [
                'name' => 'Name',
                'type' => 'file',
                'required' => true,
                'unique' => true,
                'searchable' => true,
                'opt' => [
                    'aac', 'flac', 'mp3', 'oga', 'ogg', 'wav', 'weba',
                    'gif', 'jpg', 'png', 'svg', 'webp',
                    'mp4', 'ogv', 'webm',
                    'bz2', 'csv', 'doc', 'docx', 'gz', 'odg', 'odp', 'ods', 'odt', 'pdf', 'xls', 'xlsm', 'xlsx', 'zip',
                ],
            ],
            'info' => [
                'name' => 'Info',
                'type' => 'textarea',
                'searchable' => true,
                'val' => '',
            ],
            'size' => [
                'name' => 'Size',
                'type' => 'int',
                'viewer' => 'filesize',
            ],
        ],
    ],
    'page' => [
        'name' => 'Pages',
        'type' => 'db',
        'act' => [
            'index' => ['name', 'teaser'],
        ],
        'attr' => [
            'id' => [
                'name' => 'ID',
                'auto' => true,
                'type' => 'int',
            ],
            'name' => [
                'name' => 'Name',
                'type' => 'text',
                'required' => true,
                'searchable' => true,
                'maxlength' => 100,
            ],
            'image' => [
                'name' => 'Image',
                'type' => 'ent',
                'nullable' => true,
                'ent' => 'file',
                'viewer' => 'fileopt',
            ],
            'teaser' => [
                'name' => 'Teaser',
                'type' => 'rte',
                'searchable' => true,
                'val' => '',
            ],
            'body' => [
                'name' => 'Body',
                'type' => 'rte',
                'searchable' => true,
                'val' => '',
            ],
            'slug' => [
                'name' => 'Slug',
                'type' => 'text',
                'required' => true,
                'maxlength' => 50,
                'filter' => 'id',
            ],
            'url' => [
                'name' => 'URL',
                'auto' => true,
                'type' => 'text',
            ],
            'menu' => [
                'name' => 'Menu Entry',
                'type' => 'bool',
            ],
            'parent' => [
                'name' => 'Parent',
                'type' => 'ent',
                'nullable' => true,
                'ent' => 'page',
                'opt' => 'page',
            ],
            'sort' => [
                'name' => 'Sort',
                'type' => 'int',
                'val' => 0,
            ],
            'pos' => [
                'name' => 'Position',
                'auto' => true,
                'type' => 'text',
                'viewer' => 'pos',
            ],
            'level' => [
                'name' => 'Level',
                'auto' => true,
                'type' => 'int',
            ],
            'path' => [
                'name' => 'Path',
                'auto' => true,
                'type' => 'json',
            ],
            'status' => [
                'name' => 'Status',
                'type' => 'status',
                'required' => true,
            ],
            'date' => [
                'name' => 'Date',
                'auto' => true,
                'type' => 'datetime',
            ],
            'ent' => [
                'name' => 'Page Type',
                'type' => 'select',
                'required' => true,
                'opt' => 'pagetype',
                'maxlength' => 50,
            ],
        ],
    ],
    'content' => [
        'name' => 'Content Pages',
        'type' => 'db',
        'parent' => 'page',
        'act' => [
            'admin' => ['name', 'pos', 'menu', 'status', 'date'],
            'delete' => [],
            'edit' => ['name', 'image', 'teaser', 'body', 'slug', 'menu', 'parent', 'sort', 'status'],
            'index' => ['name', 'teaser'],
            'view' => ['image', 'teaser', 'body'],
        ],
    ],
    'article' => [
        'name' => 'Articles',
        'type' => 'db',
        'parent' => 'page',
        'act' => [
            'admin' => ['name', 'parent', 'status', 'date'],
            'delete' => [],
            'edit' => ['name', 'image', 'teaser', 'body', 'slug', 'parent', 'sort', 'status'],
            'view' => ['image', 'teaser', 'body'],
        ],
    ],
    'version' => [
        'name' => 'Versions',
        'type' => 'db',
        'attr' => [
            'id' => [
                'name' => 'ID',
                'auto' => true,
                'type' => 'int',
            ],
            'name' => [
                'name' => 'Name',
                'type' => 'text',
                'required' => true,
                'searchable' => true,
            ],
            'teaser' => [
                'name' => 'Teaser',
                'type' => 'rte',
                'required' => true,
                'searchable' => true,
            ],
            'body' => [
                'name' => 'Body',
                'type' => 'rte',
                'required' => true,
                'searchable' => true,
            ],
            'status' => [
                'name' => 'Status',
                'type' => 'status',
                'required' => true,
            ],
            'date' => [
                'name' => 'Date',
                'type' => 'datetime',
                'required' => true,
            ],
            'page' => [
                'name' => 'Page',
                'type' => 'ent',
                'required' => true,
                'ent' => 'page',
            ],
        ],
    ],
];
