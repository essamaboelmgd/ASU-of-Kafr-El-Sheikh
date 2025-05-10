<?php
include("conn.php");

// التحقق من صلاحيات المشرف
session_start();
if (!isset($_SESSION['admin_users'])) {
    header("Location: login.php");
    exit();
}

// جلب جميع الطلاب
$students_query = $conn->query("
    SELECT s.*, COUNT(fs.submission_id) as submissions_count
    FROM students s
    LEFT JOIN form_submissions fs ON s.student_id = fs.student_id
    GROUP BY s.student_id
    ORDER BY s.registration_time DESC
");
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إجابات الطلاب</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: right;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
        .year-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }
        .first-year { background-color: #ffcccc; color: #cc0000; }
        .second-year { background-color: #ccffcc; color: #006600; }
        .third-year { background-color: #ccccff; color: #0000cc; }
        .fourth-year { background-color: #ffffcc; color: #666600; }
    </style>
</head>
<body>
    <div class="container">
        <h1>إجابات الطلاب</h1>
        
        <table id="studentsTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>رقم الهاتف</th>
                    <th>السنة</th>
                    <th>وقت التسجيل</th>
                    <th>عدد التقديمات</th>
                    <th>الإجابات</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($student = $students_query->fetch_assoc()): 
                    $year_class = [
                        'first' => 'first-year',
                        'second' => 'second-year',
                        'third' => 'third-year',
                        'fourth' => 'fourth-year'
                    ];
                    $year_name = [
                        'first' => 'أولى',
                        'second' => 'ثانية',
                        'third' => 'ثالثة',
                        'fourth' => 'رابعة'
                    ];
                ?>
                <tr>
                    <td><?= $student['student_id'] ?></td>
                    <td><?= htmlspecialchars($student['full_name']) ?></td>
                    <td><?= htmlspecialchars($student['phone_number']) ?></td>
                    <td>
                        <span class="year-badge <?= $year_class[$student['academic_year']] ?>">
                            <?= $year_name[$student['academic_year']] ?>
                        </span>
                    </td>
                    <td><?= date('Y-m-d H:i', strtotime($student['registration_time'])) ?></td>
                    <td><?= $student['submissions_count'] ?></td>
                    <td>
                        <a href="view_answers.php?student_id=<?= $student['student_id'] ?>">
                            <i class="fas fa-eye"></i> عرض
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#studentsTable').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/ar.json'
                }
            });
        });
    </script>
</body>
</html>