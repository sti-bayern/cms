<?php
declare(strict_types = 1);

namespace listener;

use app;
use arr;
use ent;
use file;
use http;
use DomainException;

/**
 * Entity config listener
 *
 * @throws DomainException
 */
function cfg_ent(array $data): array
{
    $cfg = app\cfg('attr');

    foreach ($data as $eId => $ent) {
        $ent = arr\replace(APP['ent'], $ent);

        if (!$ent['name'] || !$ent['type'] || empty($ent['attr']['id']) || empty($ent['attr']['name'])) {
            throw new DomainException(app\i18n('Invalid entity configuration'));
        }

        $ent['id'] = $eId;
        $ent['name'] = app\i18n($ent['name']);
        $ent['tab'] = $ent['tab'] ?: $ent['id'];

        foreach ($ent['attr'] as $aId => $attr) {
            if (empty($attr['name']) || empty($attr['type']) || empty($cfg[$attr['type']]) || $attr['type'] === 'ent' && empty($attr['opt'])) {
                throw new DomainException(app\i18n('Invalid attribute configuration'));
            }

            if ($attr['type'] === 'ent') {
                $attr['backend'] = $attr['opt'] === $eId ? $ent['attr']['id']['backend'] : $data[$attr['opt']]['attr']['id']['backend'];
            }

            $attr = arr\replace(APP['attr'], $cfg[$attr['type']], $attr);

            if (!in_array($attr['backend'], APP['backend'])) {
                throw new DomainException(app\i18n('Invalid attribute configuration'));
            }

            $attr['id'] = $aId;
            $attr['name'] = app\i18n($attr['name']);

            if ($attr['col'] === false) {
                $attr['col'] = null;
            } elseif (!$attr['col']) {
                $attr['col'] = $attr['id'];
            }

            $ent['attr'][$aId] = $attr;
        }

        $data[$eId] = $ent;
    }

    return $data;
}

/**
 * I18n config listener
 */
function cfg_i18n(array $data): array
{
    return $data + app\cfg('i18n/' . locale_get_primary_language(''));
}

/**
 * Layout config listener
 */
function cfg_layout(array $data): array
{
    $code = http_response_code();

    if ($code === 403) {
        $cfg = [app\cfg('layout/app/denied')];
    } elseif ($code === 404) {
        $cfg = [app\cfg('layout/app/error')];
    } else {
        $cfg = [app\cfg('layout/' . http\req('act')), app\cfg('layout/' . http\req('path'))];
    }

    $data = array_replace_recursive($data, ...$cfg);

    foreach ($data as $id => $§) {
        $data[$id] = arr\replace(APP['section'], $§, ['id' => $id]);
    }

    return $data;
}

/**
 * Privilege config listener
 */
function cfg_priv(array $data): array
{
    foreach ($data as $id => $item) {
        $item = arr\replace(APP['priv'], $item);
        $item['name'] = $item['name'] ? app\i18n($item['name']) : '';
        $item['assignable'] = !$item['priv'] && $item['active'] && $item['assignable'];
        $data[$id] = $item;
    }

    foreach (app\cfg('ent') as $eId => $ent) {
        foreach (array_keys($ent['act']) as $act) {
            $id = $eId . '/' . $act;
            $data[$id]['name'] = $ent['name'] . ' ' . app\i18n(ucwords($act));
            $data[$id] = arr\replace(APP['priv'], $data[$id]);
        }
    }

    return arr\order($data, ['sort' => 'asc', 'name' => 'asc']);
}

/**
 * Toolbar config listener
 */
function cfg_toolbar(array $data): array
{
    foreach ($data as $key => $item) {
        if (app\allowed_url($item['url'])) {
            $data[$key]['name'] = app\i18n($item['name']);
        } else {
            unset($data[$key]);
        }
    }

    return $data;
}

/**
 * Entity prefilter listener
 */
function ent_prefilter(array $data): array
{
    $attrs = $data['_ent']['attr'];

    foreach (array_intersect_key($data, $data['_ent']['attr']) as $aId => $val) {
        if ($attrs[$aId]['type'] === 'file' && $val) {
            $data[$aId] = $data['_ent']['id'] . '/' . $val;
        }
    }

    return $data;
}

/**
 * Entity postfilter listener
 */
function ent_postfilter(array $data): array
{
    $attrs = $data['_ent']['attr'];

    foreach (array_intersect_key($data, $data['_ent']['attr']) as $aId => $val) {
        if ($attrs[$aId]['type'] === 'password' && $val && !($data[$aId] = password_hash($val, PASSWORD_DEFAULT))) {
            $data['_error'][$aId] = app\i18n('Invalid password');
        }
    }

    return $data;
}

/**
 * Entity postsave listener
 *
 * @throws DomainException
 */
function ent_postsave(array $data): array
{
    $file = http\req('file');
    $attrs = $data['_ent']['attr'];

    foreach (array_intersect_key($data, $data['_ent']['attr']) as $aId => $val) {
        if ($attrs[$aId]['type'] === 'file' && $val && !file\upload($file[$aId]['tmp_name'], app\path('asset', $val))) {
            throw new DomainException(app\i18n('File upload failed for %s', $val));
        }
    }

    return $data;
}

/**
 * Entity postdelete listener
 *
 * @throws DomainException
 */
function ent_postdelete(array $data): array
{
    $attrs = $data['_ent']['attr'];

    foreach (array_intersect_key($data, $data['_ent']['attr']) as $aId => $val) {
        if ($attrs[$aId]['type'] === 'file' && $val && !file\delete(app\path('asset', $val))) {
            throw new DomainException(app\i18n('Could not delete %s', $val));
        }
    }

    return $data;
}

/**
 * File presave listener
 */
function file_presave(array $data): array
{
    $file = http\req('file')['name']['tmp_name'] ?? null;

    if ($file) {
        $data['size'] = filesize($file);
    }

    return $data;
}

/**
 * Page postfilter listener
 */
function page_postfilter(array $data): array
{
    $oldId = $data['_old']['id'] ?? null;

    if (!empty($data['parent_id']) && $oldId && in_array($oldId, ent\one('page', [['id', $data['parent_id']]])['path'])) {
        $data['_error']['parent_id'] = app\i18n('Cannot assign the page itself or a child page as parent');
    }

    return $data;
}
