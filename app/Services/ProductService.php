<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\StatusRepository;

class ProductService
{
    protected $productRepository;
    protected $statusRepository;
    protected $categoryRepository;

    public function __construct(ProductRepository $productRepository, StatusRepository $statusRepository, CategoryRepository $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->statusRepository = $statusRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function findAll(int $limit)
    {
        $products = $this->productRepository->findAll($limit);

        if (!$products)
        {
            throw new \Exception('there is no product');
        }

        return $products;
    }

    public function findById($id)
    {
        $product = $this->productRepository->findById($id);

        if (!$product)
        {
                throw new \Exception('invalid id');
        }

        return $product;
    }

    public function findByCategoryId($category_id, int $limit)
    {
        $product = $this->productRepository->findByCategoryId($category_id, $limit);

        if(!$product)
        {
            throw new \Exception('category_id does not exist');
        }

        return $product;
    }

    public function findByStatusId($status_id, int $limit)
    {
        $product = $this->productRepository->findByStatusId($status_id, $limit);

        if(!$product)
        {
            throw new \Exception('status_id does not exist');
        }

        return $product;
    }

    public function findByName(string $name)
    {
        $product = $this->productRepository->findByName($name);

        if(!$product)
        {
            throw new \Exception('name does not exist');
        }

        return $product;
    }

    public function createProduct(array $data)
    {
        $category_id = $this->categoryRepository->findById($data['category_id']);
        $status_id = $this->statusRepository->findById($data['status_id']);
        $name = $this->productRepository->checkName($data['name_product']);

        if (!$category_id) {
            throw new \Exception('invalid category_id');
        }

        if (!$status_id) {
            throw new \Exception('invalid status_id');
        }

        if ($name)
        {
            throw new \Exception('name already exists');
        }

        $product = $this->productRepository->createProduct($data);

        return $product;
    }

    public function updateProduct($id, array $data)
    {
        $id_product = $this->productRepository->findById($id);
        $category_id = $this->categoryRepository->findById($data['category_id']);
        $status_id = $this->statusRepository->findById($data['status_id']);

        if(!$id_product)
        {
            throw new \Exception("there is no product with id {$id}");
        }

        if (!$category_id) {
            throw new \Exception('invalid category_id');
        }

        if (!$status_id) {
            throw new \Exception('invalid status_id');
        }

        $product = $this->productRepository->updateProduct($id, $data);

        return $product;
    }

    public function deleteProduct($id)
    {
        $id_product = $this->productRepository->findById($id);

        if (!$id_product)
        {
            throw new \Exception("there is no product with id {$id}");
        }

        $product = $this->productRepository->deleteProduct($id);

        return $product;
    }

}
