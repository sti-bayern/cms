<?php
namespace qnd;

/**
 * Viewer
 *
 * @param array $attr
 * @param array $item
 *
 * @return string
 */
function viewer(array $attr, array $item): string
{
    $attr['context'] = $attr['context'] ?? 'view';

    if (!in_array($attr['context'], $attr['actions'])) {
        return '';
    }

    $attr['opt'] = opt($attr);
    $callback = fqn('viewer_' . $attr['type']);

    if (is_callable($callback)) {
        return $callback($attr, $item);
    }

    // @todo
    if (in_array($attr['frontend'], ['checkbox', 'radio', 'select'])) {
        return viewer_opt($attr, $item);
    }

    return $item[$attr['id']] ? encode($item[$attr['id']]) : (string) $item[$attr['id']];
}

/**
 * Option viewer
 *
 * @param array $attr
 * @param array $item
 *
 * @return string
 */
function viewer_opt(array $attr, array $item): string
{
    if (!$attr['opt']) {
        return '';
    }

    $values = [];

    foreach ((array) $item[$attr['id']] as $v) {
        if (!empty($attr['opt'][$v])) {
            if (is_array($attr['opt'][$v]) && !empty($attr['opt'][$v]['name'])) {
                $values[] = $attr['opt'][$v]['name'];
            } elseif (is_scalar($attr['opt'][$v])) {
                $values[] = $attr['opt'][$v];
            }
        }
    }

    return $values ? encode(implode(', ', $values)) : '';
}

/**
 * Date viewer
 *
 * @param array $attr
 * @param array $item
 *
 * @return string
 */
function viewer_date(array $attr, array $item): string
{
    return empty($item[$attr['id']]) ? '' : date_format(date_create($item[$attr['id']]), data('format', 'date.view'));
}

/**
 * Datetime viewer
 *
 * @param array $attr
 * @param array $item
 *
 * @return string
 */
function viewer_datetime(array $attr, array $item): string
{
    return empty($item[$attr['id']]) ? '' : date_format(date_create($item[$attr['id']]), data('format', 'datetime.view'));
}

/**
 * Time viewer
 *
 * @param array $attr
 * @param array $item
 *
 * @return string
 */
function viewer_time(array $attr, array $item): string
{
    return empty($item[$attr['id']]) ? '' : date_format(date_create($item[$attr['id']]), data('format', 'time.view'));
}

/**
 * Rich text viewer
 *
 * @param array $attr
 * @param array $item
 *
 * @return string
 */
function viewer_rte(array $attr, array $item): string
{
    return (string) $item[$attr['id']];
}

/**
 * Audio viewer
 *
 * @param array $attr
 * @param array $item
 *
 * @return string
 */
function viewer_audio(array $attr, array $item): string
{
    if ($item[$attr['id']]) {
        return html_tag('audio', ['src' => url_media($item[$attr['id']]), 'controls' => true]);
    }

    return '';
}

/**
 * Embed viewer
 *
 * @param array $attr
 * @param array $item
 *
 * @return string
 */
function viewer_embed(array $attr, array $item): string
{
    if ($item[$attr['id']]) {
        return html_tag('embed', ['src' => url_media($item[$attr['id']]), 'autoplay' => 'no', 'loop' => 'no'], null, true);
    }

    return '';
}

/**
 * File viewer
 *
 * @param array $attr
 * @param array $item
 *
 * @return string
 */
function viewer_file(array $attr, array $item): string
{
    if ($item[$attr['id']]) {
        return html_tag('a', ['href' => url_media($item[$attr['id']])], $item[$attr['id']]);
    }

    return '';
}

/**
 * Image viewer
 *
 * @param array $attr
 * @param array $item
 *
 * @return string
 */
function viewer_image(array $attr, array $item): string
{
    if ($item[$attr['id']] && ($opts = data('media', $attr['context']))) {
        return html_tag('img', ['src' => image($item[$attr['id']], $opts), 'alt' => $item[$attr['id']]], null, true);
    }

    return '';
}

/**
 * Video viewer
 *
 * @param array $attr
 * @param array $item
 *
 * @return string
 */
function viewer_video(array $attr, array $item): string
{
    if ($item[$attr['id']]) {
        return html_tag('video', ['src' => url_media($item[$attr['id']]), 'controls' => true]);
    }

    return '';
}
