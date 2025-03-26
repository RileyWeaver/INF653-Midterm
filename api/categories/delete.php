<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

$cat = new Category($db);

$data = json_decode(file_get_contents("php://input"));

if (empty($data->id)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

$cat->setId($data->id);

if ($cat->delete()) {
    // Return into json
    echo json_encode(["id" => $data->id]);
} else {
    echo json_encode(["message" => "category_id Not Found"]);
}
