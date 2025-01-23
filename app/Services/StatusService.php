<?php

namespace App\Services;

use App\Repositories\StatusRepository;

class StatusService
{
    protected $statusRepository;

    public function __construct(StatusRepository $statusRepository)
    {
        $this->statusRepository = $statusRepository;
    }

    public function findALl(int $limit)
    {
        $product = $this->statusRepository->findAll($limit);

        return $product;
    }

    public function findById($id)
    {
        $status = $this->statusRepository->findById($id);

        return $status;
    }

    public function createStatus(array $data)
    {
        $checkName = $this->statusRepository->checkName($data['name_status']);

        if ($checkName)
        {
            throw new \Exception('name_status already exists');
        }

        $status = $this->statusRepository->createStatus($data);

        return $status;

    }

    public function updateStatus($id, array $data)
    {
        $id_status = $this->statusRepository->findById($id);

        if (!$id_status)
        {
            throw new \Exception("there is no status with id {$id}");
        }

        $status = $this->statusRepository->updateStatus($id, $data);

        return $status;

    }

    public function deleteStatus($id)
    {
        $id_status = $this->statusRepository->findById($id);

        if (!$id_status)
        {
            throw new \Exception("there is no status with id {$id}");
        }

        $status = $this->statusRepository->deleteStatus($id);

        return $status;
    }
}
