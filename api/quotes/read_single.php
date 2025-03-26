<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

$database = new Database();
$db = $database->connect();

$quote = new Quote($db);


if (!isset($_GET['id'])) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

$quote->setId($_GET['id']);

$stmt = $quote->read_single();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    echo json_encode([
        "id" => $row["id"],
        "quote" => $row["quote"],
        "author" => $row["author"],
        "category" => $row["category"]
    ]);
} else {
    echo json_encode(["message" => "No Quotes Found"]);
}
