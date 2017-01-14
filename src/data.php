<?php
namespace qnd;

use RuntimeException;

/**
 * Data
 *
 * @param string $section
 * @param string $id
 *
 * @return mixed
 */
function data(string $section, string $id = null)
{
    $data = & registry('data.' . $section);

    if ($data === null) {
        $data = [];
        $data = data_load(path('data', $section . '.php'));

        if ($section !== 'listener') {
            event('data.load.' . $section, $data);
        }
    }

    if ($id === null) {
        return $data;
    }

    return $data[$id] ?? null;
}

/**
 * Load file data
 *
 * @param string $file
 *
 * @return array
 */
function data_load(string $file): array
{
    if (!is_readable($file)) {
        return [];
    }

    $data = include $file;

    return is_array($data) ? $data : [];
}

/**
 * Filter data by given criteria
 *
 * @param array $data
 * @param array $crit
 * @param array $opts
 *
 * @return array
 */
function data_filter(array $data, array $crit, array $opts = []): array
{
    if (!$crit) {
        return $data;
    }

    $search = !empty($opts['search']) && is_array($opts['search']) ? $opts['search'] : [];

    foreach ($data as $id => $item) {
        foreach ($crit as $key => $value) {
            $value = (array) $value;

            if (!array_key_exists($key, $item)
                || !in_array($key, $search) && !in_array($item[$key], $value)
                || in_array($key, $search) && !data_filter_match($item[$key], $value)
            ) {
                unset($data[$id]);
            }
        }
    }

    return $data;
}

/**
 * Checks wheter string matches with one of the given search patterns
 *
 * @param string $str
 * @param array $patterns
 *
 * @return bool
 */
function data_filter_match(string $str, array $patterns): bool
{
    foreach ($patterns as $pattern) {
        if (strpos((string) $str, (string) $pattern) !== false) {
            return true;
        }
    }

    return false;
}

/**
 * Sort order
 *
 * @param array $data
 * @param array $order
 *
 * @return array
 */
function data_order(array $data, array $order): array
{
    if (!$order) {
        return $data;
    }

    uasort(
        $data,
        function (array $a, array $b) use ($order) {
            return data_order_compare($order, $a, $b);
        }
    );

    return $data;
}

/**
 * Sort order compare
 *
 * @param array $order
 * @param array $a
 * @param array $b
 *
 * @return int
 */
function data_order_compare(array $order, array $a, array $b): int
{
    foreach ($order as $key => $dir) {
        $factor = $dir === 'desc' ? -1 : 1;
        $result = ($a[$key] ?? null) <=> ($b[$key] ?? null);

        if ($result) {
            return $result * $factor;
        }
    }

    return 0;
}

/**
 * Entity data
 *
 * @param array $entity
 *
 * @return array
 *
 * @throws RuntimeException
 */
function data_entity(array $entity): array
{
    if (empty($entity['uid']) || empty($entity['name']) || empty($entity['attr'])) {
        throw new RuntimeException(_('Invalid entity configuration'));
    }

    // @todo Get rid of this
    foreach (array_keys($entity) as $key) {
        if (strpos($key, '_') === 0) {
            unset($entity[$key]);
        }
    }

    $entity = array_replace(data('default', 'entity'), $entity);
    $entity['tab'] = $entity['tab'] ?: $entity['uid'];
    $sort = 0;

    foreach ($entity['attr'] as $id => $attr) {
        $attr['uid'] = $id;
        $attr = data_attr($attr);

        if (!is_numeric($attr['sort'])) {
            $attr['sort'] = $sort;
            $sort += 100;
        }

        $entity['attr'][$id] = $attr;
    }

    return $entity;
}

/**
 * Attribute data
 *
 * @param array $attr
 *
 * @return array
 *
 * @throws RuntimeException
 */
function data_attr(array $attr): array
{
    if (empty($attr['uid']) || empty($attr['name']) || empty($attr['type']) || !($type = data('attr', $attr['type']))) {
        throw new RuntimeException(_('Invalid attribute configuration'));
    }

    // @todo Get rid of this
    foreach (array_keys($attr) as $key) {
        if (strpos($key, '_') === 0) {
            unset($attr[$key]);
        }
    }

    $default = data('default', 'attr');
    $backend = data('backend', $attr['backend'] ?? $type['backend']);
    $frontend = data('frontend', $attr['frontend'] ?? $type['frontend']);
    $attr = array_replace($default, $backend, $frontend, $type, $attr);

    if ($attr['col'] === false) {
        $attr['col'] = null;
    } elseif (!$attr['col']) {
        $attr['col'] = $attr['uid'];
    }

    return $attr;
}
