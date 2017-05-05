<?php
declare(strict_types = 1);

namespace qnd;

/**
 * Config
 *
 * @param string $section
 * @param string $id
 *
 * @return mixed
 */
function config(string $section, string $id = null)
{
    $data = & registry('config.' . $section);

    if ($data === null) {
        $data = file_data(path('config', $section . '.php'));
        $data = event('config.load.' . $section, $data);
    }

    if ($id === null) {
        return $data;
    }

    return $data[$id] ?? null;
}

/**
 * Sort order
 *
 * @param array $data
 * @param array $order
 *
 * @return array
 */
function config_order(array $data, array $order): array
{
    uasort(
        $data,
        function (array $a, array $b) use ($order) {
            foreach ($order as $key => $dir) {
                $factor = $dir === 'desc' ? -1 : 1;

                if ($result = ($a[$key] ?? null) <=> ($b[$key] ?? null)) {
                    return $result * $factor;
                }
            }

            return 0;
        }
    );

    return $data;
}
