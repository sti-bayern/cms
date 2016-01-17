<?php
namespace http;

use app;
use file;
use filter;
use i18n;
use session;
use url;

/**
 * Request
 *
 * @param string $key
 * @param mixed $value
 *
 * @return mixed
 */
function request($key, $value = null)
{
    $data = & app\registry('request');

    if ($data === null) {
        $data = [];

        // Initialize request data
        $data = init();

        // Dispatch init event
        app\event('http.request', $data);

        // Prepare request data for current request
        $data = prepare($data);
    }

    // If $value is provided, set $value for $key
    if ($value !== null) {
        $data[$key] = $value;
    }

    return isset($data[$key]) ? $data[$key] : null;
}

/**
 * Initialize request data
 *
 * @return array
 */
function init()
{
    $data = app\data('skeleton', 'request');
    $data['base'] = rtrim(filter\path(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/';
    $data['url'] = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $data['base'];
    $data['original_path'] = trim(preg_replace('#^' . $data['base'] . '#', '', explode('?', $data['url'])[0]), '/');
    $data['path'] = url\rewrite($data['original_path']);
    $data['host'] = $_SERVER['HTTP_HOST'];
    $data['scheme'] = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $data['is_secure'] = $data['scheme'] === 'https';
    $data['files'] = $_FILES ? files_validate(files_convert($_FILES)) : [];
    $data['get'] = $_GET;
    $data['post'] = !empty($_POST['token']) && post_validate($_POST['token']) ? $_POST : [];

    return $data;
}

/**
 * Prepare request data for current request
 *
 * @param array $data
 *
 * @return array
 */
function prepare(array $data)
{
    // Entity, Action and Get Params
    $parts = $data['path'] ? explode('/', $data['path']) : [];
    $entity = array_shift($parts);

    if ($entity) {
        $data['entity'] = $entity;
        $action = array_shift($parts);

        if ($action) {
            $data['action'] = $action;
            $count = count($parts);

            for ($i = 0; $i < $count; $i += 2) {
                if (!empty($parts[$i]) && isset($parts[$i + 1])) {
                    $data['get'][$parts[$i]] = $parts[$i + 1];
                }
            }
        }
    }

    $data['id'] = $data['entity'] . '.' . $data['action'];
    $data['_original'] = $data;

    return $data;
}

/**
 * Redirect
 *
 * @param string $url
 * @param array $params
 *
 * @return void
 *
 * @SuppressWarnings(PHPMD.ExitExpression)
 */
function redirect($url = '', array $params = [])
{
    header('Location:' . url\path($url, $params));
    exit;
}

/**
 * Get
 *
 * @param string $key
 *
 * @return mixed
 */
function get($key = null)
{
    $data = request('get');

    if ($key === null) {
        return $data;
    }

    return isset($data[$key]) ? $data[$key] : null;
}

/**
 * Post
 *
 * @param string $key
 *
 * @return mixed
 */
function post($key = null)
{
    $data = request('post');

    if ($key === null) {
        return $data;
    }

    return isset($data[$key]) ? $data[$key] : null;
}

/**
 * Post validation
 *
 * @param string $token
 *
 * @return bool
 */
function post_validate($token)
{
    $session = session\data('token');
    $success = !empty($session) && !empty($token) && $session === $token;
    session\data('token', null, true);

    return $success;
}

/**
 * Post action
 *
 * @return mixed
 */
function post_action()
{
    $data = post('action');

    return !empty($data) && is_array($data) ? key($data) : null;
}

/**
 * Post data
 *
 * @param string $action
 * @param string $key
 *
 * @return mixed
 */
function post_data($action, $key = null)
{
    if ($action !== post_action()) {
        return null;
    }

    $data = post('data');

    if ($key === null) {
        return $data;
    }

    return isset($data[$key]) ? $data[$key] : null;
}

/**
 * Files
 *
 * @param string $key
 *
 * @return mixed
 */
function files($key = null)
{
    $data = request('files');

    if ($key === null) {
        return $data;
    }

    return isset($data[$key]) ? $data[$key] : null;
}

/**
 * Validate uploads
 *
 * @param array $data
 *
 * @return array
 */
function files_validate(array $data)
{
    $extensions = file\extensions('file');

    foreach ($data as & $items) {
        foreach ($items as & $item) {
            foreach ($item as $code => & $attribute) {
                if (empty($attribute)) {
                    continue;
                }

                $ext = pathinfo($attribute['name'], PATHINFO_EXTENSION);

                if (!in_array($ext, $extensions)) {
                    session\message(i18n\translate('Invalid file %s was rejected', $attribute['name']));
                    unset($item[$code]);
                } else {
                    $attribute['extension'] = $ext;
                }
            }
        }
    }

    return $data;
}

/**
 * Converts uploaded files
 *
 * @param array $data
 *
 * @return array
 */
function files_convert(array $data)
{
    $files = [];

    foreach ($data as $id => $item) {
        $files[$id] = files_fix($item);
    }

    $keys = ['error', 'name', 'size', 'tmp_name', 'type'];

    foreach ($files as $id => $item) {
        if (!is_array($item)) {
            continue;
        }

        $ids = array_keys($item);
        sort($ids);

        if ($ids != $keys) {
            $files[$id] = files_convert($item);
        } elseif ($item['error'] === UPLOAD_ERR_NO_FILE || !is_uploaded_file($item['tmp_name'])) {
            $files[$id] = null;
        }
    }

    return $files;
}

/**
 * Fixes a malformed PHP $_FILES array.
 *
 * PHP has a bug that the format of the $_FILES array differs, depending on
 * whether the uploaded file fields had normal field names or array-like
 * field names ("normal" vs. "parent[child]").
 *
 * This method fixes the array to look like the "normal" $_FILES array.
 *
 * It's safe to pass an already converted array, in which case this method
 * just returns the original array unmodified.
 *
 * @param array $data
 *
 * @return array
 */
function files_fix($data)
{
    if (!is_array($data)) {
        return $data;
    }

    $keys = ['error', 'name', 'size', 'tmp_name', 'type'];
    $ids = array_keys($data);
    sort($ids);

    if ($keys != $ids || !isset($data['name']) || !is_array($data['name'])) {
        return $data;
    }

    $files = $data;

    foreach ($keys as $k) {
        unset($files[$k]);
    }

    foreach (array_keys($data['name']) as $id) {
        $files[$id] = files_fix(
            [
                'error' => $data['error'][$id],
                'name' => $data['name'][$id],
                'type' => $data['type'][$id],
                'tmp_name' => $data['tmp_name'][$id],
                'size' => $data['size'][$id]
            ]
        );
    }

    return $files;
}
