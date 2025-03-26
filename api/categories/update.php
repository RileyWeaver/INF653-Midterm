<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

$cat = new Category($db);

$data = json_decode(file_get_contents("php://input"));


if (empty($data->id) || empty($data->category)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

$cat->setId($data->id);
$cat->setCategory($data->category);

if ($cat->update()) {
    echo json_encode([
        "id" => $data->id,
        "category" => $data->category
    ]);
} else {
    
    echo json_encode(["message" => "category_id Not Found"]);
}
