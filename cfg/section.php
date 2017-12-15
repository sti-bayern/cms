<?php
return [
    'container' => [
        'vars' => ['tag' => null],
    ],
    'ent' => [
        'vars' => ['ent' => null, 'crit' => [], 'opt' => [], 'act' => null],
    ],
    'index' => [
        'vars' => ['ent' => null, 'crit' => [], 'opt' => [], 'act' => null, 'params' => []],
    ],
    'msg' => [
        'tpl' => 'layout/msg.phtml',
        'vars' => [],
    ],
    'nav' => [
        'vars' => ['mode' => null],
    ],
    'pager' => [
        'vars' => ['size' => 0, 'limit' => 0, 'links' => [], 'params' => []],
    ],
    'tpl' => [
        'vars' => [],
    ],
];