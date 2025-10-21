<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MInventory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as HttpStatus;

class InventoryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/inventory",
     *     summary="Get all inventory items",
     *     tags={"Inventory"},
     *     @OA\Response(
     *         response=200,
     *         description="List of inventory items",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Inventory"))
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
            $inventories = MInventory::where('is_active', 1)->get();
            return response()->json(['data' => $inventories]);
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to retrieve inventory items',
                HttpStatus::HTTP_INTERNAL_SERVER_ERROR,
                $e
            );
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/inventory",
     *     summary="Create a new inventory item",
     *     tags={"Inventory"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/InventoryRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Inventory item created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Inventory")
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
            $validated = $this->validateInventory($request);
            
            // Create the inventory with all validated data
            $inventory = new MInventory($validated);
            $inventory->updated_by = null;
            $inventory->created_at = now()->timezone('+07:00');
            $inventory->updated_at = null;

            $inventory->save();

            return response()->json(
                ['data' => $inventory],
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
                'Failed to create inventory item',
                HttpStatus::HTTP_INTERNAL_SERVER_ERROR,
                $e
            );
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/inventory/{id}",
     *     summary="Get a specific inventory item",
     *     tags={"Inventory"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Inventory ID"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Inventory item details",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Inventory")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Inventory item not found"
     *     )
     * )
     */
    public function show(string $id): JsonResponse
    {
        try {
            // Find inventory by exact ID using findOrFail for proper 404 handling
            $inventory = MInventory::where('is_active', 1)
                ->where('id_inventory', $id)
                ->firstOrFail();

            return response()->json([
                'data' => $inventory,
                'message' => 'Data retrieved successfully',
                'status' => HttpStatus::HTTP_OK
            ], HttpStatus::HTTP_OK);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse(
                'Inventory item not found',
                HttpStatus::HTTP_NOT_FOUND,
                $e
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to retrieve inventory item',
                HttpStatus::HTTP_INTERNAL_SERVER_ERROR,
                $e
            );
        }
    }



    /**
     * @OA\Put(
     *     path="/api/v1/inventory/{id}",
     *     summary="Update an inventory item",
     *     tags={"Inventory"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Inventory ID"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/InventoryRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Inventory item updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Inventory")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Inventory item not found"
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
            $inventory = MInventory::findOrFail($id);
            $validated = $this->validateInventory($request, true);
            
            // Allow updated_by to be set via JSON, but fallback to authenticated user's ID if not provided
            $updateData = $validated;
            if (!isset($updateData['updated_by'])) {
                $updateData['updated_by'] = auth()->id();
            }

            $inventory->updated_at = now()->timezone('+07:00');

            // Update the inventory with the prepared data
            $inventory->update($updateData);

            return response()->json(['data' => $inventory->fresh()]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse(
                'Inventory item not found',
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
                'Failed to update inventory item: ' . $e->getMessage(),
                HttpStatus::HTTP_INTERNAL_SERVER_ERROR,
                $e
            );
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/inventory/{id}",
     *     summary="Delete an inventory item",
     *     tags={"Inventory"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Inventory ID"
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Inventory item deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Inventory item not found"
     *     )
     * )
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $inventory = MInventory::findOrFail($id);
            $inventory->delete();

            return response()->json([
                'message' => 'Inventory item deleted successfully',
                'status' => HttpStatus::HTTP_OK
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse(
                'Inventory item not found',
                HttpStatus::HTTP_NOT_FOUND,
                $e
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to delete inventory item',
                HttpStatus::HTTP_INTERNAL_SERVER_ERROR,
                $e
            );
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/inventory/{id}/soft-delete",
     *     summary="Soft delete an inventory item by setting is_active to 0",
     *     tags={"Inventory"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Inventory ID"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Inventory item soft deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Inventory item soft deleted successfully"),
     *             @OA\Property(property="status", type="integer", example=200)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Inventory item not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to soft delete inventory item"
     *     )
     * )
     */
    public function softDelete(Request $request, string $id): JsonResponse
    {
        try {
            $inventory = MInventory::findOrFail($id);
            
            // Get updated_by from request or use authenticated user's ID
            $updatedBy = $request->input('updated_by', auth()->id());
            
            $inventory->updated_at = now()->timezone('+07:00');
            $inventory->deleted_at = now()->timezone('+07:00');

            $inventory->update([
                'is_active' => 0,
                'updated_by' => $updatedBy,
            ]);

            return response()->json([
                'message' => 'Inventory item soft deleted successfully',
                'status' => HttpStatus::HTTP_OK
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse(
                'Inventory item not found',
                HttpStatus::HTTP_NOT_FOUND,
                $e
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to soft delete inventory item',
                HttpStatus::HTTP_INTERNAL_SERVER_ERROR,
                $e
            );
        }
    }

    /**
     * Validate inventory request data
     */
    private function validateInventory(Request $request, bool $isUpdate = false): array
    {
        $rules = [
            'id_inventory' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'name' => 'required|string|max:255',
            'qty' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'hpp' => 'required|numeric|min:0',
            'automargin' => 'required|numeric|min:0|max:100',
            'minsales' => 'required|numeric|min:0',
            'pricelist' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
            'brand' => 'nullable|string|max:100',
            'is_active' => 'boolean',
            'WSPrice' => 'required|numeric|min:0',
            'lastpurchase' => 'nullable|date',
            'created_by' => 'nullable|integer|exists:users,id',
            'updated_by' => 'nullable|integer|exists:users,id'
        ];

        if ($isUpdate) {
            // Make fields optional for update
            foreach ($rules as $field => $rule) {
                if ($field !== 'is_active') {
                    $rules[$field] = str_replace('required|', '', $rule);
                }
            }
        }

        return $request->validate($rules);
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
