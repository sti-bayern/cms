<?php
declare(strict_types = 1);

namespace qnd;

/**
 * Loader
 *
 * @param array $attr
 * @param array $data
 *
 * @return mixed
 */
function loader(array $attr, array $data)
{
    $data[$attr['id']] = cast($attr, $data[$attr['id']] ?? null);

    return $attr['loader'] ? $attr['loader']($attr, $data) : $data[$attr['id']];
}

/**
 * JSON loader
 *
 * @param array $attr
 * @param array $data
 *
 * @return array
 */
function loader_json(array $attr, array $data): array
{
    if (!$data[$attr['id']]) {
        return [];
    }

    if (is_array($data[$attr['id']])) {
        return $data[$attr['id']];
    }

    return json_decode($data[$attr['id']], true) ?: [];
}
