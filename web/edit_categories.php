<?php
$data = json_decode(file_get_contents('php://input'), true);

$file = 'categories.json';

$jsonData = json_encode($data, JSON_PRETTY_PRINT);

if (file_put_contents($file, $jsonData)) {
    echo "Categories updated successfully";
} else {
    echo "Error updating categories";
}
?>
