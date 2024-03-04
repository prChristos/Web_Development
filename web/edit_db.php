<?php
include("php/config.php");
$categoryId = $_POST['categoryId'];
$categoryName = $_POST['categoryName'];

$sql = "UPDATE categories SET cat_name = '$categoryName' WHERE cat_id = '$categoryId'";
$query = mysqli_query($con, $sql);
if ($query === TRUE) {
    echo "Database updated successfully";
} else {
    echo "Error updating database: " . $con->error;
}

?>
