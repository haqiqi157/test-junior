<?php

namespace App\Services;

use App\Repositories\CategoryRepository;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function findAll(int $limit)
    {
        $categories = $this->categoryRepository->findAll($limit);

        return $categories;
    }

    public function findById($id)
    {
        $category = $this->categoryRepository->findById($id);

        return $category;
    }

    public function createCategory(array $data)
    {
        $checkName = $this->categoryRepository->checkName($data['name_category']);

        if ($checkName)
        {
            throw new \Exception('name_category already exists');
        }

        $category = $this->categoryRepository->createCategory($data);

        return $category;
    }

    public function updateCategory($id, array $data)
    {
        $id_category = $this->categoryRepository->findById($id);

        if (!$id_category)
        {
            throw new \Exception("there is no category with id {$id}");
        }

        $category = $this->categoryRepository->updateCategory($id, $data);

        return $category;
    }

    public function deleteCategory($id)
    {
        $id_category = $this->categoryRepository->findById($id);

        if (!$id_category)
        {
            throw new \Exception("there is no category with id {$id}");
        }
        $category = $this->categoryRepository->deleteCategory($id);

        return $category;
    }

}
