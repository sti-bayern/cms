<?php
namespace qnd;

/**
 * Log levels
 */
const EMERGENCY = 'emergency';
const ALERT = 'alert';
const CRITICAL = 'critical';
const ERROR = 'error';
const WARNING = 'warning';
const NOTICE = 'notice';
const INFO = 'info';
const DEBUG = 'debug';

/**
 * System is unusable.
 *
 * @param string $message
 * @param array $context
 *
 * @return void
 */
function emergency(string $message, array $context = [])
{
    logger(EMERGENCY, $message, $context);
}

/**
 * Action must be taken immediately.
 *
 * Example: Entire website down, database unavailable, etc. This should trigger the SMS alerts and wake you up.
 *
 * @param string $message
 * @param array $context
 *
 * @return void
 */
function alert(string $message, array $context = [])
{
    logger(ALERT, $message, $context);
}

/**
 * Critical conditions.
 *
 * Example: Application component unavailable, unexpected exception.
 *
 * @param string $message
 * @param array $context
 *
 * @return void
 */
function critical(string $message, array $context = [])
{
    logger(CRITICAL, $message, $context);
}

/**
 * Runtime errors that do not require immediate action but should typically be logged and monitored.
 *
 * @param string $message
 * @param array $context
 *
 * @return void
 */
function error(string $message, array $context = [])
{
    logger(ERROR, $message, $context);
}

/**
 * Exceptional occurrences that are not errors.
 *
 * Example: Use of deprecated APIs, poor use of an API, undesirable things that are not necessarily wrong.
 *
 * @param string $message
 * @param array $context
 *
 * @return void
 */
function warning(string $message, array $context = [])
{
    logger(WARNING, $message, $context);
}

/**
 * Normal but significant events.
 *
 * @param string $message
 * @param array $context
 *
 * @return void
 */
function notice(string $message, array $context = [])
{
    logger(NOTICE, $message, $context);
}

/**
 * Interesting events.
 *
 * Example: User logs in, SQL logs.
 *
 * @param string $message
 * @param array $context
 *
 * @return void
 */
function info(string $message, array $context = [])
{
    logger(INFO, $message, $context);
}

/**
 * Detailed debug information.
 *
 * @param string $message
 * @param array $context
 *
 * @return void
 */
function debug(string $message, array $context = [])
{
    logger(DEBUG, $message, $context);
}

/**
 * Logs with an arbitrary level.
 *
 * @param string $level
 * @param string $message
 * @param array $context
 *
 * @return void
 */
function logger(string $level, string $message, array $context = [])
{
    if (empty($context['file'])) {
        $context['file'] = 'qnd.log';
    }

    $file = path('log', $context['file']);
    file_save($file, '[' . $level . '][' . date('r') . '] ' . $message . "\n\n", FILE_APPEND);
}
