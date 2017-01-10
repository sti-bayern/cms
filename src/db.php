<?php
namespace qnd;

use Exception;
use PDO;
use PDOStatement;

/**
 * Database
 *
 * @return PDO
 */
function db(): PDO
{
    static $db;

    if ($db === null) {
        $data = data('db');
        $dsn = sprintf('pgsql:host=%s;dbname=%s', $data['host'], $data['db']);
        $db = new PDO($dsn, $data['user'], $data['password'], $data['opt']);
    }

    return $db;
}

/**
 * Transaction
 *
 * @param callable $callback
 *
 * @return bool
 */
function db_trans(callable $callback): bool
{
    static $level = 0;

    ++$level === 1 ? db()->beginTransaction() : db()->exec('SAVEPOINT LEVEL_' . $level);

    try {
        $callback();
        $level === 1 ? db()->commit() : db()->exec('RELEASE SAVEPOINT LEVEL_' . $level);
        --$level;
    } catch (Exception $e) {
        $level === 1 ? db()->rollBack() : db()->exec('ROLLBACK TO SAVEPOINT LEVEL_' . $level);
        --$level;
        error($e);

        return false;
    }

    return true;
}

/**
 * Prepare statement with replacing placeholders
 *
 * @param string $sql
 * @param string[] ...$args
 *
 * @return PDOStatement
 */
function db_prep(string $sql, string ...$args): PDOStatement
{
    return db()->prepare(vsprintf($sql, $args));
}

/**
 * Parameter name
 *
 * @param string $name
 *
 * @return string
 */
function db_param(string $name): string
{
    return ':' . str_replace('-', '_', $name);
}

/**
 * Set appropriate parameter type
 *
 * @param mixed $val
 * @param array $attr
 *
 * @return int
 */
function db_type($val, array $attr): int
{
    return $val === null && !empty($attr['nullable']) ? PDO::PARAM_NULL : data('backend', $attr['backend'])['pdo'];
}

/**
 * Manipulate value for DB
 *
 * @param mixed $val
 * @param array $attr
 *
 * @return mixed
 */
function db_val($val, array $attr)
{
    return $attr['multiple'] && $attr['backend'] === 'json' ? json_encode($val) : $val;
}

/**
 * Cast
 *
 * @param string $col
 * @param string $backend
 *
 * @return string
 */
function db_cast(string $col, string $backend): string
{
    return 'CAST(' . $col . ' AS ' . data('backend', $backend)['db'] . ')';
}

/**
 * Prepare columns
 *
 * @param array $attrs
 * @param array $item
 *
 * @return array
 */
function db_cols(array $attrs, array $item): array
{
    $attrs = db_attr($attrs, true);
    $data = [];

    foreach ($item as $uid => $val) {
        if (empty($attrs[$uid])) {
            continue;
        }

        $param = db_param($uid);
        $cast = $attrs[$uid]['backend'] === 'search' ? 'TO_TSVECTOR(' . $param . ')' : $param;
        $val = db_val($val, $attrs[$uid]);
        $data[$uid]['col'] = $attrs[$uid]['col'];
        $data[$uid]['param'] = $param;
        $data[$uid]['cast'] = $cast;
        $data[$uid]['set'] = $data[$uid]['col'] . ' = ' . $cast;
        $data[$uid]['val'] = $val;
        $data[$uid]['type'] = db_type($val, $attrs[$uid]);
    }

    return $data;
}

/**
 * Filter out non-DB and optionally auto increment columns
 *
 * @param array $attrs
 * @param bool $auto
 *
 * @return array
 */
function db_attr(array $attrs, bool $auto = false): array
{
    return array_filter(
        $attrs,
        function (array $attr) use ($auto) {
            return !empty($attr['col']) && (!$auto || empty($attr['auto']));
        }
    );
}

/**
 * Quotes identifier
 *
 * @param string $id
 *
 * @return string
 */
function db_qi(string $id): string
{
    return $id ? '"' . str_replace('"', '', $id) . '"' : '';
}

/**
 * Quotes value
 *
 * @param mixed $value
 * @param array $attr
 *
 * @return string
 */
function db_qv($value, array $attr): string
{
    return db()->quote($value, db_type($value, $attr));
}

/**
 * Quotes array value
 *
 * @param mixed $value
 * @param array $attr
 *
 * @return array
 */
