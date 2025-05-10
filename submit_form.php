<?php
include('conn.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // التحقق من وجود event_id وأنه رقم صحيح
    if (!isset($_GET['event_id']) || !is_numeric($_GET['event_id'])) {
        echo "<script type='text/javascript'>alert('⚠️ الحدث غير صالح!');window.location.href = 'index.php';</script>";
        exit();
    }
    $event_id = intval($_GET['event_id']);
    $user_ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP) ?: 'unknown';

    // التحقق من أن المستخدم سجل في الحدث
    $sql_check_user = "SELECT id FROM event_users WHERE event_id = ? AND ip_address = ?";
    $stmt_check = $conn->prepare($sql_check_user);
    $stmt_check->bind_param("is", $event_id, $user_ip);
    $stmt_check->execute();
    $stmt_check->store_result();
    if ($stmt_check->num_rows === 0) {
        echo "<script type='text/javascript'>alert('⚠️ يجب التسجيل في الحدث أولاً!');window.location.href = 'index.php';</script>";
        exit();
    }
    $stmt_check->close();

    // التحقق من أن event_id موجود في جدول events
    $sql_check_event = "SELECT id FROM events WHERE id = ?";
    $stmt_event = $conn->prepare($sql_check_event);
    $stmt_event->bind_param("i", $event_id);
    $stmt_event->execute();
    $stmt_event->store_result();
    if ($stmt_event->num_rows === 0) {
        echo "<script type='text/javascript'>alert('⚠️ الحدث غير موجود!');window.location.href = 'index.php';</script>";
        exit();
    }
    $stmt_event->close();

    // جمع البيانات من الفورم
    $text_values = [];
    foreach ($_POST as $key => $value) {
        if (is_array($value)) {
            // معالجة الـ checkboxes (المصفوفات)
            $text_values[] = htmlspecialchars($key) . ": " . htmlspecialchars(implode(", ", $value));
        } else {
            // معالجة الحقول النصية والـ radio
            $text_values[] = htmlspecialchars($key) . ": " . htmlspecialchars($value);
        }
    }

    // تحويل البيانات إلى JSON
    $fields_data = json_encode($text_values, JSON_UNESCAPED_UNICODE);

    // الحصول على التاريخ والوقت الحالي
    $created_at = date('Y-m-d H:i:s');

    // إدراج البيانات في جدول users
    $stmt = $conn->prepare("INSERT INTO users (fields_data, ip_address, created_at, event_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $fields_data, $user_ip, $created_at, $event_id);

    if ($stmt->execute()) {
        echo "<script type='text/javascript'>alert('تم الحفظ بنجاح!');window.location.href = 'index.php';</script>";
    } else {
        echo "<script type='text/javascript'>alert('حدث خطأ أثناء الحفظ: " . htmlspecialchars($stmt->error) . "');window.location.href = 'index.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>