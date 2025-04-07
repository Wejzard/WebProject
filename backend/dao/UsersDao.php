<?php
require_once __DIR__ . '/BaseDao.php';

class UsersDao extends BaseDao {

     protected $table_name;

     public function __construct()
     {
        $this->table_name = "users";
        parent::__construct($this->table_name);
     }
     
     public function get_all(){

        return $this->query('SELECT * FROM ' . $this->table_name, []);
     }

     public function get_by_id($id){

        return $this->query_unique('SELECT * FROM ' . $this->table_name . ' WHERE user_id=:id', ['id' => $id]);
     }
     
     public function update_user_info($user_id, $nickname, $password_hash) {
      
      $query = "UPDATE users SET full_name = :nickname, password_hash = :password_hash WHERE user_id = :user_id";
      $stmt = $this->connection->prepare($query);
      $stmt->execute(['user_id' => $user_id, 'nickname' => $nickname, 'password_hash' => $password_hash]);
  
      return $stmt->rowCount();
  }

  
    public function update($entity, $id, $id_column = "user_id")
    {    
       
        return parent::update($entity, $id, $id_column);
    }

      
    public function delete($id)
    {
        $stmt = $this->connection->prepare("DELETE FROM " . $this->table_name . " WHERE user_id = :user_id");
        $stmt->bindValue(':user_id', $id); 
    }


}











?>