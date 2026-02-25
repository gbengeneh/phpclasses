<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/config.php';

class Post {
    private $conn;
    private $table_name = 'posts';
    public $id;
    public $title;
    public $content;
    public $image;
    public $category_id;
    public $user_id;
    public $created_at;
    public $updated_at;
    public $category_name;
    public $username;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET title=:title, content=:content, image=:image, category_id=:category_id, user_id=:user_id, created_at=NOW(), updated_at=NOW()";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':content', $this->content);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':user_id', $this->user_id);
       
        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }
    public function read() {
        $query = "SELECT p.id, p.title, p.content, p.image, p.category_id, p.user_id, p.created_at, p.updated_at, c.name as category_name, u.username FROM " . $this->table_name . " p LEFT JOIN categories c ON p.category_id = c.id LEFT JOIN users u ON p.user_id = u.id ORDER BY p.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt -> execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT p.id, p.title, p.content, p.image, p.category_id, p.user_id, p.created_at, p.updated_at, c.name as category_name, u.username FROM " . $this->table_name . " p LEFT JOIN categories c ON p.category_id = c.id LEFT JOIN users u ON p.user_id = u.id WHERE p.id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->title = $row['title'];
            $this->content = $row['content'];
            $this->image = $row['image'];
            $this->category_id = $row['category_id'];
            $this->user_id = $row['user_id'];
            $this->created_at = $row['created_at'];
            $this->updated_at = $row['updated_at'];
            $this->category_name = $row['category_name'];
            $this->username = $row['username'];
            return true;
        }
        return false;
    }
}