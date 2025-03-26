<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

$cat = new Category($db);


$data = json_decode(file_get_contents("php://input"));

if (empty($data->category)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

$cat->setCategory($data->category);

if ($cat->create()) {
    echo json_encode([
        "id" => $cat->getId(),
        "category" => $cat->getCategory()
    ]);
} else {
    echo json_encode(["message" => "Category Not Created"]);
}
