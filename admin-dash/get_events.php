<?php
include('conn.php');

$sql = "SELECT id, title FROM events";
$result = $conn->query($sql);

$events = array();
while ($row = $result->fetch_assoc()) {
    $events[] = $row;
}

echo json_encode($events);
?>