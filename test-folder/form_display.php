<?php
include("conn.php");
session_start();

// التحقق من أن المستخدم مسجل دخوله
if (!isset($_SESSION['admin_users'])) {
    header("Location: ./login.php");
    exit();
}

// جلب بيانات النموذج
if (isset($_GET['event_id'])) {
    $event_id = (int)$_GET['event_id'];
    $event_query = $conn->query("SELECT * FROM events WHERE event_id = $event_id");
    $event = $event_query->fetch_assoc();
    
    if (!$event) {
        die("النموذج غير موجود");
    }
} else {
    die("معرف النموذج غير محدد");
}

// جلب الأسئلة والإجابات
$questions = [];
$questions_query = $conn->query("SELECT * FROM questions WHERE event_id = $event_id ORDER BY question_id");
while ($question = $questions_query->fetch_assoc()) {
    $question_id = $question['question_id'];
    $answers = [];
    
    $answers_query = $conn->query("SELECT * FROM answers WHERE question_id = $question_id");
    while ($answer = $answers_query->fetch_assoc()) {
        $answers[] = $answer;
    }
    
    $question['answers'] = $answers;
    $questions[] = $question;
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($event['event_name']); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            color: #202124;
        }
        
        .form-container {
            max-width: 800px;
            margin: 30px auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        
        .form-header {
            border-bottom: 1px solid #dadce0;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .form-title {
            font-size: 32px;
            color: #202124;
            margin-bottom: 10px;
        }
        
        .form-description {
            color: #5f6368;
            font-size: 14px;
        }
        
        .question-container {
            margin-bottom: 30px;
            padding: 20px;
            border: 1px solid #dadce0;
            border-radius: 8px;
            position: relative;
        }
        
        .question-text {
            font-size: 16px;
            margin-bottom: 15px;
            color: #202124;
        }
        
        .question-image {
            max-width: 100%;
            height: auto;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        
        .answer-container {
            margin-bottom: 15px;
        }
        
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #dadce0;
            border-radius: 4px;
            font-size: 14px;
        }
        
        textarea {
            min-height: 100px;
            resize: vertical;
        }
        
        .radio-option, .checkbox-option {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        
        input[type="radio"], input[type="checkbox"] {
            margin-left: 10px;
        }
        
        .submit-btn {
            background-color: #4285f4;
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .submit-btn:hover {
            background-color: #3367d6;
        }
        
        .required-star {
            color: #d93025;
            margin-right: 5px;
        }
        
        .form-footer {
            margin-top: 30px;
            border-top: 1px solid #dadce0;
            padding-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h1 class="form-title"><?php echo htmlspecialchars($event['event_name']); ?></h1>
            <div class="form-description">
                <?php 
                $type_names = [
                    'scientific' => 'علمي',
                    'art' => 'فني',
                    'athletic' => 'رياضي',
                    'social' => 'اجتماعي',
                    'voyager' => 'سياحي',
                    'cultural' => 'ثقافي'
                ];
                echo "نوع النموذج: " . ($type_names[$event['event_type']] ?? $event['event_type']);
                ?>
            </div>
        </div>
        
        <form action="submit_form.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
            
            <?php foreach ($questions as $index => $question): ?>
                <div class="question-container">
                    <div class="question-text">
                        <?php if ($question['is_required']): ?>
                            <span class="required-star">*</span>
                        <?php endif; ?>
                        <?php echo htmlspecialchars($question['question_text']); ?>
                    </div>
                    
                    <?php if ($question['question_image']): ?>
                        <img src="../<?php echo htmlspecialchars($question['question_image']); ?>" class="question-image" alt="صورة السؤال">
                    <?php endif; ?>
                    
                    <div class="answer-container">
                        <?php switch ($question['question_type']):
                            case 'text': ?>
                                <input type="text" name="answers[<?php echo $question['question_id']; ?>]" 
                                    <?php if ($question['is_required']) echo 'required'; ?>>
                                <?php break; ?>
                            
                            case 'paragraph': ?>
                                <textarea name="answers[<?php echo $question['question_id']; ?>]" 
                                    <?php if ($question['is_required']) echo 'required'; ?>></textarea>
                                <?php break; ?>
                            
                            case 'radio': 
                            case 'checkbox': 
                                foreach ($question['answers'] as $answer): ?>
                                    <div class="<?php echo $question['question_type']; ?>-option">
                                        <input type="<?php echo $question['question_type']; ?>" 
                                               name="answers[<?php echo $question['question_id']; ?>]<?php echo $question['question_type'] == 'checkbox' ? '[]' : ''; ?>" 
                                               value="<?php echo htmlspecialchars($answer['answer_text']); ?>"
                                               id="answer_<?php echo $answer['answer_id']; ?>"
                                               <?php if ($question['is_required']) echo 'required'; ?>>
                                        <label for="answer_<?php echo $answer['answer_id']; ?>">
                                            <?php echo htmlspecialchars($answer['answer_text']); ?>
                                            <?php if ($answer['answer_image']): ?>
                                                <img src="../<?php echo htmlspecialchars($answer['answer_image']); ?>" style="max-width: 200px; display: block; margin-top: 5px;">
                                            <?php endif; ?>
                                        </label>
                                    </div>
                                <?php endforeach;
                                break; ?>
                            
                            case 'label': ?>
                                <!-- Label فقط لعرض نص بدون إدخال بيانات -->
                                <input type="hidden" name="answers[<?php echo $question['question_id']; ?>]" value="N/A">
                                <?php break; ?>
                        <?php endswitch; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            
            <div class="form-footer">
                <button type="submit" class="submit-btn">إرسال النموذج</button>
            </div>
        </form>
    </div>
</body>
</html>