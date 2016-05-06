<?php
return [
    'action.attribute' => [
        'all' => 'all',
        'edit' => 'edit',
        'view' => 'view',
        'index' => 'index',
        'list' => 'list',
        'section' => 'section',
    ],
    'action.entity' => [
        'all' => 'all',
        'create' => 'create',
        'edit' => 'edit',
        'delete' => 'delete',
        'view' => 'view',
        'index' => 'index',
        'list' => 'list',
    ],
    'file.audio' => [
        'mp3' => 'mp3',
        'oga' => 'oga',
        'ogg' => 'ogg',
        'weba' => 'weba',
    ],
    'file.embed' => [
        'avi' => 'avi',
        'mov' => 'mov',
        'mpg' => 'mpg',
        'ra' => 'ra',
        'rm' => 'rm',
        'swf' => 'swf',
        'wav' => 'wav',
        'wma' => 'wma',
        'wmv' => 'wmv',
    ],
    'file.image' => [
        'gif' => 'gif',
        'jpe' => 'jpe',
        'jpeg' => 'jpeg',
        'jpg' => 'jpg',
        'png' => 'png',
        'svg' => 'svg',
        'webp' => 'webp',
    ],
    'file.misc' => [
        'doc' => 'doc',
        'docx' => 'docx',
        'flv' => 'flv',
        'gz' => 'gz',
        'odt' => 'odt',
        'pdf' => 'pdf',
        'rar' => 'rar',
        'tar' => 'tar',
        'zip' => 'zip',
    ],
    'file.video' => [
        'mp4' => 'mp4',
        'ogv' => 'ogv',
        'ogg' => 'ogg',
        'webm' => 'webm',
    ],
    'filter.html' => '<address><article><aside><footer><h1><h2><h3><h4><h5><h6><header><nav><section>'
        . '<blockquote><dd><div><dl><dt><figcaption><figure><hr><li><ol><p><pre><ul>'
        . '<a><abbr><b><bdi><bdo><br><cite><code><dfn><em><i><kbd><mark><q><rp><rt><ruby><s><samp><small>'
        . '<span><strong><sub><sup><time><u><var><wbr><del><ins>'
        . '<area><audio><canvas><embed><iframe><img><map><object><param><source><track><video>'
        . '<caption><col><colgroup><table><tbody><tfoot><thead><td><th><tr>',
    'filter.identifier' => [
        '#ä|á|à|â|å|ã#i' => 'a',
        '#é|è|ê|ë#i' => 'e',
        '#í|ì|î|ï#i' =>  'i',
        '#ö|ó|ò|ô|õ|ð|ø#i' => 'o',
        '#ü|ú|ù|û#i' =>  'u',
        '#æ#i' =>  'ae',
        '#ß#i' => 'ss',
        '#ç#i' => 'c',
        '#ñ#i' => 'n',
        '#ý#i' => 'y',
        '#[^0-9a-z\/_-]+#i' => '-',
        '#[-]+#i' => '-',
    ],
    'i18n.charset' => 'utf-8',
    'i18n.date' => 'd.m.Y',
    'i18n.datetime' => 'd.m.Y H:i',
    'i18n.locale' => 'de-DE',
    'i18n.timezone' => 'Europe/Berlin',
    'limit.index' => 10,
    'limit.list' => 10,
    'limit.section' => 5,
    'meta.title' => 'Akilli CMS',
    'meta.separator' => '-',
    'meta' => [
        'keywords' => 'Akilli CMS',
        'description' => "Akilli CMS Quick'n'Dirty",
        'viewport' => 'width=device-width, initial-scale=1, maximum-scale=1',
    ],
    'url.asset' => '',
    'url.base' => '',
];
