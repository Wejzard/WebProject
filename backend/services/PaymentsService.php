<?php
require_once 'BaseService.php';
require_once __DIR__ . "../dao/PaymentsDao.php";

class PaymentsService extends BaseService
{
    public function __construct()
    {
        parent::__construct(new PaymentsDao());
    }

    private function ensure_admin($role)
    {
        if ($role !== 'admin') {
            Flight::halt(403, json_encode(["error" => "Access denied. Admins only."]));
        }
    }

    public function fetch_all_payments($role)
    {
        $this->ensure_admin($role);
        return $this->dao->get_all();
    }

    public function fetch_payment_by_id($id, $role)
    {
        $this->ensure_admin($role);
        return $this->dao->get_by_id($id);
    }

    public function create_payment($data, $role)
    {
        $this->ensure_admin($role);
        return $this->dao->add($data);
    }

    public function modify_payment($data, $id, $role)
    {
        $this->ensure_admin($role);
        return $this->dao->update($data, $id);
    }

    public function remove_payment($id, $role)
    {
        $this->ensure_admin($role);
        return $this->dao->delete($id);
    }
}