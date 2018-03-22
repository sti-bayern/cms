<?php
declare(strict_types = 1);

namespace app;

use account;
use act;
use arr;
use ent;
use req;
use session;
use DomainException;
use Throwable;

/**
 * Runs application
 */
function run(): void
{
    // Register functions
    set_error_handler('handler\error');
    set_exception_handler('handler\exception');
    register_shutdown_function('handler\shutdown');

    $data = & reg('app');
    $data['lang'] = locale_get_primary_language('');
    $data['gui'] = max(filemtime(path('gui')), filemtime(path('ext.gui')) ?: 0);
    $url = req\get('url');
    $rew = ent\one('url', [['name', $url]]);

    // Redirect
    if (!empty($rew['redirect'])) {
        redirect($rew['target'], $rew['redirect']);
        return;
    }

    // Rewrite
    if ($rew) {
        $url = $rew['target'];
    } elseif ($page = ent\one('page', [['url', $url]], ['select' => ['id', 'ent']])) {
        $url = '/' . $page['ent'] . '/view/' . $page['id'];
    }

    // Gather request-data
    $parts = explode('/', trim($url, '/'));
    $data['ent'] = array_shift($parts);
    $ent = cfg('ent', $data['ent']);
    $data['act'] = array_shift($parts);
    $data['id'] = array_shift($parts);
    $data['area'] = empty(cfg('priv', $data['ent'] . '/' . $data['act'])['active']) ? APP['area.public'] : APP['area.admin'];
    $data['parent'] = $ent['parent'] ?? null;
    $allowed = allowed($data['ent'] . '/' . $data['act']);
    $real = is_callable('act\\' . $data['ent'] . '_' . $data['act']) ? 'act\\' . $data['ent'] . '_' . $data['act'] : null;

    // Dispatch request
    if ($allowed && !$ent && $real) {
        $real();
    } elseif (!$allowed || !$ent || !in_array($data['act'], $ent['act'])) {
        act\app_error();
    } elseif ($real) {
        $real($ent);
    } elseif ($ent['parent'] && is_callable('act\\' . $ent['parent'] . '_' . $data['act'])) {
        ('act\\' . $ent['parent'] . '_' . $data['act'])($ent);
    } elseif (is_callable('act\\' . $data['act'])) {
        ('act\\' . $data['act'])($ent);
    }
}

/**
 * Internal registry
 */
function & reg(string $id): ?array
{
    static $data = [];

    if (!array_key_exists($id, $data)) {
        $data[$id] = null;
    }

    return $data[$id];
}

/**
 * Returns app data
 *
 * @return mixed
 */
function get(string $id)
{
    return reg('app')[$id] ?? null;
}

/**
 * Loads and returns configuration data
 *
 * @note Config data must be cacheable, you must not do any dynamic/request-dependant stuff here
 *
 * @return mixed
 */
function cfg(string $id, string $key = null)
{
    if (($data = & reg('cfg.' . $id)) === null) {
        $data = load($id);
        $data = event(['cfg.' . $id], $data);
    }

    if ($key === null) {
        return $data;
    }

    return $data[$key] ?? null;
}

/**
 * Loads configuration data with or without overwrites
 */
function load(string $id): array
{
    $data = [];

    foreach ([path('cfg', $id . '.php'), path('ext.cfg', $id . '.php')] as $file) {
        if (is_readable($file)) {
            $data = array_replace_recursive($data, include $file);
        }
    }

    return $data;
}

/**
 * Dispatches multiple events with the the same event data
 */
function event(array $events, array $data): array
{
    foreach ($events as $event) {
        if (($cfg = cfg('event', $event)) && asort($cfg, SORT_NUMERIC)) {
            foreach (array_keys($cfg) as $call) {
                $data = $call($data);
            }
        }
    }

    return $data;
}

/**
 * Check access
 */
function allowed(string $key): bool
{
    if (!$cfg = cfg('priv', $key)) {
        return false;
    }

    return !$cfg['active'] || $cfg['priv'] && allowed($cfg['priv']) || account\get('admin') || in_array($key, account\get('priv'));
}

/**
 * Translate
 */
function i18n(string $key, string ...$args): string
{
    $key = cfg('i18n', $key) ?? $key;

    return $args ? vsprintf($key, $args) : $key;
}

/**
 * Message
 */
function msg(string $msg = null, string ...$args): array
{
    if (($data = & reg('msg')) === null) {
        $data = session\get('msg') ?: [];
        session\set('msg', null);
    }

    if ($msg === null) {
        $old = $data;
        $data = [];

        return $old;
    }

    if ($msg && ($msg = i18n($msg, ...$args)) && !in_array($msg, $data)) {
        $data[] = $msg;
    }

    return $data;
}

/**
 * Logger
 */
function log(Throwable $e): void
{
    file_put_contents(APP['log'], '[' . date('r') . '] ' . $e . "\n\n", FILE_APPEND);
}

/**
 * Gets absolute path to specified subpath in given directory
 *
 * @throws DomainException
 */
function path(string $dir, string $id = null): string
{
    if (empty(APP['path'][$dir])) {
        throw new DomainException(i18n('Invalid path %s', $dir));
    }

    return APP['path'][$dir] . ($id && ($id = trim($id, '/')) ? '/' . $id : '');
}

/**
 * Template path
 */
function tpl(string $id): string
{
    $ext = path('ext.tpl', $id);

    return is_file($ext) ? $ext : path('tpl', $id);
}

/**
 * Gets or adds layout block
 *
 * @throws DomainException
 */
function layout(string $id = null, array $§ = null): array
{
    if (($data = & reg('layout')) === null) {
        $data = [];
        $data = event(['layout'], $data);
    }

    if ($id === null) {
        return $data;
    }

    if (empty($data[$id])) {
        if (empty($§['type']) || !($type = cfg('block', $§['type']))) {
            throw new DomainException(i18n('Invalid block %s', $id));
        }

        $data[$id] = arr\replace(APP['block'], $type, $§, ['id' => $id]);
    } elseif ($§) {
        $data[$id] = array_replace_recursive($data[$id], $§);
    }

    return $data[$id];
}

/**
 * Render block
 */
function §(string $id): string
{
    $§ = layout($id);

    if (!$§['active'] || $§['priv'] && !allowed($§['priv'])) {
        return '';
    }

    $§ = event(['block.' . $§['type'], 'layout.' . $id], $§);
    $type = cfg('block', $§['type']);

    if (isset($type['vars'])) {
        $§['vars'] = arr\replace($type['vars'], $§['vars'] ?? []);
    }

    return $type['call']($§);
}

/**
 * Converts special chars to HTML entities
 */
function enc(string $val): string
{
    return htmlspecialchars($val, ENT_QUOTES, ini_get('default_charset'), false);
}

/**
 * Generates URL by given path and params, optionally preserves existing params
 */
function url(string $path = '', array $param = [], bool $preserve = false): string
{
    $param = array_filter($preserve ? array_replace(req\get('param'), $param) : $param, 'is_scalar');

    return '/' . trim($path, '/') . ($param ? '?' . http_build_query($param, '', '&amp;') : '');
}

/**
 * GUI URL
 *
 * @see location /gui in nginx.conf for fallback paths
 */
function gui(string $path): string
{
    return APP['url.gui'] . get('gui') . '/' . trim($path, '/');
}

/**
 * Redirect
 */
function redirect(string $url = '/', int $code = null): void
{
    if ($code && !empty(cfg('opt', 'redirect')[$code])) {
        header('Location: ' . $url, true, $code);
    } else {
        header('Location: ' . $url);
    }

    exit;
}
