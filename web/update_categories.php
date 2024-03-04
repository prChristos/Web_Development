<?php
include("php/config.php");
$categoriesJson = file_get_contents('categories.json');
$categories = json_decode($categoriesJson, true);

$newCategoriesJson = file_get_contents('php://input');
$newCategories = json_decode($newCategoriesJson, true);

// Merge the new categories with the existing ones
$mergedCategories = array_merge($categories, $newCategories);

$mergedCategoriesJson = json_encode($mergedCategories, JSON_PRETTY_PRINT);

file_put_contents('categories.json', $mergedCategoriesJson);

echo json_encode(['message' => 'Categories updated successfully']);
?>
