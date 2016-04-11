<?php
return [
    'audio' => [
        'id' => 'audio',
        'name' => 'Audio',
        'backend' => 'varchar',
        'frontend' => 'file',
        'default' => [
            'delete' => 'akilli\deleter_file',
            'validate' => 'akilli\validator_file',
            'edit' => 'akilli\editor_file',
            'view' => 'akilli\viewer_file',
            'flag' => ['_reset' => 'Reset'],
        ],
    ],
    'bool.checkbox' => [
        'id' => 'bool.checkbox',
        'name' => 'Checkbox (Boolean)',
        'backend' => 'bool',
        'frontend' => 'checkbox',
        'default' => [
            'options' => ['No', 'Yes'],
            'validate' => 'akilli\validator_option',
            'edit' => 'akilli\editor_input_option',
            'view' => 'akilli\viewer_option',
        ],
    ],
    'bool.radio' => [
        'id' => 'bool.radio',
        'name' => 'Radio (Boolean)',
        'backend' => 'bool',
        'frontend' => 'radio',
        'default' => [
            'options' => ['No', 'Yes'],
            'validate' => 'akilli\validator_option',
            'edit' => 'akilli\editor_input_option',
            'view' => 'akilli\viewer_option',
        ],
    ],
    'callback' => [
        'id' => 'callback',
        'name' => 'Callback',
        'backend' => 'varchar',
        'frontend' => 'text',
        'default' => [
            'validate' => 'akilli\validator_callback',
        ],
    ],
    'date' => [
        'id' => 'date',
        'name' => 'Date',
        'backend' => 'datetime',
        'frontend' => 'date',
        'default' => [
            'load' => 'akilli\loader_datetime',
            'validate' => 'akilli\validator_datetime',
            'edit' => 'akilli\editor_datetime',
            'view' => 'akilli\viewer_datetime',
        ],
    ],
    'datetime' => [
        'id' => 'datetime',
        'name' => 'Datetime',
        'backend' => 'datetime',
        'frontend' => 'datetime-local',
        'default' => [
            'load' => 'akilli\loader_datetime',
            'validate' => 'akilli\validator_datetime',
            'edit' => 'akilli\editor_datetime',
            'view' => 'akilli\viewer_datetime',
        ],
    ],
    'decimal' => [
        'id' => 'decimal',
        'name' => 'Decimal',
        'backend' => 'decimal',
        'frontend' => 'number',
        'default' => [
            'validate' => 'akilli\validator_number',
            'edit' => 'akilli\editor_number',
            'step' => 0.01,
        ],
    ],
    'rte' => [
        'id' => 'rte',
        'name' => 'Rich Text Editor',
        'backend' => 'text',
        'frontend' => 'textarea',
        'default' => [
            'validate' => 'akilli\validator_rte',
            'edit' => 'akilli\editor_textarea',
            'view' => 'akilli\viewer_rte',
            'class' => ['rte'],
        ],
    ],
    'email' => [
        'id' => 'email',
        'name' => 'Email',
        'backend' => 'varchar',
        'frontend' => 'email',
        'default' => [
            'validate' => 'akilli\validator_email',
        ],
    ],
    'embed' => [
        'id' => 'embed',
        'name' => 'Embed',
        'backend' => 'varchar',
        'frontend' => 'file',
        'default' => [
            'delete' => 'akilli\deleter_file',
            'validate' => 'akilli\validator_file',
            'edit' => 'akilli\editor_file',
            'view' => 'akilli\viewer_file',
            'flag' => ['_reset' => 'Reset'],
        ],
    ],
    'file' => [
        'id' => 'file',
        'name' => 'File',
        'backend' => 'varchar',
        'frontend' => 'file',
        'default' => [
            'delete' => 'akilli\deleter_file',
            'validate' => 'akilli\validator_file',
            'edit' => 'akilli\editor_file',
            'view' => 'akilli\viewer_file',
            'flag' => ['_reset' => 'Reset'],
        ],
    ],
    'image' => [
        'id' => 'image',
        'name' => 'Image',
        'backend' => 'varchar',
        'frontend' => 'file',
        'default' => [
            'delete' => 'akilli\deleter_file',
            'validate' => 'akilli\validator_file',
            'edit' => 'akilli\editor_file',
            'view' => 'akilli\viewer_file',
            'flag' => ['_reset' => 'Reset'],
        ],
    ],
    'int' => [
        'id' => 'int',
        'name' => 'Integer',
        'backend' => 'int',
        'frontend' => 'number',
        'default' => [
            'validate' => 'akilli\validator_number',
            'edit' => 'akilli\editor_number',
        ],
    ],
    'int.checkbox' => [
        'id' => 'int.checkbox',
        'name' => 'Checkbox (Integer)',
        'backend' => 'int',
        'frontend' => 'checkbox',
        'default' => [
            'validate' => 'akilli\validator_option',
            'edit' => 'akilli\editor_input_option',
            'view' => 'akilli\viewer_option',
        ]
    ],
    'int.radio' => [
        'id' => 'int.radio',
        'name' => 'Radio (Integer)',
        'backend' => 'int',
        'frontend' => 'radio',
        'default' => [
            'validate' => 'akilli\validator_option',
            'edit' => 'akilli\editor_input_option',
            'view' => 'akilli\viewer_option',
        ],
    ],
    'int.select' => [
        'id' => 'int.select',
        'name' => 'Select (Integer)',
        'backend' => 'int',
        'frontend' => 'select',
        'default' => [
            'validate' => 'akilli\validator_option',
            'edit' => 'akilli\editor_select',
            'view' => 'akilli\viewer_option',
        ],
    ],
    'json' => [
        'id' => 'json',
        'name' => 'JSON',
        'backend' => 'text',
        'frontend' => 'textarea',
        'default' => [
            'load' => 'akilli\loader_json',
            'validate' => 'akilli\validator_json',
            'edit' => 'akilli\editor_json',
        ],
    ],
    'multicheckbox' => [
        'id' => 'multicheckbox',
        'name' => 'Multicheckbox',
        'backend' => 'text',
        'frontend' => 'checkbox',
        'default' => [
            'is_multiple' => true,
            'load' => 'akilli\loader_json',
            'save' => 'akilli\saver_multiple',
            'validate' => 'akilli\validator_option',
            'edit' => 'akilli\editor_input_option',
            'view' => 'akilli\viewer_option',
        ],
    ],
    'multiselect' => [
        'id' => 'multiselect',
        'name' => 'Multiselect',
        'backend' => 'text',
        'frontend' => 'select',
        'default' => [
            'is_multiple' => true,
            'load' => 'akilli\loader_json',
            'save' => 'akilli\saver_multiple',
            'validate' => 'akilli\validator_option',
            'edit' => 'akilli\editor_select',
            'view' => 'akilli\viewer_option',
        ],
    ],
    'password' => [
        'id' => 'password',
        'name' => 'Password',
        'backend' => 'varchar',
        'frontend' => 'password',
        'default' => [
            'is_searchable' => false,
            'save' => 'akilli\saver_password',
            'edit' => 'akilli\editor_password',
            'view' => 'akilli\viewer',
        ],
    ],
    'tel' => [
        'id' => 'tel',
        'name' => 'Telephone Number',
        'backend' => 'varchar',
        'frontend' => 'tel',
        'default' => [],
    ],
    'text' => [
        'id' => 'text',
        'name' => 'Text',
        'backend' => 'varchar',
        'frontend' => 'text',
        'default' => [],
    ],
    'textarea' => [
        'id' => 'textarea',
        'name' => 'Textarea',
        'backend' => 'text',
        'frontend' => 'textarea',
        'default' => [
            'edit' => 'akilli\editor_textarea',
        ],
    ],
    'url' => [
        'id' => 'url',
        'name' => 'URL',
        'backend' => 'varchar',
        'frontend' => 'url',
        'default' => [
            'validate' => 'akilli\validator_url',
        ],
    ],
    'varchar.checkbox' => [
        'id' => 'varchar.checkbox',
        'name' => 'Checkbox (Varchar)',
        'backend' => 'varchar',
        'frontend' => 'checkbox',
        'default' => [
            'validate' => 'akilli\validator_option',
            'edit' => 'akilli\editor_input_option',
            'view' => 'akilli\viewer_option',
        ]
    ],
    'varchar.radio' => [
        'id' => 'varchar.radio',
        'name' => 'Radio (Varchar)',
        'backend' => 'varchar',
        'frontend' => 'radio',
        'default' => [
            'validate' => 'akilli\validator_option',
            'edit' => 'akilli\editor_input_option',
            'view' => 'akilli\viewer_option',
        ],
    ],
    'varchar.select' => [
        'id' => 'varchar.select',
        'name' => 'Select (Varchar)',
        'backend' => 'varchar',
        'frontend' => 'select',
        'default' => [
            'validate' => 'akilli\validator_option',
            'edit' => 'akilli\editor_select',
            'view' => 'akilli\viewer_option',
        ],
    ],
    'video' => [
        'id' => 'video',
        'name' => 'Video',
        'backend' => 'varchar',
        'frontend' => 'file',
        'default' => [
            'delete' => 'akilli\deleter_file',
            'validate' => 'akilli\validator_file',
            'edit' => 'akilli\editor_file',
            'view' => 'akilli\viewer_file',
            'flag' => ['_reset' => 'Reset'],
        ],
    ],
];
