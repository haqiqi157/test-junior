<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{

    public function findAll(int $Limit)
    {
        $categories = Category::with(['products'])->paginate($Limit);

        return $categories;
    }

    public function checkName(string $name)
    {
        $category = Category::where('name_category',$name)->first();

        return $category;
    }

    public function findById($id)
    {
        $category = Category::with('products')->find($id);
        return $category;
    }

    public function createCategory(array $data)
    {
        $category = Category::create($data);

        return $category;
    }

    public function updateCategory($id, array $data)
    {
        $category = Category::find($id);

        if (!$category)
        {
            return null;
        }

        $category->update($data);

        return $category;
    }

    public function deleteCategory($id)
    {
        $category = Category::find($id);

        if (!$category)
        {
            return null;
        }

        $category->delete($category);
    }
}
