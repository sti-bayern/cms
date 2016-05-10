<?php
return [
    // Input
    'email' => [
        'name' => 'Email',
        'backend' => 'varchar',
        'frontend' => 'email',
    ],
    'password' => [
        'name' => 'Password',
        'backend' => 'varchar',
        'frontend' => 'password',
    ],
    'text' => [
        'name' => 'Text',
        'backend' => 'varchar',
        'frontend' => 'text',
    ],
    'url' => [
        'name' => 'URL',
        'backend' => 'varchar',
        'frontend' => 'url',
    ],
    // Input Number
    'int' => [
        'name' => 'Integer',
        'backend' => 'int',
        'frontend' => 'number',
    ],
    'decimal' => [
        'name' => 'Decimal',
        'backend' => 'decimal',
        'frontend' => 'number',
        'step' => 0.01,
    ],
    'range' => [
        'name' => 'Range',
        'backend' => 'int',
        'frontend' => 'range',
    ],
    // Input Date
    'date' => [
        'name' => 'Date',
        'backend' => 'datetime',
        'frontend' => 'date',
    ],
    'datetime' => [
        'name' => 'Datetime',
        'backend' => 'datetime',
        'frontend' => 'datetime-local',
    ],
    // Input File
    'audio' => [
        'name' => 'Audio',
        'backend' => 'varchar',
        'frontend' => 'file',
    ],
    'embed' => [
        'name' => 'Embed',
        'backend' => 'varchar',
        'frontend' => 'file',
    ],
    'file' => [
        'name' => 'File',
        'backend' => 'varchar',
        'frontend' => 'file',
    ],
    'image' => [
        'name' => 'Image',
        'backend' => 'varchar',
        'frontend' => 'file',
    ],
    'video' => [
        'name' => 'Video',
        'backend' => 'varchar',
        'frontend' => 'file',
    ],
    // Textarea
    'index' => [
        'name' => 'Search Index',
        'backend' => 'text',
        'frontend' => 'textarea',
    ],
    'json' => [
        'name' => 'JSON',
        'backend' => 'text',
        'frontend' => 'textarea',
    ],
    'rte' => [
        'name' => 'Rich Text Editor',
        'backend' => 'text',
        'frontend' => 'textarea',
        'class' => ['rte'],
    ],
    'textarea' => [
        'name' => 'Textarea',
        'backend' => 'text',
        'frontend' => 'textarea',
    ],
    // Checkbox
    'checkbox.bool' => [
        'name' => 'Checkbox (Boolean)',
        'backend' => 'bool',
        'frontend' => 'checkbox',
    ],
    'checkbox.int' => [
        'name' => 'Checkbox (Integer)',
        'backend' => 'int',
        'frontend' => 'checkbox',
    ],
    'checkbox.varchar' => [
        'name' => 'Checkbox (Varchar)',
        'backend' => 'varchar',
        'frontend' => 'checkbox',
    ],
    'multicheckbox' => [
        'name' => 'Multicheckbox',
        'backend' => 'text',
        'frontend' => 'checkbox',
        'multiple' => true,
    ],
    // Radio
    'radio.bool' => [
        'name' => 'Radio (Boolean)',
        'backend' => 'bool',
        'frontend' => 'radio',
    ],
    'radio.int' => [
        'name' => 'Radio (Integer)',
        'backend' => 'int',
        'frontend' => 'radio',
    ],
    'radio.varchar' => [
        'name' => 'Radio (Varchar)',
        'backend' => 'varchar',
        'frontend' => 'radio',
    ],
    // Select
    'select.bool' => [
        'name' => 'Select (Boolean)',
        'backend' => 'bool',
        'frontend' => 'select',
    ],
    'select.int' => [
        'name' => 'Select (Integer)',
        'backend' => 'int',
        'frontend' => 'select',
    ],
    'select.varchar' => [
        'name' => 'Select (Varchar)',
        'backend' => 'varchar',
        'frontend' => 'select',
    ],
    'multiselect' => [
        'name' => 'Multiselect',
        'backend' => 'text',
        'frontend' => 'select',
        'multiple' => true,
    ],
];
