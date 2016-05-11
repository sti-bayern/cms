<?php
return [
    'attribute' => [
        'id' => 'attribute',
        'name' => 'Attribute',
        'actions' => ['create', 'edit', 'delete', 'index'],
        'toolbar' => 'structure',
        'sort' => 400,
        'attributes' => [
            'id' => [
                'name' => 'ID',
                'generator' => 'id',
                'type' => 'text',
                'required' => true,
                'unambiguous' => true,
                'actions' => ['index'],
            ],
            'name' => [
                'name' => 'Name',
                'type' => 'text',
                'required' => true,
                'actions' => ['all'],
            ],
            'type' => [
                'name' => 'Type',
                'type' => 'select.varchar',
                'required' => true,
                'options_callback' => ['qnd\data', ['attribute']],
                'actions' => ['edit', 'index'],
            ],
            'options_entity' => [
                'name' => 'Options Entity',
                'type' => 'select.varchar',
                'nullable' => true,
                'options_callback' => ['qnd\data', ['meta']],
                'actions' => ['edit'],
            ],
            'options' => [
                'name' => 'Options',
                'type' => 'json',
                'actions' => ['edit'],
            ],
        ],
    ],
    'content' => [
        'id' => 'content',
        'name' => 'Content',
        'attributes' => [
            'id' => [
                'name' => 'ID',
                'generator' => 'auto',
                'type' => 'int',
                'actions' => ['index'],
            ],
            'name' => [
                'name' => 'Name',
                'type' => 'text',
                'required' => true,
                'searchable' => true,
                'actions' => ['all'],
            ],
            'entity_id' => [
                'name' => 'Entity',
                'type' => 'select.varchar',
                'options_entity' => 'entity',
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
            'content' => [
                'name' => 'Content',
                'type' => 'rte',
                'nullable' => true,
                'actions' => ['edit', 'view'],
            ],
            'meta' => [
                'name' => 'Meta Tags',
                'type' => 'json',
                'nullable' => true,
                'actions' => ['edit'],
            ],
            'search' => [
                'name' => 'Search Index',
                'type' => 'index',
                'nullable' => true,
            ],
            'created' => [
                'name' => 'Created',
                'type' => 'datetime',
            ],
            'creator' => [
                'name' => 'Creator',
                'type' => 'select.int',
                'nullable' => true,
                'options_entity' => 'user',
            ],
            'modified' => [
                'name' => 'Modified',
                'type' => 'datetime',
            ],
            'modifier' => [
                'name' => 'Modifier',
                'type' => 'select.int',
                'nullable' => true,
                'options_entity' => 'user',
            ],
        ],
    ],
    'eav' => [
        'id' => 'eav',
        'name' => 'EAV',
        'attributes' => [
            'id' => [
                'name' => 'ID',
                'generator' => 'auto',
                'type' => 'int',
                'actions' => ['index'],
            ],
            'entity_id' => [
                'name' => 'Entity',
                'type' => 'select.varchar',
                'required' => true,
                'options_entity' => 'entity',
                'actions' => ['edit', 'index'],
            ],
            'attribute_id' => [
                'name' => 'Attribute',
                'type' => 'select.varchar',
                'required' => true,
                'options_entity' => 'attribute',
                'actions' => ['edit', 'index'],
            ],
            'content_id' => [
                'name' => 'Content',
                'type' => 'select.int',
                'required' => true,
                'options_entity' => 'content',
                'actions' => ['edit', 'index'],
            ],
            'value_bool' => [
                'name' => 'Value Boolean',
                'type' => 'checkbox.bool',
                'nullable' => true,
                'actions' => ['edit'],
            ],
            'value_datetime' => [
                'name' => 'Value Datetime',
                'nullable' => true,
                'type' => 'datetime',
                'actions' => ['edit'],
            ],
            'value_decimal' => [
                'name' => 'Value Decimal',
                'type' => 'decimal',
                'nullable' => true,
                'actions' => ['edit'],
            ],
            'value_int' => [
                'name' => 'Value Int',
                'type' => 'int',
                'nullable' => true,
                'actions' => ['edit'],
            ],
            'value_text' => [
                'name' => 'Value Text',
                'type' => 'textarea',
                'nullable' => true,
                'actions' => ['edit'],
            ],
            'value_varchar' => [
                'name' => 'Value Varchar',
                'type' => 'text',
                'nullable' => true,
                'actions' => ['edit'],
            ],
        ],
    ],
    'entity' => [
        'id' => 'entity',
        'name' => 'Entity',
        'actions' => ['create', 'edit', 'delete', 'index'],
        'toolbar' => 'structure',
        'sort' => 300,
        'attributes' => [
            'id' => [
                'name' => 'ID',
                'generator' => 'id',
                'type' => 'text',
                'required' => true,
                'unambiguous' => true,
                'actions' => ['index'],
            ],
            'name' => [
                'name' => 'Name',
                'type' => 'text',
                'required' => true,
                'actions' => ['all'],
            ],
            'actions' => [
                'name' => 'Actions',
                'type' => 'multiselect',
                'nullable' => true,
                'options_callback' => ['qnd\config', ['action.entity']],
                'actions' => ['edit', 'index'],
            ],
            'toolbar' => [
                'name' => 'Toolbar',
                'type' => 'select.varchar',
                'required' => true,
                'options_callback' => ['qnd\data', ['toolbar']],
                'actions' => ['edit'],
            ],
            'sort' => [
                'name' => 'Sort',
                'type' => 'int',
                'actions' => ['edit'],
            ],
            'system' => [
                'name' => 'System',
                'type' => 'checkbox.bool',
                'actions' => ['index'],
            ],
        ],
    ],
    'meta' => [
        'id' => 'meta',
        'name' => 'Metadata',
        'actions' => ['create', 'edit', 'delete', 'index'],
        'toolbar' => 'structure',
        'sort' => 500,
        'attributes' => [
            'id' => [
                'name' => 'ID',
                'generator' => 'auto',
                'type' => 'int',
                'actions' => ['index'],
            ],
            'entity_id' => [
                'name' => 'Entity',
                'type' => 'select.varchar',
                'required' => true,
                'options_entity' => 'entity',
                'actions' => ['edit', 'index'],
            ],
            'attribute_id' => [
                'name' => 'Attribute',
                'type' => 'select.varchar',
                'required' => true,
                'options_entity' => 'attribute',
                'actions' => ['edit', 'index'],
            ],
            'sort' => [
                'name' => 'Sort',
                'type' => 'int',
                'actions' => ['edit', 'index'],
            ],
            'required' => [
                'name' => 'Required',
                'type' => 'checkbox.bool',
                'actions' => ['edit'],
            ],
            'unambiguous' => [
                'name' => 'Unambiguous',
                'type' => 'checkbox.bool',
                'actions' => ['edit'],
            ],
            'searchable' => [
                'name' => 'Searchable',
                'type' => 'checkbox.bool',
                'actions' => ['edit'],
            ],
            'filterable' => [
                'name' => 'Filterable',
                'type' => 'checkbox.bool',
                'actions' => ['edit'],
            ],
            'sortable' => [
                'name' => 'Sortable',
                'type' => 'checkbox.bool',
                'actions' => ['edit'],
            ],
            'actions' => [
                'name' => 'Actions',
                'type' => 'multiselect',
                'nullable' => true,
                'options_callback' => ['qnd\config', ['action.attribute']],
                'actions' => ['edit', 'index'],
            ],
        ],
    ],
    'project' => [
        'id' => 'project',
        'name' => 'Project',
        'actions' => ['create', 'edit', 'delete',  'index'],
        'toolbar' => 'system',
        'sort' => 100,
        'attributes' => [
            'id' => [
                'name' => 'ID',
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
                'unambiguous' => true,
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
        'id' => 'rewrite',
        'name' => 'Rewrite',
        'actions' => ['create', 'edit', 'delete', 'index'],
        'toolbar' => 'system',
        'sort' => 400,
        'attributes' => [
            'id' => [
                'name' => 'ID',
                'generator' => 'id',
                'type' => 'text',
                'required' => true,
                'unambiguous' => true,
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
        ],
    ],
    'role' => [
        'id' => 'role',
        'name' => 'Role',
        'actions' => ['create', 'edit', 'delete', 'index'],
        'toolbar' => 'system',
        'sort' => 300,
        'attributes' => [
            'id' => [
                'name' => 'ID',
                'generator' => 'auto',
                'type' => 'int',
                'actions' => ['index'],
            ],
            'name' => [
                'name' => 'Name',
                'type' => 'text',
                'required' => true,
                'unambiguous' => true,
                'actions' => ['all'],
            ],
            'privilege' => [
                'name' => 'Privileges',
                'type' => 'multiselect',
                'options_callback' => ['qnd\privileges'],
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
        ],
    ],
    'tree' => [
        'id' => 'tree',
        'name' => 'Menu Tree',
        'type' => 'tree',
        'actions' => ['create', 'edit', 'delete', 'index'],
        'toolbar' => 'structure',
        'sort' => 200,
        'attributes' => [
            'id' => [
                'name' => 'ID',
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
                'required' => true,
                'actions' => ['edit', 'index'],
            ],
            'root_id' => [
                'name' => 'Menu Tree Root',
                'type' => 'select.varchar',
                'required' => true,
                'options_entity' => 'tree_root',
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
            'mode' => [
                'name' => 'Mode',
                'virtual' => true,
                'type' => 'select.varchar',
                'options' => ['after' => 'After', 'before' => 'Before', 'child' => 'Child'],
                'actions' => ['edit'],
            ],
            'position' => [
                'name' => 'Position',
                'virtual' => true,
                'type' => 'select.varchar',
                'required' => true,
                'options_callback' => ['qnd\option_position'],
                'actions' => ['edit'],
            ],
            'level' => [
                'name' => 'Level',
                'virtual' => true,
                'type' => 'int',
                'actions' => ['index'],
            ],
            'parent_id' => [
                'name' => 'Parent',
                'virtual' => true,
                'type' => 'select.int',
                'nullable' => true,
                'options_entity' => 'tree',
                'actions' => ['index'],
            ],
        ],
    ],
    'tree_root' => [
        'id' => 'tree_root',
        'name' => 'Menu Tree Root',
        'actions' => ['create', 'edit', 'delete', 'index'],
        'toolbar' => 'structure',
        'sort' => 100,
        'attributes' => [
            'id' => [
                'name' => 'ID',
                'generator' => 'auto',
                'type' => 'int',
                'actions' => ['index'],
            ],
            'name' => [
                'name' => 'Name',
                'type' => 'text',
                'actions' => ['all'],
                'required' => true,
            ],
            'system' => [
                'name' => 'System',
                'type' => 'checkbox.bool',
                'actions' => ['index'],
            ],
        ],
    ],
    'user' => [
        'id' => 'user',
        'name' => 'User',
        'actions' => ['create', 'edit', 'delete',  'index'],
        'toolbar' => 'system',
        'sort' => 200,
        'attributes' => [
            'id' => [
                'name' => 'ID',
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
                'unambiguous' => true,
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
                'options_entity' => 'role',
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
];
