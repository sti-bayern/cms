<?php
namespace qnd;

/**
 * Session data
 *
 * @param string $key
 * @param mixed $value
 * @param bool $reset
 *
 * @return mixed
 */
function & session(string $key = null, $value = null, bool $reset = false)
{
    static $data;

    if ($data === null) {
        // Start session if it was not started before
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $data = & $_SESSION;
    }

    if ($key === null) {
        return $data;
    }

    // If $value is provided, set $value for $key
    if ($value !== null) {
        $data[$key] = $value;
    }

    // Reset value or set $key in first call, so we have something to return
    if (isset($data[$key]) && $reset || !isset($data[$key])) {
        $data[$key] = null;
    }

    return $data[$key];
}

/**
 * Add message
 *
 * @param string $message
 *
 * @return void
 */
function message(string $message)
{
    $data = & session('message');

    if ($message && (!$data || !in_array($message, $data))) {
        $data[] = $message;
    }
}

/**
 * Token
 *
 * @return string
 */
function token(): string
{
    $token = & session('token');

    if (empty($token)) {
        $token = md5(uniqid(mt_rand(), true));
    }

    return $token;
}
