<?php
require_once __DIR__ . '/../services/EventsService.php';

/**
 * @OA\Get(
 *     path="/events/category/{category}",
 *     summary="Get events by category",
 *     security={{"JWT":{}}},
 *     operationId="getEventsByCategory",
 *     tags={"Events"},
 *     @OA\Parameter(
 *         name="category",
 *         in="path",
 *         required=true,
 *         description="Category of the event",
 *         @OA\Schema(type="string", example="music")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of events in the specified category",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="event_id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Concert in the Park"),
 *                 @OA\Property(property="category", type="string", example="music"),
 *                 @OA\Property(property="date", type="string", example="2025-05-01")
 *             )
 *         )
 *     )
 * )
 */
Flight::route('GET /events/category/@category', function($category) {
         Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::events_service()->get_by_category($category));
});
/**
 * @OA\Get(
 *     path="/events/search/{name}",
 *     summary="Search events by name",
 *     security={{"JWT":{}}},
 *     operationId="searchEventsByName",
 *     tags={"Events"},
 *     @OA\Parameter(
 *         name="name",
 *         in="path",
 *         required=true,
 *         description="Name or partial name of the event",
 *         @OA\Schema(type="string", example="Concert")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of events that match the search term",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="event_id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Concert in the Park"),
 *                 @OA\Property(property="category", type="string", example="music"),
 *                 @OA\Property(property="date", type="string", example="2025-05-01")
 *             )
 *         )
 *     )
 * )
 */
Flight::route('GET /events/search/@name', function($name) {
         Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::events_service()->search_by_name($name));
});


/**
 * @OA\Post(
 *     path="/events",
 *     summary="Create a new event",
 *     security={{"JWT":{}}},
 *     operationId="createEvent",
 *     tags={"Events"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "category", "date"},
 *             @OA\Property(property="name", type="string", example="Concert in the Park"),
 *             @OA\Property(property="category", type="string", example="music"),
 *             @OA\Property(property="date", type="string", example="2025-05-01")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Event created successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Event posted successfully."),
 *             @OA\Property(property="data", type="object", example={"event_id": 1, "name": "Concert in the Park", "category": "music", "date": "2025-05-01"})
 *         )
 *     )
 * )
 */
Flight::route('POST /events', function () {
      Flight::auth_middleware()->authorizeRoles(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    $service = new EventsService();

    Flight::json([
        'message' => 'Event posted successfully.',
        'data' => $service->add_event($data)
    ]);
});
/**
 * @OA\Put(
 *     path="/events/{id}",
 *     summary="Update an existing event by ID",
 *     security={{"JWT":{}}},
 *     operationId="updateEvent",
 *     tags={"Events"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Event ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "category", "date"},
 *             @OA\Property(property="name", type="string", example="Updated Concert in the Park"),
 *             @OA\Property(property="category", type="string", example="music"),
 *             @OA\Property(property="date", type="string", example="2025-06-01")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Event updated successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Event updated successfully."),
 *             @OA\Property(property="data", type="object", example={"event_id": 1, "name": "Updated Concert in the Park", "category": "music", "date": "2025-06-01"})
 *         )
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Unauthorized: Admins only",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Unauthorized: Admins only")
 *         )
 *     )
 * )
 */
Flight::route('PUT /events/@id', function($id) {
   
    Flight::auth_middleware()->authorizeRoles(Roles::ADMIN);
   
     $data = Flight::request()->data->getData();
    $service = new EventsService();
    Flight::json([
        'message' => 'Event updated successfully',
        'data' => $service->update($data, $id)
    ]);
});

/**
 * @OA\Delete(
 *     path="/events/{id}",
 *     summary="Delete an event by ID",
 *     security={{"JWT":{}}},
 *     operationId="deleteEvent",
 *     tags={"Events"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Event ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Event deleted successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Event deleted successfully."),
 *             @OA\Property(property="data", type="object", example={"event_id": 1})
 *         )
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Unauthorized: Admins only",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Unauthorized: Admins only")
 *         )
 *     )
 * )
 */
Flight::route('DELETE /events/@id', function($id) {

    Flight::auth_middleware()->authorizeRoles(Roles::ADMIN);
    $data = Flight::request()->data->getData();

    $service = new EventsService();
    $service->delete($id);

    Flight::json(['message' => 'Event deleted successfully']);
});