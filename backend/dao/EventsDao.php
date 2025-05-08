<?php
require_once __DIR__ . '/BaseDao.php';

class EventsDao extends BaseDao {

    protected $table_name;

    public function __construct() {
        $this->table_name = "events";
        parent::__construct($this->table_name);
    }

    public function get_all($page = 1, $limit = 4) {
        $offset = ($page - 1) * $limit;
        $query = "SELECT * FROM {$this->table_name} LIMIT :limit OFFSET :offset";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_by_id($id) {
        return $this->query_unique("SELECT * FROM {$this->table_name} WHERE event_id = :id", ['id' => $id]);
    }

    public function get_by_category($page = 1, $limit = 4, $category = null) {
        $offset = ($page - 1) * $limit;
        $query = "SELECT * FROM {$this->table_name}";
        if ($category !== null) {
            $query .= " WHERE category = :category";
        }
        $query .= " LIMIT :limit OFFSET :offset";

        $stmt = $this->connection->prepare($query);
        if ($category !== null) {
            $stmt->bindParam(':category', $category, PDO::PARAM_STR);
        }
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function search_by_name($name) {
        $stmt = $this->connection->prepare("SELECT * FROM {$this->table_name} WHERE title LIKE :name");
        $stmt->execute(['name' => "%$name%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add_event($data) {
        // If BaseDao already has add(), this will work:
        return $this->add($data);
    }

    public function delete($id) {
        $stmt = $this->connection->prepare("DELETE FROM {$this->table_name} WHERE event_id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function update($entity, $id, $id_column = "event_id") {
        return parent::update($entity, $id, $id_column);
    }
}