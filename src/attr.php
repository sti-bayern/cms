<?php
declare(strict_types = 1);

namespace attr;

use app;
use arr;
use ent;
use html;
use opt;
use DomainException;

/**
 * Filter
 *
 * @throws DomainException
 */
function filter(array $attr, array $data): array
{
    $data[$attr['id']] = cast($attr, $data[$attr['id']] ?? null);

    if ($attr['nullable'] && $data[$attr['id']] === null) {
        return $data;
    }

    if ($attr['filter']) {
        $data[$attr['id']] = ('filter\\' . $attr['filter'])($data[$attr['id']], opt($attr, $data));
    }

    $crit = [[$attr['id'], $data[$attr['id']]]];

    if ($data['_old']) {
        $crit[] = ['id', $data['_old']['id'], APP['crit']['!=']];
    }

    if ($attr['unique'] && ent\size($data['_ent']['id'], $crit)) {
        throw new DomainException(app\i18n('Value must be unique'));
    }

    if ($attr['required'] && ($data[$attr['id']] === null || $data[$attr['id']] === '')) {
        throw new DomainException(app\i18n('Value is required'));
    }

    $vals = $attr['multiple'] ? $data[$attr['id']] : [$data[$attr['id']]];

    foreach ($vals as $val) {
        if ($attr['min'] > 0 && $val < $attr['min']
            || $attr['max'] > 0 && $val > $attr['max']
            || $attr['minlength'] > 0 && strlen($val) < $attr['minlength']
            || $attr['maxlength'] > 0 && strlen($val) > $attr['maxlength']
        ) {
            throw new DomainException(app\i18n('Value out of range'));
        }
    }

    return $data;
}

/**
 * Frontend
 */
function frontend(array $attr, array $data): string
{
    $data[$attr['id']] = cast(['nullable' => false] + $attr, $data[$attr['id']] ?? $attr['val']);
    $html['id'] =  'data-' . $attr['id'];
    $html['name'] =  'data[' . $attr['id'] . ']';
    $html['data-type'] =  $attr['type'];
    $label = $attr['name'];
    $error = '';

    if ($attr['multiple']) {
        $html['name'] .= '[]';
        $html['multiple'] = true;
    }

    if ($attr['required'] && !ignorable($attr, $data)) {
        $html['required'] = true;
        $label .= ' ' . html\tag('em', ['class' => 'required'], app\i18n('Required'));
    }

    if ($attr['unique']) {
        $label .= ' ' . html\tag('em', ['class' => 'unique'], app\i18n('Unique'));
    }

    foreach ([['min', 'max'], ['minlength', 'maxlength']] as $edge) {
        if ($attr[$edge[0]] <= $attr[$edge[1]]) {
            if ($attr[$edge[0]] > 0) {
                $html[$edge[0]] = $attr[$edge[0]];
            }

            if ($attr[$edge[1]] > 0) {
                $html[$edge[1]] = $attr[$edge[1]];
            }
        }
    }

    if (!empty($data['_error'][$attr['id']])) {
        $html['class'] = empty($html['class']) ? 'invalid' : $html['class'] . ' invalid';
        $error = html\tag('div', ['class' => 'error'], $data['_error'][$attr['id']]);
    }

    $out = ('frontend\\' . $attr['frontend'])($html, $data[$attr['id']], opt($attr, $data));

    return html\tag('label', ['for' => $html['id']], $label) . $out . $error;
}

/**
 * Viewer
 */
function viewer(array $attr, array $data): string
{
    if (!isset($data[$attr['id']]) || $data[$attr['id']] === '') {
        return '';
    }

    if ($attr['viewer']) {
        return ('viewer\\' . $attr['viewer'])($data[$attr['id']], opt($attr, $data));
    }

    return app\enc((string) $data[$attr['id']]);
}

/**
 * Option
 */
function opt(array $attr, array $data): array
{
    if ($attr['type'] === 'ent') {
        return opt\ent($attr);
    }

    if (is_string($attr['opt'])) {
        return ('opt\\' . $attr['opt'])($attr, $data);
    }

    return array_map('app\i18n', $attr['opt']);
}

/**
 * Cast to appropriate php type
 *
 * @return mixed
 */
function cast(array $attr, $val)
{
    if ($attr['nullable'] && ($val === null || $val === '')) {
        return null;
    }

    if ($attr['backend'] === 'json') {
        return is_array($val) || $val && ($val = json_decode($val, true)) ? $val : [];
    }

    if ($attr['multiple']) {
        return is_array($val) ? arr\map(__FUNCTION__, $val, ['multiple' => false] + $attr) : [];
    }

    if ($attr['backend'] === 'bool') {
        return (bool) $val;
    }

    if ($attr['backend'] === 'int') {
        return (int) $val;
    }

    if ($attr['backend'] === 'decimal') {
        return (float) $val;
    }

    return (string) $val;
}

/**
 * Check wheter attribute can be ignored
 */
function ignorable(array $attr, array $data): bool
{
    return $attr['ignorable'] && !empty($data['_old'][$attr['id']]);
}
