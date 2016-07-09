<?php
namespace qnd;

use PDO;

/**
 * Size entity
 *
 * @param array $entity
 * @param array $crit
 * @param array $opts
 *
 * @return int
 */
function eav_size(array $entity, array $crit = [], array $opts = []): int
{
    $mainAttrs = data('entity', 'content')['attr'];
    $addAttrs = array_diff_key($entity['attr'], $mainAttrs);
    $crit['entity_id'] = $entity['id'];

    if (!$addAttrs) {
        return flat_size($entity, $crit, $opts);
    }

    $list = [];
    $params = [];

    foreach ($addAttrs as $uid => $attr) {
        if (empty($attr['col']) || empty($crit[$uid])) {
            continue;
        }

        $val = array_map(
            function ($v) use ($attr) {
                return qv($v, $attr['backend']);
            },
            (array) $crit[$uid]
        );
        $params[$uid] = ':' . str_replace('-', '_', $uid);
        $list[] = sprintf(
            '(id IN (SELECT content_id FROM eav WHERE attr_id = %s AND CAST(value AS %s) IN (%s)))',
            $params[$uid],
            db_cast($attr),
            implode(', ', $val)
        );
    }

    $stmt = prep(
        'SELECT COUNT(*) FROM content %s %s',
        where($crit, $mainAttrs, $opts),
        $list ? ' AND ' . implode(' AND ', $list) : ''
    );

    foreach ($params as $uid => $param) {
        $stmt->bindValue($param, $addAttrs[$uid]['eav_id'], PDO::PARAM_INT);
    }

    $stmt->execute();

    return $stmt->fetchColumn();
}

/**
 * Load entity
 *
 * @param array $entity
 * @param array $crit
 * @param array $opts
 *
 * @return array
 */
function eav_load(array $entity, array $crit = [], array $opts = []): array
{
    $mainAttrs = data('entity', 'content')['attr'];
    $addAttrs = array_diff_key($entity['attr'], $mainAttrs);
    $crit['entity_id'] = $entity['id'];

    if (!$addAttrs) {
        return flat_load($entity, $crit, $opts);
    }

    $opts['as'] = 'e';
    $list = [];
    $params = [];
    $having = [];

    foreach ($addAttrs as $uid => $attr) {
        if (empty($attr['col'])) {
            continue;
        }

        $params[$uid] = ':' . str_replace('-', '_', $uid);
        $list[] = sprintf(
            'MAX(CASE WHEN a.attr_id = %s THEN CAST(a.value AS %s) END) AS %s',
            $params[$uid],
            db_cast($attr),
            qi($uid)
        );

        if (isset($crit[$uid])) {
            $having[$uid] = $crit[$uid];
            unset($crit[$uid]);
        }
    }

    $stmt = db()->prepare(
        select($mainAttrs, 'e')
        . ($list ? ', ' . implode(', ', $list) : '')
        . ' FROM content e'
        . ($list ? ' LEFT JOIN eav a ON a.content_id = e.id' : '')
        . where($crit, $mainAttrs, $opts)
        . group(['id'])
        . having($having, $entity['attr'], $opts)
        . order($opts['order'] ?? [], $entity['attr'])
        . limit($opts['limit'] ?? 0, $opts['offset'] ?? 0)
    );

    foreach ($params as $uid => $param) {
        $stmt->bindValue($param, $addAttrs[$uid]['eav_id'], PDO::PARAM_INT);
    }

    $stmt->execute();

    if (!empty($opts['one'])) {
        return $stmt->fetch() ?: [];
    }

    return $stmt->fetchAll();
}

/**
 * Create entity
 *
 * @param array $item
 *
 * @return bool
 */
function eav_create(array & $item): bool
{
    $item['entity_id'] = $item['_entity']['id'];
    $attrs = $item['_entity']['attr'];
    $mainAttrs = data('entity', 'content')['attr'];
    $addAttrs = array_diff_key($attrs, $mainAttrs);

    // Main attributes
    $item['_entity']['attr'] = $mainAttrs;
    $result = flat_create($item);
    $item['_entity']['attr'] = $attrs;

    if (!$result || !$addAttrs) {
        return $result;
    }

    // Save additional attributes
    $stmt = db()->prepare('
        INSERT INTO 
            eav
            (content_id, attr_id, value) 
         VALUES 
            (:content_id, :attr_id, :value)
    ');

    foreach ($addAttrs as $uid => $attr) {
        if (!array_key_exists($uid, $item)) {
            continue;
        }

        $val = $attr['multiple'] && $attr['backend'] === 'json' ? json_encode($item[$uid]) : $item[$uid];
        $stmt->bindValue(':content_id', $item['id'], PDO::PARAM_INT);
        $stmt->bindValue(':attr_id', $attr['eav_id'], PDO::PARAM_INT);
        $stmt->bindValue(':value', $val, PDO::PARAM_STR);
        $stmt->execute();
    }

    return true;
}

/**
 * Save entity
 *
 * @param array $item
 *
 * @return bool
 */
function eav_save(array & $item): bool
{
    $item['entity_id'] = $item['_entity']['id'];
    $attrs = $item['_entity']['attr'];
    $mainAttrs = data('entity', 'content')['attr'];
    $addAttrs = array_diff_key($attrs, $mainAttrs);

    // Main attributes
    $item['_entity']['attr'] = $mainAttrs;
    $result = flat_save($item);
    $item['_entity']['attr'] = $attrs;

    if (!$result || !$addAttrs) {
        return $result;
    }

    // Save additional attributes
    $stmt = db()->prepare('
        INSERT INTO 
            eav
        SET
            content_id = :content_id,
            attr_id = :attr_id,
            value = :value
        ON DUPLICATE KEY UPDATE
            value = VALUES(value)
    ');

    foreach ($addAttrs as $uid => $attr) {
        if (!array_key_exists($uid, $item)) {
            continue;
        }

        $val = $attr['multiple'] && $attr['backend'] === 'json' ? json_encode($item[$uid]) : $item[$uid];
        $stmt->bindValue(':content_id', $item['id'], PDO::PARAM_INT);
        $stmt->bindValue(':attr_id', $attr['eav_id'], PDO::PARAM_INT);
        $stmt->bindValue(':value', $val, PDO::PARAM_STR);
        $stmt->execute();
    }

    return true;
}

/**
 * Delete entity
 *
 * @param array $item
 *
 * @return bool
 */
function eav_delete(array & $item): bool
{
    return !empty($item['_entity']['id']) && $item['_entity']['id'] === $item['entity_id'] && flat_delete($item);
}
