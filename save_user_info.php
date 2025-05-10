<?php
include('conn.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = intval($_POST['event_id']);
    $user_name = trim($_POST['user_name']);
    $grade = $_POST['grade'];
    $ip_address = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP) ?: 'unknown';
    $created_at = date("Y-m-d H:i:s");

    $user_ip = $_SERVER['REMOTE_ADDR'];

    $check_ip_query = "SELECT id FROM event_users WHERE ip_address = ? and event_id = ?";
    $stmt_1 = $conn->prepare($check_ip_query);
    $stmt_1->bind_param("si", $user_ip, $event_id);
    $stmt_1->execute();
    $stmt_1->store_result();

    if ($stmt_1->num_rows > 0) {
        // إذا كان الـ IP موجودًا بالفعل، نمنع الإدخال
        echo "<script type='text/javascript'>alert('⚠️ لقد قمت بإرسال البيانات مسبقًا! لا يمكنك إدخالها مرة أخرى.');window.location.href = 'index.php';</script>";
        $stmt_1->close();
        exit(); // إنهاء التنفيذ لمنع الحفظ
    }
    
    $stmt_1->close();
    
    // Validate input
    if (empty($user_name) || !in_array($grade, ['First', 'Second', 'Third', 'Fourth'])) {
        echo 'Invalid input';
        exit;
    }

    try {
        $sql = "INSERT INTO event_users (event_id, user_name, grade, created_at, ip_address) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issss", $event_id, $user_name, $grade, $created_at, $ip_address);
        $stmt->execute();
        $stmt->close();

        // Store user info in session
        $_SESSION['event_user'] = [
            'event_id' => $event_id,
            'user_name' => $user_name,
            'grade' => $grade
        ];

        echo 'success';
    } catch (Exception $e) {
        error_log("Error in save_user_info.php: " . $e->getMessage());
        echo 'Database error';
    }
}

$conn->close();
?>