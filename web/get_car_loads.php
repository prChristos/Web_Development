<?php
include("php/config.php");

$result_car = mysqli_query($con, "SELECT car_id, pr_name, quantity FROM loads");
$rows = array();

if (mysqli_num_rows($result_car) > 0) {
    while ($row_car = mysqli_fetch_array($result_car)) {
        $rows[] = $row_car;
    }
}
echo json_encode($rows);
?>