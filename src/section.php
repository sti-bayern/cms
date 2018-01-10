<?php
declare(strict_types = 1);

namespace section;

use app;
use arr;
use ent;
use html;
use http;
use session;

/**
 * Container section
 */
function container(array $§): string
{
    $§['vars'] = arr\replace(['tag' => null], $§['vars']);
    $html = '';

    foreach (arr\order(arr\crit(app\layout(), [['parent_id', $§['id']]]), ['sort' => 'asc']) as $child) {
        $html .= app\§($child['id']);
    }

    return $§['vars']['tag'] ? html\tag($§['vars']['tag'], ['id' => $§['id']], $html) : $html;
}

/**
 * Entity section
 */
function ent(array $§): string
{
    $§['vars'] = arr\replace(['attr' => [], 'crit' => [], 'eId' => null, 'opt' => [], 'title' => null], $§['vars']);

    if (!$§['vars']['eId'] || !($§['vars']['ent'] = app\cfg('ent', $§['vars']['eId']))) {
        return '';
    }

    $§['vars']['data'] = ent\one($§['vars']['eId'], $§['vars']['crit'], $§['vars']['opt']);
    unset($§['vars']['crit'], $§['vars']['eId'], $§['vars']['opt']);

    return tpl($§);
}

/**
 * Index section
 */
function index(array $§): string
{
    $§['vars'] = arr\replace(['attr' => [], 'crit' => [], 'eId' => null, 'opt' => [], 'param' => [], 'title' => null], $§['vars']);

    if (!$§['vars']['eId'] || !($§['vars']['ent'] = app\cfg('ent', $§['vars']['eId']))) {
        return '';
    }

    $§['vars']['opt']['limit'] = app\cfg('app', 'limit');
    $§['vars']['data'] = ent\all($§['vars']['eId'], $§['vars']['crit'], $§['vars']['opt']);
    // Pager
    $§['vars']['size'] = ent\size($§['vars']['eId'], $§['vars']['crit']);
    $§['vars']['limit'] = $§['vars']['opt']['limit'];
    $cur = max($§['vars']['param']['cur'] ?? 0, 1);
    $pages = (int) ceil($§['vars']['size'] / $§['vars']['limit']);
    $§['vars']['offset'] = ($cur - 1) * $§['vars']['limit'];
    $cfg = app\cfg('app', 'pager');
    $min = max(1, min($cur - intdiv($cfg, 2), $pages - $cfg + 1));
    $max = min($min + $cfg - 1, $pages);
    $§['vars']['pager'] = [];

    if ($cur >= 2) {
        $§['vars']['pager'][] = ['name' => app\i18n('Previous'), 'param' => ['cur' => $cur - 1] + $§['vars']['param']];
    }

    for ($i = $min; $min < $max && $i <= $max; $i++) {
        $§['vars']['pager'][] = ['name' => $i, 'param' => ['cur' => $i] + $§['vars']['param'], 'active' => $i === $cur];
    }

    if ($cur < $pages) {
        $§['vars']['pager'][] = ['name' => app\i18n('Next'), 'param' => ['cur' => $cur + 1] + $§['vars']['param']];
    }

    unset($§['vars']['crit'], $§['vars']['eId'], $§['vars']['opt']);

    return tpl($§);
}

/**
 * Menu section
 */
function menu(array $§): string
{
    $§['vars'] = arr\replace(['mode' => null], $§['vars']);
    $id = http\req('id');
    $cur = http\req('ent') === 'page' && $id ? ent\one('page', [['id', $id], ['status', 'published']]) : null;
    $anc = $cur && count($cur['path']) > 1 ? ent\one('page', [['id', $cur['path'][0]], ['status', 'published']]) : $cur;
    $crit = [['status', 'published']];
    $opt = ['select' => ['id', 'name', 'url', 'parent_id', 'level', 'path'], 'order' => ['pos' => 'asc']];

    if ($§['vars']['mode'] === 'sub') {
        if (!$anc) {
            return '';
        }

        $crit[] = ['parent_id', null, APP['crit']['!=']];
        $crit[] = [['id', $cur['path']], ['parent_id', [$anc['id'], $cur['id'], $cur['parent_id']]]];
    } elseif ($§['vars']['mode'] === 'top') {
        $cur = $anc;
        $crit[] = ['parent_id', null];
    }

    if (!$menu = ent\all('page', $crit, $opt)) {
        return '';
    }

    $count = count($menu);
    $level = 0;
    $i = 0;
    $html = '';

    foreach ($menu as $item) {
        if ($item['parent_id'] && ($§['vars']['mode'] !== 'sub' || $item['parent_id'] !== $anc['id']) && empty($menu[$item['parent_id']])) {
            continue;
        }

        $a = ['href' => $item['url']];
        $class = '';

        if ($cur && $cur['id'] === $item['id']) {
            $a['class'] = 'active';
            $class .= ' class="active"';
        }

        if ($item['level'] > $level) {
             $html .= '<ul><li' . $class . '>';
        } elseif ($item['level'] < $level) {
             $html .= '</li>' . str_repeat('</ul></li>', $level - $item['level']) . '<li' . $class . '>';
        } else {
             $html .= '</li><li' . $class . '>';
        }

        $html .= html\tag('a', $a, $item['name']);
        $html .= ++$i === $count ? str_repeat('</li></ul>', $item['level']) : '';
        $level = $item['level'];
    }

    return html\tag('nav', ['id' => $§['id']], $html);
}

/**
 * Message section
 */
function msg(array $§): string
{
    $§['vars'] = [];

    if (!$§['vars']['data'] = session\get('msg')) {
        return '';
    }

    session\set('msg', null);

    return tpl($§);
}

/**
 * Template section
 */
function tpl(array $§): string
{
    $§['vars'] = ['id' => $§['id'], 'tpl' => $§['tpl']] + $§['vars'];
    $§ = function ($key) use ($§) {
        return $§['vars'][$key] ?? null;
    };
    ob_start();
    include app\tpl((string) $§('tpl'));

    return ob_get_clean();
}
