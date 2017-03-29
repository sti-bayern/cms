<?php
return [
    'project' => [
        'name' => 'Projects',
        'actions' => ['admin', 'delete', 'edit', 'export', 'import', 'switch'],
        'attr' => [
            'id' => [
                'name' => 'ID',
                'auto' => true,
                'type' => 'int',
            ],
            'uid' => [
                'name' => 'UID',
                'type' => 'text',
                'required' => true,
                'uniq' => true,
                'actions' => ['admin', 'edit'],
                'maxval' => 20,
                'validator' => 'id',
            ],
            'name' => [
                'name' => 'Name',
                'type' => 'text',
                'required' => true,
                'actions' => ['admin', 'edit'],
                'maxval' => 50,
            ],
            'active' => [
                'name' => 'Active',
                'type' => 'checkbox',
                'actions' => ['admin', 'edit'],
                'val' => false,
            ],
            'system' => [
                'name' => 'System',
                'type' => 'checkbox',
                'val' => false,
            ],
        ],
    ],
    'role' => [
        'name' => 'Roles',
        'actions' => ['admin', 'delete', 'edit'],
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
                'uniq' => true,
                'actions' => ['admin', 'edit'],
                'maxval' => 50,
            ],
            'privilege' => [
                'name' => 'Privileges',
                'type' => 'multicheckbox',
                'opt' => ['opt_privilege'],
                'actions' => ['edit'],
            ],
            'active' => [
                'name' => 'Active',
                'type' => 'checkbox',
                'actions' => ['admin', 'edit'],
                'val' => false,
            ],
            'system' => [
                'name' => 'System',
                'type' => 'checkbox',
                'val' => false,
            ],
            'project_id' => [
                'name' => 'Project',
                'type' => 'entity',
                'opt' => ['project'],
            ],
        ],
    ],
    'account' => [
        'name' => 'Accounts',
        'actions' => ['admin', 'dashboard', 'delete', 'edit', 'login', 'logout', 'password'],
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
                'uniq' => true,
                'actions' => ['admin', 'edit'],
                'maxval' => 50,
            ],
            'password' => [
                'name' => 'Password',
                'type' => 'password',
                'required' => true,
                'actions' => ['edit'],
            ],
            'role_id' => [
                'name' => 'Role',
                'type' => 'entity',
                'required' => true,
                'opt' => ['role'],
                'actions' => ['admin', 'edit'],
            ],
            'active' => [
                'name' => 'Active',
                'type' => 'checkbox',
                'actions' => ['admin', 'edit'],
                'val' => false,
            ],
            'system' => [
                'name' => 'System',
                'type' => 'checkbox',
                'val' => false,
            ],
            'project_id' => [
                'name' => 'Project',
                'type' => 'entity',
                'opt' => ['project'],
            ],
        ],
    ],
    'page' => [
        'name' => 'Pages',
        'actions' => ['admin', 'delete', 'edit', 'import', 'index', 'view'],
        'attr' => [
            'id' => [
                'name' => 'ID',
                'auto' => true,
                'type' => 'int',
                'actions' => ['admin'],
            ],
            'name' => [
                'name' => 'Name',
                'type' => 'text',
                'required' => true,
                'searchable' => true,
                'actions' => ['admin', 'edit', 'form', 'index', 'view'],
                'maxval' => 100,
            ],
            'url' => [
                'name' => 'URL',
                'type' => 'text',
                'required' => true,
                'uniq' => true,
            ],
            'active' => [
                'name' => 'Active',
                'type' => 'checkbox',
                'actions' => ['admin', 'edit'],
                'val' => false,
            ],
            'parent_id' => [
                'name' => 'Parent',
                'type' => 'entity',
                'nullable' => true,
                'opt' => ['page'],
                'actions' => ['admin', 'edit'],
                'validator' => 'page',
            ],
            'sort' => [
                'name' => 'Sort',
                'type' => 'int',
                'actions' => ['admin', 'edit'],
                'val' => 0,
            ],
            'content' => [
                'name' => 'Content',
                'type' => 'rte',
                'searchable' => true,
                'actions' => ['edit', 'view'],
            ],
            'search' => [
                'name' => 'Search',
                'type' => 'search',
            ],
            'project_id' => [
                'name' => 'Project',
                'type' => 'entity',
                'opt' => ['project'],
            ],
        ],
    ],
    'template' => [
        'name' => 'Templates',
        'actions' => ['admin', 'delete', 'edit', 'import'],
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
                'actions' => ['admin', 'edit'],
                'maxval' => 100,
            ],
            'image' => [
                'name' => 'Image',
                'type' => 'image',
                'actions' => ['admin', 'edit'],
            ],
            'info' => [
                'name' => 'Info',
                'type' => 'textarea',
                'actions' => ['edit'],
            ],
            'content' => [
                'name' => 'Content',
                'type' => 'rte',
                'required' => true,
                'actions' => ['edit'],
            ],
            'project_id' => [
                'name' => 'Project',
                'type' => 'entity',
                'opt' => ['project'],
            ],
        ],
    ],
    'media' => [
        'name' => 'Media',
        'model' => 'media',
        'actions' => ['admin', 'delete', 'edit', 'import'],
        'attr' => [
            'id' => [
                'name' => 'ID',
                'auto' => true,
                'type' => 'text',
            ],
            'name' => [
                'name' => 'Name',
                'type' => 'file',
                'required' => true,
                'uniq' => true,
                'actions' => ['admin', 'edit'],
            ],
            'size' => [
                'name' => 'Size',
                'type' => 'int',
                'actions' => ['admin'],
                'viewer' => 'filesize',
            ],
        ],
    ],
];
