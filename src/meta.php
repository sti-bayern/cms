<?php
namespace qnd;

use RuntimeException;

/**
 * Entity
 *
 * @param array $data
 *
 * @return array
 *
 * @throws RuntimeException
 */
function meta_entity(array $data): array
{
    // Check minimum requirements
    if (empty($data['id']) || empty($data['name']) || empty($data['attributes'])) {
        throw new RuntimeException(_('Entity metadata does not meet the minimum requirements'));
    }

    // Clean up
    foreach (array_keys($data) as $key) {
        if (strpos($key, '_') === 0) {
            unset($data[$key]);
        }
    }

    $data = array_replace_recursive(data('skeleton', 'entity'), $data);
     // Set table name from ID if it is not set already
    $data['table'] = $data['table'] ?: $data['id'];
    // Attributes
    $sort = 0;

    foreach ($data['attributes'] as $id => $attr) {
        $attr['id'] = $id;
        $attr = meta_attribute($attr);

        if (!is_numeric($attr['sort'])) {
            $attr['sort'] = $sort;
            $sort += 100;
        }

        $data['attributes'][$id] = $attr;
    }

    return $data;
}

/**
 * Attribute
 *
 * @param array $data
 *
 * @return array
 *
 * @throws RuntimeException
 */
function meta_attribute(array $data): array
{
    // Check minimum requirements
    if (empty($data['id']) || empty($data['name']) || empty($data['type'])) {
        throw new RuntimeException(_('Attribute metadata does not meet the minimum requirements'));
    }

    // Clean up
    foreach (array_keys($data) as $key) {
        if (strpos($key, '_') === 0) {
            unset($data[$key]);
        }
    }

    // Type, Backend, Frontend
    $type = data('attribute', $data['type']);

    if (!$type || empty($type['backend']) || empty($type['frontend'])) {
        throw new RuntimeException(_('Invalid type %s configured for attribute %s', $data['type'], $data['id']));
    }

    $data = array_replace(data('skeleton', 'attribute'), $type, $data);

    // Column
    if (!empty($data['virtual'])) {
        $data['column'] = null;
    } elseif (empty($data['column'])) {
        $data['column'] = $data['id'];
    }

    // Correct invalid values
    $data['required'] = empty($data['nullable']) && $data['required'];
    $data['unambiguous'] = !in_array($data['backend'], ['bool', 'text']) && $data['unambiguous'];
    $data['multiple'] = in_array($data['type'], ['multicheckbox', 'multiselect']);

    return $data;
}

/**
 * Check wheter entity or attribute supports at least one of provided actions
 *
 * @param string|array $action
 * @param array $data
 *
 * @return bool
 */
function meta_action($action, array $data): bool
{
    if (empty($data['actions']) || !is_array($data['actions']) && !($data['actions'] = json_decode($data['actions'], true))) {
        // No actions supported
        return false;
    } elseif (in_array('all', $data['actions']) && ($action !== 'edit' || empty($data['generator']) || $data['generator'] !== 'auto')) {
        // All actions supported
        return true;
    }

    foreach ((array) $action as $key) {
        if (in_array($key, $data['actions']) && ($key !== 'edit' || empty($data['generator']) || $data['generator'] !== 'auto')) {
            return true;
        }
    }

    return false;
}

/**
 * Retrieve empty entity
 *
 * @param string $entity
 * @param int $number
 * @param bool $bare
 *
 * @return array
 */
function meta_skeleton(string $entity, int $number = null, bool $bare = false): array
{
    $meta = data('meta', $entity);
    $item = [];

    foreach ($meta['attributes'] as $code => $attr) {
        if (meta_action('edit', $attr)) {
            $item[$code] = null;
        }
    }

    $item += $bare ? [] : ['_old' => null, '_meta' => $meta, '_id' => null];

    if ($number === null) {
        return $item;
    }

    $data = array_fill_keys(range(-1, -1 * max(1, (int) $number)), $item);

    foreach ($data as $key => $value) {
        $data[$key]['_id'] = $key;
    }

    return $data;
}
