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
    if (!data_action('edit', $attr)) {
        return '';
    }

    // Common
    $item[$attr['id']] = $item[$attr['id']] ?? $attr['value'];
    $html = '';
    $attr['context'] = 'edit';
    $attr['html']['id'] =  html_id($attr, $item);
    $attr['html']['name'] =  html_name($attr, $item);

    if ($attr['required'] && !ignorable($attr, $item)) {
        $attr['html']['required'] = true;
    }

    if (!empty($attr['multiple'])) {
        $attr['html']['multiple'] = true;
    }

    if (!empty($item['_error'][$attr['id']])) {
        $attr['html']['class'][] = 'invalid';
    }

    // Callback
    $callback = fqn('editor_' . $attr['type']);

    if (is_callable($callback)) {
        $html = $callback($attr, $item);
    } else {
        // Temporary
        switch ($attr['frontend']) {
            case 'select':
                $html = editor_select($attr, $item);
                break;
            case 'checkbox':
            case 'radio':
                $html = editor_option($attr, $item);
                break;
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
    $attr['options'] = option($attr);

    if (!is_array($value)) {
        $value = !$value && !is_numeric($value) ? [] : [$value];
    }

    if (empty($attr['options'])) {
        $html = html_tag('optgroup', ['label' => _('No options configured')]);
    } else {
        $html = html_tag('option', ['value' => '', 'class' => 'empty'], _('Please choose'));

        foreach ($attr['options'] as $optId => $optVal) {
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

            $html .= html_tag('option', $a, option_name($optId, $optVal));
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
function editor_option(array $attr, array $item): string
{
    $attr['options'] = option($attr);
    $value = $item[$attr['id']];

    if ($attr['backend'] === 'bool') {
        $value = [(int) $value];
    } elseif (!is_array($value)) {
        $value = empty($value) && !is_numeric($value) ? [] : [$value];
    }

    if (empty($attr['options'])) {
        return html_tag('span', ['id' => $attr['html']['id']], _('No options configured'));
    }

    $html = '';

    foreach ($attr['options'] as $optId => $optVal) {
        $htmlId = $attr['html']['id'] . '-' . $optId;
        $a = ['id' => $htmlId, 'name' => $attr['html']['name'], 'type' => $attr['frontend'], 'value' => $optId];

        if (in_array($optId, $value)) {
            $a['checked'] = true;
        }

        if (!empty($attr['html']['required'])) {
            $a['required'] = true;
        }

        if (!empty($attr['html']['class'])) {
            $a['class'] = $attr['html']['class'];
        }

        $html .= html_tag('input', $a, null, true);
        $html .= html_tag('label', ['for' => $htmlId, 'class' => 'inline'], option_name($optId, $optVal));
    }

    return $html;
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
    $attr['html']['value'] = encode($item[$attr['id']]);

    if ($attr['min'] > 0 && $attr['min'] <= $attr['max']) {
        $attr['html']['minlength'] = $attr['min'];
    }

    if ($attr['max'] > 0 && $attr['min'] <= $attr['max']) {
        $attr['html']['maxlength'] = $attr['max'];
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

    if ($attr['min'] > 0 && $attr['min'] <= $attr['max']) {
        $attr['html']['min'] = $attr['min'];
    }

    if ($attr['max'] > 0 && $attr['min'] <= $attr['max']) {
        $attr['html']['max'] = $attr['max'];
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
        $in = 'Y-m-d';
        $out = 'Y-m-d';
    } elseif ($attr['frontend'] === 'time') {
        $in = 'H:i:s';
        $out = 'H:i';
    } else {
        $in = 'Y-m-d H:i:s';
        $out = 'Y-m-d\TH:i';
    }

    if ($item[$attr['id']] && ($value = date_format(date_create_from_format($in, $item[$attr['id']]), $out))) {
        $item[$attr['id']] = $value;
    }

    $attr['html']['type'] = $attr['frontend'];
    $attr['html']['value'] = $item[$attr['id']];

    if ($attr['min'] > 0 && $attr['min'] <= $attr['max']) {
        $attr['html']['min'] = $attr['min'];
    }

    if ($attr['max'] > 0 && $attr['min'] <= $attr['max']) {
        $attr['html']['max'] = $attr['max'];
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
    $reset = [
        'id' => 'data-' . $item['_id'] . '-_reset-' . $attr['id'],
        'name' => 'data[' . $item['_id'] . '][_reset]' . '[' . $attr['id'] . ']',
        'type' => 'checkbox',
        'value' => 1,
    ];

    return html_tag('div', [], viewer($attr, $item))
        . html_tag('input', $attr['html'], null, true)
        . html_tag('input', $reset, null, true)
        . html_tag('label', ['for' => $reset['id'], 'class' => 'inline'], _('Reset'));
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
    if ($attr['min'] > 0 && $attr['min'] <= $attr['max']) {
        $attr['html']['minlength'] = $attr['min'];
    }

    if ($attr['max'] > 0 && $attr['min'] <= $attr['max']) {
        $attr['html']['maxlength'] = $attr['max'];
    }

    return html_tag('textarea', $attr['html'], encode($item[$attr['id']]));
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
