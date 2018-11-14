<?php
declare(strict_types = 1);

namespace action;

use account;
use app;
use entity;
use request;
use session;

/**
 * View Action
 */
function view(array $entity): void
{
    if (!($id = app\get('id')) || !entity\size($entity['id'], [['id', $id]])) {
        app\error();
    }
}

/**
 * Page View Action
 */
function page_view(): void
{
    if (!($page = app\get('page')) || !app\allowed($page['entity'] . '/edit') && $page['status'] !== 'published') {
        app\error();
    }
}

/**
 * Delete Action
 */
function delete(array $entity): void
{
    if ($id = app\get('id')) {
        entity\delete($entity['id'], [['id', $id]]);
    } else {
        app\msg('Nothing to delete');
    }

    request\redirect(app\url($entity['id'] . '/admin'));
}

/**
 * App JavaScript Action
 */
function app_js(): void
{
    header('Content-Type: text/javascript', true);
    die(json_encode(['i18n' => app\cfg('i18n')]));
}

/**
 * Account Login Action
 */
function account_login(): void
{
    if ($data = request\get('data')) {
        if (!empty($data['name']) && !empty($data['password']) && ($data = account\login($data['name'], $data['password']))) {
            session\regenerate();
            session\set('account', $data['id']);
            request\redirect();
            return;
        }

        app\msg('Invalid name and password combination');
    }
}

/**
 * Account Logout Action
 */
function account_logout(): void
{
    session\regenerate();
    request\redirect();
}
