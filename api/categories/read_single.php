<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

$cat = new Category($db);

if (!isset($_GET['id'])) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

$cat->setId($_GET['id']);

$result = $cat->read_single();
$row = $result->fetch(PDO::FETCH_ASSOC);

if ($row) {
    echo json_encode([
        "id" => $row["id"],
        "category" => $row["category"]
    ]);
} else {
    echo json_encode(["message" => "category_id Not Found"]);
}
