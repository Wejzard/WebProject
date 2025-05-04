<?php 
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/routes/UsersRoutes.php';
require __DIR__ . '/routes/EventsRoutes.php';
require __DIR__ . '/routes/TicketsRoutes.php';
require __DIR__ . '/routes/PaymentsRoutes.php';
require __DIR__ . '/routes/OrdersRoutes.php';


Flight::route('/ping', function () {
    echo 'pong';
});

Flight::start();
