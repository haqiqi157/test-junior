<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseAPI;
use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function fetch(Request $request)
    {
        try {
            $limit = $request->input('limit', 10);

            $categories = $this->categoryService->findAll($limit);

            return ResponseAPI::success($categories, 'successfully fetch categories');
        } catch (\Exception $e) {
            return ResponseAPI::error($e->getMessage(), 500);
        }

    }

    /**
     * Display a listing of the resource.
     */

    public function findById($id)
    {
        try {
            // Panggil service untuk mengambil data berdasarkan ID
            $status = $this->categoryService->findById($id);

            // Kembalikan respons sukses jika produk ditemukan
            return ResponseAPI::success($status, "successfully find product with id `{$id}`");
        } catch (\Exception $e) {
            // Kembalikan respons error jika ada exception
            return ResponseAPI::error('data not found', 404);
        }
    }

    public function createCategory(Request $request)
    {
        try {
            $name_category = $request->input('name_category');

            if (strlen($name_category) < 3)
            {
                throw new \Exception('name_category must be at least 3 characters');
            }

            if (!$name_category)
            {
                throw new \Exception('name_category must be provided');
            }

            $category = $this->categoryService->createCategory(
                [
                'name_category' => $name_category
                ]
            );

            return ResponseAPI::success($category, 'successfully create category');
        } catch (\Exception $e)
        {
            return ResponseAPI::error($e->getMessage(),500);
        }

    }

    public function updateCategory(Request $request, $id)
    {
        try {
            $name_category = $request->input('name_category');

            if (strlen($name_category) < 3)
            {
                throw new \Exception('name_category must be at least 3 characters');
            }

            $category = $this->categoryService->updateCategory($id,
                [
                'name_category' => $name_category
                ]
            );

            return ResponseAPI::success($category, "successfully update category with id {$id}");
        } catch (\Exception $e)
        {
            return ResponseAPI::error($e->getMessage(),404);
        }

    }

    public function deleteCategory($id)
    {
        try {
            $category = $this->categoryService->deleteCategory($id);
            return ResponseAPI::success($category, "success delete category with id {$id}");
        } catch (\Exception $e)
        {
            return ResponseAPI::error($e->getMessage(),404);
        }

    }
}
