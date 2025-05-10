<?php
include('conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $checkboxes = isset($_POST['checkboxes']) ? implode(", ", $_POST['checkboxes']) : "";

    // الحصول على IP المستخدم
    $user_ip = $_SERVER['REMOTE_ADDR'];

    $check_ip_query = "SELECT id FROM users WHERE ip_address = ?";
    $stmt_1 = $conn->prepare($check_ip_query);
    $stmt_1->bind_param("s", $user_ip);
    $stmt_1->execute();
    $stmt_1->store_result();

    if ($stmt_1->num_rows > 0) {
        // إذا كان الـ IP موجودًا بالفعل، نمنع الإدخال
        echo "<script type='text/javascript'>alert('⚠️ لقد قمت بإرسال البيانات مسبقًا! لا يمكنك إدخالها مرة أخرى.');</script>";
        exit(); // إنهاء التنفيذ لمنع الحفظ
    }

    // جمع جميع البيانات النصية من النموذج
    $text_values = [];
    foreach ($_POST as $key => $value) {
        if ($key !== "checkboxes") {
            $text_values[] = "$key: " . htmlspecialchars($value);
        }
    }

    // تحويل القيم النصية إلى JSON لتخزينها في قاعدة البيانات
    $fields_data = json_encode($text_values, JSON_UNESCAPED_UNICODE);

    // الحصول على التاريخ والوقت الحالي
    $created_at = date('Y-m-d H:i:s');

    // إدراج البيانات في جدول users
    $stmt = $conn->prepare("INSERT INTO users ( fields_data, ip_address, created_at) VALUES ( ?, ?, ?)");
    $stmt->bind_param("sss", $fields_data, $user_ip, $created_at);

    if ($stmt->execute()) {
        echo "<script type='text/javascript'>alert('تم الحفظ بنجاح!');</script>";
    } else {
        echo "<script type='text/javascript'>alert('حدث خطأ أثناء الحفظ: . $stmt->error ');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
