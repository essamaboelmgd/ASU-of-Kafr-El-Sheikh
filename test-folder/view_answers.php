<?php
include("conn.php");

// التحقق من صلاحيات المشرف
session_start();
if (!isset($_SESSION['admin_users'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['student_id'])) {
    header("Location: students_answers.php");
    exit();
}

$student_id = (int)$_GET['student_id'];

// جلب بيانات الطالب
$student_query = $conn->query("SELECT * FROM students WHERE student_id = $student_id");
$student = $student_query->fetch_assoc();

if (!$student) {
    die("الطالب غير موجود");
}

// جلب التقديمات والإجابات
$submissions_query = $conn->query("
    SELECT fs.*, e.event_name
    FROM form_submissions fs
    JOIN events e ON fs.event_id = e.event_id
    WHERE fs.student_id = $student_id
    ORDER BY fs.submit_time DESC
");
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إجابات الطالب</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1, h2 {
            color: #333;
        }
        .student-info {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .submission {
            margin-bottom: 30px;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
        }
        .question-answer {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px dashed #eee;
        }
        .question-text {
            font-weight: bold;
            color: #444;
        }
        .answer-text {
            padding-right: 20px;
            color: #666;
        }
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #4285f4;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="students_answers.php" class="back-link">
            <i class="fas fa-arrow-right"></i> العودة إلى قائمة الطلاب
        </a>
        
        <div class="student-info">
            <h1>إجابات الطالب: <?= htmlspecialchars($student['full_name']) ?></h1>
            <p>رقم الهاتف: <?= htmlspecialchars($student['phone_number']) ?></p>
            <p>السنة الدراسية: <?= [
                'first' => 'أولى',
                'second' => 'ثانية',
                'third' => 'ثالثة',
                'fourth' => 'رابعة'
            ][$student['academic_year']] ?? $student['academic_year'] ?></p>
            <p>IP Address: <?= htmlspecialchars($student['ip_address']) ?></p>
        </div>
        
        <?php while ($submission = $submissions_query->fetch_assoc()): ?>
            <div class="submission">
                <h2>النموذج: <?= htmlspecialchars($submission['event_name']) ?></h2>
                <p>وقت التقديم: <?= date('Y-m-d H:i', strtotime($submission['submit_time'])) ?></p>
                
                <?php
                // جلب إجابات هذا التقديم
                $answers_query = $conn->query("
                    SELECT ua.*, q.question_text, q.question_type
                    FROM user_answers ua
                    JOIN questions q ON ua.question_id = q.question_id
                    WHERE ua.submission_id = {$submission['submission_id']}
                    ORDER BY ua.answer_id
                ");
                
                while ($answer = $answers_query->fetch_assoc()): ?>
                    <div class="question-answer">
                        <div class="question-text"><?= htmlspecialchars($answer['question_text']) ?></div>
                        <div class="answer-text">
                            <?php if ($answer['question_type'] === 'checkbox' || $answer['question_type'] === 'radio'): ?>
                                <i class="far fa-check-circle"></i> 
                            <?php endif; ?>
                            <?= htmlspecialchars($answer['answer_text']) ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>