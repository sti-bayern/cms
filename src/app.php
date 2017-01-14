<?php
namespace qnd;

use InvalidArgumentException;

/**
 * Runs application
 *
 * @return void
 */
function app(): void
{
    // Dispatch request
    $prefix = fqn('action_');
    $action = request('action');
    $eUid = request('entity');
    $entity = data('entity', $eUid);
    $args = $entity ? [$entity] : [];

    foreach ([$prefix . $eUid . '_' . $action, $prefix . $action] as $call) {
        if (is_callable($call)) {
            allowed() ? $call(...$args) : action_denied();
            return;
        }
    }

    action_error();
}

/**
 * Internal registry
 *
 * @param string $id
 *
 * @return array|null
 */
function & registry(string $id): ?array
{
    static $data = [];

    if ($id === null) {
        $old = $data;
        $data = [];

        return $old;
    }

    if (!array_key_exists($id, $data)) {
        $data[$id] = null;
    }

    return $data[$id];
}

/**
 * Gets absolute path to specified subpath in given directory
 *
 * @param string $dir
 * @param string $id
 *
 * @return string
 *
 * @throws InvalidArgumentException
 */
function path(string $dir, string $id = null): string
{
    $data = & registry('path');

    if ($data === null) {
        $data = [];
        $root = realpath(__DIR__ . '/..');
        $public = realpath(dirname($_SERVER['SCRIPT_FILENAME']));
        $data['asset'] = $public . '/asset';
        $data['data'] = $root . '/data';
        $data['lib'] = $public . '/lib';
        $data['log'] = $root . '/log';
        $data['template'] = $root . '/template';
        $data['theme'] = $public . '/theme';
        $data['tmp'] = sys_get_temp_dir();
    }

    if (empty($data[$dir])) {
        throw new InvalidArgumentException(_('Invalid path %s', $dir));
    }

    $id = trim($id, '/');

    return $data[$dir] . ($id ? '/' . $id : '');
}

/**
 * Dispatches one or multiple events
 *
 * Calls all listeners for given event until one listener returns true
 *
 * @param string|array $event
 * @param array $data
 *
 * @return void
 */
function event($event, array & $data): void
{
    foreach ((array) $event as $id) {
        foreach (listener($id) as $listener) {
            if (is_callable($listener) && $listener($data)) {
                break;
            }
        }
    }
}

/**
 * Retrieve listeners for specified event
 *
 * @param string $event
 *
 * @return array
 */
function listener(string $event): array
{
    $data = & registry('listener');

    if ($data === null) {
        $data = [];

        foreach (data_order(data('listener'), ['sort' => 'asc']) as $listener) {
            $data[$listener['event']][] = fqn('listener_' . $listener['id']);
        }
    }

    return $data[$event] ?? [];
}

/**
 * Translate
 *
 * @param string $key
 * @param string[] ...$params
 *
 * @return string
 */
function _(string $key, string ...$params): string
{
    if (!$key) {
        return '';
    }

    $key = data('i18n.' . data('app', 'lang'), $key) ?? $key;

    if (!$params) {
        return $key;
    }

    return vsprintf($key, $params) ?: $key;
}

/**
 * Returns fully qualified name
 *
 * @param string $name
 *
 * @return string
 */
function fqn(string $name): string
{
    return strpos($name, '\\') === false ? __NAMESPACE__ . '\\' . $name : $name;
}
