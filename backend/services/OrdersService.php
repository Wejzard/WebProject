<?php
require_once 'BaseService.php';
require_once __DIR__ . "/../dao/OrdersDao.php";

class OrdersService extends BaseService
{
    public function __construct()
    {
        parent::__construct(new OrdersDao());
    }

    
    public function place_order($data)
    {
        if (!isset($data['user_id']) || !isset($data['total']) || !isset($data['status'])) {
            Flight::halt(400, json_encode(["error" => "Missing required order data."]));
        }

        return $this->dao->add($data);
    }

    // Admin-only methods
    public function admin_get_all()
    {
        
        return $this->dao->get_all();
    }

    public function admin_update($data, $id)
    {
      
        return $this->dao->update($data, $id);
    }

    public function admin_delete($id)
    {
       
        return $this->dao->delete($id);
    }

    //Everyone can fetch their own order 
    public function get_by_id($id)
    {
        return $this->dao->get_by_id($id);
    }
}


