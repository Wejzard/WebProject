<?php
require_once 'BaseService.php';
require_once __DIR__ . "/../dao/TicketsDao.php";

class TicketsService extends BaseService
{
    public function __construct()
    {
        parent::__construct(new TicketsDao());
    }


    public function fetch_all_tickets()
    {
       
        return $this->dao->get_all();
    }

    public function fetch_ticket_by_id($id, )
    {
    
        return $this->dao->get_by_id($id);
    }

    public function create_ticket($data)
    {
       
        return $this->dao->add($data);
    }

    public function modify_ticket($data, $id)
    {
 
        return $this->dao->update($data, $id);
    }

    public function remove_ticket($id, )
    {
    
        return $this->dao->delete($id);
    }
}