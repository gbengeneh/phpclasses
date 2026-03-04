<?php
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '../middleware/AuthMiddleware.php';


class CategoryController{
    private $category;
    public function __construct() {
        $this->category = new Category();
    }

    public function getAllCategories(){
        $stmt = $this->category->read();
        $categories = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $categories[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'description' => $row['description'],
                'created_at' => $row['created_at']
            ];
        }
        echo json_encode($categories);
    }

    public function getCategory($id){
        $this->category->id=$id;
        if($this->category->readone()){
            echo json_encode([
                'id' => $this->category->id,
                'name' => $this->category->name,
                'description' => $this->category->description,
                'created_at' => $this->category->created_at
            ]);
        }else{
            http_response_code(404);
            echo json_encode(['message' => 'Category not found']);
        }
    }

    public function createCategory($data){
        AuthMiddleware::authenticate();

        if(empty($data['name'])){
            http_response_code(400);
            echo json_encode(['message' => 'Name is required']);
            return;
        }

        $this->category->name = htmlspecialchars(strip_tags($data['name']));
        $this->category->description = isset($data['description']) ? htmlspecialchars(strip_tags($data['description'])) : '';

        if($this->category->create()){
            http_response_code(201);
            echo json_encode(['message' => 'Category created successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to create category']);
        }
    }
}
