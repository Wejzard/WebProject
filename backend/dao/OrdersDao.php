<?php
require_once __DIR__ . '/BaseDao.php';

class OrdersDao extends BaseDao {

     protected $table_name;
     public function __construct()
     {
        $this->table_name = "orders";
        parent::__construct($this->table_name);
     }
     
     public function get_all(){

        return $this->query('SELECT * FROM ' . $this->table_name, []);
     }

     public function get_by_id($id){

        return $this->query_unique('SELECT * FROM ' . $this->table_name . ' WHERE order_id=:id', ['id' => $id]);
     }

     public function create_order_ticket($order_id, $ticket_id, $quantity) {
       
        $query = "INSERT INTO order_tickets (order_id, ticket_id, quantity) VALUES (:order_id, :ticket_id, :quantity)";
        $stmt = $this->connection->prepare($query);
        $stmt->execute(['order_id' => $order_id, 'ticket_id' => $ticket_id, 'quantity' => $quantity]);
    
        return $this->connection->lastInsertId(); 
    }

    public function update($entity, $id, $id_column = "order_id")
    {    
       
        return parent::update($entity, $id, $id_column);
    }
    /*
    public function reserve_ticket($order_id) {
   
      $query = "UPDATE orders SET status = 'reserved' WHERE order_id = :order_id";
      $stmt = $this->connection->prepare($query);
      $stmt->execute(['order_id' => $order_id]);
   
      return $stmt->rowCount(); 
   
   }*/
 


}