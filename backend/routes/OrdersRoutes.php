<?php
require_once __DIR__ . '/../services/OrdersService.php';

$ordersService = new OrdersService();
/**
 * @OA\Post(
 *     path="/orders",
 *     summary="Place an order",
 *     security={{"JWT":{}}},
 *     operationId="placeOrder",
 *     tags={"Orders"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"product_id", "quantity", "user_id"},
 *             @OA\Property(property="product_id", type="integer", example=1),
 *             @OA\Property(property="quantity", type="integer", example=2),
 *             @OA\Property(property="user_id", type="integer", example=123)
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Order placed successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Order placed successfully."),
 *             @OA\Property(property="data", type="object", example={"order_id": 1, "product_id": 1, "quantity": 2, "user_id": 123})
 *         )
 *     )
 * )
 */
//USER: Place an order
Flight::route('POST /orders', function () use ($ordersService) {
     Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    $data = Flight::request()->data->getData();
    Flight::json([
        'message' => 'Order placed successfully.',
        'data' => $ordersService->place_order($data)
    ]);
});
/**
 * @OA\Get(
 *     path="/orders",
 *     summary="Get all orders (Admin only)",
 *     security={{"JWT":{}}},
 *     operationId="getAllOrdersAdmin",
 *     tags={"Orders"},
 *     @OA\Response(
 *         response=200,
 *         description="List of all orders",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="order_id", type="integer", example=1),
 *                 @OA\Property(property="product_id", type="integer", example=1),
 *                 @OA\Property(property="quantity", type="integer", example=2),
 *                 @OA\Property(property="user_id", type="integer", example=123),
 *                 @OA\Property(property="status", type="string", example="pending")
 *             )
 *         )
 *     )
 * )
 */
// ADMIN: Get all orders
Flight::route('GET /orders', function () use ($ordersService) {
    Flight::auth_middleware()->authorizeRoles(Roles::ADMIN);
    Flight::json($ordersService->admin_get_all());
});
/**
 * @OA\Put(
 *     path="/orders/{id}",
 *     summary="Update an existing order by ID (Admin only)",
 *     security={{"JWT":{}}},
 *     operationId="updateOrderAdmin",
 *     tags={"Orders"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Order ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"quantity", "status"},
 *             @OA\Property(property="quantity", type="integer", example=3),
 *             @OA\Property(property="status", type="string", example="shipped")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Order updated successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Order updated successfully."),
 *             @OA\Property(property="data", type="object", example={"order_id": 1, "product_id": 1, "quantity": 3, "status": "shipped"})
 *         )
 *     )
 * )
 */
// ADMIN: Update an order
Flight::route('PUT /orders/@id', function ($id) use ($ordersService) {
    Flight::auth_middleware()->authorizeRoles(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json([
        'message' => 'Order updated successfully.',
        'data' => $ordersService->admin_update($data, $id)
    ]);
});
/**
 * @OA\Delete(
 *     path="/orders/{id}",
 *     summary="Delete an order by ID (Admin only)",
 *     security={{"JWT":{}}},
 *     operationId="deleteOrderAdmin",
 *     tags={"Orders"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Order ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Order deleted successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Order deleted successfully."),
 *             @OA\Property(property="data", type="object", example={"order_id": 1})
 *         )
 *     )
 * )
 */
// ADMIN: Delete an order
Flight::route('DELETE /orders/@id', function ($id) use ($ordersService) {
    Flight::auth_middleware()->authorizeRoles(Roles::ADMIN);
    Flight::json([
        'message' => 'Order deleted successfully.',
        'data' => $ordersService->admin_delete($id)
    ]);
});
/**
 * @OA\Get(
 *     path="/orders/{id}",
 *     summary="Get an order by ID (Admin only)",
 *     security={{"JWT":{}}},
 *     operationId="getOrderById",
 *     tags={"Orders"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Order ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Order details",
 *         @OA\JsonContent(
 *             @OA\Property(property="order_id", type="integer", example=1),
 *             @OA\Property(property="product_id", type="integer", example=1),
 *             @OA\Property(property="quantity", type="integer", example=2),
 *             @OA\Property(property="status", type="string", example="pending")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Order not found"
 *     )
 * )
 */
// ADMIN: Get single order by ID
Flight::route('GET /orders/@id', function ($id) use ($ordersService) {
   Flight::auth_middleware()->authorizeRoles(Roles::ADMIN);
    Flight::json($ordersService->get_by_id($id));
});