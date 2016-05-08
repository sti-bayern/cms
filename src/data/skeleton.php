<?php
return [
    'attribute' => [
        'id' => null,
        'name' => null,
        'column' => null,
        'auto' => false,
        'sort_order' => null,
        'type' => null,
        'backend' => null,
        'frontend' => null,
        'nullable' => false,
        'required' => false,
        'unambiguous' => false,
        'multiple' => false,
        'searchable' => false,
        'options_entity' => null,
        'options_callback' => null,
        'options_callback_param' => [],
        'options' => [],
        'actions' => [],
        'action' => null,
        'generator' => null,
        'generator_base' => null,
        'validator' => null,
        'min' => null,
        'max' => null,
        'step' => null,
        'class' => [],
    ],
    'entity' => [
        'id' => null,
        'name' => null,
        'table' => null,
        'type' => 'flat',
        'controller' => 'entity',
        'actions' => [],
        'toolbar' => null,
        'sort_order' => null,
        'attributes' => [],
    ],
    'request' => [
        'id' => 'http.index',
        'action' => 'index',
        'entity' => 'http',
        'base' => '',
        'url' => '',
        'original_path' => '',
        'path' => '',
        'host' => '',
        'scheme' => 'http',
        'secure' => false,
        'params' => [],
        'get' => [],
        'post' => [],
        'files' => [],
    ],
    'section' => [
        'id' => null,
        'type' => null,
        'template' => null,
        'vars' => [],
        'active' => true,
        'privilege' => null,
        'parent' => 'root',
        'sort_order' => 0,
        'children' => [],
    ],
];
