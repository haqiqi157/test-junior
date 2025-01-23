<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseAPI;
use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     */
    public function fetch(Request $request)
    {
        //find data with pagination
        try {
            $category_id = $request->input('category_id');
            $status_id = $request->input('status_id');
            $name = $request->input('name');
            $limit = $request->input('limit', 10);

            //minimal 3 characters
//            if (strlen($name) < 3)
//            {
//                throw new \Exception('name must be at least 3 characters long');
//            }

            switch (true) {
                case !empty($category_id):
                    // fetch by category_id
                    $products = $this->productService->findByCategoryId($category_id, $limit);
                    $message = "successfully fetched products with category_id {$category_id}";
                    break;

                case !empty($status_id):
                    // fetch by status_id
                    $products = $this->productService->findByStatusId($status_id, $limit);
                    $message = "successfully fetched products with status_id {$status_id}";
                    break;

                case !empty($name):
                    // fetch by name
                    $products = $this->productService->findByName($name);
                    $message = "successfully fetched products with name {$name}";
                    break;

                default:
                    // fetch all products
                    $products = $this->productService->findAll($limit);
                    $message = 'successfully fetched all products';
                    break;
            }

            // return response success
            return ResponseAPI::success($products, $message);
        } catch (\Exception $e) {
            // return response error
            return ResponseAPI::error($e->getMessage(), 404); // Menggunakan status code 500 untuk internal server error
        }

    }

    public function findById($id)
    {
        try {
            //call product service
            $product = $this->productService->findById($id);

            // return response success
            return ResponseAPI::success($product, "successfully find product with id `{$id}`");
        } catch (Exception $e) {
            // return response error
            return ResponseAPI::error($e->getMessage(), 404);
        }
    }

    public function createProduct(Request $request)
    {
        try {

            $name_product = $request->input('name_product');
            $price = $request->input('price');
            $category_id = $request->input('category_id');
            $status_id = $request->input('status_id');

            if (!$name_product)
            {
                throw new \Exception('name_product must be provided');
            }

            if (!$price)
            {
                throw new \Exception('price must be provided');
            }

            if (!$category_id)
            {
                throw new \Exception('category_id must be provided');
            }

            if (!$status_id)
            {
                throw new \Exception('status_id must be provided');
            }

            $product = $this->productService->createProduct(
                [
                    'name_product' => $name_product,
                    'slug' => Str::slug($name_product),
                    'price' => $price,
                    'category_id' => $category_id,
                    'status_id' => $status_id,
                ]
            );
            return ResponseAPI::success($product, 'successfully created product');
        } catch (\Exception $e) {
            return ResponseAPI::error($e->getMessage(),500);
        }
    }

    public function updateProduct(Request $request, $id)
    {
        try {

            $name_product = $request->input('name_product');
            $price = $request->input('price');
            $category_id = $request->input('category_id');
            $status_id = $request->input('status_id');

            if (!$name_product)
            {
                throw new \Exception('name_product must be provided');
            }

            if (!$price)
            {
                throw new \Exception('price must be provided');
            }

            if (!$category_id)
            {
                throw new \Exception('category_id must be provided');
            }

            if (!$status_id)
            {
                throw new \Exception('status_id must be provided');
            }

            $product = $this->productService->updateProduct($id,
                [
                    'name_product' => $name_product,
                    'slug' => Str::slug($name_product),
                    'price' => $price,
                    'category_id' => $category_id,
                    'status_id' => $status_id
                ]
            );

            return ResponseAPI::success($product, "success update data product {$id}");
        } catch (\Exception $e) {
            return ResponseAPI::error($e->getMessage(), 500);
        }
    }

    public function deleteProduct($id)
    {
        try {

            $product = $this->productService->deleteProduct($id);

            return ResponseAPI::success($product, "success delete product with id {$id}");
        } catch (\Exception $e)
        {
            return ResponseAPI::error($e->getMessage(), 404);
        }
    }
}
