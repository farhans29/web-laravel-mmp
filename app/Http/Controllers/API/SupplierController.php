<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MSupplier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as HttpStatus;

class SupplierController extends Controller
{
    /**
     * Validate the supplier request data
     */
    protected function validateSupplier(Request $request, bool $isUpdate = false): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:500'],
            'city' => ['nullable', 'string', 'max:100'],
            'country' => ['nullable', 'string', 'max:100'],
            'zipcode' => ['nullable', 'string', 'max:20'],
            'telephone' => ['nullable', 'string', 'max:20'],
            'fax' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'tax_name' => ['nullable', 'string', 'max:255'],
            'tax_address' => ['nullable', 'string', 'max:500'],
            'tax_city' => ['nullable', 'string', 'max:100'],
            'tax_country' => ['nullable', 'string', 'max:100'],
            'tax_zipcode' => ['nullable', 'string', 'max:20'],
            'tax_id' => ['nullable', 'string', 'max:50'],
            'is_active' => ['boolean'],
            'pic_1' => ['nullable', 'string', 'max:100'],
            'ext_1' => ['nullable', 'string', 'max:20'],
            'pic_2' => ['nullable', 'string', 'max:100'],
            'ext_2' => ['nullable', 'string', 'max:20'],
            'pic_3' => ['nullable', 'string', 'max:100'],
            'ext_3' => ['nullable', 'string', 'max:20'],
        ];

        // If this is an update, make fields optional
        if ($isUpdate) {
            $rules = array_map(function ($rule) {
                return array_merge($rule, ['sometimes']);
            }, $rules);
        }

        return $request->validate($rules);
    }
    /**
     * @OA\Get(
     *     path="/api/v1/supplier",
     *     summary="Get all suppliers",
     *     tags={"Supplier"},
     *     @OA\Response(
     *         response=200,
     *         description="List of suppliers",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Supplier"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        try {
            $suppliers = MSupplier::where('is_active', 1)->get();
            return response()->json(['data' => $suppliers]);
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to retrieve suppliers',
                HttpStatus::HTTP_INTERNAL_SERVER_ERROR,
                $e
            );
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/supplier",
     *     summary="Create a new supplier",
     *     tags={"Supplier"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/SupplierRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Supplier created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Supplier")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $this->validateSupplier($request);
            
            // Create the supplier with all validated data
            $supplier = new MSupplier($validated);
            $supplier->save();

            return response()->json(
                ['data' => $supplier],
                HttpStatus::HTTP_CREATED
            );
        } catch (ValidationException $e) {
            return $this->errorResponse(
                'Validation failed',
                HttpStatus::HTTP_UNPROCESSABLE_ENTITY,
                $e,
                ['errors' => $e->errors()]
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to create supplier',
                HttpStatus::HTTP_INTERNAL_SERVER_ERROR,
                $e
            );
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/supplier/{id}",
     *     summary="Get a specific supplier",
     *     tags={"Supplier"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Supplier ID"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Supplier details",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Supplier")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Supplier not found"
     *     )
     * )
     */
    public function show(string $id): JsonResponse
    {
        try {
            $supplier = MSupplier::where('is_active', 1)->findOrFail($id);
            return response()->json(['data' => $supplier]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse(
                'Supplier not found',
                HttpStatus::HTTP_NOT_FOUND,
                $e
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to retrieve supplier',
                HttpStatus::HTTP_INTERNAL_SERVER_ERROR,
                $e
            );
        }
    }

    /**
     * @OA\Put(
     *     path="/api/v1/supplier/{id}",
     *     summary="Update a supplier",
     *     tags={"Supplier"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Supplier ID"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/SupplierRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Supplier updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Supplier")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Supplier not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $supplier = MSupplier::findOrFail($id);
            $validated = $this->validateSupplier($request, true);
            
            // Update the supplier with the validated data
            $supplier->update($validated);

            return response()->json(['data' => $supplier->fresh()]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse(
                'Supplier not found',
                HttpStatus::HTTP_NOT_FOUND,
                $e
            );
        } catch (ValidationException $e) {
            return $this->errorResponse(
                'Validation failed',
                HttpStatus::HTTP_UNPROCESSABLE_ENTITY,
                $e,
                ['errors' => $e->errors()]
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to update supplier',
                HttpStatus::HTTP_INTERNAL_SERVER_ERROR,
                $e
            );
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/supplier/{id}",
     *     summary="Delete a supplier",
     *     tags={"Supplier"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Supplier ID"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Supplier deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Supplier not found"
     *     )
     * )
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $supplier = MSupplier::findOrFail($id);
            $supplier->delete();
            
            return response()->json(
                ['message' => 'Supplier deleted successfully']
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse(
                'Supplier not found',
                HttpStatus::HTTP_NOT_FOUND,
                $e
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to delete supplier',
                HttpStatus::HTTP_INTERNAL_SERVER_ERROR,
                $e
            );
        }
    }

    /**
     * Format error response
     */
    /**
     * @OA\Post(
     *     path="/api/v1/supplier/{id}/soft-delete",
     *     summary="Soft delete a supplier by setting is_active to 0",
     *     tags={"Supplier"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Supplier ID"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Supplier soft deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Supplier soft deleted successfully"),
     *             @OA\Property(property="status", type="integer", example=200)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Supplier not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to soft delete supplier"
     *     )
     * )
     */
    public function softDelete(Request $request, string $id): JsonResponse
    {
        try {
            $supplier = MSupplier::findOrFail($id);
            
            // Get updated_by from request or use authenticated user's ID
            $updatedBy = $request->input('updated_by', auth()->id());
            
            $supplier->update([
                'is_active' => 0,
                'updated_by' => $updatedBy
            ]);

            return response()->json([
                'message' => 'Supplier soft deleted successfully',
                'status' => HttpStatus::HTTP_OK
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse(
                'Supplier not found',
                HttpStatus::HTTP_NOT_FOUND,
                $e
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to soft delete supplier',
                HttpStatus::HTTP_INTERNAL_SERVER_ERROR,
                $e
            );
        }
    }

    /**
     * Format error response
     */
    private function errorResponse(
        string $message,
        int $statusCode,
        ?\Throwable $exception = null,
        array $additional = []
    ): JsonResponse {
        $response = [
            'message' => $message,
            'status' => $statusCode,
        ];

        if (config('app.debug') && $exception) {
            $response['debug'] = [
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => $exception->getTraceAsString(),
            ];
        }

        return response()->json(
            array_merge($response, $additional),
            $statusCode
        );
    }
}
