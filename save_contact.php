<?php
include('conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone_number = trim($_POST['phone_num']);
    $message = trim($_POST['msg']);
    $ip_address = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP) ?: 'unknown';
    $created_at = date("Y-m-d H:i:s");

    // Validate input
    if (empty($phone_number) || empty($message) || strlen($phone_number) != 11 || !is_numeric($phone_number)) {
        echo 'Invalid input';
        exit;
    }

    try {
        $sql = "INSERT INTO contact_messages (phone_number, message, created_at, ip_address) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $phone_number, $message, $created_at, $ip_address);
        $stmt->execute();
        $stmt->close();
        echo 'success';
    } catch (Exception $e) {
        error_log("Error in save_contact.php: " . $e->getMessage());
        echo 'Database error';
    }
}

$conn->close();
?>