<?php
declare(strict_types = 1);

namespace cms;

use Exception;
use RuntimeException;

const ENTITY = [
    'id' => null,
    'name' => null,
    'tab' => null,
    'model' => 'flat',
    'load' => null,
    'save' => null,
    'delete' => null,
    'actions' => [],
    'attr' => []
];
const CRIT = [
    '=' => '=',
    '!=' => '!=',
    '>' => '>',
    '>=' => '>=',
    '<' => '>',
    '<=' => '<=',
    '~' => '~',
    '!~' => '!~',
    '~^' => '~^',
    '!~^' => '!~^',
    '~$' => '~$',
    '!~$' => '!~$',
];
const OPTS = [
    'mode' => 'all',
    'index' => 'id',
    'select' => [],
    'order' => [],
    'limit' => 0,
    'offset' => 0
];

/**
 * Size entity
 */
function size(string $eId, array $crit = []): int
{
    $entity = cfg('entity', $eId);
    $opts = ['mode' => 'size'] + OPTS;

    try {
        return $entity['load']($entity, $crit, $opts)[0];
    } catch (Exception $e) {
        logger((string) $e);
        message(_('Could not load data'));
    }

    return 0;
}

/**
 * Load one entity
 */
function one(string $eId, array $crit = [], array $opts = []): array
{
    $entity = cfg('entity', $eId);
    $data = [];
    $opts = array_replace(OPTS, array_intersect_key($opts, OPTS), ['mode' => 'one', 'limit' => 1]);

    try {
        if ($data = $entity['load']($entity, $crit, $opts)) {
            $data = entity_load($entity, $data);
        }
    } catch (Exception $e) {
        logger((string) $e);
        message(_('Could not load data'));
    }

    return $data;
}

/**
 * Load entity collection
 */
function all(string $eId, array $crit = [], array $opts = []): array
{
    $entity = cfg('entity', $eId);
    $opts = array_replace(OPTS, array_intersect_key($opts, OPTS), ['mode' => 'all']);

    if ($opts['select']) {
        foreach (array_unique(['id', $opts['index']]) as $k) {
            if (!in_array($k, $opts['select'])) {
                $opts['select'][] = $k;
            }
        }
    }

    try {
        $data = $entity['load']($entity, $crit, $opts);

        foreach ($data as $id => $item) {
            $data[$id] = entity_load($entity, $item);
        }

        return array_column($data, null, $opts['index']);
    } catch (Exception $e) {
        logger((string) $e);
        message(_('Could not load data'));
    }

    return [];
}

/**
 * Save entity
 */
function save(string $eId, array & $data): bool
{
    $temp = $data;
    $editable = entity($eId);

    if (!empty($temp['id']) && ($base = one($eId, [['id', $temp['id']]]))) {
        $temp['_old'] = $base;
        unset($temp['_old']['_entity'], $temp['_old']['_old']);
    }

    $temp = array_replace($editable, $temp);
    $aIds = array_keys(array_intersect_key($editable, $temp['_entity']['attr']));

    foreach ($aIds as $aId) {
        try {
            $temp = validator($temp['_entity']['attr'][$aId], $temp);
        } catch (Exception $e) {
            $data['_error'][$aId] = $e->getMessage();
        }
    }

    if (!empty($data['_error'])) {
        message(_('Could not save %s', $temp['name']));
        return false;
    }

    $trans = db_trans(
        function () use (& $temp, $aIds): void {
            $temp = event('entity.presave', $temp);
            $temp = event('model.presave.' . $temp['_entity']['model'], $temp);
            $temp = event('entity.presave.' . $temp['_entity']['id'], $temp);

            foreach ($aIds as $aId) {
                $temp = saver($temp['_entity']['attr'][$aId], $temp);
            }

            $temp = $temp['_entity']['save']($temp);
            event('entity.postsave', $temp);
            event('model.postsave.' . $temp['_entity']['model'], $temp);
            event('entity.postsave.' . $temp['_entity']['id'], $temp);
        }
    );

    if ($trans) {
        message(_('Successfully saved %s', $temp['name']));
        $data = $temp;
    } else {
        message(_('Could not save %s', $temp['name']));
    }

    return $trans;
}

/**
 * Delete entity
 */
function delete(string $eId, array $crit = [], array $opts = []): bool
{
    $success = [];
    $error = [];

    foreach (all($eId, $crit, $opts) as $id => $data) {
        if (!empty($data['system'])) {
            message(_('System items must not be deleted! Therefore skipped ID %s', (string) $id));
            continue;
        }

        $trans = db_trans(
            function () use ($data): void {
                $data = event('entity.predelete', $data);
                $data = event('model.predelete.' . $data['_entity']['model'], $data);
                $data = event('entity.predelete.' . $data['_entity']['id'], $data);
                $data['_entity']['delete']($data);
                event('entity.postdelete', $data);
                event('model.postdelete.' . $data['_entity']['model'], $data);
                event('entity.postdelete.' . $data['_entity']['id'], $data);
            }
        );

        if ($trans) {
            $success[] = $data['name'];
        } else {
            $error[] = $data['name'];
        }
    }

    if ($success) {
        message(_('Successfully deleted %s', implode(', ', $success)));
    }

    if ($error) {
        message(_('Could not delete %s', implode(', ', $error)));
    }

    return !$error;
}

/**
 * Retrieve empty entity
 *
 * @throws RuntimeException
 */
function entity(string $eId, bool $bare = false): array
{
    if (!$entity = cfg('entity', $eId)) {
        throw new RuntimeException(_('Invalid entity %s', $eId));
    }

    $item = array_fill_keys(array_keys(entity_attr($entity, 'edit')), null);

    return $bare ? $item : $item + ['_old' => null, '_entity' => $entity];
}

/**
 * Retrieve entity attributes filtered by given action
 */
function entity_attr(array $entity, string $act): array
{
    foreach ($entity['attr'] as $aId => $attr) {
        if (!in_array($act, $attr['actions'])) {
            unset($entity['attr'][$aId]);
        }
    }

    return $entity['attr'];
}

/**
 * Internal entity loader
 */
function entity_load(array $entity, array $data): array
{
    foreach ($data as $aId => $val) {
        if (isset($entity['attr'][$aId])) {
            $data[$aId] = loader($entity['attr'][$aId], $data);
        }
    }

    $data['_old'] = $data;
    $data['_entity'] = $entity;
    $data = event('entity.load', $data);
    $data = event('model.load.' . $entity['model'], $data);
    $data = event('entity.load.' . $entity['id'], $data);

    return $data;
}
