<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

$database = new Database();
$db = $database->connect();

$quote = new Quote($db);

$data = json_decode(file_get_contents("php://input"));


if (empty($data->id) || empty($data->quote) || empty($data->author_id) || empty($data->category_id)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

$quote->setId($data->id);
$quote->setQuote($data->quote);
$quote->setAuthorId($data->author_id);
$quote->setCategoryId($data->category_id);

if ($quote->update()) {
   
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
} else {
    echo json_encode(["message" => "No Quotes Found"]);
}
