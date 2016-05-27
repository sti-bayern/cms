<?php
namespace qnd;

/**
 * HTML section
 *
 * @param array $section
 *
 * @return string
 */
function section_template(array & $section): string
{
    $§ = function ($key = null, $default = null) use ($section) {
        if ($key === null) {
            return isset($section['vars']) && is_array($section['vars']) ? $section['vars'] : [];
        }

        return $section['vars'][$key] ?? $default;
    };
    $output = function (string $ţ) use ($§) {
        ob_start();
        include path('template', $ţ);

        return ob_get_clean();
    };

    return $output($section['template']);
}

/**
 * Container section
 *
 * @param array $section
 *
 * @return string
 */
function section_container(array & $section): string
{
    $html = '';

    if (!empty($section['children']) && is_array($section['children'])) {
        asort($section['children'], SORT_NUMERIC);

        foreach (array_keys($section['children']) as $id) {
            $html .= §($id);
        }
    }

    return $html;
}

/**
 * Entity section
 *
 * @param array $section
 *
 * @return string
 */
function section_entity(array & $section): string
{
    if (empty($section['vars']['entity']) || !($entity = data('entity', $section['vars']['entity']))) {
        return '';
    }

    $section['vars'] = array_replace(['crit' => [], 'opts' => []], $section['vars']);
    $section['vars']['data'] = all($section['vars']['entity'], $section['vars']['crit'], $section['vars']['opts']);
    $section['vars']['title'] = _($entity['name']);

    return section_template($section);
}

/**
 * Pager section
 *
 * @param array $section
 *
 * @return string
 */
function section_pager(array & $section): string
{
    if (empty($section['vars']['pages']) || $section['vars']['pages'] < 1 || empty($section['vars']['page'])) {
        return '';
    }

    if (empty($section['vars']['params'])) {
        $section['vars']['params'] = [];
    }

    $section['vars']['first'] = url('*/*', $section['vars']['params']);

    if ($section['vars']['pages'] === 1) {
        $section['vars']['last'] = $section['vars']['first'];
    } else {
        $section['vars']['last'] = url(
            '*/*',
            array_replace($section['vars']['params'], ['page' => $section['vars']['pages']])
        );
    }

    $section['vars']['previous'] = $section['vars']['next'] = '#';

    if ($section['vars']['page'] < $section['vars']['pages']) {
        $section['vars']['next'] = url(
            '*/*',
            array_replace($section['vars']['params'], ['page' => $section['vars']['page'] + 1])
        );
    }

    if ($section['vars']['page'] === 2) {
        $section['vars']['previous'] = url('*/*', $section['vars']['params']);
    } elseif ($section['vars']['page'] > 2) {
        $section['vars']['previous'] = url(
            '*/*',
            array_replace($section['vars']['params'], ['page' => $section['vars']['page'] - 1])
        );
    }

    return section_template($section);
}

/**
 * Message section
 *
 * @param array $section
 *
 * @return string
 */
function section_message(array & $section): string
{
    if (!$section['vars']['data'] = session('message')) {
        return '';
    }

    session('message', null, true);

    return section_template($section);
}

/**
 * Node section
 *
 * @param array $section
 *
 * @return string
 */
function section_node(array & $section): string
{
    if (empty($section['vars']['crit']) || !$data = all('node', $section['vars']['crit'])) {
        return '';
    }

    $count = count($data);
    $level = 0;
    $i = 0;
    $html = '';

    if (!empty($section['vars']['title'])) {
        $html .= html_tag('h1', [], $section['vars']['title']);
    }

    foreach ($data as $item) {
        $attrs = [];
        $class = '';

        if ($item['target'] === request('path')) {
            $attrs['class'] = 'active';
            $class .= ' class="active"';
        }

        if ($item['level'] > $level) {
             $html .= '<ul><li' . $class . '>';
        } elseif ($item['level'] < $level) {
             $html .= '</li>' . str_repeat('</ul></li>', $level - $item['level']) . '<li' . $class . '>';
        } else {
             $html .= '</li><li' . $class . '>';
        }

        if ($item['target'] !== '#') {
            $attrs['href'] = url($item['target']);
            $html .= html_tag('a', $attrs, $item['name']);
        } else {
            $html .= html_tag('span', [], $item['name']);
        }

        $html .= ++$i === $count ? str_repeat('</li></ul>', $item['level']) : '';
        $level = $item['level'];
    }

    return html_tag('nav', ['id' => $section['id']], $html);
}
