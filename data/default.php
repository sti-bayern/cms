<?php
return [
    'attr' => [
        'id' => null,
        'uid' => null,
        'name' => null,
        'col' => null,
        'auto' => false,
        'sort' => null,
        'type' => null,
        'backend' => null,
        'frontend' => null,
        'db_type' => null,
        'pdo' => null,
        'nullable' => false,
        'required' => false,
        'uniq' => false,
        'multiple' => false,
        'searchable' => false,
        'opt' => [],
        'actions' => [],
        'val' => null,
        'minval' => null,
        'maxval' => null,
        'context' => null,
        'html' => [],
        'validator' => null,
        'saver' => null,
        'deleter' => null,
        'loader' => null,
        'editor' => null,
        'viewer' => null,
    ],
    'entity' => [
        'id' => null,
        'uid' => null,
        'name' => null,
        'tab' => null,
        'model' => 'flat',
        'actions' => ['admin', 'delete', 'edit'],
        'system' => false,
        'attr' => [],
    ],
    'load' => [
        'mode' => 'all',
        'index' => ['id'],
        'search' => [],
        'select' => [],
        'order' => [],
        'limit' => 0,
        'offset' => 0
    ],
    'section' => [
        'id' => null,
        'type' => null,
        'template' => null,
        'vars' => [],
        'active' => true,
        'privilege' => null,
        'parent' => 'root',
        'sort' => 0,
        'children' => [],
    ],
];
