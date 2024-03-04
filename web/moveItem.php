<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "xristos";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);

$car_id = mysqli_real_escape_string($conn, $data['car_id']);
$pr_name = mysqli_real_escape_string($conn, $data['pr_name']);
$category = mysqli_real_escape_string($conn, $data['category']);
$quantity = mysqli_real_escape_string($conn, $data['quantity']);
switch($category){
          
    case "1":
        $category = 'Beverages';
        break;    

    case "2":
        $category = 'Cleaning Supplies';
        break; 
    case "3":
        $category = 'Clothing';
        break; 
    case "4":
        $category = 'First Aid';
        break; 
    case "5":
        $category = 'Food';
        break; 
    case "6":
        $category = 'Kitchen Supplies';
        break; 
    case "7":
        $category = 'Medical Supplies';
        break;
    case "8":
        $category = 'Personal Hygiene';
        break;
    case "9":
        $category = 'Shoes';
        break;             
}

$conn->begin_transaction();

try {
    $loadSql = "INSERT INTO loads (car_id, pr_name, category, quantity) VALUES (?, ?, ?, ?)";
    $loadStmt = $conn->prepare($loadSql);
    $loadStmt->bind_param("isss", $car_id, $pr_name, $category, $quantity);

    if (!$loadStmt->execute()) {
        throw new Exception("Error: " . $loadSql . "<br>" . $conn->error);
    }

    $updateProductSql = "UPDATE products SET quantity = quantity - ? WHERE pr_name = ?";
    $updateProductStmt = $conn->prepare($updateProductSql);
    $updateProductStmt->bind_param("is", $quantity, $pr_name);

    if (!$updateProductStmt->execute()) {
        throw new Exception("Error: " . $updateProductSql . "<br>" . $conn->error);
    }

    $conn->commit();
    echo json_encode(array("message" => "Record added successfully"));
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(array("error" => $e->getMessage()));
}

$loadStmt->close();
$updateProductStmt->close();
$conn->close();
?>