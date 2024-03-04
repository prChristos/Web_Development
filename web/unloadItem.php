<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "xristos";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$loadId = mysqli_real_escape_string($conn, $_POST['loadId']);

$sqlSelectLoad = "SELECT pr_name, category, quantity FROM loads WHERE load_id = ?";
$stmtSelectLoad = $conn->prepare($sqlSelectLoad);
$stmtSelectLoad->bind_param("i", $loadId);

$stmtSelectLoad->execute();
$stmtSelectLoad->store_result();
$stmtSelectLoad->bind_result($prName, $category, $quantity);

$stmtSelectLoad->fetch();

$sqlCheckExisting = "SELECT quantity FROM products WHERE pr_name = ? AND category = ?";
$stmtCheckExisting = $conn->prepare($sqlCheckExisting);
$stmtCheckExisting->bind_param("ss", $prName, $category);

$stmtCheckExisting->execute();
$stmtCheckExisting->store_result();

if ($stmtCheckExisting->num_rows > 0) {
    $stmtCheckExisting->bind_result($existingQuantity);
    $stmtCheckExisting->fetch();

    $newQuantity = $existingQuantity + $quantity;

    $sqlUpdateExisting = "UPDATE products SET quantity = ? WHERE pr_name = ? AND category = ?";
    $stmtUpdateExisting = $conn->prepare($sqlUpdateExisting);
    $stmtUpdateExisting->bind_param("iss", $newQuantity, $prName, $category);

    $stmtUpdateExisting->execute();

    echo json_encode(array("message" => "Record added to existing item in inventory successfully"));
} else {
    // Insert a new record in products table
    $sqlInsertNew = "INSERT INTO products (pr_name, category, quantity) VALUES (?, ?, ?)";
    $stmtInsertNew = $conn->prepare($sqlInsertNew);
    $stmtInsertNew->bind_param("ssi", $prName, $category, $quantity);

    $stmtInsertNew->execute();

    echo json_encode(array("message" => "New record added to inventory successfully"));
}

$sqlDeleteLoad = "DELETE FROM loads WHERE load_id = ?";
$stmtDeleteLoad = $conn->prepare($sqlDeleteLoad);
$stmtDeleteLoad->bind_param("i", $loadId);

$stmtDeleteLoad->execute();

$stmtSelectLoad->close();
$stmtCheckExisting->close();
$stmtDeleteLoad->close();

if (isset($stmtUpdateExisting)) {
    $stmtUpdateExisting->close();
}

if (isset($stmtInsertNew)) {
    $stmtInsertNew->close();
}

$conn->close();
?>