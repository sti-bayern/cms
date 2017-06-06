<?php
declare(strict_types = 1);

namespace cms;

use RuntimeException;

/**
 * App data listener
 *
 * @param array $data
 *
 * @return array
 */
function listener_data_app(array $data): array
{
    ini_set('default_charset', $data['charset']);
    ini_set('intl.default_locale', $data['locale']);
    ini_set('date.timezone', $data['timezone']);

    return $data;
}

/**
 * Entity data listener
 *
 * @param array $data
 *
 * @return array
 */
function listener_data_entity(array $data): array
{
    $defEnt = $data['default'];
    unset($data['default']);
    $model = data('model');
    $cfg = data('attr');

    foreach ($data as $eId => $entity) {
        if (empty($entity['name']) || empty($entity['attr'])) {
            throw new RuntimeException(_('Invalid entity configuration'));
        }

        $entity = array_replace($defEnt, $entity);

        if (empty($model[$entity['model']])) {
            throw new RuntimeException(_('Invalid entity configuration'));
        }

        $entity['model'] = ['id' => $entity['model']] + $model[$entity['model']];
        $entity['id'] = $eId;
        $entity['name'] = _($entity['name']);
        $entity['tab'] = $entity['tab'] ?: $entity['id'];
        $sort = 0;

        foreach ($entity['attr'] as $id => $attr) {
            if (empty($attr['name']) || empty($attr['type']) || !($type = $cfg['type'][$attr['type']] ?? null)) {
                throw new RuntimeException(_('Invalid attribute configuration'));
            }

            $backend = $cfg['backend'][$attr['backend'] ?? $type['backend']];
            $frontend = $cfg['frontend'][$attr['frontend'] ?? $type['frontend']];
            $attr = array_replace($cfg['default'], $backend, $frontend, $type, $attr);
            $attr['id'] = $id;
            $attr['name'] = _($attr['name']);
            $attr['entity'] = $entity['id'];

            if ($attr['col'] === false) {
                $attr['col'] = null;
            } elseif (!$attr['col']) {
                $attr['col'] = $attr['id'];
            }

            if (!is_numeric($attr['sort'])) {
                $attr['sort'] = $sort;
                $sort += 100;
            }

            $entity['attr'][$id] = $attr;
        }

        $entity['attr'] = arr_order($entity['attr'], ['sort' => 'asc']);
        $data[$eId] = $entity;
    }

    return $data;
}

/**
 * I18n data listener
 *
 * @param array $data
 *
 * @return array
 */
function listener_data_i18n(array $data): array
{
    return $data + data('i18n.' . data('app', 'lang'));
}

/**
 * Privilege data listener
 *
 * @param array $data
 *
 * @return array
 */
function listener_data_privilege(array $data): array
{
    foreach ($data as $id => $item) {
        $data[$id]['name'] = !empty($item['name']) ? _($item['name']) : '';
    }

    foreach (data('entity') as $eId => $entity) {
        foreach ($entity['actions'] as $act) {
            $data[$eId . '/' . $act]['name'] = $entity['name'] . ' ' . _(ucwords($act));
            $data[$eId . '/' . $act]['global'] = empty($entity['attr']['project_id']);
        }
    }

    return arr_order($data, ['sort' => 'asc', 'name' => 'asc']);
}

/**
 * Section data listener
 *
 * @param array $data
 *
 * @return array
 */
function listener_data_section(array $data): array
{
    $default = $data['default'];
    unset($data['default']);

    foreach ($data as $id => $item) {
        $data[$id] = array_replace($default, $item);
    }

    return $data;
}

/**
 * Toolbar data listener
 *
 * @param array $data
 *
 * @return array
 */
function listener_data_toolbar(array $data): array
{
    foreach ($data as $key => $item) {
        if (allowed_url($item['url'])) {
            $data[$key]['name'] = _($item['name']);
        } else {
            unset($data[$key]);
        }
    }

    return $data;
}

/**
 * Project post-delete listener
 *
 * @param array $data
 *
 * @return array
 */
function listener_project_postdelete(array $data): array
{
    $asset = path('asset', (string) $data['id']);

    if (!file_delete($asset)) {
        message(_('Could not delete directory %s', $asset));
    }

    return $data;
}

/**
 * Page pre-save listener
 *
 * @param array $data
 *
 * @return array
 */
function listener_page_presave(array $data): array
{
    if ($data['name'] !== ($data['_old']['name'] ?? null)) {
        $base = filter_id($data['name']);
        $data['url'] = url($base . URL['page']);

        for ($i = 1; one('page', [['url', $data['url']], ['project_id', $data['project_id']]]); $i++) {
            $data['url'] = url($base . '-' . $i . URL['page']);
        }
    }

    return $data;
}
