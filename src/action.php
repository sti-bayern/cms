<?php
declare(strict_types = 1);

namespace action;

use account;
use app;
use cfg;
use entity;
use layout;
use request;
use session;

/**
 * Delete
 */
function delete(array $entity): void
{
    entity\delete($entity['id'], [['id', app\data('id')]]);
    request\redirect(app\url($entity['id'] . '/admin'));
}

/**
 * App Config
 */
function app_cfg(): void
{
    header('Content-Type: application/json', true);
    die(json_encode(['i18n' => cfg\data('i18n')]));
}

/**
 * Account Login
 */
function account_login(): void
{
    if ($data = request\data('post')) {
        if (!empty($data['username']) && !empty($data['password']) && ($data = account\login($data['username'], $data['password']))) {
            session\regenerate();
            session\set('account', $data['id']);
            request\redirect(app\url('account/dashboard'));
            return;
        }

        app\msg('Invalid name and password combination');
    }
}

/**
 * Account Logout
 */
function account_logout(): void
{
    session\regenerate();
    request\redirect(app\url('account/login'));
}

/**
 * Account Logout
 */
function block_api(): void
{
    die(app\data('id') ? layout\db_render(app\data('id')) : '');
}
