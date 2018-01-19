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
                'type' => 'serial',
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
                'type' => 'serial',
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
                'opt' => 'role',
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
                'type' => 'serial',
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
        'version' => true,
        'act' => [
            'admin' => ['name', 'pos', 'status', 'date'],
            'delete' => [],
            'edit' => ['name', 'image', 'teaser', 'content', 'slug', 'parent', 'sort', 'status'],
            'index' => ['name', 'teaser'],
            'view' => ['image', 'teaser', 'content'],
        ],
        'attr' => [
            'id' => [
                'name' => 'ID',
                'type' => 'serial',
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
                'opt' => 'file',
                'viewer' => 'fileopt',
            ],
            'teaser' => [
                'name' => 'Teaser',
                'type' => 'rte',
                'searchable' => true,
                'val' => '',
            ],
            'content' => [
                'name' => 'Content',
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
                'type' => 'text',
                'required' => true,
                'unique' => true,
                'filter' => 'path',
            ],
            'parent' => [
                'name' => 'Parent',
                'type' => 'ent',
                'nullable' => true,
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
                'type' => 'serial',
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
    'version' => [
        'name' => 'Versions',
        'type' => 'db',
        'attr' => [
            'id' => [
                'name' => 'ID',
                'type' => 'serial',
            ],
            'name' => [
                'name' => 'Name',
                'type' => 'text',
                'required' => true,
                'searchable' => true,
                'maxlength' => 100,
            ],
            'ent' => [
                'name' => 'Entity',
                'type' => 'select',
                'required' => true,
                'searchable' => true,
                'opt' => 'ent_cfg',
                'maxlength' => 50,
            ],
            'ent_id' => [
                'name' => 'Entity-ID',
                'type' => 'int',
                'required' => true,
            ],
            'status' => [
                'name' => 'Status',
                'type' => 'status',
                'required' => true,
            ],
            'date' => [
                'name' => 'Date',
                'type' => 'datetime',
            ],
            'data' => [
                'name' => 'Data',
                'type' => 'json',
            ],
        ],
    ],
];
