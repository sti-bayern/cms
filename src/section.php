<?php
declare(strict_types = 1);

namespace qnd;

/**
 * Container section
 *
 * @param array $§
 *
 * @return string
 */
function section_container(array $§): string
{
    $§['vars']['tag'] = $§['vars']['tag'] ?? null;
    $html = '';

    if (!empty($§['children']) && is_array($§['children'])) {
        asort($§['children'], SORT_NUMERIC);

        foreach (array_keys($§['children']) as $id) {
            $html .= §($id);
        }
    }

    return $html && $§['vars']['tag'] ? html_tag($§['vars']['tag'], ['id' => $§['id']], $html) : $html;
}

/**
 * Message section
 *
 * @param array $§
 *
 * @return string
 */
function section_message(array $§): string
{
    if (!$§['vars']['data'] = session('message')) {
        return '';
    }

    session('message', null, true);

    return render($§);
}

/**
 * Navigation section
 *
 * @param array $§
 *
 * @return string
 */
function section_nav(array $§): string
{
    if (($§['vars']['type'] ?? null) === 'sub') {
        $attrs = ['id' => 'subnav'];

        if (!$anc = page_tree(['id' => request('id'), 'ancestor' => true])) {
            return '';
        }

        $crit = ['id' => $anc[0]['id']];
    } else {
        $attrs = ['id' => 'nav'];
        $crit = ['depth' => 1];
    }


    if (!$nav = page_tree($crit)) {
        return '';
    }

    $count = count($nav);
    $depth = 0;
    $i = 0;
    $html = '';

    foreach ($nav as $page) {
        $a = ['href' => $page['url']];
        $class = '';

        if ($page['url'] === request('path')) {
            $a['class'] = 'active';
            $class .= ' class="active"';
        }

        if ($page['depth'] > $depth) {
             $html .= '<ul><li' . $class . '>';
        } elseif ($page['depth'] < $depth) {
             $html .= '</li>' . str_repeat('</ul></li>', $depth - $page['depth']) . '<li' . $class . '>';
        } else {
             $html .= '</li><li' . $class . '>';
        }

        $html .= html_tag('a', $a, $page['name']);
        $html .= ++$i === $count ? str_repeat('</li></ul>', $page['depth']) : '';
        $depth = $page['depth'];
    }

    return html_tag('nav', $attrs, $html);
}

/**
 * Pager section
 *
 * @param array $§
 *
 * @return string
 */
function section_pager(array $§): string
{
    $§['vars'] += ['size' => 0, 'limit' => 0, 'links' => [], 'params' => []];

    if ($§['vars']['size'] < 1 || $§['vars']['limit'] < 1) {
        return '';
    }

    $§['vars']['pages'] = (int) ceil($§['vars']['size'] / $§['vars']['limit']);
    $§['vars']['page'] = max($§['vars']['params']['page'] ?? 0, 1);
    $§['vars']['offset'] = ($§['vars']['page'] - 1) * $§['vars']['limit'];
    unset($§['vars']['params']['page']);
    $c = max(0, data('app', 'limit.pager'));
    $min = max(1, min($§['vars']['page'] - intdiv($c, 2), $§['vars']['pages'] - $c + 1));
    $max = min($min + $c - 1, $§['vars']['pages']);

    if ($§['vars']['page'] >= 2) {
        $p = $§['vars']['page'] === 2 ? $§['vars']['params'] : ['page' => $§['vars']['page'] - 1] + $§['vars']['params'];
        $§['vars']['links'][] = ['name' => _('Previous'), 'params' => $p];
    }

    for ($i = $min; $min < $max && $i <= $max; $i++) {
        $p = $i > 1 ? ['page' => $i] + $§['vars']['params'] : $§['vars']['params'];
        $§['vars']['links'][] = ['name' => $i, 'params' => $p, 'active' => $i === $§['vars']['page']];
    }

    if ($§['vars']['page'] < $§['vars']['pages']) {
        $p = ['page' => $§['vars']['page'] + 1] + $§['vars']['params'];
        $§['vars']['links'][] = ['name' => _('Next'), 'params' => $p];
    }

    return render($§);
}

/**
 * Template section
 *
 * @param array $§
 *
 * @return string
 */
function section_template(array $§): string
{
    return render($§);
}

/**
 * Toolbar section
 *
 * @param array $§
 *
 * @return string
 */
function section_toolbar(array $§): string
{
    $crit = ['active' => true];
    $§['vars']['projects'] = allowed('project.switch') && size('project', $crit) > 1 ? all('project', $crit) : [];

    return render($§);
}
