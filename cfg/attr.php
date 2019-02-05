<?php
return [
    'audio' => [
        'backend' => 'int',
        'frontend' => 'frontend\file',
        'validator' => 'validator\entity',
        'viewer' => 'viewer\file',
        'ref' => 'file_audio',
    ],
    'bool' => [
        'backend' => 'bool',
        'frontend' => 'frontend\bool',
        'viewer' => 'viewer\opt',
        'opt' => 'bool',
    ],
    'checkbox' => [
        'backend' => 'json',
        'frontend' => 'frontend\checkbox',
        'validator' => 'validator\opt',
        'viewer' => 'viewer\opt',
        'multiple' => true,
    ],
    'date' => [
        'backend' => 'date',
        'frontend' => 'frontend\date',
        'validator' => 'validator\date',
        'viewer' => 'viewer\date',
    ],
    'datetime' => [
        'backend' => 'datetime',
        'frontend' => 'frontend\datetime',
        'validator' => 'validator\datetime',
        'viewer' => 'viewer\datetime',
    ],
    'decimal' => [
        'backend' => 'decimal',
        'frontend' => 'frontend\decimal',
    ],
    'doc' => [
        'backend' => 'int',
        'frontend' => 'frontend\file',
        'validator' => 'validator\entity',
        'viewer' => 'viewer\file',
        'ref' => 'file_doc',
    ],
    'email' => [
        'backend' => 'varchar',
        'frontend' => 'frontend\email',
        'validator' => 'validator\email',
        'viewer' => 'viewer\email',
    ],
    'entity' => [
        'backend' => 'int',
        'frontend' => 'frontend\select',
        'validator' => 'validator\entity',
        'viewer' => 'viewer\entity',
        'opt' => 'opt\entity',
    ],
    'file' => [
        'backend' => 'int',
        'frontend' => 'frontend\file',
        'validator' => 'validator\entity',
        'viewer' => 'viewer\file',
        'ref' => 'file',
    ],
    'image' => [
        'backend' => 'int',
        'frontend' => 'frontend\file',
        'validator' => 'validator\entity',
        'viewer' => 'viewer\file',
        'ref' => 'file_image',
    ],
    'int' => [
        'backend' => 'int',
        'frontend' => 'frontend\int',
    ],
    'json' => [
        'backend' => 'json',
        'frontend' => 'frontend\json',
        'viewer' => 'viewer\json',
    ],
    'page' => [
        'backend' => 'int',
        'frontend' => 'frontend\select',
        'validator' => 'validator\entity',
        'viewer' => 'viewer\page',
        'ref' => 'page',
        'opt' => 'opt\page',
    ],
    'parent' => [
        'backend' => 'varchar',
        'frontend' => 'frontend\select',
        'validator' => 'validator\opt',
        'viewer' => 'viewer\opt',
        'opt' => 'opt\parent',
        'maxlength' => 50,
    ],
    'password' => [
        'backend' => 'varchar',
        'frontend' => 'frontend\password',
        'ignorable' => true,
    ],
    'radio' => [
        'backend' => 'varchar',
        'frontend' => 'frontend\radio',
        'validator' => 'validator\opt',
        'viewer' => 'viewer\opt',
    ],
    'range' => [
        'backend' => 'int',
        'frontend' => 'frontend\range',
    ],
    'rte' => [
        'backend' => 'text',
        'frontend' => 'frontend\textarea',
        'validator' => 'validator\rte',
        'viewer' => 'viewer\rte',
    ],
    'rtemin' => [
        'backend' => 'text',
        'frontend' => 'frontend\textarea',
        'validator' => 'validator\rtemin',
        'viewer' => 'viewer\rte',
    ],
    'select' => [
        'backend' => 'varchar',
        'frontend' => 'frontend\select',
        'validator' => 'validator\opt',
        'viewer' => 'viewer\opt',
    ],
    'serial' => [
        'backend' => 'int',
        'frontend' => 'frontend\int',
        'auto' => true,
    ],
    'status' => [
        'backend' => 'varchar',
        'frontend' => 'frontend\radio',
        'validator' => 'validator\opt',
        'viewer' => 'viewer\opt',
        'opt' => 'opt\status',
    ],
    'tel' => [
        'backend' => 'varchar',
        'frontend' => 'frontend\tel',
        'validator' => 'validator\text',
    ],
    'text' => [
        'backend' => 'varchar',
        'frontend' => 'frontend\text',
        'validator' => 'validator\text',
    ],
    'textarea' => [
        'backend' => 'text',
        'frontend' => 'frontend\textarea',
        'validator' => 'validator\text',
    ],
    'time' => [
        'backend' => 'time',
        'frontend' => 'frontend\time',
        'validator' => 'validator\time',
        'viewer' => 'viewer\time',
    ],
    'uid' => [
        'backend' => 'varchar',
        'frontend' => 'frontend\text',
        'validator' => 'validator\uid',
    ],
    'upload' => [
        'backend' => 'varchar',
        'frontend' => 'frontend\upload',
        'validator' => 'validator\upload',
        'viewer' => 'viewer\upload',
        'ignorable' => true,
    ],
    'url' => [
        'backend' => 'varchar',
        'frontend' => 'frontend\url',
        'validator' => 'validator\url',
        'viewer' => 'viewer\url',
    ],
    'video' => [
        'backend' => 'int',
        'frontend' => 'frontend\file',
        'validator' => 'validator\entity',
        'viewer' => 'viewer\file',
        'ref' => 'file_video',
    ],
];
