<?php
include("php/config.php");
$itemsJson = file_get_contents('items.json');
$items = json_decode($itemsJson, true);

$newitemsJson = file_get_contents('php://input');
$newitems = json_decode($newitemsJson, true);

$mergeditems = array_merge($items, $newitems);

$mergeditemsJson = json_encode($mergeditems, JSON_PRETTY_PRINT);

file_put_contents('items.json', $mergeditemsJson);

echo json_encode(['message' => 'Items updated successfully']);

foreach ($newitems as $newItem){
    $itemId = mysqli_real_escape_string($con, $newItem['id']);
    $itemName = mysqli_real_escape_string($con, $newItem['name']);
    $itemCat = mysqli_real_escape_string($con, $newItem['category']);
    $query = "INSERT INTO products(id, pr_name, category) VALUES('$itemId', '$itemName', '$itemCat')";
    mysqli_query($con, $query);

    foreach($newItem['details'] as $detail){
        $detailName = mysqli_real_escape_string($con, $detail['detail_name']);
        $detailValue = mysqli_real_escape_string($con, $detail['detail_value']);
        $detailQuery = "INSERT INTO product_details(pr_id, detail_name, detail_value, quantity) VALUES('$itemId', '$detailName', '$detailValue', '')";
        mysqli_query($con, $detailQuery);
    }
}
?>