<?php
return [
    'home' => [
        'name' => 'Homepage',
        'url' => '/',
        'priv' => 'page_content/view',
        'sort' => 10,
    ],
    'page' => [
        'name' => 'Pages',
        'sort' => 20,
    ],
    'page_content' => [
        'name' => 'Content Pages',
        'url' => '/page_content/admin',
        'priv' => 'page_content/admin',
        'parent_id' => 'page',
        'sort' => 10,
    ],
    'page_article' => [
        'name' => 'Articles',
        'url' => '/page_article/admin',
        'priv' => 'page_article/admin',
        'parent_id' => 'page',
        'sort' => 20,
    ],
    'block' => [
        'name' => 'Blocks',
        'sort' => 30,
    ],
    'block_content' => [
        'name' => 'Content Blocks',
        'url' => '/block_content/admin',
        'priv' => 'block_content/admin',
        'parent_id' => 'block',
        'sort' => 10,
    ],
    'file' => [
        'name' => 'Files',
        'sort' => 40,
    ],
    'file_image' => [
        'name' => 'Images',
        'url' => '/file_image/admin',
        'priv' => 'file_image/admin',
        'parent_id' => 'file',
        'sort' => 10,
    ],
    'file_doc' => [
        'name' => 'Documents',
        'url' => '/file_doc/admin',
        'priv' => 'file_doc/admin',
        'parent_id' => 'file',
        'sort' => 20,
    ],
    'file_video' => [
        'name' => 'Videos',
        'url' => '/file_video/admin',
        'priv' => 'file_video/admin',
        'parent_id' => 'file',
        'sort' => 30,
    ],
    'file_audio' => [
        'name' => 'Audios',
        'url' => '/file_audio/admin',
        'priv' => 'file_audio/admin',
        'parent_id' => 'file',
        'sort' => 40,
    ],
    'role' => [
        'name' => 'Roles',
        'url' => '/role/admin',
        'priv' => 'role/admin',
        'sort' => 50,
    ],
    'account' => [
        'name' => 'Accounts',
        'url' => '/account/admin',
        'priv' => 'account/admin',
        'sort' => 60,
    ],
    'password' => [
        'name' => 'Password',
        'url' => '/account/password',
        'priv' => 'account/password',
        'sort' => 70,
    ],
    'logout' => [
        'name' => 'Logout',
        'url' => '/account/logout',
        'priv' => 'account/logout',
        'sort' => 80,
    ],
];
