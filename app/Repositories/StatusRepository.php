<?php

namespace App\Repositories;

use App\Models\Status;

class StatusRepository
{
    public function findById($id)
    {
        $status = Status::with('product')->find($id);

        return $status;
    }

    public function findAll(int $limit)
    {
        $status = Status::with('product')->paginate($limit);

        return $status;
    }

    public function checkName(string $name)
    {
        $status = Status::where('name_status', $name)->first();

        return $status;
    }


    public function createStatus(array $data)
    {
        $status = Status::create($data);

        return $status;
    }

    public function updateStatus($id,array $data)
    {
        $status = Status::find($id);

        if (!$status)
        {
            return null;
        }

        $status->update($data);

        return $status;
    }

    public function deleteStatus($id)
    {
        $status = Status::find($id);

        if (!$status)
        {
            return null;
        }

        $status->delete($status);
    }
}
