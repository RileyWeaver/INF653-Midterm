<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

$cat = new Category($db);

$result = $cat->read();
$num = $result->rowCount();

if ($num > 0) {
    $cats_arr = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        
        $cat_item = [
            "id" => $id,
            "category" => $category
        ];
        $cats_arr[] = $cat_item;
    }
    echo json_encode($cats_arr);
} else {
    
    echo json_encode([]);
}
