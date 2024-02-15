<?php
require 'connectionDB.php';

$json_data = file_get_contents($_FILES['jsonFile']['tmp_name']);
$data = json_decode($json_data, true);

$conn->begin_transaction();

try {
    foreach ($data as $row) {
        $employee_name = $row['employee_name'];
        $employee_mail = $row['employee_mail'];
        $event_name = $row['event_name'];
        $event_price = isset($row['participation_fee']) ? $row['participation_fee'] : 0; // Якщо fee відсутнє, встановлюємо 0
        $event_date = $row['event_date'];

        $query_employee = "SELECT id, employee_mail FROM participation WHERE employee_mail = '$employee_mail'";
        $result_employee = mysqli_query($conn, $query_employee);
        $response_employee = mysqli_fetch_assoc($result_employee);

        $query_event = "SELECT id, event_name FROM event WHERE event_name = '$event_name'";
        $result_event = mysqli_query($conn, $query_event);
        $response_event = mysqli_fetch_assoc($result_event);

        if ($response_employee['employee_mail'] != $employee_mail) {
            $sql = "INSERT INTO participation (employee_name, employee_mail) VALUES ('$employee_name', '$employee_mail')";
            $conn->query($sql);
            $participation_id = $conn->insert_id;
        } else {
            $participation_id = $response_employee['id'];
        }

        if ($response_event['event_name'] != $event_name) {
            $sql = "INSERT INTO event (event_name, event_date) VALUES ('$event_name', '$event_date')";
            $conn->query($sql);
            $event_id = $conn->insert_id;
        } else {
            $event_id = $response_event['id'];
        }

        $participation_id = mysqli_real_escape_string($conn, $participation_id);
        $event_id = mysqli_real_escape_string($conn, $event_id);
        $sql = "INSERT INTO event_book (event_id, participation_id, event_price, event_book_date) VALUES ('$event_id', '$participation_id','$event_price', NOW())";
        $conn->query($sql);
    }
    $conn->commit();
} catch (Exception $e) {
    $conn->rollback();
    throw $e;
}

$conn->close();

header("Location: index.php");
exit();
?>