<?php
namespace qnd;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

/**
 * List files recursively inside the specified path
 *
 * @param string $path
 * @param array $crit
 * @param array $opts
 *
 * @return array
 */
function file_load(string $path, array $crit = [], array $opts = []): array
{
    if (!is_dir($path)) {
        return [];
    }

    if (empty($opts['index']) || is_array($opts['index']) && (empty($opts['index'][0]) || empty($opts['index'][1]))) {
        $opts['index'] = 'id';
    }

    $data = [];
    $iterator = new RecursiveDirectoryIterator(
        $path,
        RecursiveDirectoryIterator::SKIP_DOTS | RecursiveDirectoryIterator::UNIX_PATHS
    );

    if (!empty($crit['recursive'])) {
        $iterator = new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::LEAVES_ONLY);
        unset($crit['recursive']);
    }

    /* @var SplFileInfo $file */
    foreach ($iterator as $file) {
        if (!$file->isFile()) {
            continue;
        }

        $item = [
            'id' => $iterator->getSubPathname(),
            'name' => $iterator->getSubPathname(),
            'path' => $file->getRealPath(),
            'extension' => $file->getExtension(),
            'size' => $file->getSize(),
            'modified' => $file->getMTime()
        ];

        if ($opts['index'] === 'uniq') {
            $data['id'][$item['id']] = $item['id'];
        } elseif (is_array($opts['index'])) {
            $data[$item[$opts['index'][0]]][$item[$opts['index'][1]]] = $item;
        } else {
            $data[$item[$opts['index']]] = $item;
        }
    }

    if ($crit) {
        $data = data_filter($data, $crit, !empty($opts['search']));
    }

    if (!empty($opts['order'])) {
        $data = data_order($data, $opts['order']);
    }

    if (!empty($opts['limit'])) {
        $data = data_limit($data, $opts['limit'], $opts['offset'] ?? 0);
    }

    return $data;
}

/**
 * Create file
 *
 * @param string $dest
 * @param string $content
 * @param int $flags
 * @param resource $context
 *
 * @return bool
 */
function file_save(string $dest, string $content, int $flags = 0, $context = null): bool
{
    if (!file_dir(dirname($dest))) {
        return false;
    }

    $umask = umask(0);
    $result = file_put_contents($dest, $content, $flags, $context);
    umask($umask);

    return $result !== false;
}

/**
 * Removes a file or directory
 *
 * A directory will be removed recursively, will preserve specified path if $preserve is set to true
 *
 * @param string $path
 * @param bool $preserve
 *
 * @return bool
 */
function file_delete(string $path, bool $preserve = false): bool
{
    if (!file_exists($path)) {
        return true;
    } elseif (!file_writable($path)) {
        return false;
    } elseif (is_file($path)) {
        return unlink($path);
    }

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator(
            $path,
            RecursiveDirectoryIterator::SKIP_DOTS | RecursiveDirectoryIterator::UNIX_PATHS
        ),
        RecursiveIteratorIterator::CHILD_FIRST
    );

    /* @var SplFileInfo $file */
    foreach ($iterator as $file) {
        if ($file->isDir()) {
            rmdir($file->getPathname());
        } elseif ($file->isFile() || $file->isLink()) {
            unlink($file->getPathname());
        }
    }

    if ($preserve) {
        return true;
    }

    rmdir($path);

    return !file_exists($path);
}

/**
 * Copies a file or directory
 *
 * @param string $src
 * @param string $dest
 * @param array $crit
 *
 * @return bool
 */
function file_copy(string $src, string $dest, array $crit = []): bool
{
    if (!($isFile = is_file($src)) && !is_dir($src) || !file_dir(dirname($dest))) {
        return false;
    }

    $umask = umask(0);

    if ($isFile) {
        copy($src, $dest);
    } else {
        $files = file_load($src, $crit);

        foreach ($files as $id => $file) {
            if (file_dir(dirname($dest . '/' . $id))) {
                copy($file['path'], $dest . '/' . $id);
            }
        }
    }

    umask($umask);

    return $isFile ? is_file($dest) : is_dir($dest);
}

/**
 * Upload file
 *
 * @param string $src
 * @param string $dest
 *
 * @return bool
 */
function file_upload(string $src, string $dest): bool
{
    if (!is_uploaded_file($src) || !file_dir(dirname($dest))) {
        return false;
    }

    $umask = umask(0);
    move_uploaded_file($src, $dest);
    umask($umask);

    return is_file($dest);
}

/**
 * Makes a directory if it doesn't exist
 *
 * @param string $path
 * @param int $mode
 * @param bool $recursive
 *
 * @return bool
 */
function file_dir(string $path, int $mode = 0775, bool $recursive = true): bool
{
    if (!file_writable($path)) {
        return false;
    } elseif (is_dir($path)) {
        return true;
    }

    $umask = umask(0);
    $result = mkdir($path, $mode, $recursive);
    umask($umask);

    return $result;
}

/**
 * Checks whether specified path is writable
 *
 * @param string $path
 *
 * @return bool
 */
function file_writable(string $path): bool
{
    static $pattern;

    if ($pattern === null) {
        $pattern = '#^(file://)?(' . path('app') . '|' . path('asset') . ')#';
    }

    return (bool) preg_match($pattern, $path);
}
