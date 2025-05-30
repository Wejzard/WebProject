<?php
require_once 'BaseService.php';
require_once __DIR__ . "/../dao/PaymentsDao.php";

class PaymentsService extends BaseService
{
    public function __construct()
    {
        parent::__construct(new PaymentsDao());
    }


    public function fetch_all_payments()
    {

        return $this->dao->get_all();
    }

    public function fetch_payment_by_id($id)
    {
      
        return $this->dao->get_by_id($id);
    }

    public function create_payment($data)
    {
    
        return $this->dao->add($data);
    }

    public function modify_payment($data, $id)
    {
      
        return $this->dao->update($data, $id);
    }

    public function remove_payment($id)
    {
       
        return $this->dao->delete($id);
    }
}