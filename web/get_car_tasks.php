<?php
include("php/config.php");

$task_car = mysqli_query($con, "SELECT car_id, eidos_task, username_res, citizen_name, citizen_mobile, proion, atoma FROM tasks");
$rowss = array();

if (mysqli_num_rows($task_car) > 0) {
    while ($row_cars = mysqli_fetch_array($task_car)) {
        $rowss[] = $row_cars;
    }
}

echo json_encode($rowss);
?>