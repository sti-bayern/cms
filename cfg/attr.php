<?php
return [
    'audio' => [
        'backend' => 'int',
        'frontend' => 'frontend\file',
        'filter' => 'frontend\int',
        'validator' => 'validator\entity',
        'viewer' => 'viewer\file',
        'ref' => 'file_audio',
    ],
    'bool' => [
        'backend' => 'bool',
        'frontend' => 'frontend\bool',
        'filter' => 'frontend\select',
        'viewer' => 'viewer\opt',
        'opt' => 'bool',
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
        'filter' => 'frontend\date',
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
        'filter' => 'frontend\int',
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
        'filter' => 'frontend\int',
        'validator' => 'validator\entity',
        'viewer' => 'viewer\file',
        'ref' => 'file',
    ],
    'image' => [
        'backend' => 'int',
        'frontend' => 'frontend\file',
        'filter' => 'frontend\int',
        'validator' => 'validator\entity',
        'viewer' => 'viewer\file',
        'ref' => 'file_image',
    ],
    'int' => [
        'backend' => 'int',
        'frontend' => 'frontend\int',
    ],
    'int[]' => [
        'backend' => 'int',
        'frontend' => 'frontend\checkbox',
        'filter' => 'frontend\select',
        'validator' => 'validator\opt',
        'viewer' => 'viewer\opt',
        'multiple' => true,
    ],
    'json' => [
        'backend' => 'json',
        'frontend' => 'frontend\json',
        'filter' => 'frontend\text',
        'viewer' => 'viewer\json',
    ],
    'media' => [
        'backend' => 'int',
        'frontend' => 'frontend\file',
        'filter' => 'frontend\int',
        'validator' => 'validator\entity',
        'viewer' => 'viewer\file',
        'ref' => 'file_media',
    ],
    'multientity' => [
        'backend' => 'int',
        'frontend' => 'frontend\select',
        'validator' => 'validator\multientity',
        'viewer' => 'viewer\multientity',
        'multiple' => true,
        'opt' => 'opt\entity',
    ],
    'multipage' => [
        'backend' => 'int',
        'frontend' => 'frontend\select',
        'validator' => 'validator\multientity',
        'viewer' => 'viewer\multientity',
        'multiple' => true,
        'ref' => 'page',
        'opt' => 'opt\page',
    ],
    'page' => [
        'backend' => 'int',
        'frontend' => 'frontend\select',
        'validator' => 'validator\entity',
        'viewer' => 'viewer\entity',
        'ref' => 'page',
        'opt' => 'opt\page',
    ],
    'parent' => [
        'backend' => 'varchar',
        'frontend' => 'frontend\select',
        'validator' => 'validator\opt',
        'viewer' => 'viewer\opt',
        'opt' => 'opt\parent',
        'max' => 50,
    ],
    'password' => [
        'backend' => 'varchar',
        'frontend' => 'frontend\password',
    ],
    'path' => [
        'backend' => 'varchar',
        'frontend' => 'frontend\text',
        'validator' => 'validator\path',
        'viewer' => 'viewer\url',
    ],
    'radio' => [
        'backend' => 'varchar',
        'frontend' => 'frontend\radio',
        'filter' => 'frontend\select',
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
        'filter' => 'frontend\text',
        'validator' => 'validator\rte',
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
        'filter' => 'frontend\select',
        'validator' => 'validator\opt',
        'viewer' => 'viewer\opt',
        'opt' => 'status',
        'opt.frontend' => 'opt\status',
        'opt.validator' => 'opt\status',
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
    'text[]' => [
        'backend' => 'varchar',
        'frontend' => 'frontend\checkbox',
        'filter' => 'frontend\select',
        'validator' => 'validator\opt',
        'viewer' => 'viewer\opt',
        'multiple' => true,
    ],
    'textarea' => [
        'backend' => 'text',
        'frontend' => 'frontend\textarea',
        'filter' => 'frontend\text',
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
        'filter' => 'frontend\text',
        'validator' => 'validator\upload',
        'viewer' => 'viewer\upload',
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
        'filter' => 'frontend\int',
        'validator' => 'validator\entity',
        'viewer' => 'viewer\file',
        'ref' => 'file_video',
    ],
];
