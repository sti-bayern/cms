<?php
namespace qnd;

/**
 * Saver
 *
 * @param array $attr
 * @param array $item
 *
 * @return bool
 */
function saver(array $attr, array & $item): bool
{
    return !$attr['saver'] || ($call = fqn('saver_' . $attr['saver'])) && $call($attr, $item);
}

/**
 * Password saver
 *
 * @param array $attr
 * @param array $item
 *
 * @return bool
 */
function saver_password(array $attr, array & $item): bool
{
    if (!empty($item[$attr['id']]) && is_string($item[$attr['id']])) {
        $item[$attr['id']] = password_hash($item[$attr['id']], PASSWORD_DEFAULT);
    }

    return true;
}

/**
 * File saver
 *
 * @param array $attr
 * @param array $item
 *
 * @return bool
 */
function saver_file(array $attr, array & $item): bool
{
    $item[$attr['id']] = null;
    $file = http_files('data')[$item['_id']][$attr['id']] ?? null;

    // Delete old file
    if (!empty($item['_old'][$attr['id']])
        && ($file || !empty($item['_delete'][$attr['id']]))
        && !file_delete_media($item['_old'][$attr['id']])
    ) {
        $item['_error'][$attr['id']] = _('Could not delete old file %s', $item['_old'][$attr['id']]);
        return false;
    }

    // No upload
    if (!$file) {
        return true;
    }

    $value = filter_file($file['name'], project_path('media'));

    // Upload failed
    if (!file_upload($file['tmp_name'], project_path('media', $value))) {
        $item['_error'][$attr['id']] = _('File upload failed');
        return false;
    }

    $item[$attr['id']] = $value;

    return true;
}
