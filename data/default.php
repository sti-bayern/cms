<?php
return [
    'attr' => [
        'id' => null,
        'name' => null,
        'col' => null,
        'auto' => false,
        'entity_id' => null,
        'sort' => null,
        'type' => null,
        'backend' => null,
        'frontend' => null,
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
    ],
    'entity' => [
        'id' => null,
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
        'as' => null,
        'type' => null,
        'template' => null,
        'vars' => [],
        'active' => true,
        'privilege' => null,
        'parent' => 'root',
        'sort' => 0,
        'children' => [],
        'html' => null,
    ],
];
