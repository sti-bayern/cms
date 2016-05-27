<?php
return [
    'attr' => [
        'name' => 'Attribute',
        'actions' => ['create', 'edit', 'delete', 'index'],
        'attr' => [
            'id' => [
                'name' => 'Id',
                'type' => 'text',
                'required' => true,
                'uniq' => true,
                'actions' => ['edit', 'index'],
            ],
            'name' => [
                'name' => 'Name',
                'type' => 'text',
                'required' => true,
                'actions' => ['all'],
            ],
            'entity_id' => [
                'name' => 'Entity',
                'type' => 'select.varchar',
                'required' => true,
                'opt' => ['qnd\all', ['entity', ['model' => 'eav']]],
                'actions' => ['edit', 'index'],
            ],
            'sort' => [
                'name' => 'Sort',
                'type' => 'int',
                'actions' => ['edit', 'index'],
            ],
            'type' => [
                'name' => 'Type',
                'type' => 'select.varchar',
                'required' => true,
                'opt' => ['qnd\data', ['attr']],
                'actions' => ['edit', 'index'],
            ],
            'required' => [
                'name' => 'Required',
                'type' => 'checkbox.bool',
                'actions' => ['edit'],
            ],
            'uniq' => [
                'name' => 'Unique',
                'type' => 'checkbox.bool',
                'actions' => ['edit'],
            ],
            'searchable' => [
                'name' => 'Searchable',
                'type' => 'checkbox.bool',
                'actions' => ['edit'],
            ],
            'opt' => [
                'name' => 'Options',
                'type' => 'json',
                'nullable' => true,
                'actions' => ['edit'],
            ],
            'actions' => [
                'name' => 'Actions',
                'type' => 'multiselect',
                'nullable' => true,
                'opt' => ['qnd\config', ['action.attr']],
                'actions' => ['edit', 'index'],
            ],
        ],
    ],
    'content' => [
        'name' => 'Content',
        'attr' => [
            'id' => [
                'name' => 'Id',
                'generator' => 'auto',
                'sort' => -1200,
                'type' => 'int',
                'actions' => ['index'],
            ],
            'name' => [
                'name' => 'Name',
                'type' => 'text',
                'sort' => -1100,
                'required' => true,
                'searchable' => true,
                'actions' => ['all'],
            ],
            'entity_id' => [
                'name' => 'Entity',
                'sort' => -1000,
                'type' => 'select.varchar',
                'opt' => ['qnd\all', ['entity']],
            ],
            'active' => [
                'name' => 'Active',
                'sort' => -900,
                'type' => 'checkbox.bool',
                'actions' => ['edit', 'index'],
            ],
            'system' => [
                'name' => 'System',
                'sort' => -800,
                'type' => 'checkbox.bool',
                'actions' => ['index'],
            ],
            'content' => [
                'name' => 'Content',
                'sort' => -700,
                'type' => 'rte',
                'nullable' => true,
                'actions' => ['edit', 'view'],
            ],
            'meta' => [
                'name' => 'Meta Tags',
                'sort' => -600,
                'type' => 'json',
                'nullable' => true,
                'actions' => ['edit'],
            ],
            'search' => [
                'name' => 'Search Index',
                'sort' => -500,
                'type' => 'index',
                'nullable' => true,
            ],
            'created' => [
                'name' => 'Created',
                'generator' => 'auto',
                'sort' => -400,
                'type' => 'datetime',
            ],
            'creator' => [
                'name' => 'Creator',
                'sort' => -300,
                'type' => 'select.int',
                'nullable' => true,
                'opt' => ['qnd\all', ['user']],
            ],
            'modified' => [
                'name' => 'Modified',
                'generator' => 'auto',
                'sort' => -200,
                'type' => 'datetime',
            ],
            'modifier' => [
                'name' => 'Modifier',
                'sort' => -100,
                'type' => 'select.int',
                'nullable' => true,
                'opt' => ['qnd\all', ['user']],
            ],
            'project_id' => [
                'name' => 'Project',
                'type' => 'select.int',
                'opt' => ['qnd\all', ['project']],
            ],
        ],
    ],
    'eav' => [
        'name' => 'EAV',
        'attr' => [
            'content_id' => [
                'name' => 'Content',
                'type' => 'select.int',
                'required' => true,
                'opt' => ['qnd\all', ['content']],
                'actions' => ['edit', 'index'],
            ],
            'attr_id' => [
                'name' => 'Attribute',
                'type' => 'select.varchar',
                'required' => true,
                'opt' => ['qnd\all', ['attr']],
                'actions' => ['edit', 'index'],
            ],
            'value' => [
                'name' => 'Value',
                'type' => 'textarea',
                'actions' => ['edit'],
            ],
        ],
    ],
    'entity' => [
        'name' => 'Entity',
        'actions' => ['create', 'edit', 'delete', 'index'],
        'attr' => [
            'id' => [
                'name' => 'Id',
                'type' => 'text',
                'required' => true,
                'uniq' => true,
                'actions' => ['edit', 'index'],
            ],
            'name' => [
                'name' => 'Name',
                'type' => 'text',
                'required' => true,
                'actions' => ['all'],
            ],
            'model' => [
                'name' => 'Model',
                'type' => 'select.varchar',
                'required' => true,
                'opt' => ['qnd\config', ['entity.model']],
                'actions' => ['all'],
            ],
            'actions' => [
                'name' => 'Actions',
                'type' => 'multiselect',
                'nullable' => true,
                'opt' => ['qnd\config', ['action.entity']],
                'actions' => ['edit', 'index'],
            ],
            'system' => [
                'name' => 'System',
                'type' => 'checkbox.bool',
                'actions' => ['index'],
            ],
        ],
    ],
    'node' => [
        'name' => 'Menu Node',
        'model' => 'node',
        'actions' => ['create', 'edit', 'delete', 'index'],
        'attr' => [
            'id' => [
                'name' => 'Id',
                'generator' => 'auto',
                'type' => 'int',
                'actions' => ['index'],
            ],
            'name' => [
                'name' => 'Name',
                'type' => 'text',
                'required' => true,
                'actions' => ['all'],
            ],
            'target' => [
                'name' => 'Target',
                'type' => 'text',
                'actions' => ['edit', 'index'],
            ],
            'root_id' => [
                'name' => 'Menu',
                'generator' => 'auto',
                'type' => 'select.int',
                'opt' => ['qnd\all', ['menu']],
                'actions' => ['index'],
            ],
            'lft' => [
                'name' => 'Position Left',
                'generator' => 'auto',
                'type' => 'int',
            ],
            'rgt' => [
                'name' => 'Position Right',
                'generator' => 'auto',
                'type' => 'int',
            ],
            'parent_id' => [
                'name' => 'Parent',
                'generator' => 'auto',
                'type' => 'select.int',
                'nullable' => true,
                'opt' => ['qnd\all', ['node']],
                'actions' => ['index'],
            ],
            'level' => [
                'name' => 'Level',
                'generator' => 'auto',
                'type' => 'int',
                'actions' => ['index'],
            ],
            'mode' => [
                'name' => 'Mode',
                'virtual' => true,
                'type' => 'select.varchar',
                'opt' => [['after' => 'After', 'before' => 'Before', 'child' => 'Child']],
                'actions' => ['edit'],
            ],
            'position' => [
                'name' => 'Position',
                'generator' => 'auto',
                'type' => 'select.varchar',
                'required' => true,
                'opt' => ['qnd\opt_position'],
                'actions' => ['edit'],
            ],
            'project_id' => [
                'name' => 'Project',
                'type' => 'select.int',
                'opt' => ['qnd\all', ['project']],
            ],
        ],
    ],
    'project' => [
        'name' => 'Project',
        'actions' => ['create', 'edit', 'delete',  'index'],
        'attr' => [
            'id' => [
                'name' => 'Id',
                'generator' => 'auto',
                'type' => 'int',
                'actions' => ['index'],
            ],
            'name' => [
                'name' => 'Name',
                'type' => 'text',
                'required' => true,
                'actions' => ['all'],
            ],
            'host' => [
                'name' => 'Host',
                'type' => 'text',
                'nullable' => true,
                'uniq' => true,
                'actions' => ['edit', 'index'],
            ],
            'active' => [
                'name' => 'Active',
                'type' => 'checkbox.bool',
                'actions' => ['edit', 'index'],
            ],
            'system' => [
                'name' => 'System',
                'type' => 'checkbox.bool',
                'actions' => ['index'],
            ],
        ],
    ],
    'rewrite' => [
        'name' => 'Rewrite',
        'actions' => ['create', 'edit', 'delete', 'index'],
        'attr' => [
            'id' => [
                'name' => 'Id',
                'generator' => 'auto',
                'type' => 'int',
                'actions' => ['index'],
            ],
            'name' => [
                'name' => 'Name',
                'type' => 'text',
                'uniq' => true,
                'actions' => ['all'],
            ],
            'target' => [
                'name' => 'Target',
                'type' => 'text',
                'required' => true,
                'actions' => ['edit', 'index'],
            ],
            'redirect' => [
                'name' => 'Redirect',
                'type' => 'checkbox.bool',
                'actions' => ['edit', 'index'],
            ],
            'system' => [
                'name' => 'System',
                'type' => 'checkbox.bool',
                'actions' => ['index'],
            ],
            'project_id' => [
                'name' => 'Project',
                'type' => 'select.int',
                'opt' => ['qnd\all', ['project']],
            ],
        ],
    ],
    'role' => [
        'name' => 'Role',
        'actions' => ['create', 'edit', 'delete', 'index'],
        'attr' => [
            'id' => [
                'name' => 'Id',
                'generator' => 'auto',
                'type' => 'int',
                'actions' => ['index'],
            ],
            'name' => [
                'name' => 'Name',
                'type' => 'text',
                'required' => true,
                'uniq' => true,
                'actions' => ['all'],
            ],
            'privilege' => [
                'name' => 'Privileges',
                'type' => 'multiselect',
                'opt' => ['qnd\privileges'],
                'actions' => ['edit'],
            ],
            'active' => [
                'name' => 'Active',
                'type' => 'checkbox.bool',
                'actions' => ['edit', 'index'],
            ],
            'system' => [
                'name' => 'System',
                'type' => 'checkbox.bool',
                'actions' => ['index'],
            ],
            'project_id' => [
                'name' => 'Project',
                'type' => 'select.int',
                'opt' => ['qnd\all', ['project']],
            ],
        ],
    ],
    'user' => [
        'name' => 'User',
        'actions' => ['create', 'edit', 'delete',  'index'],
        'attr' => [
            'id' => [
                'name' => 'Id',
                'generator' => 'auto',
                'type' => 'int',
                'actions' => ['index'],
            ],
            'name' => [
                'name' => 'Name',
                'type' => 'text',
                'required' => true,
                'actions' => ['all'],
            ],
            'username' => [
                'name' => 'Username',
                'type' => 'text',
                'required' => true,
                'uniq' => true,
                'actions' => ['all'],
            ],
            'password' => [
                'name' => 'Password',
                'type' => 'password',
                'required' => true,
                'actions' => ['edit'],
            ],
            'role_id' => [
                'name' => 'Role',
                'type' => 'select.int',
                'required' => true,
                'opt' => ['qnd\all', ['role']],
                'actions' => ['edit', 'index'],
            ],
            'active' => [
                'name' => 'Active',
                'type' => 'checkbox.bool',
                'actions' => ['edit', 'index'],
            ],
            'system' => [
                'name' => 'System',
                'type' => 'checkbox.bool',
                'actions' => ['index'],
            ],
            'project_id' => [
                'name' => 'Project',
                'type' => 'select.int',
                'opt' => ['qnd\all', ['project']],
            ],
        ],
    ],
];
