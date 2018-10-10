<?php
declare(strict_types = 1);

namespace viewer;

use app;
use entity;
use html;

/**
 * URL viewer
 */
function url(array $attr, string $val): string
{
    return html\tag('a', ['href' => $val] + $attr['html'], $val);
}

/**
 * Datetime viewer
 */
function datetime(array $attr, string $val): string
{
    return date_format(date_create($val), $attr['cfg.viewer']);
}

/**
 * Rich text viewer
 */
function rte(array $attr, string $val): string
{
    return $val;
}

/**
 * JSON viewer
 */
function json(array $attr, array $val): string
{
    return html\tag('pre', $attr['html'], app\enc(print_r($val, true)));
}

/**
 * Position viewer
 */
function pos(array $attr, string $val): string
{
    $parts = explode('.', $val);

    foreach ($parts as $k => $v) {
        $parts[$k] = ltrim($v, '0');
    }

    return implode('.', $parts);
}

/**
 * Option viewer
 */
function opt(array $attr, $val): string
{
    if (!is_array($val)) {
        $val = $val === null && $val === '' ? [] : [$val];
    }

    $out = '';

    foreach ($val as $v) {
        if (isset($attr['opt'][$v])) {
            $out .= ($out ? ', ' : '') . $attr['opt'][$v];
        }
    }

    return $out;
}

/**
 * Ent viewer
 */
function entity(array $attr, int $val): string
{
    return $val ? entity\one($attr['ref'], [['id', $val]], ['select' => ['id', 'name']])['name'] : '';
}

/**
 * Page viewer
 */
function page(array $attr, int $val): string
{
    if (!$val) {
        return '';
    }

    $page = entity\one($attr['ref'], [['id', $val]], ['select' => ['id', 'name', 'menu_name']]);

    return $page['menu_name'] ?: $page['name'];
}

/**
 * File viewer
 */
function file(array $attr, int $val): string
{
    if (!$val) {
        return '';
    }

    $file = entity\one($attr['ref'], [['id', $val]], ['select' => ['id', 'name', 'type', 'info']]);

    if ((APP['file'][$file['type']] ?? null) === 'img') {
        $attr['html']['alt'] = app\enc($file['info']);
    }

    return upload($attr, $file['name']);
}

/**
 * Upload viewer
 */
function upload(array $attr, string $val): string
{
    $tag = APP['file'][pathinfo($val, PATHINFO_EXTENSION)] ?? 'a';

    if ($tag === 'img') {
        return html\tag('img', ['src' => $val] + $attr['html'], null, true);
    }

    if (in_array($tag, ['audio', 'video'])) {
        return html\tag($tag, ['src' => $val, 'controls' => true] + $attr['html']);
    }

    return html\tag('a', ['href' => $val] + $attr['html'], $val);
}
