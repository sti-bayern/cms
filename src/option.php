<?php
namespace qnd;

/**
 * Option
 *
 * @param array $attr
 *
 * @return array
 */
function option(array $attr): array
{
    if ($attr['backend'] === 'bool') {
        return option_translate(['No', 'Yes']);
    }

    if (empty($attr['opt'][0]) || !is_string($attr['opt'][0]) && !is_array($attr['opt'][0])) {
        return [];
    }

    if (is_string($attr['opt'][0])) {
        $params = $attr['opt'][1] ?? [];
        return option_translate($attr['opt'][0](...$params));
    }

    return option_translate($attr['opt'][0]);
}

/**
 * Option name
 *
 * @param int|string $id
 * @param mixed $value
 *
 * @return string
 */
function option_name($id, $value): string
{
    if (is_array($value) && !empty($value['name'])) {
        return $value['name'];
    }

    if (is_scalar($value)) {
        return (string) $value;
    }

    return (string) $id;
}

/**
 * Translate options
 *
 * @param array $opts
 *
 * @return array
 */
function option_translate(array $opts): array
{
    foreach ($opts as $key => $value) {
        if (is_scalar($value)) {
            $opts[$key] = _($value);
        } elseif (is_array($value) && !empty($value['name'])) {
            $opts[$key]['name'] = _($value['name']);
        }
    }

    return $opts;
}

/**
 * Tree options
 *
 * @return array
 */
function option_position(): array
{
    $roots = load('menu');
    $data = [];

    foreach (load('node') as $item) {
        if (empty($data[$item['root_id']  . ':0'])) {
            $data[$item['root_id']  . ':0']['name'] = $roots[$item['root_id']]['name'];
            $data[$item['root_id']  . ':0']['class'] = 'group';
        }

        $data[$item['position']]['name'] = $item['name'];
        $data[$item['position']]['level'] = $item['level'];
    }

    // Add roots without items
    foreach ($roots as $id => $root) {
        if (empty($data[$id  . ':0'])) {
            $data[$id  . ':0']['name'] = $root['name'];
            $data[$id  . ':0']['class'] = 'group';
        }
    }

    return $data;
}