function db_qa(array $value, array $attr): array
{
    return array_map(
        function ($v) use ($attr) {
            return db_qv($v, $attr);
        },
        $value
    );
}

/**
 * AND expression
 *
 * @param array $crit
 *
 * @return string
 */
function db_and(array $crit): string
{
    return implode(' AND ', $crit);
}

/**
 * OR expression
 *
 * @param array $crit
 *
 * @return string
 */
function db_or(array $crit): string
{
    return '(' . implode(' OR ', $crit) . ')';
}

/**
 * IS NULL expression
 *
 * @param string $col
 *
 * @return string
 */
function db_null(string $col): string
{
    return $col . ' IS NULL';
}

/**
 * IN expression
 *
 * @param string $col
 * @param array $vals
 *
 * @return string
 */
function db_in(string $col, array $vals): string
{
    return $col . ' IN (' . db_list($vals) . ')';
}

/**
 * LIKE expression
 *
 * @param string $col
 * @param string $val
 *
 * @return string
 */
function db_like(string $col, string $val): string
{
    return $col . ' ILIKE ' . $val;
}

/**
 * SEARCH expression
 *
 * @param string $col
 * @param string $val
 *
 * @return string
 */
function db_search(string $col, string $val): string
{
    return $col . ' @@ TO_TSQUERY(' . $val . ')';
}

/**
 * List columns
 *
 * @param array $cols
 *
 * @return string
 */
function db_list(array $cols): string
{
    return implode(', ', $cols);
}

/**
 * SELECT part
 *
 * @param array $select
 *
 * @return string
 */
function select(array $select): string
{
    $cols = [];

    foreach ($select as $as => $col) {
        $cols[] = $col . ($as && is_string($as) ? ' AS ' . db_qi($as) : '');
    }

    return $cols ? 'SELECT ' . db_list($cols) : '';
}

/**
 * FROM part
 *
 * @param string $tab
 * @param string $as
 *
 * @return string
 */
function from(string $tab, string $as = null): string
{
    return ' FROM ' . $tab . ' ' . $as;
}

/**
 * NATURAL JOIN part
 *
 * @param string $tab
 * @param string $as
 *
 * @return string
 */
function njoin(string $tab, string $as = null): string
{
    return $tab ? ' NATURAL JOIN ' . $tab . ' ' . $as : '';
}

/**
 * WHERE part
 *
 * @param array $crit
 * @param array $attrs
 * @param array $opts
 *
 * @return string
 */
function where(array $crit, array $attrs, array $opts = []): string
{
    $search = !empty($opts['search']) && is_array($opts['search']) ? $opts['search'] : [];
    $cols = [];

    foreach ($crit as $id => $value) {
        if (empty($attrs[$id]['col'])) {
            continue;
        }

        $attr = $attrs[$id];
        $col = $attr['col'];

        if ($value === null) {
            $cols[$id] = db_null($col);
            continue;
        }

        $value = (array) $value;
        $r = [];

        if (!in_array($id, $search)) {
            $r[] = db_in($col, db_qa($value, $attr));
        } elseif ($attr['backend'] === 'search') {
            $r[] = db_search($col, db_qv(implode(' | ', $value), $attr));
        } else {
            foreach ($value as $v) {
                $r[] = db_like($col, db_qv('%' . str_replace(['%', '_'], ['\%', '\_'], $v) . '%', $attr));
            }
        }

        $cols[$id] = db_or($r);
    }

    return $cols ? ' WHERE ' . db_and($cols) : '';
}

/**
 * GROUP BY part
 *
 * @param string[] $cols
 *
 * @return string
 */
function group(array $cols): string
{
    return $cols ? ' GROUP BY ' . db_list($cols) : '';
}

/**
 * ORDER BY part
 *
 * @param string[] $order
 *
 * @return string
 */
function order(array $order): string
{
    $cols = [];

    foreach ($order as $uid => $dir) {
        $cols[] = db_qi($uid) . ' ' . (strtoupper($dir) === 'DESC' ? 'DESC' : 'ASC');
    }

    return $cols ? ' ORDER BY ' . db_list($cols) : '';
}

/**
 * LIMIT part
 *
 * @param int $limit
 * @param int $offset
 *
 * @return string
 */
function limit(int $limit, int $offset = 0): string
{
    return $limit > 0 ? ' LIMIT ' . $limit . ' OFFSET ' . max(0, $offset) : '';
}
