<?php
include "config.php";
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

$username = $data['username'];
$rating = $data['rating'];
$comment = $data['comment'];

$q = "INSERT INTO reviews (username, rating, comment) VALUES ('$username', '$rating', '$comment')";
mysqli_query($conn, $q);

echo json_encode(["message" => "Thanks for your feedback!"]);
