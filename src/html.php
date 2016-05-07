<?php
namespace qnd;

/**
 * Label
 *
 * @param array $attr
 * @param array $item
 *
 * @return string
 */
function html_label(array $attr, array $item): string
{
    $message = '';

    if (!empty($attr['required']) && !ignorable($attr, $item)) {
        $message .= ' <em class="required">' . _('Required') . '</em>';
    }

    if (!empty($attr['unambiguous'])) {
        $message .= ' <em class="unambiguous">' . _('Unambiguous') . '</em>';
    }

    return '<label for="' . html_id($attr, $item) . '">' . _($attr['name']) . $message . '</label>';
}

/**
 * HTML id attribute
 *
 * @param array $attr
 * @param array $item
 *
 * @return string
 */
function html_id(array $attr, array $item): string
{
    return 'data-' . $item['_id'] . '-' . $attr['id'];
}

/**
 * HTML name attribute
 *
 * @param array $attr
 * @param array $item
 *
 * @return string
 */
function html_name(array $attr, array $item): string
{
    return 'data[' . $item['_id'] . '][' . $attr['id'] . ']' . (!empty($attr['multiple']) ? '[]' : '');
}

/**
 * HTML required attribute
 *
 * @param array $attr
 * @param array $item
 *
 * @return string
 */
function html_required(array $attr, array $item): string
{
    return !empty($attr['required']) && !ignorable($attr, $item) ? ' required="required"' : '';
}

/**
 * HTML class attribute
 *
 * @param array $attr
 *
 * @return string
 */
function html_class(array $attr): string
{
    if (empty($attr['class'])) {
        return '';
    }

    $class = is_array($attr['class']) ? implode(' ', $attr['class']) : $attr['class'];

    return ' class="' . $class . '"';
}

/**
 * Message
 *
 * @param array $attr
 * @param array $item
 *
 * @return string
 */
function html_message(array $attr, array $item): string
{
    if (empty($item['_error'][$attr['id']])) {
        return '';
    }

    return '<p class="message error">' . $item['_error'][$attr['id']] . '</p>';
}
