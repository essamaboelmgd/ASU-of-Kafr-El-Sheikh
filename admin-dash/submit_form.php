<?php
include('conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $checkbox_values = isset($_POST['checkboxes']) ? json_encode($_POST['checkboxes']) : '[]';

    $sql = "INSERT INTO user_responses (checkboxes) VALUES ('$checkbox_values')";
    $conn->query($sql);

    echo "<script type='text/javascript'>alert('Form Submitted successfully!');</script>";
}
?>
