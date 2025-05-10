<?php
include("conn.php");
session_start();

// التحقق من وجود جلسة المشرف
if (!isset($_SESSION['admin_users'])) {
    header("Location: ./login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // تنظيف المدخلات
    $form_name = $conn->real_escape_string($_POST['form_name']);
    $event_id = isset($_POST['event_id']) ? (int)$_POST['event_id'] : 0;
    $fields = json_decode($_POST['fields'], true);
    
    // إدخال بيانات الفورم الأساسية
    $sql = "INSERT INTO forms (form_name, event_id, created_at) 
            VALUES ('$form_name', $event_id, NOW())";
    
    if ($conn->query($sql)) {
        $form_id = $conn->insert_id;
        
        // إدخال حقول الفورم
        foreach ($fields as $field) {
            $field_type = $conn->real_escape_string($field['type']);
            $field_label = $conn->real_escape_string($field['label']);
            $field_required = isset($field['required']) ? 1 : 0;
            
            $sql = "INSERT INTO form_fields (form_id, field_type, field_label, is_required, display_order)
                    VALUES ($form_id, '$field_type', '$field_label', $field_required, " . ($index + 1) . ")";
            
            if (!$conn->query($sql)) {
                echo "Error: " . $conn->error;
                exit();
            }
        }
        
        echo "تم حفظ الفورم بنجاح!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>