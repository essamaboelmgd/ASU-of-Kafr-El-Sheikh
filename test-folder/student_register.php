<?php
include("conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // التحقق من البيانات
    if (empty($_POST['full_name']) || empty($_POST['phone_number']) || empty($_POST['academic_year'])) {
        die("الرجاء ملء جميع الحقول المطلوبة");
    }

    // تنظيف المدخلات
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $phone_number = $conn->real_escape_string($_POST['phone_number']);
    $academic_year = $conn->real_escape_string($_POST['academic_year']);
    $ip_address = $_SERVER['REMOTE_ADDR'];

    // التحقق من أن الرقم ليس مسجلاً من قبل
    $check_phone = $conn->query("SELECT * FROM students WHERE phone_number = '$phone_number'");
    if ($check_phone->num_rows > 0) {
        die("هذا الرقم مسجل من قبل");
    }

    // التحقق من أن IP ليس مسجلاً من قبل
    $check_ip = $conn->query("SELECT * FROM students WHERE ip_address = '$ip_address'");
    if ($check_ip->num_rows > 0) {
        die("لا يمكن التسجيل أكثر من مرة من نفس الجهاز");
    }

    // تسجيل الطالب
    $sql = "INSERT INTO students (full_name, phone_number, academic_year, ip_address) 
            VALUES ('$full_name', '$phone_number', '$academic_year', '$ip_address')";

    if ($conn->query($sql)) {
        // بدء جلسة الطالب
        session_start();
        $_SESSION['student_id'] = $conn->insert_id;
        $_SESSION['student_name'] = $full_name;
        
        header("Location: form_display.php");
        exit();
    } else {
        die("حدث خطأ أثناء التسجيل: " . $conn->error);
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الطالب</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], input[type="tel"], select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>تسجيل الطالب</h1>
        <form action="student_register.php" method="POST">
            <div class="form-group">
                <label for="full_name">الاسم بالكامل:</label>
                <input type="text" id="full_name" name="full_name" required>
            </div>
            
            <div class="form-group">
                <label for="phone_number">رقم الهاتف:</label>
                <input type="tel" id="phone_number" name="phone_number" required>
            </div>
            
            <div class="form-group">
                <label for="academic_year">السنة الدراسية:</label>
                <select id="academic_year" name="academic_year" required>
                    <option value="">اختر السنة الدراسية</option>
                    <option value="first">أولى</option>
                    <option value="second">ثانية</option>
                    <option value="third">ثالثة</option>
                    <option value="fourth">رابعة</option>
                </select>
            </div>
            
            <button type="submit">تسجيل الدخول</button>
        </form>
    </div>
</body>
</html>