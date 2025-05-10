<?php
include("conn.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ./login.php");
    exit();
}

$student_id = (int)$_SESSION['student_id'];

        
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['event_id'])) {
    $event_id = (int)$_POST['event_id'];
    $user_id = (int)$_SESSION['user_id'];
    
    // التحقق من وجود النموذج
    $event_query = $conn->query("SELECT * FROM events WHERE event_id = $event_id");
    if ($event_query->num_rows == 0) {
        die("النموذج غير موجود");
    }
    
    // بدء المعاملة
    $conn->begin_transaction();
    
    try {
        // تسجيل تقديم النموذج
        $submit_time = date('Y-m-d H:i:s');
        $sql = "INSERT INTO form_submissions (event_id, student_id, submit_time) 
            VALUES ($event_id, $student_id, '$submit_time')";
        
        if (!$conn->query($sql)) {
            throw new Exception("خطأ في تسجيل التقديم: " . $conn->error);
        }
        
        $submission_id = $conn->insert_id;
        
        // حفظ الإجابات
        if (!empty($_POST['answers'])) {
            foreach ($_POST['answers'] as $question_id => $answer_value) {
                $question_id = (int)$question_id;
                
                // إذا كانت الإجابة متعددة (checkbox)
                if (is_array($answer_value)) {
                    foreach ($answer_value as $value) {
                        $value = $conn->real_escape_string($value);
                        $sql = "INSERT INTO user_answers (submission_id, question_id, answer_text) 
                                VALUES ($submission_id, $question_id, '$value')";
                        $conn->query($sql);
                    }
                } else {
                    $answer_value = $conn->real_escape_string($answer_value);
                    $sql = "INSERT INTO user_answers (submission_id, question_id, answer_text) 
                            VALUES ($submission_id, $question_id, '$answer_value')";
                    $conn->query($sql);
                }
            }
        }
        
        $conn->commit();
        $_SESSION['form_success'] = "تم تقديم النموذج بنجاح!";
        header("Location: form_thankyou.php?event_id=$event_id");
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['form_error'] = "حدث خطأ أثناء تقديم النموذج: " . $e->getMessage();
        header("Location: form_display.php?event_id=$event_id");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>