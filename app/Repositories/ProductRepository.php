<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{

    public function findAll(int $limit)
    {
        $products = Product::with(['category', 'status'])->paginate($limit);
        return $products;
    }
    public function findById($id)
    {
        $product = Product::with(['category', 'status'])->where('id', $id)->first();

        return $product;
    }

    public function findByName(string $name)
    {
        // Menggunakan LIKE untuk mencari produk yang mengandung kata yang diinputkan
        $products = Product::where('name_product', 'LIKE', '%' . $name . '%')->get();

        if ($products->isEmpty())
        {
            throw new \Exception('name_product does not exist');
        }

        return $products;
    }

    public function checkName(string $name)
    {
        $products = Product::where('name_product', $name)->first();

        return $products;
    }

    public function findByCategoryId($category_id, int $limit)
    {
        $product = Product::where('category_id', $category_id)->paginate($limit);

        if ($product->isEmpty())
        {
            return null;
        }

        return $product;
    }

    public function findByStatusId($status_id, int $limit)
    {
        $product = Product::where('status_id', $status_id)->paginate($limit);

        if ($product->isEmpty())
        {
            return null;
        }

        return $product;
    }

    public function createProduct(array $data)
    {
        $product = Product::create($data);

        return $product;
    }

    public function updateProduct($id, array $data)
    {
        // Cari produk berdasarkan ID
        $product = Product::find($id);

        if (!$product)
        {
            return null;
        }
        $product->update($data);

        return $product;
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);

        if (!$product)
        {
            return null;
        }

        $product->delete($product);
    }

}
