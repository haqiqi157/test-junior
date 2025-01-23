<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseAPI;
use App\Http\Controllers\Controller;
use App\Services\StatusService;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    protected $statusService;

    public function __construct(StatusService $statusService)
    {
        $this->statusService = $statusService;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function fetch(Request $request)
    {
        try {

            $limit = $request->input('limit', 10);

            $status = $this->statusService->findALl($limit);

            return ResponseAPI::success($status, 'successfully fetch all status');
        } catch (\Exception $e) {
            return ResponseAPI::error($e->getMessage(),500);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function findById($id)
    {
        try {
            // Panggil service untuk mengambil data berdasarkan ID
            $status = $this->statusService->findById($id);

            // Kembalikan respons sukses jika produk ditemukan
            return ResponseAPI::success($status, "successfully find status with id `{$id}`");
        } catch (\Exception $e) {
            // Kembalikan respons error jika ada exception
            return ResponseAPI::error('data not found', 404);
        }
    }

    public function createStatus(Request $request)
    {
        try {
            $name_status = $request->input('name_status');

            if (strlen($name_status) < 3)
            {
                throw new \Exception('name_status must be at least 3 characters');
            }

            $status = $this->statusService->createStatus([
                'name_status' => $name_status
            ]);

            return ResponseAPI::success($status, 'successfully create status');
        } catch (\Exception $e) {
            return ResponseAPI::error($e->getMessage(),500);
        }
    }


    public function updateStatus(Request $request, $id)
    {
        try {

            $name_status = $request->input('name_status');

            if (strlen($name_status) < 3)
            {
                throw new \Exception('name_status must be at least 3 characters');
            }

            if(!$name_status)
            {
                throw new \Exception('name_status must be provided');
            }

            $status = $this->statusService->updateStatus($id,
                [
                'name_status' => $name_status
                ]
            );

            return ResponseAPI::success($status, "success update status with id {$id}");
        } catch (\Exception $e) {
            return ResponseAPI::error($e->getMessage(),500);
        }
    }


    public function deleteStatus($id)
    {
        try {

            $status = $this->statusService->deleteStatus($id);

            return ResponseAPI::success($status, "success delete status with id {$id}");
        } catch (\Exception $e) {
            return ResponseAPI::error($e->getMessage(),404);
        }
    }

}
