<?php
namespace qnd;

/**
 * Project
 *
 * @param string $key
 *
 * @return mixed
 */
function project(string $key = null)
{
    static $data;

    if ($data === null) {
        $data = [];
        $id = session('project');
        $criteria = $id === null ? ['host' => request('host')] : ['id' => $id];
        $criteria['active'] = true;
        $data = load('project', $criteria, false);

        if (!$data) {
            $data = load('project', ['id' => 0, 'active' => true], false);
        }

        if ($id <= 0 || !$data) {
            session('project', null, true);
        }
    }

    if ($key === null) {
        return $data;
    }

    return $data[$key] ?? null;
}
