<?php
namespace qnd;

/**
 * Editor
 *
 * @param array $attr
 * @param array $item
 *
 * @return string
 */
function editor(array $attr, array $item): string
{
    if (!in_array('edit', $attr['actions'])) {
        return '';
    }

    $item[$attr['id']] = $item[$attr['id']] ?? $attr['val'];
    $attr['opt'] = opt($attr);
    $attr['context'] = 'edit';
    $attr['html']['id'] =  html_id($attr, $item);
    $attr['html']['name'] =  html_name($attr, $item);
    $attr['html']['data-type'] =  $attr['type'];

    if ($attr['required'] && !ignorable($attr, $item)) {
        $attr['html']['required'] = true;
    }

    if (!empty($attr['multiple'])) {
        $attr['html']['multiple'] = true;
    }

    if (!empty($item['_error'][$attr['id']])) {
        $attr['html']['class'] = empty($attr['html']['class']) ? 'invalid' : $attr['html']['class'] . ' invalid';
    }

    $html = '';
    $callback = fqn('editor_' . $attr['type']);

    if (is_callable($callback)) {
        $html = $callback($attr, $item);
    } else {
        // @todo
        switch ($attr['frontend']) {
            case 'select':
                $html = editor_select($attr, $item);
                break;
            case 'checkbox':
            case 'radio':
                $html = editor_opt($attr, $item);
                break;
            case 'color':
            case 'email':
            case 'url':
                $html = editor_text($attr, $item);
                break;
            case 'number':
            case 'range':
                $html = editor_int($attr, $item);
                break;
            case 'date':
            case 'time':
                $html = editor_datetime($attr, $item);
                break;
            case 'file':
                $html = editor_file($attr, $item);
                break;
            case 'textarea':
                $html = editor_textarea($attr, $item);
                break;
        }
    }

    return $html ? html_label($attr, $item) . $html . html_message($attr, $item) : '';
}

/**
 * Delete editor
 *
 * @param array $attr
 * @param array $item
 *
 * @return string
 */
function editor_delete(array $attr, array $item): string
{
    if (!isset($item['_old'][$attr['id']])) {
        return '';
    }

    $input = [
        'id' => 'data-' . $item['_id'] . '-_delete-' . $attr['id'],
        'name' => 'data[' . $item['_id'] . '][_delete]' . '[' . $attr['id'] . ']',
        'type' => 'checkbox',
        'value' => 1,
    ];
    $label = ['for' => $input['id'], 'class' => 'inline'];

    return html_tag('input', $input, null, true) . html_tag('label', $label, _('Reset'));
}

/**
 * Select editor
 *
 * @param array $attr
 * @param array $item
 *
 * @return string
 */
function editor_select(array $attr, array $item): string
{
    $value = $item[$attr['id']];

    if (!is_array($value)) {
        $value = !$value && !is_numeric($value) ? [] : [$value];
    }

    if (empty($attr['opt'])) {
        $html = html_tag('optgroup', ['label' => _('No options configured')]);
    } else {
        $html = html_tag('option', ['value' => '', 'class' => 'empty'], _('Please choose'));

        foreach ($attr['opt'] as $optId => $optVal) {
            $a = ['value' => $optId];

            if (in_array($optId, $value)) {
                $a['selected'] = true;
            }

            if (is_array($optVal) && !empty($optVal['class'])) {
                $a['class'] = $optVal['class'];
            }

            if (is_array($optVal) && !empty($optVal['level'])) {
                $a['data-level'] = $optVal['level'];
            }

            $html .= html_tag('option', $a, editor_opt_name($optId, $optVal));
        }
    }

    return html_tag('select', $attr['html'], $html);
}

/**
 * Option editor
 *
 * @param array $attr
 * @param array $item
 *
 * @return string
 */
function editor_opt(array $attr, array $item): string
{
    if (!$attr['opt']) {
        return html_tag('span', ['id' => $attr['html']['id']], _('No options configured'));
    } elseif ($attr['backend'] === 'bool' && $attr['frontend'] === 'checkbox') {
        $attr['opt'] = [1 => _('Yes')];
    }

    $value = $item[$attr['id']];

    if ($attr['backend'] === 'bool') {
        $value = [(int) $value];
    } elseif (!is_array($value)) {
        $value = !$value && !is_numeric($value) ? [] : [$value];
    }

    $html = '';

    foreach ($attr['opt'] as $optId => $optVal) {
        $htmlId = $attr['html']['id'] . '-' . $optId;
        $a = [
            'id' => $htmlId,
            'name' => $attr['html']['name'],
            'type' => $attr['frontend'],
            'value' => $optId,
            'checked' => in_array($optId, $value)
        ];
        $a = array_replace($attr['html'], $a);
        $html .= html_tag('input', $a, null, true);
        $html .= html_tag('label', ['for' => $htmlId, 'class' => 'inline'], editor_opt_name($optId, $optVal));
    }

    return $html;
}

