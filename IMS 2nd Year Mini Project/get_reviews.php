<?php
include "config.php";
header("Content-Type: application/json");

$q = "SELECT * FROM reviews ORDER BY id DESC";
$res = mysqli_query($conn, $q);

$rows = [];
while ($r = mysqli_fetch_assoc($res)) {
    $rows[] = $r;
}

echo json_encode($rows);
