<?php
include('conn.php');

$event_id = $_GET['event_id'];

$sql = "SELECT * FROM form_fields WHERE event_id = $event_id";
$result = $conn->query($sql);

$fields = array();
while ($row = $result->fetch_assoc()) {
    $fields[] = $row;
}

echo json_encode($fields);
?>