/**
 * Option name
 *
 * @param int|string $id
 * @param mixed $value
 *
 * @return string
 */
function editor_opt_name($id, $value): string
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
 * Text editor
 *
 * @param array $attr
 * @param array $item
 *
 * @return string
 */
function editor_text(array $attr, array $item): string
{
    $attr['html']['type'] = $attr['frontend'];
    $attr['html']['value'] = $item[$attr['id']] ? encode($item[$attr['id']]) : $item[$attr['id']];

    if ($attr['minval'] > 0 && $attr['minval'] <= $attr['maxval']) {
        $attr['html']['minlength'] = $attr['minval'];
    }

    if ($attr['maxval'] > 0 && $attr['minval'] <= $attr['maxval']) {
        $attr['html']['maxlength'] = $attr['maxval'];
    }

    return html_tag('input', $attr['html'], null, true);
}

/**
 * Password editor
 *
 * @param array $attr
 * @param array $item
 *
 * @return string
 */
function editor_password(array $attr, array $item): string
{
    $item[$attr['id']] = null;
    $attr['html']['autocomplete'] = 'off';

    return editor_text($attr, $item);
}

/**
 * Int editor
 *
 * @param array $attr
 * @param array $item
 *
 * @return string
 */
function editor_int(array $attr, array $item): string
{
    $attr['html']['type'] = $attr['frontend'];
    $attr['html']['value'] = $item[$attr['id']];

    if ($attr['minval'] > 0 && $attr['minval'] <= $attr['maxval']) {
        $attr['html']['min'] = $attr['minval'];
    }

    if ($attr['maxval'] > 0 && $attr['minval'] <= $attr['maxval']) {
        $attr['html']['max'] = $attr['maxval'];
    }

    return html_tag('input', $attr['html'], null, true);
}

/**
 * Datetime editor
 *
 * @param array $attr
 * @param array $item
 *
 * @return string
 */
function editor_datetime(array $attr, array $item): string
{
    if ($attr['frontend'] === 'date') {
        $in = BACKEND_DATE;
        $out = FRONTEND_DATE;
    } elseif ($attr['frontend'] === 'time') {
        $in = BACKEND_TIME;
        $out = FRONTEND_TIME;
    } else {
        $in = BACKEND_DATETIME;
        $out = FRONTEND_DATETIME;
    }

    if ($item[$attr['id']] && ($value = date_format(date_create_from_format($in, $item[$attr['id']]), $out))) {
        $item[$attr['id']] = $value;
    }

    $attr['html']['type'] = $attr['frontend'];
    $attr['html']['value'] = $item[$attr['id']];

    if ($attr['minval'] > 0 && $attr['minval'] <= $attr['maxval']) {
        $attr['html']['min'] = $attr['minval'];
    }

    if ($attr['maxval'] > 0 && $attr['minval'] <= $attr['maxval']) {
        $attr['html']['max'] = $attr['maxval'];
    }

    return html_tag('input', $attr['html'], null, true);
}

/**
 * File editor
 *
 * @param array $attr
 * @param array $item
 *
 * @return string
 */
function editor_file(array $attr, array $item): string
{
    $attr['html']['type'] = $attr['frontend'];
    $delete = editor_delete($attr, $item);

    return html_tag('div', [], viewer($attr, $item)) . html_tag('input', $attr['html'], null, true) . $delete;
}

/**
 * Textarea editor
 *
 * @param array $attr
 * @param array $item
 *
 * @return string
 */
function editor_textarea(array $attr, array $item): string
{
    $item[$attr['id']] = $item[$attr['id']] ? encode($item[$attr['id']]) : $item[$attr['id']];

    if ($attr['minval'] > 0 && $attr['minval'] <= $attr['maxval']) {
        $attr['html']['minlength'] = $attr['minval'];
    }

    if ($attr['maxval'] > 0 && $attr['minval'] <= $attr['maxval']) {
        $attr['html']['maxlength'] = $attr['maxval'];
    }

    return html_tag('textarea', $attr['html'], $item[$attr['id']]);
}

/**
 * JSON editor
 *
 * @param array $attr
 * @param array $item
 *
 * @return string
 */
function editor_json(array $attr, array $item): string
{
    if (is_array($item[$attr['id']])) {
        $item[$attr['id']] = !empty($item[$attr['id']]) ? json_encode($item[$attr['id']]) : '';
    }

    return editor_textarea($attr, $item);
}
