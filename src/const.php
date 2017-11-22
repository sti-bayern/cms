<?php
declare(strict_types = 1);

const APP = [
    'account.guest' => 'account-guest',
    'account.user' => 'account-user',
    'all' => '_all_',
    'attr' => [
        'id' => null,
        'name' => null,
        'col' => null,
        'auto' => false,
        'type' => null,
        'backend' => null,
        'frontend' => null,
        'nullable' => false,
        'required' => false,
        'unique' => false,
        'multiple' => false,
        'searchable' => false,
        'ignorable' => false,
        'opt' => [],
        'val' => null,
        'min' => 0,
        'max' => 0,
        'minlength' => 0,
        'maxlength' => 0,
        'filter' => null,
        'viewer' => null,
    ],
    'backend' => ['bool', 'date', 'datetime', 'decimal', 'int', 'json', 'text', 'time', 'varchar'],
    'backend.date' => 'Y-m-d',
    'backend.datetime' => 'Y-m-d H:i:s',
    'backend.time' => 'H:i:s',
    'crit' => [
        '=' => '=',
        '!=' => '!=',
        '>' => '>',
        '>=' => '>=',
        '<' => '>',
        '<=' => '<=',
        '~' => '~',
        '!~' => '!~',
        '~^' => '~^',
        '!~^' => '!~^',
        '~$' => '~$',
        '!~$' => '!~$',
    ],
    'ent' => [
        'id' => null,
        'name' => null,
        'tab' => null,
        'type' => 'db',
        'act' => [],
        'attr' => [],
    ],
    'ent.opt' => [
        'mode' => 'all',
        'index' => 'id',
        'select' => [],
        'order' => [],
        'limit' => 0,
        'offset' => 0,
    ],
    'frontend.date' => 'Y-m-d',
    'frontend.datetime' => 'Y-m-d\TH:i',
    'frontend.time' => 'H:i',
    'log' => 'php://stdout',
    'path' => [
        'asset' => '/data/asset',
        'cfg' => '/app/cfg',
        'ext' => '/app/ext',
        'theme' => '/app/www/theme',
        'tpl' => '/app/tpl',
    ],
    'priv' => [
        'name' => null,
        'sort' => 0,
        'priv' => null,
        'active' => true,
        'assignable' => true,
    ],
    'section' => [
        'id' => null,
        'section' => null,
        'tpl' => null,
        'active' => true,
        'priv' => null,
        'parent_id' => null,
        'sort' => 0,
        'vars' => [],
    ],
    'upload' => ['error', 'name', 'size', 'tmp_name', 'type'],
    'url.asset' => '/asset/',
    'url.page' => '/page/view/',
    'url.theme' => '/theme/'
];
