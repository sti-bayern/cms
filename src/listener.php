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
        $ent = arr\replace(APP['ent'], $ent, ['id' => $eId]);
        $ent['name'] = app\i18n((string) $ent['name']);
        $p = $ent['parent'] && !empty($data[$ent['parent']]) ? $data[$ent['parent']] : null;
        $a = ['id' => null, 'name' => null];

        if (!$ent['name'] || !$ent['type'] || !$ent['parent'] && array_intersect_key($a, $ent['attr']) !== $a || $ent['parent'] && (!$p || $p['parent'])) {
            throw new DomainException(app\i18n('Invalid configuration'));
        } elseif ($ent['parent']) {
            $ent['attr'] = $p['attr'] + $ent['attr'];
        }

        foreach ($ent['attr'] as $aId => $attr) {
            if (empty($attr['name']) || empty($attr['type']) || empty($cfg[$attr['type']]) || $attr['type'] === 'ent' && empty($attr['ent'])) {
                throw new DomainException(app\i18n('Invalid configuration'));
            }

            $attr = arr\replace(APP['attr'], $cfg[$attr['type']], $attr, ['id' => $aId, 'name' => app\i18n($attr['name'])]);

            if (!in_array($attr['backend'], APP['backend'])) {
                throw new DomainException(app\i18n('Invalid configuration'));
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
    return $data + app\load('i18n/' . locale_get_primary_language(''));
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

    foreach (app\cfg('ent') as $ent) {
        if (!empty($ent['act']['edit']) && in_array('page', [$ent['id'], $ent['parent']])) {
            $id = $ent['id'] . '-publish';
            $data[$id]['name'] = $ent['name'] . ' ' . app\i18n(ucwords('Publish'));
            $data[$id] = arr\replace(APP['priv'], $data[$id]);
        }

        foreach (array_keys($ent['act']) as $act) {
            $id = $ent['id'] . '/' . $act;
            $data[$id]['name'] = $ent['name'] . ' ' . app\i18n(ucwords($act));
            $data[$id] = arr\replace(APP['priv'], $data[$id]);
        }
    }

    return $data;
}

/**
 * Toolbar config listener
 *
 * @throws DomainException
 */
function cfg_toolbar(array $data): array
{
    foreach ($data as $act => $item) {
        if (empty($item['name'])) {
            throw new DomainException(app\i18n('Invalid configuration'));
        }

        $data[$act] = arr\replace(APP['toolbar'], $item, ['name' => app\i18n($item['name']), 'url' => app\url($act)]);
    }

    return arr\order($data, ['sort' => 'asc']);
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
 * Page entity postfilter listener
 */
function ent_postfilter_page(array $data): array
{
    $oldId = $data['_old']['id'] ?? null;
    $parent = !empty($data['parent']) ? ent\one('page', [['id', $data['parent']]]) : null;

    if ($parent && $oldId && in_array($oldId, $parent['path'])) {
        $data['_error']['parent'] = app\i18n('Cannot assign the page itself or a child page as parent');
    }

    if (!empty($data['slug'])) {
        $data['url'] = ($parent ? $parent['url'] : '') . '/' . $data['slug'];
        $crit = $oldId ? [['url', $data['url']], ['id', $oldId, APP['crit']['!=']]] : [['url', $data['url']]];

        if (ent\size('page', $crit)) {
            $data['_error']['slug'] = app\i18n('Slug already used with selected parent');
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
 * Page entity postsave listener
 */
function ent_postsave_page(array $data): array
{
    if (!empty($data['_old']['url']) && !empty($data['url']) && $data['_old']['url'] !== $data['url']) {
        // Position is potentially not set or has changed within transaction
        $d = ent\one('page', [['id', $data['_old']['id']]]);
        $sub = ent\all('page', [['pos', $d['pos'] . '.', APP['crit']['~^']]], ['order' => ['pos' => 'asc']]);

        foreach ($sub as $s) {
            if (!ent\save('page', $s)) {
                throw new DomainException(app\i18n('Could not update URLs of subpages'));
            }
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
 * File entity presave listener
 */
function ent_presave_file(array $data): array
{
    $file = http\req('file')['name'] ?? null;

    if ($file) {
        $data['size'] = $file['size'];
    }

    return $data;
}
