<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

$database = new Database();
$db = $database->connect();

$quote = new Quote($db);

$data = json_decode(file_get_contents("php://input"));


if (empty($data->id)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

$quote->setId($data->id);


$stmt = $quote->read_single();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    echo json_encode(["message" => "No Quotes Found"]);
    exit();
}

$deletedQuote = [
    "id" => $row["id"],
    "quote" => $row["quote"],
    "author" => $row["author"],
    "category" => $row["category"]
];


if ($quote->delete()) {
    
    echo json_encode($deletedQuote);
} else {
    echo json_encode(["message" => "No Quotes Found"]);
}
