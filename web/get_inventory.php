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

$userCarId = mysqli_real_escape_string($conn, $data['car_id']);

$sql = "SELECT load_id, pr_name, category, SUM(quantity) AS quantity FROM loads WHERE car_id = ? GROUP BY load_id, pr_name, category";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userCarId);

if ($stmt->execute()) {
    $result = $stmt->get_result();

    $inventoryData = array();
    while ($row = $result->fetch_assoc()) {
        $inventoryData[] = $row;
    }

    echo json_encode($inventoryData);
} else {
    echo json_encode(array("error" => "Error: " . $sql . "<br>" . $conn->error));
}

$stmt->close();
$conn->close();
?>