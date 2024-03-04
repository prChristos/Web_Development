<?php
include("php/config.php");

$delCategoryIdJson = file_get_contents('php://input');
$delCategoryId = json_decode($delCategoryIdJson, true);

$categoriesJson = file_get_contents('categories.json');
$categories = json_decode($categoriesJson, true);

$index = array_search($delCategoryId, array_column($categories, 'id'));

if ($index !== false) {
    array_splice($categories, $index, 1);
}

$updatedCategoriesJson = json_encode(array_values($categories), JSON_PRETTY_PRINT);


file_put_contents('categories.json', $updatedCategoriesJson);

header('Content-Type: application/json');

echo json_encode(['message' => 'Category deleted successfully']);
?>