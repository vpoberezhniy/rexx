<?php
require_once 'connectionDB.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $employeeName = isset($_GET['employeeName']) ? $_GET['employeeName'] : '';
    $eventName = isset($_GET['eventName']) ? $_GET['eventName'] : '';
    $eventDate = isset($_GET['eventDate']) ? $_GET['eventDate'] : '';

    $sql = "SELECT participation.employee_name, event.event_name, event.event_date, event_book.event_price 
            FROM participation 
            JOIN event_book ON participation.id = event_book.participation_id 
            JOIN event ON event_book.event_id = event.id 
            WHERE 1";

    $params = array();
    $types = "";

    if ($employeeName !== '') {
        $sql .= " AND participation.employee_name LIKE ?";
        $params[] = "%$employeeName%";
        $types .= "s";
    }

    if ($eventName !== '') {
        $sql .= " AND event.event_name LIKE ?";
        $params[] = "%$eventName%";
        $types .= "s";
    }

    if ($eventDate !== '') {
        $sql .= " AND event.event_date = ?";
        $params[] = $eventDate;
        $types .= "s";
    }

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();

        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        echo json_encode($data);

        $stmt->close();
    }

    $conn->close();
}
?>
