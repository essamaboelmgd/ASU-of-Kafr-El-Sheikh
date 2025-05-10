<?php
include('conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fields = json_decode($_POST['fields'], true);
    $event_id = intval($_POST['event_id']);

    // حذف الحقول القديمة لهذا الحدث فقط
    $delete_sql = "DELETE FROM form_fields WHERE event_id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();

    // إضافة الحقول الجديدة
    foreach ($fields as $field) {
        $field_type = $conn->real_escape_string($field['type']);
        $field_label = $conn->real_escape_string($field['label']);
        $field_value = isset($field['value']) ? 1 : 0; // للcheckboxes و radios

        $insert_sql = "INSERT INTO form_fields (field_type, field_label, event_id) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("ssi", $field_type, $field_label, $event_id);
        $stmt->execute();
    }

    echo "Form saved successfully for event ID: " . $event_id;
}
?>