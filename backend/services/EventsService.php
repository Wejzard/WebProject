<?php
require_once 'BaseService.php';
require_once __DIR__ . "../dao/EventsDao.php";

class EventsService extends BaseService
{
    public function __construct()
    {
        parent::__construct(new EventsDao());
    }

    public function get_by_category($category) {
        return $this->dao->get_by_category($category);
    }
    public function add_event($data) {
        // Basic validations
        if (strlen(trim($data['title'] ?? '')) < 3) {
            Flight::halt(400, json_encode(['error' => 'Title is too short.']));
        }
        if (empty($data['event_date']) || empty($data['event_time'])) {
            Flight::halt(400, json_encode(['error' => 'Date and time are required.']));
        }
        if (!is_numeric($data['price']) || $data['price'] < 0) {
            Flight::halt(400, json_encode(['error' => 'Price must be a non-negative number.']));
        }

        // Add created_at if needed
        $data['created_at'] = date('Y-m-d H:i:s');

        return $this->dao->add($data);
    }



    
}