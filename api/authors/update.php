<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Author.php';

$database = new Database();
$db = $database->connect();

$author = new Author($db);

$data = json_decode(file_get_contents("php://input"));


if (empty($data->id) || empty($data->author)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

$author->setId($data->id);
$author->setAuthor($data->author);


if ($author->update()) {
    
    echo json_encode([
        "id" => $data->id,
        "author" => $data->author
    ]);
} else {
   
    echo json_encode(["message" => "author_id Not Found"]);
}
