<?php
namespace qnd;

/**
 * App data listener
 *
 * @param array $data
 *
 * @return void
 */
function listener_data_app(array & $data): void
{
    // Configure PHP
    ini_set('default_charset', $data['charset']);
    ini_set('intl.default_locale', $data['locale']);
    ini_set('date.timezone', $data['timezone']);
}

/**
 * Entity data listener
 *
 * @param array $data
 *
 * @return void
 */
function listener_data_entity(array & $data): void
{
    foreach ($data as $eId => $item) {
        $item['id'] = $eId;
        $item = data_entity($item);
        $item['attr'] = data_order($item['attr'], ['sort' => 'asc']);
        $data[$eId] = $item;
    }

    if (!$entities = all('entity', ['project_id' => project('ids')])) {
        return;
    }

    $attrs = all('attr', ['project_id' => project('ids')], ['index' => ['entity_id', 'uid']]);

    foreach ($entities as $id => $item) {
        $eId = $item['uid'];

        // @todo Define custom validator for entity UID and EAV attr UID
        if (!empty($data[$eId])) {
            message(_('Can not use reserved UID %s for Entity %s', $eId, $item['name']));
            continue;
        }

        $item = array_replace($data['content'], $item, ['id' => $eId, 'eav_id' => $id, 'model' => 'eav']);

        if (!empty($attrs[$id])) {
            foreach ($attrs[$id] as $uid => $attr) {
                if (empty($item['attr'][$uid])) {
                    $attr['eav_id'] = $attr['id'];
                    unset($attr['id'], $attr['uid'], $attr['project_id']);
                    $item['attr'][$uid] = $attr;
                }
            }
        }

        unset($item['uid'], $item['project_id']);
        $item = data_entity($item);
        $item['attr'] = data_order($item['attr'], ['sort' => 'asc']);
        $data[$eId] = $item;
    }
}

/**
 * Privilege data listener
 *
 * @param array $data
 *
 * @return void
 */
function listener_data_privilege(array & $data): void
{
    foreach ($data as $id => $item) {
        if (!empty($item['callback'])) {
            $data[$id]['callback'] = fqn($item['callback']);
        }
    }

    foreach (data('entity') as $eId => $entity) {
        foreach ($entity['actions'] as $action) {
            $data[$eId . '.' . $action] = [
                'name' => $entity['name'] . ' ' . ucwords($action),
                'active' => true,
            ];
        }
    }

    $data = data_order($data, ['sort' => 'asc', 'name' => 'asc']);
}

/**
 * Request data listener
 *
 * @param array $data
 *
 * @return void
 */
function listener_data_request(array & $data): void
{
    $data['host'] = $_SERVER['HTTP_X_FORWARDED_HOST'] ?? $_SERVER['HTTP_HOST'];

    if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https'
        || !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'
    ) {
        $data['scheme'] = 'https';
    } else {
        $data['scheme'] = 'http';
    }

    $data['secure'] = $data['scheme'] === 'https';
    $data['get'] = http_filter($_GET);
    $data['post'] = !empty($_POST['token']) && http_post_validate($_POST['token']) ? $_POST : [];
    $data['files'] = $_FILES ? http_files_convert($_FILES) : [];
    $url = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    $data['url'] = preg_replace('#^' . $_SERVER['SCRIPT_NAME'] . '#', '', $url);
    $data['path'] = url_rewrite($data['url'], true);
    $parts = explode('/', trim($data['path'], '/'));
    $data['entity'] = $parts[0] ?? $data['entity'];
    $data['action'] = $parts[1] ?? $data['action'];
    $data['id'] = $parts[2] ?? $data['id'];
}

/**
 * Toolbar data listener
 *
 * @param array $data
 *
 * @return void
 */
function listener_data_toolbar(array & $data): void
{
    $entities = array_filter(
        data('entity'),
        function ($item) {
            return !empty($item['eav_id']);
        }
    );
    foreach ($entities as $entity) {
        if (in_array('admin', $entity['actions']) && allowed($entity['id'] . '.admin')) {
            $data['content']['children'][] = ['name' => $entity['name'], 'url' => url($entity['id'] . '/admin')];
        }
    }

    $filter = function (array $item) use (& $filter) {
        $item['children'] = !empty($item['children']) ? array_filter($item['children'], $filter) : [];

        return !$item['url'] && $item['children'] || $item['url'] && allowed(privilege_url($item['url']));
    };
    $data = array_filter($data, $filter);
}

/**
 * Save listener
 *
 * @param array $data
 *
 * @return void
 */
function listener_save(array & $data): void
{
    if ($data['_entity']['id'] === 'url' || !in_array('view', $data['_entity']['actions'])) {
        return;
    }

    $target = sprintf('%s%s/view/%s', url(), $data['_entity']['id'], $data['id']);
    $old = one('url', ['target' => $target, 'system' => true]);
    $id = $old['id'] ?? -1;
    $all = all('url', [], ['index' => ['name']]);
    $name = filter_url($data['name'], array_column($all, 'name', 'id'), $id);
    $url = [$id => ['name' => $name, 'target' => $target, 'system' => true]];
    save('url', $url);
}

/**
 * Delete listener
 *
 * @param array $data
 *
 * @return void
 */
function listener_delete(array & $data): void
{
    delete('url', ['target' => sprintf('%s%s/view/%s', url(), $data['_entity']['id'], $data['id'])], ['system' => true]);
}


/**
 * EAV save listener
 *
 * @param array $data
 *
 * @return void
 */
function listener_eav_save(array & $data): void
{
    $data['search'] = '';

    foreach ($data['_entity']['attr'] as $a) {
        if ($a['searchable']) {
            $data['search'] .= ' ' . str_replace("\n", ' ', strip_tags($data[$a['id']]));
        }
    }
}

/**
 * Entity save listener
 *
 * @param array $data
 *
 * @return void
 */
function listener_entity_save(array & $data): void
{
    if (empty($data['_old'])) {
        return;
    }

    $base = url();
    $crit = ['target' => sprintf('%s%s/view/', $base, $data['_old']['id'])];

    if (!in_array('view', $data['actions'])) {
        delete('url', $crit, ['search' => ['name'], 'system' => true]);
    } elseif ($data['id'] !== $data['_old']['id'] && ($url = all('url', $crit, ['search' => ['name']]))) {
        foreach ($url as $id => $u) {
            $from = sprintf('#^%s%s/#', $base, $data['_old']['id']);
            $to = sprintf('%s%s/', $base, $data['id']);
            $url[$id]['target'] = preg_replace($from, $to, $u['target']);
        }

        save('url', $url);
    }
}

/**
 * Entity delete listener
 *
 * @param array $data
 *
 * @return void
 */
function listener_entity_delete(array & $data): void
{
    delete('url', ['target' => sprintf('%s%s/view/', url(), $data['id'])], ['search' => ['name'], 'system' => true]);
}

/**
 * Project save listener
 *
 * @param array $data
 *
 * @return void
 */
function listener_project_save(array & $data): void
{
    if (empty($data['_old']['id']) || $data['id'] === $data['_old']['id']) {
        return;
    }

    $old = path('asset', $data['_old']['id']);
    $new = path('asset', $data['id']);

    if (file_exists($old) && !rename($old, $new)) {
        message(_('Could not move directory %s to %s', $old, $new));
    }
}

/**
 * Project save listener
 *
 * @param array $data
 *
 * @return void
 */
function listener_project_delete(array & $data): void
{
    if (!file_delete(path('asset', $data['id']))) {
        message(_('Could not delete directory %s', path('asset', $data['id'])));
    }
}
