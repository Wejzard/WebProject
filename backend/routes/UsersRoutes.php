<?php
require_once __DIR__ . '/../services/UsersService.php';
/**
 * @OA\Post(
 *     path="/register",
 *     summary="Register a new user",
 *     operationId="registerUser",
 *     tags={"User"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"username", "email", "password"},
 *             @OA\Property(property="username", type="string", example="user123"),
 *             @OA\Property(property="email", type="string", example="user@example.com"),
 *             @OA\Property(property="password", type="string", example="password123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User registered successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="User registered successfully"),
 *             @OA\Property(property="data", type="object", example={"id": 1, "username": "user123"})
 *         )
 *     )
 * )
 */
Flight::route('POST /register', function () {
    $data = Flight::request()->data->getData();
    $service = new UsersService();

    Flight::json([
        'message' => 'User registered successfully',
        'data' => $service->register($data)
    ]);
});
/**
 * @OA\Post(
 *     path="/login",
 *     summary="Login an existing user",
 *     operationId="loginUser",
 *     tags={"User"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email", "password"},
 *             @OA\Property(property="email", type="string", example="user@example.com"),
 *             @OA\Property(property="password", type="string", example="password123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Login successful",
 *         @OA\JsonContent(
 *             @OA\Property(property="token", type="string", example="jwt_token_example")
 *         )
 *     )
 * )
 */
Flight::route('POST /login', function () {
    $data = Flight::request()->data->getData();
    $service = new UsersService();

    Flight::json($service->login($data));
});
/**
 * @OA\Post(
 *     path="/change-password",
 *     summary="Change user password",
 *     operationId="changeUserPassword",
 *     tags={"User"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email", "new_password", "old_password"},
 *             @OA\Property(property="email", type="string", example="user@example.com"),
 *             @OA\Property(property="new_password", type="string", example="new_password123"),
 *             @OA\Property(property="old_password", type="string", example="old_password123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Password updated successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Password updated successfully"),
 *             @OA\Property(property="data", type="object", example={"id": 1, "username": "user123"})
 *         )
 *     )
 * )
 */
Flight::route('POST /change-password', function () {
    $data = Flight::request()->data->getData();
    $service = new UsersService();

    Flight::json([
        'message' => 'Password updated successfully',
        'data' => $service->change_password($data)
    ]);
});
/**
 * @OA\Get(
 *     path="/users",
 *     summary="Get all users",
 *     operationId="getAllUsers",
 *     tags={"User"},
 *     @OA\Response(
 *         response=200,
 *         description="List of all users",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="username", type="string", example="user123"),
 *                 @OA\Property(property="email", type="string", example="user@example.com")
 *             )
 *         )
 *     )
 * )
 */
Flight::route('GET /users', function () {
    $service = new UsersService();
    Flight::json($service->get_all());
});
/**
 * @OA\Get(
 *     path="/users/{id}",
 *     summary="Get user by ID",
 *     operationId="getUserById",
 *     tags={"User"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the user to retrieve",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User found",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="username", type="string", example="user123"),
 *             @OA\Property(property="email", type="string", example="user@example.com")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found"
 *     )
 * )
 */
// Get user by ID
Flight::route('GET /users/@id', function ($id) {
    $service = new UsersService();
    Flight::json($service->get_by_id($id));
});
/**
 * @OA\Put(
 *     path="/users/{id}",
 *     summary="Update an existing user by ID",
 *     operationId="updateUser",
 *     tags={"User"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the user to update",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"username", "email"},
 *             @OA\Property(property="username", type="string", example="user123"),
 *             @OA\Property(property="email", type="string", example="user@example.com")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User updated successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="User updated successfully"),
 *             @OA\Property(property="data", type="object", example={"id": 1, "username": "user123"})
 *         )
 *     )
 * )
 */
Flight::route('PUT /users/@id', function ($id) {
    $data = Flight::request()->data->getData();
    $service = new UsersService();

    Flight::json([
        'message' => 'User updated successfully',
        'data' => $service->update($data, $id, 'user_id')
    ]);
});
/**
 * @OA\Delete(
 *     path="/users/{id}",
 *     summary="Delete a user by ID",
 *     operationId="deleteUser",
 *     tags={"User"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the user to delete",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User deleted successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="User deleted successfully.")
 *         )
 *     )
 * )
 */
Flight::route('DELETE /users/@id', function ($id) {
    $service = new UsersService();
    $service->delete($id);
    Flight::json(['message' => "User deleted successfully."]);
});





